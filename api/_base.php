<?php
require_once __DIR__ . '/../config.php';

header('Content-Type: application/json; charset=utf-8');
header('X-Content-Type-Options: nosniff');

set_exception_handler(function (Throwable $e): void {
    error_log('Unhandled exception: ' . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage(), 'file' => $e->getFile(), 'line' => $e->getLine()], JSON_UNESCAPED_UNICODE);
    exit;
});

function respond(array $data): void {
    echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    exit;
}

function respondError(string $msg, int $code = 400): void {
    http_response_code($code);
    respond(['error' => $msg]);
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
