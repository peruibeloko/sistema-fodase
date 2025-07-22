<?php
require_once __DIR__ . "/../../shared/route_setup.php";
require_once __DIR__ . "/../../controllers/UserController.php";

switch ($method) {
  case "GET":
    return get_or_list_users(param("id", false));
  case "POST":
    return create_user(body());
  case "DELETE":
    return delete_user(param("id"));
  default:
    http_response_code(501);
    send("Unsupported operation");
    break;
}
