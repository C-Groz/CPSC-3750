
<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

define("ADAY", (60*60*24));
if (!isset($_SESSION['user_id'])) {
  die("User not logged in. Please log in.");
}
if (isset($_SESSION['month']) && isset($_SESSION['year'])) {
  $month = $_SESSION['month'];
  $year = $_SESSION['year'];
} else {
  $nowArray = getdate();
  $month = $nowArray['mon'];
  $year = $nowArray['year'];
}

$start = mktime (12, 0, 0, $month, 1, $year);
$firstDayArray = getdate($start);
$user_id = $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html>
<head>
<title><?php echo "Calendar: ".$firstDayArray['month']." ".$firstDayArray['year']; ?></title>
<style type="text/css">
  h2 {
    font-size: 16pt;
  }
  body {
    font-family: Arial, sans-serif;
    text-align: center;
  }
  table {
    border: 2px solid #333;
    border-collapse: collapse;
    margin: 20px auto; 
    width: 90%; 
    max-width: 1200px;
    background: #f9f9f9;
  }
  th {
    border: 1px solid #333;
    padding: 12px;
    font-weight: bold;
    background: #666;
    color: #fff;
  }
  td {
    border: 1px solid #999;
    padding: 12px;
    vertical-align: top;
    height: 120px;
    width: 14.28%;
    background: #fff;
    position: relative;
  }
  .event-box {
    border: 1px solid #666;
    padding: 4px;
    margin-top: 6px;
    border-radius: 6px;
    font-size: small;
    text-align: left;
  }

  /* Category Colors - work, personal, school, other */
  .event-box.work {
    background-color:rgb(136, 184, 234); 
  }
  .event-box.personal {
    background-color:rgb(224, 95, 140); 
  }
  .event-box.school {
    background-color:rgb(203, 148, 21); 
  }
  .event-box.other {
    background-color:rgb(111, 255, 116); 
  }
  a {
    text-decoration: none;
    color: #007bff;
  }
</style>
</head>
<body>
  <form method="post" action="dashboard.php">
  <select name="month">
    <?php
    $months = Array("January", "February", "March", "April", "May",  "June", "July", "August", "September", "October", "November", "December");
    for ($x=1; $x <= count($months); $x++) {
    	echo"<option value=\"$x\"";
  	    if ($x == $month) {
   	      echo " selected";
  	    }
	    echo ">".$months[$x-1]."</option>";
    }
    ?>
    </select>
    <select name="year">
    <?php
    for ($x=1990; $x<=2030; $x++) {
    	echo "<option";
    	if ($x == $year) {
    		echo " selected";
    	}
    	echo ">$x</option>";
    }
    ?>
    </select>
    <button type="submit" name="submit" value="submit">Go!</button>
    </form>
    <br>
    <?php
    $days = Array("Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat");
    echo "<table><tr>\n";
    foreach ($days as $day) {
	  echo "<th>".$day."</th>\n";
    }
    for ($count=0; $count < (6*7); $count++) {
	  $dayArray = getdate($start);
	  if (($count % 7) == 0) {
        if ($dayArray['mon'] != $month) {
			break;
		} else {
			echo "</tr><tr>\n";
		}
      }
      if ($count < $firstDayArray['wday'] || $dayArray['mon'] != $month) {
	    echo "<td>&nbsp;</td>\n";
	  } else {
		 $event_title = "";
     $mysqli = mysqli_connect("localhost", "u461793670_groz", "dykde3-fyrCyd-nyfbic", "u461793670_prog_db");
		 $getEvent_sql = "SELECT event_id, event_title, event_shortdesc, date_format(event_start, '%l:%i %p') as fmt_date, category
                             FROM calendar_events 
                             WHERE month(event_start) = ? 
                             AND dayofmonth(event_start) = ? 
                             AND year(event_start) = ? 
                             AND id = ? 
                             ORDER BY event_start";
     $stmt = mysqli_prepare($mysqli, $getEvent_sql);
     mysqli_stmt_bind_param($stmt, 'iiii', $month, $dayArray['mday'], $year, $user_id);
     mysqli_stmt_execute($stmt);
     $result = mysqli_stmt_get_result($stmt);

		 if (mysqli_num_rows($result) > 0) {
			  while ($ev = mysqli_fetch_array($result)) {
          $event_category = strtolower($ev['category']);
          $event_box_class = "event-box " . $event_category;
          $event_title .= "<div class='$event_box_class'>"
                  . htmlspecialchars(stripslashes($ev['event_title'])) . "<br>"
                  . "<a href=\"javascript:editWindow('edit_event.php?id=" . $ev['event_id'] . "')\" style='font-size:x-small;'>Edit</a>"
                  . "<a href=\"javascript:viewWindow('view_event.php?id=" . $ev['event_id'] . "')\" style='font-size:x-small;'>View</a>"
                  . "</div>";
			  }
		 } else {
			  $event_title = "";
		 }

		 echo "<td><a href=\"javascript:eventWindow('event.php?m=".$month.
		 "&amp;d=".$dayArray['mday']."&amp;y=$year');\">".$dayArray['mday']."</a>
		 <br>".$event_title."</td>\n";

		 unset($event_title);

		 $start += ADAY;
	  }
    }
    echo "</tr></table>";

    //close connection to MySQL
    mysqli_close($mysqli);
    ?>

  <script type="text/javascript">
  function eventWindow(url) {
      event_popupWin = window.open(url, 'event', 'resizable=yes, scrollbars=yes, toolbar=no,width=400,height=400');
     event_popupWin.opener = self;
  }
  function editWindow(url) {
    edit_popupWin = window.open(url, 'edit', 'resizable=yes, scrollbars=yes, toolbar=no, width=500, height=500');
    edit_popupWin.opener = self;
  }
  function viewWindow(url) {
    edit_popupWin = window.open(url, 'view', 'resizable=yes, scrollbars=yes, toolbar=no, width=500, height=500');
    edit_popupWin.opener = self;
  }
  </script>

</body>
</html>