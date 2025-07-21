<?php
include "../models/UserModel.php";

function create_user(mixed $body) {
  ["email" => $email, "name" => $name] = $body;
  $result = User::save($name, $email);

  if ($result === false) {
    http_response_code(500);
    return send("Error persisting data");
  }

  http_response_code(201);
  return send($result);
}

function delete_user(int $id) {
  $result = User::delete($id);

  if ($result === false) {
    http_response_code(500);
    return send("Error persisting data");
  }

  http_response_code(204);
  return send(null);
}
