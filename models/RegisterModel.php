<?php
require __DIR__ . "/../shared/Persistence.php";

const REPO = "register";

class Register {
  static function save(mixed $data) {
    return (new Persistence(REPO))->create($data);
  }

  static function delete($id) {
    return (new Persistence(REPO))->delete($id);
  }
}
