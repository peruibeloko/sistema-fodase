<?php
require_once __DIR__ . "/../models/SubjectModel.php";

function list_subjects() {
  $result = Subject::list_available();

  if ($result === null) {
    http_response_code(204);
    return send("");
  }
  
  http_response_code(200);
  return send($result);
}

function create_subject(mixed $data) {
  return handle_error(Subject::save($data), 201);
}

function replace_subject(int $id, mixed $data) {
  return handle_error(Subject::replace($id, $data), 201);
}

function delete_subject(int $id) {
  return handle_error(Subject::delete($id), 204);
}
