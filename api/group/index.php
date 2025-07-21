<?php
require __DIR__ . "/../../shared/route_setup.php";
require __DIR__ . "/../../controllers/GroupController.php";

switch ($method) {
  case "POST":
    return create_group(body());
  case "PUT":
    return replace_group(param("id"), body());
  case "DELETE":
    return delete_group(param("id"));
  default:
    send("Unsupported operation");
    break;
}
