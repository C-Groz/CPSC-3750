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
$_SESSION = array();
session_destroy();
header("Location: login.php");
exit;
?>