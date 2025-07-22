<?php
require_once __DIR__ . "/../shared/Persistence.php";
require_once __DIR__ . "/../shared/common.php";

const REPO = "group";

enum Status: string {
  case AVAILABLE = "AVAILABLE";
  case FINISHED = "FINISHED";
}

class Group {
  static function parse(mixed $data) {
    function parse_status(string $status) {
      if (array_search($status, enum_values(Status::class)) === false) {
        http_response_code(400);

        $statueses = join(", ", enum_values(Status::class));
        return send("Invalid topic code (allowed codes are $statueses)");
      }

      return Status::from($status);
    }

    return [
      "title" => parse_string($data["title"], "title"),
      "description" => parse_string($data["description"], "description"),
      "status" => parse_status($data["status"]),
      "seats" => parse_int($data["seats"], "seats"),
      "start_date" => parse_iso_date($data["start_date"]),
      "end_date" => parse_iso_date($data["end_date"]),
      "subject_id" => parse_string($data["subject_id"], "subject_id"),
    ];
  }

  static function is_group_open(mixed $group) {
    [
      "status" => $status,
      "start_date" => $start_date,
      "end_date" => $end_date
    ] = $group;

    $today = date("Y-m-d");

    if (Status::from($status) !== Status::AVAILABLE) return false;
    if (is_before($today, $start_date)) return false;
    if (is_after($today, $end_date)) return false;

    return true;
  }

  static function list_groups(string $topic) {
    $result = (new Persistence(REPO))->read(null);

    if ($result === null) return null;

    $subjects = array_keys(
      array_filter(
        $result,
        fn($v) => $v["topic"] === $topic
      )
    );

    if (count($subjects) === 0) return null;
    return $subjects;
  }

  static function save(
    $data
  ) {
    return (new Persistence(REPO))->create($data);
  }

  static function replace(string $id, mixed $data) {
    return (new Persistence(REPO))->replace($id, $data);
  }

  static function delete(string $id) {
    return (new Persistence(REPO))->delete($id);
  }
}
