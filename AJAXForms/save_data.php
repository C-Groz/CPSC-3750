<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Get the posted data which came from client
  $name = isset($_POST['name']) ? $_POST['name'] : '';
  $age = isset($_POST['age']) ? $_POST['age'] : '';
  $food = isset($_POST['food']) ? $_POST['food'] : '';
  $animal = isset($_POST['animal']) ? $_POST['animal'] : '';
  $color = isset($_POST['color']) ? $_POST['color'] : '';
  $nfl = isset($_POST['nfl']) ? $_POST['nfl'] : '';
  $mlb = isset($_POST['mlb']) ? $_POST['mlb'] : '';
  $nhl = isset($_POST['nhl']) ? $_POST['nhl'] : '';
  $cfb = isset($_POST['cfb']) ? $_POST['cfb'] : '';
  $sport = isset($_POST['sport']) ? $_POST['sport'] : '';


  // prepare data to write to a text file using JSON
  $file = "data.txt";
  $data = array(
     'name' => $name,
     'age' => $age,
     'food' => $food,
     'animal' => $animal,
     'color' => $color,
     'nfl' => $nfl,
     'mlb' => $mlb,
     'nhl' => $nhl,
     'cfb' => $cfb,
     'sport' => $sport,
  );

  // Encode the updated data array to JSON
  $json_data = json_encode($data);

  // Write the JSON data back to the file
  file_put_contents($file, $json_data . PHP_EOL);

  // Redirect back to the index page
  header("Location: forms.html");
  exit();
} else
    echo "Invalid request!";
?>