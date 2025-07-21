<?php
require __DIR__ . "/../shared/Persistence.php";

const REPO = "group";

enum Status: string {
  case AVAILABLE = "AVAILABLE";
  case FINISHED = "FINISHED";
}

class Group {
  static function save(
    $data
  ) {
    return (new Persistence(REPO))->create($data);
  }

  static function replace($id, $data) {
    return (new Persistence(REPO))->replace($id, $data);
  }

  static function delete($id) {
    return (new Persistence(REPO))->delete($id);
  }
}
