<?php
header("Content-Type: application/json");
header('Content-Security-Policy: default-src "self"');
$method = $_SERVER["REQUEST_METHOD"];
