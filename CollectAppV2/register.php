<head>
    <title>Register</title>
</head>
<style>
    body, html{
        margin-top: 30px;
    }
</style>
<link rel="stylesheet" href="collectApp.css">
<script>
    fetch("../navbar.html")
        .then(response => response.text())
        .then(data => document.body.insertAdjacentHTML("afterbegin", data));
    fetch("nav.html")
        .then(response => response.text())
        .then(data => document.body.insertAdjacentHTML("afterbegin", data));
</script>

<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

// Connect db
$mysqli = mysqli_connect("localhost", "u461793670_cg", "dykde3-fyrCyd-nyfbic", "u461793670_collect");

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $username = mysqli_real_escape_string($mysqli, $_POST['username']);
    $password = mysqli_real_escape_string($mysqli, $_POST['password']);
    
    // Hash PW
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($mysqli, $sql);

    // Ensure no duplicates
    if(mysqli_num_rows($result) > 0){
        echo "Username already taken";
    }else{
        $sql = "INSERT INTO users (username, password) VALUES ('$username', '$hashed_password')";
        if(mysqli_query($mysqli, $sql)){
            echo "User registered successfully! <a href='login.php'>Login now</a>";
        }else{
            echo "Error: " . mysqli_error($mysqli);
        }
    }
}
?>

<h1>Create An Account</h1>

<form id="pwForm" action="register.php" method="post">
    <label for="username">Username:</label>
    <input type="text" name="username" id="username" required>
    <label for="password">Password:</label>
    <input type="password" name="password" id="password" required>
    <input type="submit" value="Register">
</form>
