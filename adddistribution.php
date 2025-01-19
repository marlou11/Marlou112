<?php
include('db_connection.php');
// Database connection (ensure to replace with your actual credentials)
$mysqli = new mysqli('localhost', 'username', 'password', 'database');

// Check for connection errors
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Ensure the batch ID and selected farmers are passed in the request
if (isset($_POST['distributionBatchId']) && isset($_POST['selectedFarmers'])) {
    $batchId = $_POST['distributionBatchId'];
    $distributedQuantity = $_POST['distributedQuantity'];
    $distributionDate = $_POST['distributionDate'];
    $selectedFarmers = $_POST['selectedFarmers'];

    // Update the batch's remaining quantity in the database
    $query = "UPDATE batches SET remaining_quantity = remaining_quantity - ? WHERE batch_id = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('ii', $distributedQuantity, $batchId);
    $stmt->execute();

    // Insert a new distribution record for each selected farmer
    foreach ($selectedFarmers as $farmerId) {
        $query = "INSERT INTO distribution_records (batch_id, farmer_id, distributed_quantity, distribution_date) VALUES (?, ?, ?, ?)";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param('iiis', $batchId, $farmerId, $distributedQuantity, $distributionDate);
        $stmt->execute();
    }

    echo "Distribution record added successfully.";
} else {
    echo "Error: Missing data.";
}

$mysqli->close();
?>
