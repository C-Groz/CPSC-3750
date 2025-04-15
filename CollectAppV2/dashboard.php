<head>
    <title>Dashboard</title>
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
session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("Location: login.php");
    exit;
}
?>

<body>
<h1>Welcome, <?php echo $_SESSION['username']; ?>!</h1>
<a href="logout.php">Log Out</a>

<h1>Search for a Movie</h1>

<form id="movieForm">
    <input type="text" id="movieQuery" placeholder="Enter movie name">
    <input type="number" id="numMovies" placeholder="Enter amount of movies to retrieve">
    <button type="submit">Search</button>
</form>
<div id="results"></div>
<script type="text/javascript" src="collectApp.js"></script>
</body>