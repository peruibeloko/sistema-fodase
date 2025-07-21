<?php
require_once __DIR__ . "/../shared/Persistence.php";
require_once __DIR__ . "/../shared/common.php";

const REPO = "user";

class User {
  static function parse(mixed $data) {
    return [
      "name" => parse_string($data, "name"),
      "email" => parse_string($data, "email")
    ];
  }
  static function read(string|null $id) {
    return (new Persistence(REPO))->read($id);
  }

  static function save(mixed $data) {
    return (new Persistence(REPO))->create($data);
  }

  static function delete(string $id) {
    return (new Persistence(REPO))->delete($id);
  }
}
