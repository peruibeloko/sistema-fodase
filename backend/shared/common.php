<?php
function body(): mixed {
  $json = json_decode(file_get_contents("php://input"), true);
  if ($json === []) {
    http_response_code(400);
    return send("Missing request body");
  }
  return $json;
}

function param(string $name, bool $required = true): mixed {
  if (!array_key_exists($name, $_GET)) {
    if ($required) {
      http_response_code(400);
      return send("Missing required parameter: $name");
    }
    
    return null;
  }

  return $_GET[$name];
}

function required(mixed $thing, string $param) {
  if ($thing === null) {
    http_response_code(400);
    return send("Missing required parameter: $param");
  }
  return $thing;
}

function send(mixed $value) {
  echo json_encode($value);
}

function parse_int(string $str, string $field) {
  $int = intval($str);

  if ($int <= 0) {
    http_response_code(400);
    return send("$field must be a positive integer");
  }

  return $int;
}

function parse_iso_date(string $date) {
  $is_match = preg_match("/^\d{4}\-\d{2}\-\d{2}$/", $date);

  if ($is_match === 1) return $date;

  http_response_code(400);
  return send("Invalid date, use YYYY-MM-DD");
}

function slice_date(string $date) {
  return explode("-", $date);
}

function is_before(string $subject, string $reference) {
  [$y1, $m1, $d1] = slice_date($subject);
  [$y2, $m2, $d2] = slice_date($reference);

  return $y1 <= $y2 && $m1 <= $m2 && $d1 <= $d2;
}

function is_after(string $subject, string $reference) {
  [$y1, $m1, $d1] = slice_date($subject);
  [$y2, $m2, $d2] = slice_date($reference);

  return $y1 >= $y2 && $m1 >= $m2 && $d1 >= $d2;
}

function parse_string(string $str, string $field) {
  $is_match = preg_match("/^\s*$/", $str);

  if ($is_match === 1) {
    http_response_code(400);
    return send("Please provide a valid $field");
  }

  return $str;
}

function handle_error(mixed $result, int $success_code) {
  if ($result === false) {
    http_response_code(500);
    return send("Error persisting data");
  }

  http_response_code($success_code);
  return send($result);
}

function enum_values(mixed $enum) {
  return array_map(fn($x) => $x->name, $enum::cases());
}
