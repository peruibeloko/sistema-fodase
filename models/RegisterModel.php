<?php
require_once __DIR__ . "/../shared/Persistence.php";

const REPO = "register";

class Register {
  static function parse(mixed $data) {
    return [
      "user_id" => parse_string($data, "user_id"),
      "subject_id" => parse_string($data, "subject_id"),
    ];
  }

  static function save(mixed $data) {
    return (new Persistence(REPO))->create(Register::parse($data));
  }

  static function delete(string $id) {
    return (new Persistence(REPO))->delete($id);
  }
}
