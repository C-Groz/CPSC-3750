<?php
session_start();

// Connect db
$mysqli = mysqli_connect("localhost", "u461793670_groz", "DatabasePW123|", "u461793670_prog_db");

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    
    // Hash PW
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $sql);

    // Ensure no duplicates
    if(mysqli_num_rows($result) > 0){
        echo "Username already taken";
    }else{
        $sql = "INSERT INTO users (username, password) VALUES ('$username', '$hashed_password')";
        if(mysqli_query($conn, $sql)){
            echo "User registered successfully! <a href='login.php'>Login now</a>";
        }else{
            echo "Error: " . mysqli_error($conn);
        }
    }
}
?>

<form action="register.php" method="post">
    <label for="username">Username:</label>
    <input type="text" name="username" id="username" required>
    <label for="password">Password:</label>
    <input type="password" name="password" id="password" required>
    <input type="submit" value="Register">
</form>
