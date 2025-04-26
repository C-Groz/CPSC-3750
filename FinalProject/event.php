<!DOCTYPE html>
<html>
<head>
  <title>Show/Add Events</title>
</head>
<body>
  <h1>Show/Add Events</h1>
  <?php
  error_reporting(E_ALL);
  ini_set('display_errors', 1);
  session_start();
  if(!isset($_SESSION['user_id'])){
	echo "You must be logged in to add an event.";
	exit;
  }

  $mysqli = mysqli_connect("localhost", "u461793670_groz", "dykde3-fyrCyd-nyfbic", "u461793670_prog_db");

  $user_id = $_SESSION['user_id'];

  //add any new event
  if ($_POST) {
	//create database-safe strings
	$safe_m = mysqli_real_escape_string($mysqli, $_POST['m']);
	$safe_d = mysqli_real_escape_string($mysqli, $_POST['d']);
	$safe_y = mysqli_real_escape_string($mysqli, $_POST['y']);
	$safe_event_title = mysqli_real_escape_string($mysqli, $_POST['event_title']);
	$safe_event_shortdesc = mysqli_real_escape_string($mysqli, $_POST['event_shortdesc']);
	$safe_event_time_hh = mysqli_real_escape_string($mysqli, $_POST['event_time_hh']);
	$safe_event_time_mm = mysqli_real_escape_string($mysqli, $_POST['event_time_mm']);
  $safe_category = mysqli_real_escape_string($mysqli, $_POST['category']);
  $safe_recurrence = mysqli_real_escape_string($mysqli, $_POST['recurrence']);
  $safe_recurrence_end_date = mysqli_real_escape_string($mysqli, $_POST['recurrence_end_date']);

  $image_filename = NULL; 

  if (isset($_FILES['event_image']) && $_FILES['event_image']['error'] == 0) {
    $allowed_types = array('image/jpeg', 'image/png', 'image/gif');
    
    if (in_array($_FILES['event_image']['type'], $allowed_types)) {
      $upload_dir = 'uploads/';
      if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0777, true);
      }
      $image_filename = basename($_FILES['event_image']['name']);
      $target_path = $upload_dir . $image_filename;
      move_uploaded_file($_FILES['event_image']['tmp_name'], $target_path);
    }
  }

	$event_date = $safe_y."-".$safe_m."-".$safe_d." ".$safe_event_time_hh.":".$safe_event_time_mm.":00";

  $insEvent_sql = "INSERT INTO calendar_events (event_title, event_shortdesc, event_start, id, category, event_image) VALUES('".$safe_event_title."', '".$safe_event_shortdesc."', '".$event_date."', '".$user_id."', '".$safe_category."', '".$image_filename."')";
	$insEvent_res = mysqli_query($mysqli, $insEvent_sql) or die(mysqli_error($mysqli));
  
  if($safe_recurrence != 'None'){
    $recurrence_date = strtotime($event_date); 
    $end_date = strtotime($safe_recurrence_end_date);

    // loop through to add recoccuring events
    while ($recurrence_date < $end_date) {
      switch ($safe_recurrence) {
        case 'Daily':
          $recurrence_date = strtotime("+1 day", $recurrence_date);
          break;
        case 'Weekly':
          $recurrence_date = strtotime("+1 week", $recurrence_date);
          break;
        case 'Monthly':
          $recurrence_date = strtotime("+1 month", $recurrence_date);
          break;
      }

      // add recurring event into the database
      $recurring_event_date = date("Y-m-d H:i:s", $recurrence_date);
      $insRecurringEvent_sql = "INSERT INTO calendar_events (event_title, event_shortdesc, event_start, id, category, recurrence, recurrence_end_date, event_image) VALUES ('".$safe_event_title."', '".$safe_event_shortdesc."', '".$recurring_event_date."', '".$user_id."', '".$safe_category."', '".$safe_recurrence."', '".$safe_recurrence_end_date."', '".$image_filename."')";
      $insRecurringEvent_res = mysqli_query($mysqli, $insRecurringEvent_sql) or die(mysqli_error($mysqli));
    }

  /* Close pop-up and reload page after insertion */
  echo "<script>
    window.opener.location.href = 'showcalendar_withevent.php?m=$safe_m&d=$safe_d&y=$safe_y';
    window.close();
  </script>"; 
  exit;
  }

  } else {
	//create database-safe strings
	$safe_m = mysqli_real_escape_string($mysqli, $_GET['m']);
	$safe_d = mysqli_real_escape_string($mysqli, $_GET['d']);
	$safe_y = mysqli_real_escape_string($mysqli, $_GET['y']);
  }


  //show events for this day
  $getEvent_sql = "SELECT event_title, event_shortdesc, category, date_format(event_start, '%l:%i %p') as fmt_date 
                   FROM calendar_events 
                   WHERE month(event_start) = ? 
                   AND dayofmonth(event_start) = ? 
                   AND year(event_start) = ? 
                   AND id = ? 
                   ORDER BY event_start";
  $stmt = mysqli_prepare($mysqli, $getEvent_sql);
  mysqli_stmt_bind_param($stmt, 'iiii', $safe_m, $safe_d, $safe_y, $user_id);
  mysqli_stmt_execute($stmt);
  $getEvent_res = mysqli_stmt_get_result($stmt);

  if(mysqli_num_rows($getEvent_res) > 0){
	$event_txt = "<ul>";
	while ($ev = mysqli_fetch_array($getEvent_res)) {
		$event_title = stripslashes($ev['event_title']);
		$event_shortdesc = stripslashes($ev['event_shortdesc']);
		$fmt_date = $ev['fmt_date'];
    $category = $ev['category'];
    $event_txt .= "<li><strong>".$fmt_date."</strong>: ".$event_title." (<em>".$category."</em>)<br>".$event_shortdesc."</li>";
	}
	$event_txt .= "</ul>";
	mysqli_free_result($getEvent_res);
  }else{
	$event_txt = "";
  }

  // close connection to MySQL
  mysqli_close($mysqli);

  if ($event_txt != "") {
	echo "<p><strong>Today's Events:</strong></p>
	$event_txt
	<hr>";
  }

  // show form for adding an event
  echo <<<END_OF_TEXT
<form method="post" action="$_SERVER[PHP_SELF]" enctype="multipart/form-data">
<p><strong>Would you like to add an event?</strong><br>
Complete the form below and press the submit button to add the event and refresh this window.</p>

<p><label for="event_title">Event Title:</label><br>
<input type="text" id="event_title" name="event_title" size="25" maxlength="25"></p>

<p><label for="event_shortdesc">Event Description:</label><br>
<input type="text" id="event_shortdesc" name="event_shortdesc" size="25" maxlength="255"></p>

<p><label for="category">Event Category:</label><br>
<select id="category" name="category">
  <option value="Work">Work</option>
  <option value="Personal">Personal</option>
  <option value="School">School</option>
  <option value="Other">other</option>
</select></p>

<p><label for="recurrence">Recurrence:</label><br>
<select name="recurrence">
  <option value="None">None</option>
  <option value="Daily">Daily</option>
  <option value="Weekly">Weekly</option>
  <option value="Monthly">Monthly</option>
</select></p>

<p><label for="recurrence_end_date">End Date (optional):</label><br>
<input type="date" id="recurrence_end_date" name="recurrence_end_date"></p>

<fieldset>
<legend>Event Time (hh:mm):</legend>
<select name="event_time_hh">
END_OF_TEXT;

  for ($x=1; $x <= 24; $x++) {
  	echo "<option value=\"$x\">$x</option>";
  }

  echo <<<END_OF_TEXT
</select> :
<select name="event_time_mm">
<option value="00">00</option>
<option value="15">15</option>
<option value="30">30</option>
<option value="45">45</option>
</select>
</fieldset>
<input type="hidden" name="m" value="$safe_m">
<input type="hidden" name="d" value="$safe_d">
<input type="hidden" name="y" value="$safe_y">

<p><label for="event_image">Upload Image:</label><br>
<input type="file" id="event_image" name="event_image" accept="image/*"><br>
  
<button type="submit" name="submit" value="submit">Add Event</button>
</form>
END_OF_TEXT;
  ?>
</body>
</html>