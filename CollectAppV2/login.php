<head>
    <title>Log In</title>
</head>
<style>
    body, html{
        margin-top: 30px;
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

$mysqli = mysqli_connect("localhost", "u461793670_cg", "jipdyr-kitwyv-0hujKi", "u461793670_collect");

if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
    header("Location: dashboard.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $username = mysqli_real_escape_string($mysqli, $_POST['username']);
    $password = mysqli_real_escape_string($mysqli, $_POST['password']);
    
    $sql = "SELECT id, username, password FROM users WHERE username = '$username'";
    $result = mysqli_query($mysqli, $sql);
    
    if($result && mysqli_num_rows($result) > 0){
        $user = mysqli_fetch_assoc($result);
        
        if(password_verify($password, $user['password'])){
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $user['username'];
            $_SESSION['user_id'] = $user['id'];
            header("Location: dashboard.php");
            exit;
        }else{
            echo "Invalid username or password";
        }
    }else{
        echo "Invalid username or password";
    }
}
?>

<form id="pwForm" action="login.php" method="post">
    <label for="username">Username:</label>
    <input type="text" name="username" id="username" required>
    <label for="password">Password:</label>
    <input type="password" name="password" id="password" required>
    <input type="submit" value="Login">
</form>

