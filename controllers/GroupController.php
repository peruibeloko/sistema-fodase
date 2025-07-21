<?php
include "../models/GroupModel.php";

function get_valid_status(string $status) {
  if (!array_search($status, Status::cases())) {
    return false;
  }

  return Status::from($status);
}

function create_group(mixed $body) {
  [
    'title' => $title,
    'description' => $description,
    'status' => $status,
    'seats' => $seats,
    'start_date' => $start_date,
    'end_date' => $end_date,
  ] = $body;

  $valid_status = get_valid_status($status);

  if ($valid_status === false) {
    http_response_code(400);
    return send("Invalid topic code (allowed codes are "
      . join(", ", Topic::cases()) . ")");
  }

  $result = Group::save(
    $title,
    $description,
    $valid_status,
    $seats,
    $start_date,
    $end_date
  );

  if ($result === false) {
    http_response_code(500);
    return send("Error persisting data");
  }

  http_response_code(201);
  return send($result);
}

function replace_group(int $id, mixed $body) {
  [
    'title' => $title,
    'description' => $description,
    'status' => $status,
    'seats' => $seats,
    'start_date' => $start_date,
    'end_date' => $end_date,
  ] = $body;

  $valid_status = get_valid_status($status);

  if ($valid_status === false) {
    http_response_code(400);
    return send("Invalid topic code (allowed codes are "
      . join(", ", Topic::cases()) . ")");
  }

  $result = Group::replace(
    $id,
    $title,
    $description,
    $valid_status,
    $seats,
    $start_date,
    $end_date
  );

  if ($result === false) {
    http_response_code(500);
    return send("Error persisting data");
  }

  http_response_code(201);
  return send($result);
}

function delete_group(int $id) {
  $result = Group::delete($id);

  if ($result === false) {
    http_response_code(500);
    return send("Error persisting data");
  }

  http_response_code(204);
  return send(null);
}
