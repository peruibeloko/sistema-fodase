<?php
require __DIR__ . "/../models/UserModel.php";
require __DIR__ . "/../shared/common.php";

function parse_user(mixed $data) {
  return [
    "name" => parse_string($data["name"], "Please provide a valid name"),
    "email" => parse_string($data["email"], "Please provide a valid email")
  ];
}

function create_user(mixed $data) {
  return handle_error(User::save(parse_user($data)), 201);
}

function delete_user(string $id) {
  return handle_error(User::delete($id), 204);
}
