<?php
include "../shared/common.php";
include "../controllers/UserController.php";

switch ($method) {
  case "POST":
    return create_user(body());
  case "DELETE":
    return delete_user(param("id"));
  default:
    send("Unsupported operation");
    break;
}
