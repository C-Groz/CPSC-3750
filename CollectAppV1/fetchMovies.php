<?php
header('Content-Type: application/json');
require_once('vendor/autoload.php');

$client = new \GuzzleHttp\Client();

$query = isset($_GET['query']) ? $_GET['query'] : '';
$page = isset($_GET['page']) ? $_GET['page'] : 100;

if (empty($query)){
    echo json_encode(["error" => "No query provided"]);
    exit;
}

$response = $client->request('GET', "https://api.themoviedb.org/3/search/movie", [
    'headers' => [
        'Authorization' => 'Bearer eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiI4M2E1MmQ3YzI4NTNiOWRlMDY2YWFiNDdlNWYzMDNjNSIsIm5iZiI6MTc0MzM0NTEzMy45NDksInN1YiI6IjY3ZTk1NWVkMmNjYTZmYzhmYmM2YmUxNSIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.u3olDlLJQMRyr9WKiQ-qqfsYkI_u759xVlyLHkyGt-w',
        'accept' => 'application/json',
    ],
    'query' => [
        'query' => $query,
        'include_adult' => 'false',
        'language' => 'en-US',
        'page' => $page,
    ],
]);

echo $response->getBody();
?>
