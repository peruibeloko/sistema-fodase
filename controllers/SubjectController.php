<?php
require __DIR__ . "/../models/SubjectModel.php";
require __DIR__ . "/../shared/common.php";

function parse_topic(string $topic) {
  if (!array_search($topic, enum_values(Topic::class))) {
    http_response_code(400);
    $topics = join(", ", enum_values(Topic::class));
    return send("Invalid topic code (allowed codes are $topics)");
  }

  return Topic::from($topic);
}

function parse_subject(mixed $data) {
  return [
    "title" => parse_string($data["title"], "title"),
    "description" => parse_string($data["description"], "description"),
    "topic" => parse_topic($data["topic"]),
    "image_url" => parse_string($data["image_url"], "image_url"),
  ];
}

function create_subject(mixed $data) {
  return handle_error(Subject::save(parse_subject($data)), 201);
}

function replace_subject(int $id, mixed $data) {
  return handle_error(Subject::replace($id, parse_subject($data)), 201);
}

function delete_subject(int $id) {
  return handle_error(Subject::delete($id), 204);
}
