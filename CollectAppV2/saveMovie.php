<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

$mysqli = mysqli_connect("localhost", "u461793670_cg", "dykde3-fyrCyd-nyfbic", "u461793670_collect");

if(!isset($_SESSION['user_id'])) {
    echo "User not logged in";
    exit;
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $data = json_decode(file_get_contents("php://input"), true);

    if(!$data){
        http_response_code(400);
        echo "Invalid input";
        exit;
    }

    $user_id = $_SESSION['user_id'];
    $title = mysqli_real_escape_string($mysqli, $data['title'] ?? '');
    $overview = mysqli_real_escape_string($mysqli, $data['overview'] ?? '');
    $release_date = mysqli_real_escape_string($mysqli, $data['release_date'] ?? '');
    $popularity = mysqli_real_escape_string($mysqli, $data['popularity'] ?? '');

    $sql = "INSERT INTO saved_movies (user_id, title, overview, release_date, popularity) VALUES (?, ?, ?, ?, ?)";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("issss", $user_id, $title, $overview, $release_date, $popularity);

    if($stmt->execute()){
        echo "Movie saved successfully";
    }else{
        echo "Error saving movie: ";
    }

    $stmt->close();
    $mysqli->close();
}
?>
