<?php
session_start();
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true){
    header("Location: login.php");
    exit;
}
?>

<head>
    <title>Collection</title>
    <link rel="stylesheet" href="collectApp.css">
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
</head>

<body>
    <h1><?php echo $_SESSION['username']; ?>'s Collection</h1>
    <ul id="results"></ul>
    <script src="collection.js"></script>
</body>
