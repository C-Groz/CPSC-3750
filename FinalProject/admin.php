<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

$mysqli = mysqli_connect("localhost", "u461793670_groz", "dykde3-fyrCyd-nyfbic", "u461793670_prog_db");

// Check if user is logged as the admin (or professor wooster)
if (!isset($_SESSION['loggedin']) || !($_SESSION['username'] == 'admin' || $_SESSION['username'] == 'dan@demo.com')) {
    header("Location: login.php");
    exit;
}

// Handle delete
if (isset($_GET['delete'])) {
    $delete_id = intval($_GET['delete']);
    
    $check = mysqli_query($mysqli, "SELECT username FROM users WHERE id = $delete_id");
    $user = mysqli_fetch_assoc($check);
    
    if ($user && $user['username'] !== 'admin') {
        mysqli_query($mysqli, "DELETE FROM users WHERE id = $delete_id");
        header("Location: admin.php");
        exit;
    } else {
        echo "<p>Cannot delete the admin account</p>";
    }
}

// fetch all users
$result = mysqli_query($mysqli, "SELECT id, username, created_at FROM users ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <style>
        body, html {
            margin-top: 30px;
        }
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 20px;
        }
        table {
            margin: 0 auto;
            width: 80%;
        }
        th, td {
            padding: 10px;
            border: 1px solid black;
        }
        th {
            background-color:rgb(255, 255, 255);
        }
        a.delete-btn {
            color: red;
            text-decoration: none;
        }
    </style>
</head>
<script>
    fetch("../navbar.html")
        .then(response => response.text())
        .then(data => document.body.insertAdjacentHTML("afterbegin", data));
    fetch("nav.html")
        .then(response => response.text())
        .then(data => document.body.insertAdjacentHTML("afterbegin", data));
</script>
<body>

<h1>Admin Dashboard</h1>
<p>Welcome, admin!</p>

<table>
    <tr>
        <th>ID</th>
        <th>Username</th>
        <th>Created At</th>
        <th>Action</th>
    </tr>
    <?php while($user = mysqli_fetch_assoc($result)): ?>
    <tr>
        <td><?php echo htmlspecialchars($user['id']); ?></td>
        <td><?php echo htmlspecialchars($user['username']); ?></td>
        <td><?php echo htmlspecialchars($user['created_at']); ?></td>
        <td>
            <?php if($user['username'] !== 'admin'): ?>
                <a class="delete-btn" href="admin.php?delete=<?php echo $user['id']; ?>" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
            <?php else: ?>
                (protected)
            <?php endif; ?>
        </td>
    </tr>
    <?php endwhile; ?>
</table>
<a href="logout.php">Log Out</a>
</body>
</html>
