<?php
require_once __DIR__ . "/../models/GroupModel.php";

function list_groups(string $topic) {
  $result = Group::list_groups($topic);

  if ($result === null) {
    http_response_code(204);
    return send("");
  }

  http_response_code(200);
  return send($result);
}

function create_group(mixed $data) {
  return handle_error(Group::save(Group::parse($data)), 201);
}

function replace_group(string $id, mixed $data) {
  return handle_error(Group::replace($id, Group::parse($data)), 201);
}

function delete_group(string $id) {
  return handle_error(Group::delete($id), 204);
}

function register_user(mixed $data) {
  return handle_error(Register::save($data), 201);
}

function unregister_user(string $id) {
  return handle_error(Register::delete($id), 204);
}
