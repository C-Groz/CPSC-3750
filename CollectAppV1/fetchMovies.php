<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json');

// Include the Composer autoloader
require '../vendor/autoload.php';

// Create a new Guzzle client
$client = new \GuzzleHttp\Client();

// Make the GET request to the API
$response = $client->request('GET', 'https://api.themoviedb.org/3/search/movie?query=reach&include_adult=false&language=en-US&page=10', [
    'headers' => [
        'Authorization' => 'Bearer eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiI4M2E1MmQ3YzI4NTNiOWRlMDY2YWFiNDdlNWYzMDNjNSIsIm5iZiI6MTc0MzM0NTEzMy45NDksInN1YiI6IjY3ZTk1NWVkMmNjYTZmYzhmYmM2YmUxNSIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.u3olDlLJQMRyr9WKiQ-qqfsYkI_u759xVlyLHkyGt-w', 
        'accept' => 'application/json',
    ]
]);

// Output the raw response body
echo $response->getBody();
?>
