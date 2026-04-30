<?php
require_once __DIR__ . '/../config.php';

header('Content-Type: application/json; charset=utf-8');
header('X-Content-Type-Options: nosniff');

function respond(array $data): void {
    echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    exit;
}

function respondError(string $msg, int $code = 400): void {
    http_response_code($code);
    respond(['error' => $msg]);
}

function q(string $sql, array $params = []): array {
    try {
        $stmt = getConnection()->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        error_log('DB: ' . $e->getMessage());
        respondError('Eroare bază de date.', 500);
    }
}

function intParam(string $key): ?int {
    if (!isset($_GET[$key]) || $_GET[$key] === '') return null;
    $v = filter_var($_GET[$key], FILTER_VALIDATE_INT);
    return $v === false ? null : $v;
}

function strParam(string $key, array $allowed): ?string {
    $v = $_GET[$key] ?? '';
    return in_array($v, $allowed, true) ? $v : null;
}
