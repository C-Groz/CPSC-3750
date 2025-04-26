<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

$mysqli = mysqli_connect("localhost", "u461793670_groz", "dykde3-fyrCyd-nyfbic", "u461793670_prog_db");

if(!isset($_SESSION['user_id'])){
    echo "You must be logged in to view your account.";
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch user info
$user_sql = "SELECT username, created_at FROM users WHERE id = ?";
$stmt = mysqli_prepare($mysqli, $user_sql);
mysqli_stmt_bind_param($stmt, 'i', $user_id);
mysqli_stmt_execute($stmt);
$user_result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($user_result);

// Fetch user events
$today = date("Y-m-d");
$events_sql = "SELECT event_title, event_start FROM calendar_events WHERE id = ? AND event_start >= ? ORDER BY event_start ASC";
$stmt = mysqli_prepare($mysqli, $events_sql);
mysqli_stmt_bind_param($stmt, 'is', $user_id, $today);
mysqli_stmt_execute($stmt);
$events_result = mysqli_stmt_get_result($stmt);

// Count total events
$count_sql = "SELECT COUNT(*) as total_events FROM calendar_events WHERE id = ?";
$stmt = mysqli_prepare($mysqli, $count_sql);
mysqli_stmt_bind_param($stmt, 'i', $user_id);
mysqli_stmt_execute($stmt);
$count_result = mysqli_stmt_get_result($stmt);
$count_row = mysqli_fetch_assoc($count_result);

mysqli_close($mysqli);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Account</title>
    <style>
        body { 
            margin: 40px; 
        }
        h1, h2 { 
            text-align: center; 
        }
        .section { 
            margin-bottom: 40px; 
        }
        ul { 
            text-align: center;
            padding: 0; 
        }
        li { 
            text-align: center;
            margin: 10px 0; 
        }
        .stats { 
            text-align: center; 
            font-size: 18px; 
        }
    </style>
</head>
<body>

    <h1>Welcome, <?php echo htmlspecialchars($user['username']); ?>!</h1>

    <div class="section">
        <h2>Your Information</h2>
        <p><strong>Username:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
        <p><strong>Member Since:</strong> <?php echo htmlspecialchars(date("F j, Y", strtotime($user['created_at']))); ?></p>
    </div>

    <div class="section">
        <h2>Upcoming Events</h2>
        <?php if(mysqli_num_rows($events_result) > 0): ?>
            <ul>
                <?php while($event = mysqli_fetch_assoc($events_result)): ?>
                    <li>
                        <strong><?php echo htmlspecialchars(date("F j, Y g:i A", strtotime($event['event_start']))); ?></strong> — 
                        <?php echo htmlspecialchars($event['event_title']); ?>
                    </li>
                <?php endwhile; ?>
            </ul>
        <?php else: ?>
            <p>No upcoming events.</p>
        <?php endif; ?>
    </div>

    <div class="section stats">
        <h2>Your Statistics</h2>
        <p><strong>Total Events:</strong> <?php echo $count_row['total_events']; ?></p>
    </div>

</body>
</html>
