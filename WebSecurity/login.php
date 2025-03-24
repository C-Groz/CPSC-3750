<head>
    <title>Web Security</title>
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
</script>

<?php
session_start();

if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
    header("Location: dashboard.php");
    exit;
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $username = 'admin';
    $password = 'password123';

    if(htmlspecialchars($_POST['username']) == $username && htmlspecialchars($_POST['password']) == $password){
        session_regenerate_id(true);
        $_SESSION['loggedin'] = true;
        header("Location: dashboard.php");
        exit;
    }else{
        echo "Invalid username or password";
    }
}

?>

<form action="login.php" method="post">
    <label for="username">Username:</label>
    <input type="text" name="username" id="username" required>
    <label for="password">Password:</label>
    <input type="password" name="password" id="password" required>
    <input type="submit" value="login">
</form>


