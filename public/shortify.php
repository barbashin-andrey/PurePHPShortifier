<?php
require_once('database.php');

function generatePath($link) {
    $bytes = random_bytes(6);
    return bin2hex($bytes);
}
function jsonResponse($status_code, $array) {
    http_response_code($status_code);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($array);
}

$json = json_decode(file_get_contents('php://input'), true);
if(!(!is_null($json) && array_key_exists('link', $json) && filter_var($json['link'], FILTER_VALIDATE_URL)))
{
    jsonResponse(400, array("error" => "invalid link"));
    exit;
}

$db = new Database();
$link = $json['link'];
$path = generatePath($link);

while (!$db->checkPathIsUnique($path)) {
    $path = generatePath($link);
}

$db->newUrl($link, $path);

jsonResponse(200, array("short_path" => $path));
?>