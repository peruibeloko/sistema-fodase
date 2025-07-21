<?php
include "../shared/Persistence.php";

const REPO = "user";

class User {
  static function save(mixed $data) {
    return (new Persistence(REPO))->create($data);
  }

  static function delete($id) {
    return (new Persistence(REPO))->delete($id);
  }
}
