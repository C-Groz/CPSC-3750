<?php
require_once 'config.php'; 

$link = mysqli_connect(
    $dbConfig['host'],
    $dbConfig['username'],
    $dbConfig['passwd'],
    $dbConfig['dbname']
);

if (!$link) {
    die("Connection failed: " . mysqli_connect_error());
}

// Handle form submission
if (isset($_POST['person'])) {
    $person = mysqli_real_escape_string($link, $_POST['person']);
    $sql = "INSERT INTO person (name) VALUES ('" . $person . "')";
    mysqli_query($link, $sql);
}

// Fetch people from the database
$sql = 'SELECT person_id, name FROM person';
$people = array();

if (mysqli_real_query($link, $sql)) {
    if ($result = mysqli_store_result($link)) {
        while ($row = mysqli_fetch_assoc($result)) {
            $people[$row['person_id']] = $row['name'];
        }
    }
}

mysqli_close($link);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>People</title>
</head>
<body>
    <script>
        fetch("../navbar.html")
            .then(response => response.text())
            .then(data => document.body.insertAdjacentHTML("afterbegin", data));
    </script>
    <style>
      html, body {
        padding-top: 25px;
      }
      h1{
        text-align: center;
      }
    </style>
    <ul>
        <?php foreach ($people as $id => $name): ?>
            <li><a href="<?= $_SERVER['PHP_SELF'] ?>?id=<?= urlencode($id) ?>"><?= htmlspecialchars($name) ?></a></li>
        <?php endforeach; ?>
    </ul>

    <form method="POST" action="<?= $_SERVER['PHP_SELF'] ?>">
        <dl>
            <dt>Add person</dt>
            <dd><input type="text" name="person" required /></dd>
        </dl>
        <input type="submit" name="submit" value="Submit" />
    </form>
</body>
</html>
