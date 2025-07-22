<?php
require_once __DIR__ . "/../models/UserModel.php";
require_once __DIR__ . "/../models/SubjectModel.php";

function get_or_list_users(string|null $id) {
  return handle_error(User::read($id), 200);
}

function create_user(mixed $data) {
  return handle_error(User::save(User::parse($data)), 201);
}

function delete_user(string $id) {
  return handle_error(User::delete($id), 204);
}

function list_subjects(string $id) {
  $result = Subject::list_subjects($id);

  if ($result === null) {
    http_response_code(204);
    return send("");
  }

  http_response_code(200);
  return send($result);
}