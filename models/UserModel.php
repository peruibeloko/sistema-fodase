<?php
include "../shared/Persistence.php";

const REPO = "user";

class User {
  static function save(string $name, string $email) {
    return (new Persistence(REPO))->create(['name' => $name, 'email' => $email]);
  }

  static function delete($id) {
    return (new Persistence(REPO))->delete($id);
  }
}
