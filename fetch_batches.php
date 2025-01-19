<?php
include 'db_connection.php';

header('Content-Type: application/json');

$conn = new mysqli('localhost', 'root', '', 'arms_db');

if ($conn->connect_error) {
    die(json_encode(['success' => false, 'error' => 'Database connection failed']));
}

$sql = "SELECT batch_name, batch_number, total_quantity FROM batches";
$result = $conn->query($sql);

$batches = [];
while ($row = $result->fetch_assoc()) {
    $batches[] = $row;
}

echo json_encode($batches);

$conn->close();
?>