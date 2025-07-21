<?php
function body(): mixed {
  return json_decode(file_get_contents("php://input"), true);
}

function param(string $name): mixed {
  return $_GET[$name];
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

  if ($is_match === 1) {
    return $date;
  }

  http_response_code(400);
  return send("Invalid date, use YYYY-MM-DD");
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
