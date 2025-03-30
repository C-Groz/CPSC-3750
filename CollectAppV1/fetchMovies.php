<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json');

require '../vendor/autoload.php';

$query = isset($_GET['query']) ? $_GET['query'] : '';
$apiKey = 'd73d06ff';

$client = new \GuzzleHttp\Client();


$response = $client->request('GET', 'http://www.omdbapi.com/', [
    'query' => [
        'apikey' => $apiKey,  
        's' => $query,       
        'type' => 'movie',    
    ]
]);


echo $response->getBody();
?>
