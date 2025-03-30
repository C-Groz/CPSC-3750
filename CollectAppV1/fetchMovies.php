<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json');

require '../vendor/autoload.php';

$query = isset($_GET['query']) ? $_GET['query'] : '';

$client = new \GuzzleHttp\Client();


$response = $client->request('GET', 'https://api.themoviedb.org/3/search/movie', [
    'query' => [
        'query' => $query,
        'include_adult' => false,
        'language' => 'en-US',
        'page' => 1,
    ],
    'headers' => [
        'Authorization' => 'Bearer eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiI4M2E1MmQ3YzI4NTNiOWRlMDY2YWFiNDdlNWYzMDNjNSIsIm5iZiI6MTc0MzM0NTEzMy45NDksInN1YiI6IjY3ZTk1NWVkMmNjYTZmYzhmYmM2YmUxNSIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.u3olDlLJQMRyr9WKiQ-qqfsYkI_u759xVlyLHkyGt-w',
        'Accept' => 'application/json',
    ]
]);

echo $response->getBody();
?>
