<head>
    <title>Log In</title>
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

$mysqli = mysqli_connect("localhost", "u461793670_groz", "dykde3-fyrCyd-nyfbic", "u461793670_prog_db");

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

<form action="login.php" method="post">
    <h2 style="text-align:center;">Log In</h2>
    <p class="instructions">Enter your username and password below.</p>
    <label for="username">Username:</label>
    <input type="text" name="username" id="username" required>
    <label for="password">Password:</label>
    <input type="password" name="password" id="password" required>
    <input type="submit" value="Login">
</form>

