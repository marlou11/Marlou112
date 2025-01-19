<?php
include('db_connection.php');

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    // If connection fails, return a JSON error message
    echo json_encode(["status" => "error", "message" => "Connection failed: " . $conn->connect_error]);
    exit();
}

// Query to fetch batches
$sql = "SELECT batch_id, batch_name, total_quantity, remaining_quantity FROM distribution_batches";
$result = $conn->query($sql);

// Initialize an empty array to store batches
$batches = [];

if ($result->num_rows > 0) {
    // Fetch all batches
    while ($row = $result->fetch_assoc()) {
        $batches[] = $row;
    }
    // Return batches as JSON
    echo json_encode($batches);
} else {
    // If no batches found, return an empty array
    echo json_encode([]);
}

$conn->close();
?>