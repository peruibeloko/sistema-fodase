<?php
require_once __DIR__ . "/../../shared/route_setup.php";
require_once __DIR__ . "/../../controllers/GroupController.php";

switch ($method) {
  case "POST":
    return register_user(body());
  case "DELETE":
    return unregister_user(param("id"));
  default:
    http_response_code(501);
    send("Unsupported operation");
    break;
}
