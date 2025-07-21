<?php
include "../shared/Persistence.php";

const REPO = "subject";

enum Topic: string {
  case INOV = "Inovação";
  case TECH = "Tecnologia";
  case MKTN = "Marketing";
  case EMPR = "Empreendedorismo";
  case AGRO = "Agronegócio";
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
