<?php
// Read JSON data from the text file
$file = "data.txt";
$json_data = file_get_contents($file);

// Decode JSON data into an associative array
$data_array = json_decode($json_data, true);

// Extract name and age from the data
$name = isset($data_array['name']) ? $data_array['name'] : '';
$age = isset($data_array['age']) ? $data_array['age'] : '';
$food = isset($data_array['food']) ? $data_array['food'] : '';
$animal = isset($data_array['animal']) ? $data_array['animal'] : '';
$color = isset($data_array['color']) ? $data_array['color'] : '';
$nfl = isset($data_array['nfl']) ? $data_array['nfl'] : '';
$mlb = isset($data_array['mlb']) ? $data_array['mlb'] : '';
$nhl = isset($data_array['nhl']) ? $data_array['nhl'] : '';
$cfb = isset($data_array['cfb']) ? $data_array['cfb'] : '';
$sport = isset($data_array['sport']) ? $data_array['sport'] : '';


// Create an associative array to hold the extracted data
$data = array('name' => $name, 'age' => $age, 'food' => $food, 'animal' => $animal, 'color' => $color, 'nfl' => $nfl, 'mlb' => $mlb, 'nhl' => $nhl, 'cfb' => $cfb, 'sport' => $sport);

// Send the data back to the client as JSON
header('Content-Type: application/json');
echo json_encode($data);
?>

