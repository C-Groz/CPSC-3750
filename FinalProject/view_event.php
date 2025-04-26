<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
if(!isset($_SESSION['user_id'])){
	echo "You must be logged in to view an event.";
	exit;
}

if(!isset($_GET['id'])){
	echo "No event specified.";
	exit;
}

$mysqli = mysqli_connect("localhost", "u461793670_groz", "dykde3-fyrCyd-nyfbic", "u461793670_prog_db");

$event_id = intval($_GET['id']);
$user_id = $_SESSION['user_id'];

$getEvent_sql = "SELECT event_title, event_shortdesc, category, date_format(event_start, '%W, %M %e, %Y at %l:%i %p') as fmt_date, event_image 
                 FROM calendar_events 
                 WHERE event_id = ? 
                 AND id = ?";
$stmt = mysqli_prepare($mysqli, $getEvent_sql);
mysqli_stmt_bind_param($stmt, 'ii', $event_id, $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if(mysqli_num_rows($result) > 0){
  $event = mysqli_fetch_assoc($result);

  echo "<h1>".$event['event_title']."</h1>";
  echo "<p><strong>Date:</strong> ".$event['fmt_date']."</p>";
  echo "<p><strong>Category:</strong> ".$event['category']."</p>";
  echo "<p>".$event['event_shortdesc']."</p>";

  if (!empty($event['event_image'])) {
    echo "<img src='uploads/".htmlspecialchars($event['event_image'])."' alt='Event Image' style='max-width:100%; height:auto;'>";
  }

} else {
  echo "Event not found.";
}

mysqli_close($mysqli);
?>
