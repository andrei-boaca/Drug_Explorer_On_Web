<?php
require_once __DIR__ . '/../config.php';

header('Content-Type: application/json; charset=utf-8');
header('X-Content-Type-Options: nosniff');

$cacheFile = __DIR__ . '/../cache/ai_map.json';
$cacheTTL  = 24 * 60 * 60;

if (file_exists($cacheFile) && (time() - filemtime($cacheFile)) < $cacheTTL) {
    $cached = json_decode(file_get_contents($cacheFile), true);
    $cached['from_cache'] = true;
    echo json_encode($cached, JSON_UNESCAPED_UNICODE);
    exit;
}

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
    'contents' => [
        ['parts' => [['text' => $prompt]]]
    ],
    'generationConfig' => [
        'maxOutputTokens' => 2048,
        'temperature'     => 0.3,
    ]
]);

$url = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key=' . GEMINI_API_KEY;

$ch = curl_init($url);
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST           => true,
    CURLOPT_POSTFIELDS     => $payload,
    CURLOPT_HTTPHEADER     => ['Content-Type: application/json'],
    CURLOPT_TIMEOUT        => 30,
]);

$raw      = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($raw === false || $httpCode !== 200) {
    http_response_code(502);
    echo json_encode(['error' => 'Gemini API unavailable. HTTP ' . $httpCode], JSON_UNESCAPED_UNICODE);
    exit;
}

$apiResp = json_decode($raw, true);
$text    = $apiResp['candidates'][0]['content']['parts'][0]['text'] ?? '';

$text = trim($text);
$text = preg_replace('/^```(?:json)?\s*/i', '', $text);
$text = preg_replace('/```.*$/s', '', $text);
$text = trim($text);

$data = json_decode(trim($text), true);

if (!$data || !isset($data['scores'])) {
    http_response_code(502);
    echo json_encode(['error' => 'Raspuns invalid de la Gemini.'], JSON_UNESCAPED_UNICODE);
    exit;
}

$data['updated_at'] = date('d.m.Y H:i');
$data['from_cache'] = false;

file_put_contents($cacheFile, json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
echo json_encode($data, JSON_UNESCAPED_UNICODE);
