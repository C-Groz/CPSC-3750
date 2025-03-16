<?php
$filename = "zipcodes.txt";
$content = file_get_contents($filename);

if($content !== false){
    $rows = explode("\n", trim($content));
    $data = [];

    foreach($rows as $line){
        $parts = explode(",", trim($line));
        $zipcode = $parts[0];
        $latitude = floatval($parts[1]);
        $longitude = floatval($parts[2]);
        $data[$zipcode] = ["latitude" => $latitude, "longitude" => $longitude];
    }

    header('Content-Type: application/json');
    echo json_encode($data);
}else{
    echo json_encode(["error" => "Failed to read file"]);
}
?>
