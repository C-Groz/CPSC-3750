<?php
require_once 'config.php'; 

$link = mysqli_connect(
    $dbConfig['host'],
    $dbConfig['username'],
    $dbConfig['passwd'],
    $dbConfig['dbname']
);

if (isset($_POST['person'])) {
    $person = mysqli_real_escape_string($link, $_POST['person']);
    $sql = "INSERT INTO person (name) VALUES ('" . $person . "')";
    mysqli_query($link, $sql);
}

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

    <h1>Simple Database</h1>

    <form method="POST" action="<?= $_SERVER['PHP_SELF'] ?>">
        <dl>
            <dt>Add person</dt>
            <dd><input type="text" name="person" required /></dd>
        </dl>
        <input type="submit" name="submit" value="Submit" />
    </form>
    <h2>Database Items:</h2>
    <ul>
        <?php foreach ($people as $name): ?>
            <li><?= htmlspecialchars($name) ?></li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
