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

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("Location: login.php");
    exit;
}
?>

<h1>Welcome User!</h1>
<br>
<a href="logout.php">Log Out</a>