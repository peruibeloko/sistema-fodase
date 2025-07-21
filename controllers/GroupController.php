<?php
require __DIR__ . "/../models/GroupModel.php";
require __DIR__ . "/../shared/common.php";

function parse_status(string $status) {
  if (array_search($status, enum_values(Status::class)) === false) {
    http_response_code(400);

    $statueses = join(", ", enum_values(Status::class));
    return send("Invalid topic code (allowed codes are $statueses)");
  }

  return Status::from($status);
}

function parse_group(mixed $data) {
  return [
    "title" => parse_string($data["title"], "title"),
    "description" => parse_string($data["description"], "description"),
    "status" => parse_status($data["status"]),
    "seats" => parse_int($data["seats"], "seats"),
    "start_date" => parse_iso_date($data["start_date"]),
    "end_date" => parse_iso_date($data["end_date"]),
    "subject_id" => parse_string($data["subject_id"], "subject_id"),
  ];
}

function create_group(mixed $data) {
  return handle_error(Group::save(parse_group($data)), 201);
}

function replace_group(int $id, mixed $data) {
  return handle_error(Group::replace($id, parse_group($data)), 201);
}

function delete_group(int $id) {
  return handle_error(Group::delete($id), 204);
}
