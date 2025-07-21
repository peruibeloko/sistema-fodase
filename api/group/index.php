<?php
require_once __DIR__ . "/../../shared/route_setup.php";
require_once __DIR__ . "/../../controllers/GroupController.php";

switch ($method) {
  case "GET":
    $topic = param("topic");
    return list_groups($topic);
  case "POST":
    $body = body();
    return create_group($body);
  case "PUT":
    $id = param("id");
    $body = body();
    return replace_group($id, $body);
  case "DELETE":
    return delete_group(param("id"));
  default:
    http_response_code(501);
    send("Unsupported operation");
    break;
}
