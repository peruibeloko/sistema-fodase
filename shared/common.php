<?php
function body(): mixed {
  return json_decode(file_get_contents('php://input'), true);
}

function param(string $name): mixed {
  return $_GET[$name];
}

function send(mixed $value) {
  echo json_encode($value);
}

header("Content-Type: application/json");
header("Content-Security-Policy: default-src 'self'");
$method = $_SERVER['REQUEST_METHOD'];
