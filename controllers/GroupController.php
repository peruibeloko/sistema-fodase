<?php
include "../models/GroupModel.php";
include "../shared/controller_setup.php";
include "../shared/common.php";

function parse_status(string $status) {
  if (!array_search($status, Status::cases())) {
    http_response_code(400);
    return send("Invalid topic code (allowed codes are "
      . join(", ", Topic::cases()) . ")");
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
  ];
}

function create_group(mixed $body) {
  return handle_error(Group::save(parse_group($body)), 201);
}

function replace_group(int $id, mixed $body) {
  return handle_error(Group::replace($id, parse_group($body)), 201);
}

function delete_group(int $id) {
  return handle_error(Group::delete($id), 204);
}
