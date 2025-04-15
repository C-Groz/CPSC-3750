<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

$mysqli = new mysqli("localhost", "u461793670_cg", "jipdyr-kitwyv-0hujKi", "u461793670_collect");

$user_id = $_SESSION['user_id'];

$data = json_decode(file_get_contents("php://input"), true);
$movie_id = $data['id'] ?? null;

if($movie_id === null){
    echo "Missing movieID.";
    exit;
}

//delete from db based on movie ID
$sql = "DELETE FROM saved_movies WHERE id = ? AND user_id = ?";
$statement = $mysqli->prepare($sql);
$statement->bind_param("ii", $movie_id, $user_id);

if($statement->execute()){
    echo "Movie deleted";
}else{
    echo "Failed to delete movie";
}
?>
