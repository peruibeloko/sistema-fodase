<?php
include "../models/SubjectModel.php";

function get_valid_topic(string $topic) {
  if (!array_search($topic, Topic::cases())) {
    return false;
  }

  return Topic::from($topic);
}

function create_subject(mixed $body) {
  [
    'title' => $title,
    'description' => $description,
    'topic' => $topic,
    'image_url' => $image_url,
  ] = $body;

  $valid_topic = get_valid_topic($topic);

  if ($valid_topic === false) {
    http_response_code(400);
    return send("Invalid topic code (allowed codes are "
      . join(", ", Topic::cases()) . ")");
  }

  $result = Subject::save(
    $title,
    $description,
    $valid_topic,
    $image_url
  );

  if ($result === false) {
    http_response_code(500);
    return send("Error persisting data");
  }

  http_response_code(201);
  return send($result);
}

function replace_subject(int $id, mixed $body) {
  [
    'title' => $title,
    'description' => $description,
    'topic' => $topic,
    'image_url' => $image_url,
  ] = $body;

  $valid_topic = get_valid_topic($topic);

  if ($valid_topic === false) {
    http_response_code(400);
    return send("Invalid topic code (allowed codes are "
      . join(", ", Topic::cases()) . ")");
  }

  $result = Subject::replace(
    $id,
    $title,
    $description,
    $valid_topic,
    $image_url
  );

  if ($result === false) {
    http_response_code(500);
    return send("Error persisting data");
  }

  http_response_code(201);
  return send($result);
}

function delete_subject(int $id) {
  $result = Subject::delete($id);

  if ($result === false) {
    http_response_code(500);
    return send("Error persisting data");
  }

  http_response_code(204);
  return send(null);
}
