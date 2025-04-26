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
if (isset($_POST['month']) && isset($_POST['year'])) {
    $_SESSION['month'] = $_POST['month'];
    $_SESSION['year'] = $_POST['year'];
}

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("Location: login.php");
    exit;
}
?>

<h1>Welcome, <?php echo $_SESSION['username']; ?>!</h1>
<p>Select a date from the dropdown menu below and press Go! to start.</p>
<p>You can add custom events by clicking the blue date in any box below.<p>
<p>You can edit events by clicking the blue 'edit' button in the event box<p>
<p>You can view events/images by clicking the blue 'view' button in the event box<p>

<h2>Here's your personalized calendar:</h2>
<?php
    include('showcalendar_withevent.php');
    ?>
<br>
<a href="logout.php">Log Out</a>
