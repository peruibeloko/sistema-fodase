<?php
include "../Persistence.php";

const REPO = "group";

enum Status: string {
  case AVAILABLE = 'Disponível';
  case FINISHED = 'Encerrado';
}

class Group {
  static function save(
    ...$data
  ) {
    return (new Persistence(REPO))->create([
      'title' => $data["title"],
      'description' => $data["description"],
      'status' => $data["status"],
      'seats' => $data["seats"],
      'start_date' => $data["start_date"],
      'end_date' => $data["end_date"],
    ]);
  }

  static function replace($id, ...$data) {
    return (new Persistence(REPO))->replace($id, [
      'title' => $data["title"],
      'description' => $data["description"],
      'status' => $data["status"],
      'seats' => $data["seats"],
      'start_date' => $data["start_date"],
      'end_date' => $data["end_date"],
    ]);
  }

  static function delete($id) {
    return (new Persistence(REPO))->delete($id);
  }
}
