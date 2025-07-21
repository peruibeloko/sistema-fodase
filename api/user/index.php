<?php
require __DIR__ . "/../../shared/route_setup.php";
require __DIR__ . "/../../controllers/UserController.php";

switch ($method) {
  case "POST":
    return create_user(body());
  case "DELETE":
    return delete_user(param("id"));
  default:
    http_response_code(501);
    send("Unsupported operation");
    break;
}
