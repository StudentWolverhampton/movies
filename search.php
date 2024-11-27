<?php
include('db.php');

// Get search term from the AJAX request
$search_term = isset($_GET['query']) ? $conn->real_escape_string($_GET['query']) : '';

$sql = "SELECT * FROM movies WHERE Movie_name LIKE '%$search_term%' LIMIT 10";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $movies = [];
    while ($row = $result->fetch_assoc()) {
        $movies[] = $row;
    }
    echo json_encode($movies);
} else {
    echo json_encode([]);
}
$conn->close();