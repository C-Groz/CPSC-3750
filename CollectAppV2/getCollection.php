<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

$mysqli = new mysqli("localhost", "u461793670_cg", "jipdyr-kitwyv-0hujKi", "u461793670_collect");

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode([]);
    exit;
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT id, title, overview, release_date, popularity, created_at FROM saved_movies WHERE user_id = ? ORDER BY created_at DESC";
$statement = $mysqli->prepare($sql);
$statement->bind_param("i", $user_id);
$statement->execute();
$result = $statement->get_result();

$movies = [];
while($row = $result->fetch_assoc()){
    $movies[] = $row;
}

echo json_encode($movies);
?>
