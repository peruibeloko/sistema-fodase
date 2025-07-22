<?php
require_once __DIR__ . "/../shared/Persistence.php";
require_once __DIR__ . "/../models/GroupModel.php";

const REPO = "subject";

enum Topic: string {
  case INOV = "INOV";
  case TECH = "TECH";
  case MKTN = "MKTN";
  case EMPR = "EMPR";
  case AGRO = "AGRO";
}

class Subject {
  static function parse(mixed $data) {
    function parse_topic(string $topic) {
      if (!array_search($topic, enum_values(Topic::class))) {
        http_response_code(400);
        $topics = join(", ", enum_values(Topic::class));
        return send("Invalid topic code (allowed codes are $topics)");
      }

      return Topic::from($topic);
    }

    return [
      "title" => parse_string($data["title"], "title"),
      "description" => parse_string($data["description"], "description"),
      "topic" => parse_topic($data["topic"]),
      "image_url" => parse_string($data["image_url"], "image_url"),
    ];
  }

  static function save(
    $data
  ) {
    return (new Persistence(REPO))->create(Subject::parse($data));
  }

  static function list_available() {
    function is_available($subj) {
      $groups = Group::list_groups($subj["topic"]);
      return count(array_filter($groups, fn($v) => Group::is_group_open($v))) > 0;
    }

    $result = (new Persistence(REPO))->read(null);

    if ($result === null) return null;

    $subjects = array_keys(array_filter($result, 'is_available'));
    if (count($subjects) === 0) return null;
    return $subjects;
  }

  static function list_subjects(string $user_id) {
    $result = (new Persistence(REPO))->read(null);
    $subjects = array_keys(
      array_filter(
        $result,
        fn($v) => $v["user_id"] === $user_id
      )
    );
    if (count($subjects) === 0) return null;
    return $subjects;
  }

  static function replace(string $id, mixed $data) {
    return (new Persistence(REPO))->replace($id, Subject::parse($data));
  }

  static function delete(string $id) {
    return (new Persistence(REPO))->delete($id);
  }
}
