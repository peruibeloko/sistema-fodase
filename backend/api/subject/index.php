<?php
require_once __DIR__ . "/../../shared/route_setup.php";
require_once __DIR__ . "/../../controllers/SubjectController.php";

switch ($method) {
  case "GET":
    return list_subjects(param("topic"));
  case "POST":
    return create_subject(body());
  case "PUT":
    return replace_subject(param("id"), body());
  case "DELETE":
    return delete_subject(param("id"));
  default:
    http_response_code(501);
    send("Unsupported operation");
    break;
}
