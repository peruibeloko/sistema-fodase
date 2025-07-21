<?php
include "../models/UserModel.php";
include "../shared/controller_setup.php";
include "../shared/common.php";

function parse_user(mixed $data) {
  return [
    "name" => parse_string($data["name"], "Please provide a valid name"),
    "email" => parse_string($data["email"], "Please provide a valid email")
  ];
}

function create_user(mixed $body) {
  return handle_error(User::save(parse_user($body)), 201);
}

function delete_user(string $id) {
  return handle_error(User::delete($id), 204);
}
