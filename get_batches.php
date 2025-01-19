<?php
// Include database connection
include 'db_connection.php';
header('Content-Type: application/json');
ini_set('display_errors', 1);
error_reporting(E_ALL);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to fetch batches
$sql = "SELECT batch_id, batch_name, date_created FROM batches";
$result = $conn->query($sql);

$batches = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $batches[] = $row;  // Store each batch's data
    }
}

header('Content-Type: application/json');
echo json_encode($batches);

$conn->close();
?>