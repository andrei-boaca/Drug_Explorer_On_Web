<?php
require_once __DIR__ . '/../config.php';

header('Content-Type: application/json; charset=utf-8');
header('X-Content-Type-Options: nosniff');

$pdo = getConnection();

function readFromDB(PDO $pdo): ?array {
    $row = $pdo->query("SELECT text, updated_at FROM ai_sumar WHERE id = 1")->fetch();
    if (!$row) return null;

    $scores = [];
    foreach ($pdo->query("SELECT cod_tara, scor FROM ai_tari_scoruri WHERE updated_at = (SELECT MAX(updated_at) FROM ai_tari_scoruri)") as $r) {
        $scores[$r['cod_tara']] = (float) $r['scor'];
    }

    $trending = $pdo->query("SELECT tara AS country, cod_tara AS code, tendinta AS trend, motiv AS reason
                              FROM ai_tendinte
                              WHERE updated_at = (SELECT MAX(updated_at) FROM ai_tendinte)")
                    ->fetchAll();

    return [
        'scores'     => $scores,
        'trending'   => $trending,
        'summary'    => $row['text'],
        'updated_at' => date('d.m.Y H:i', strtotime($row['updated_at'])),
        'from_cache' => true,
    ];
}

function getFromDB(PDO $pdo): ?array {
    $row = $pdo->query("SELECT updated_at FROM ai_sumar WHERE id = 1")->fetch();
    if (!$row) return null;
    if ((time() - strtotime($row['updated_at'])) >= 86400) return null;
    return readFromDB($pdo);
}

function saveToDb(PDO $pdo, array $data, string $updatedAt): void {
    $pdo->beginTransaction();

    $pdo->exec("DELETE FROM ai_tari_scoruri");
    $stmt = $pdo->prepare("INSERT INTO ai_tari_scoruri (cod_tara, scor, updated_at) VALUES (?, ?, ?)");
    foreach ($data['scores'] as $cod => $scor) {
        $stmt->execute([$cod, $scor, $updatedAt]);
    }

    $pdo->exec("DELETE FROM ai_tendinte");
    $stmt = $pdo->prepare("INSERT INTO ai_tendinte (tara, cod_tara, tendinta, motiv, updated_at) VALUES (?, ?, ?, ?, ?)");
    foreach ($data['trending'] as $t) {
        $stmt->execute([$t['country'], $t['code'], $t['trend'], $t['reason'], $updatedAt]);
    }

    $pdo->exec("DELETE FROM ai_sumar");
    $pdo->prepare("INSERT INTO ai_sumar (id, text, updated_at) VALUES (1, ?, ?)")
        ->execute([$data['summary'], $updatedAt]);

    $pdo->commit();
}

function callGroq(): array {
    $prompt = <<<PROMPT
You are a drug policy data analyst. Based on the latest available data from the EMCDDA (European Monitoring Centre for Drugs and Drug Addiction) and other reputable sources, provide a comprehensive assessment of drug consumption prevalence across European countries.

Return ONLY a valid JSON object — no markdown, no explanation, just raw JSON — in exactly this format:
{
  "scores": {
    "AL": 3.1, "AT": 6.2, "BE": 7.1, "BA": 3.5, "BG": 4.0,
    "HR": 5.5, "CY": 5.8, "CZ": 7.5, "DK": 7.8, "EE": 5.2,
    "FI": 5.0, "FR": 7.9, "DE": 7.2, "GR": 4.5, "HU": 4.3,
    "IS": 6.0, "IE": 7.6, "IT": 7.0, "LV": 4.8, "LT": 4.5,
    "LU": 8.1, "MT": 6.5, "MD": 2.8, "ME": 4.2, "NL": 8.5,
    "MK": 3.8, "NO": 6.5, "PL": 5.5, "PT": 5.8, "RO": 2.5,
    "RU": 5.0, "RS": 4.5, "SK": 5.2, "SI": 6.8, "ES": 8.0,
    "SE": 6.0, "CH": 7.3, "UA": 4.0, "GB": 8.3, "BY": 3.5,
    "LI": 5.0, "AD": 5.5, "MC": 5.0, "SM": 4.0
  },
  "trending": [
    {
      "country": "Country Name",
      "code": "XX",
      "trend": "rising",
      "reason": "2-3 sentence explanation referencing specific substances, demographics or policy factors."
    }
  ],
  "summary": "A 2-3 sentence overview of the current drug consumption landscape across Europe."
}

Rules:
- Scores are 0-10 (0 = negligible, 10 = extremely high prevalence) based on best available EMCDDA data.
- Include exactly 6 trending entries mixing rising and declining trends across different regions.
- Use ISO 3166-1 alpha-2 country codes.
- Return ONLY the JSON. No markdown code fences. No extra text.
PROMPT;

    $payload = json_encode([
        'model'           => 'llama-3.3-70b-versatile',
        'messages'        => [['role' => 'user', 'content' => $prompt]],
        'max_tokens'      => 4096,
        'temperature'     => 0.3,
        'response_format' => ['type' => 'json_object'],
    ]);

    $context = stream_context_create([
        'http' => [
            'method'  => 'POST',
            'header'  => implode("\r\n", [
                'Content-Type: application/json',
                'Authorization: Bearer ' . GROQ_API_KEY,
            ]),
            'content' => $payload,
            'timeout' => 30,
            'ignore_errors' => true,
        ],
    ]);

    $raw      = @file_get_contents('https://api.groq.com/openai/v1/chat/completions', false, $context);
    $httpCode = 0;
    if (isset($http_response_header)) {
        preg_match('/HTTP\/\S+\s+(\d+)/', $http_response_header[0] ?? '', $m);
        $httpCode = (int) ($m[1] ?? 0);
    }

    if ($raw === false || $httpCode !== 200) {
        throw new RuntimeException('Groq API unavailable. HTTP ' . $httpCode);
    }

    $apiResp = json_decode($raw, true);
    $text    = $apiResp['choices'][0]['message']['content'] ?? '';

    $text = trim($text);

    // Try to parse as-is first
    $data = json_decode($text, true);

    // If that fails, extract between first { and last } and attempt repair
    if (!$data || !isset($data['scores'])) {
        $start = strpos($text, '{');
        $end   = strrpos($text, '}');
        if ($start !== false && $end !== false && $end > $start) {
            $text = substr($text, $start, $end - $start + 1);
            $data = json_decode($text, true);
        }
    }

    // Last resort: try appending missing closing brackets for truncated responses
    if (!$data || !isset($data['scores'])) {
        foreach (["\n]\n}", "\n  }\n]\n}"] as $suffix) {
            $candidate = $text . $suffix;
            $data = json_decode($candidate, true);
            if ($data && isset($data['scores'])) break;
        }
    }

    if (!$data || !isset($data['scores'])) {
        throw new RuntimeException('Raspuns invalid de la Groq. JSON error: ' . json_last_error_msg());
    }

    return $data;
}

$cached = getFromDB($pdo);
if ($cached) {
    echo json_encode($cached, JSON_UNESCAPED_UNICODE);
    exit;
}

try {
    $data       = callGroq();
    $updatedAt  = date('Y-m-d H:i:s');
    saveToDb($pdo, $data, $updatedAt);

    $data['updated_at'] = date('d.m.Y H:i');
    $data['from_cache'] = false;
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
} catch (RuntimeException $e) {
    // Groq unavailable — return stale DB data if available rather than failing
    $stale = readFromDB($pdo);
    if ($stale) {
        $stale['stale'] = true;
        echo json_encode($stale, JSON_UNESCAPED_UNICODE);
    } else {
        http_response_code(502);
        echo json_encode(['error' => $e->getMessage()], JSON_UNESCAPED_UNICODE);
    }
}
