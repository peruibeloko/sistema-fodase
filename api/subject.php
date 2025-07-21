<?php
include "../shared/common.php";
include "../controllers/SubjectController.php";

switch ($method) {
  case "POST":
    return create_subject(body());
  case "PUT":
    return replace_subject(param("id"), body());
  case "DELETE":
    return delete_subject(param("id"));
  default:
    send("Unsupported operation");
    break;
}
