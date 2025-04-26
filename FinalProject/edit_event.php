<!DOCTYPE html>
<html>
<head>
  <title>Edit Event</title>
</head>
<body>
  <h1>Edit Event</h1>
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
if(!isset($_SESSION['user_id'])){
    echo "You must be logged in to edit an event.";
    exit;
}

$mysqli = mysqli_connect("localhost", "u461793670_groz", "dykde3-fyrCyd-nyfbic", "u461793670_prog_db");

$user_id = $_SESSION['user_id'];

// get event id
if(!isset($_GET['id']) && !isset($_POST['id'])){
    echo "No event provided";
    exit;
}

// update the event
if ($_POST) {
    $safe_id = mysqli_real_escape_string($mysqli, $_POST['id']);
    $safe_m = mysqli_real_escape_string($mysqli, $_POST['m']);
    $safe_d = mysqli_real_escape_string($mysqli, $_POST['d']);
    $safe_y = mysqli_real_escape_string($mysqli, $_POST['y']);
    $safe_event_title = mysqli_real_escape_string($mysqli, $_POST['event_title']);
    $safe_event_shortdesc = mysqli_real_escape_string($mysqli, $_POST['event_shortdesc']);
    $safe_event_time_hh = mysqli_real_escape_string($mysqli, $_POST['event_time_hh']);
    $safe_event_time_mm = mysqli_real_escape_string($mysqli, $_POST['event_time_mm']);
    $safe_category = mysqli_real_escape_string($mysqli, $_POST['category']);

    $event_date = $safe_y."-".$safe_m."-".$safe_d." ".$safe_event_time_hh.":".$safe_event_time_mm.":00";

    $update_sql = "UPDATE calendar_events 
        SET event_title = '$safe_event_title', 
            event_shortdesc = '$safe_event_shortdesc', 
            event_start = '$event_date', 
            category = '$safe_category'
        WHERE id = '$user_id' AND event_id = '$safe_id'";

    mysqli_query($mysqli, $update_sql) or die(mysqli_error($mysqli));
  
    echo "<script>
        window.opener.location.href = 'dashboard.php?m=$safe_m&d=$safe_d&y=$safe_y';
        window.close();
    </script>";
    exit;
} else {
    $safe_id = mysqli_real_escape_string($mysqli, $_GET['id']);

    $getEvent_sql = "SELECT event_id, event_title, event_shortdesc, category, event_start
                    FROM calendar_events
                    WHERE id = ? AND event_id = ?";
    $stmt = mysqli_prepare($mysqli, $getEvent_sql);
    mysqli_stmt_bind_param($stmt, 'ii', $user_id, $safe_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) < 1) {
        echo "Event not found.";
        exit;
    }

    $event = mysqli_fetch_assoc($result);

    $timestamp = strtotime($event['event_start']);
    $safe_m = date('n', $timestamp);
    $safe_d = date('j', $timestamp);
    $safe_y = date('Y', $timestamp);
    $event_time_hh = date('G', $timestamp); 
    $event_time_mm = date('i', $timestamp);

    mysqli_free_result($result);
}

mysqli_close($mysqli);
?>

<!-- Display Form -->
<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
<p><label for="event_title">Event Title:</label><br>
<input type="text" id="event_title" name="event_title" size="25" maxlength="25" value="<?php echo htmlspecialchars($event['event_title']); ?>"></p>

<p><label for="event_shortdesc">Event Description:</label><br>
<input type="text" id="event_shortdesc" name="event_shortdesc" size="25" maxlength="255" value="<?php echo htmlspecialchars($event['event_shortdesc']); ?>"></p>

<p><label for="category">Event Category:</label><br>
<select id="category" name="category">
  <option value="Work" <?php if ($event['category'] == "Work") echo "selected"; ?>>Work</option>
  <option value="Personal" <?php if ($event['category'] == "Personal") echo "selected"; ?>>Personal</option>
  <option value="School" <?php if ($event['category'] == "School") echo "selected"; ?>>School</option>
  <option value="Other" <?php if ($event['category'] == "Other") echo "selected"; ?>>Other</option>
</select></p>

<fieldset>
<legend>Event Time (hh:mm):</legend>
<select name="event_time_hh">
<?php
for ($x=0; $x <= 23; $x++) {
    echo "<option value=\"$x\"";
    if ($x == $event_time_hh) echo " selected";
    echo ">$x</option>";
}
?>
</select> :
<select name="event_time_mm">
  <option value="00" <?php if ($event_time_mm == "00") echo "selected"; ?>>00</option>
  <option value="15" <?php if ($event_time_mm == "15") echo "selected"; ?>>15</option>
  <option value="30" <?php if ($event_time_mm == "30") echo "selected"; ?>>30</option>
  <option value="45" <?php if ($event_time_mm == "45") echo "selected"; ?>>45</option>
</select>
</fieldset>

<input type="hidden" name="id" value="<?php echo $event['event_id']; ?>">
<input type="hidden" name="m" value="<?php echo $safe_m; ?>">
<input type="hidden" name="d" value="<?php echo $safe_d; ?>">
<input type="hidden" name="y" value="<?php echo $safe_y; ?>">

<button type="submit" name="submit" value="submit">Update Event</button>
</form>

</body>
</html>
