<?php
require_once __DIR__ . "/../../shared/route_setup.php";
require_once __DIR__ . "/../../controllers/UserController.php";

switch ($method) {
  case "GET":
    return list_subjects(param("id"));
  default:
    http_response_code(501);
    send("Unsupported operation");
    break;
}
