<?php
require __DIR__ . "/../shared/Persistence.php";

const REPO = "subject";

enum Topic: string {
  case INOV = "INOV";
  case TECH = "TECH";
  case MKTN = "MKTN";
  case EMPR = "EMPR";
  case AGRO = "AGRO";
}

class Subject {
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
