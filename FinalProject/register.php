<head>
    <title>Register</title>
</head>
<style>
    body, html{
        margin-top: 30px;
    }
    body {
        font-family: Arial, sans-serif;
        margin: 50px;
    }
    form {
        max-width: 300px;
        margin: auto;
    }
    label, input {
        display: block;
        width: 100%;
        margin-bottom: 10px;
    }
    input[type="submit"] {
        background: #4CAF50;
        color: white;
        border: none;
        padding: 10px;
        cursor: pointer;
    }
    input[type="submit"]:hover {
        background: #45a049;
    }
    .instructions {
        text-align: center;
        margin-bottom: 20px;
    }
</style>
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
$mysqli = mysqli_connect("localhost", "u461793670_groz", "dykde3-fyrCyd-nyfbic", "u461793670_prog_db");

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

<form action="register.php" method="post">
    <h2 style="text-align:center;">Register</h2>
    <p class="instructions">Enter a unique username and password below. Then follow instructions to login</p>
    <label for="username">Username:</label>
    <input type="text" name="username" id="username" required>
    <label for="password">Password:</label>
    <input type="password" name="password" id="password" required>
    <input type="submit" value="Register">
</form>
