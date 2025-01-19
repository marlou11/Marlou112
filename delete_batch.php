<?php
// Include your database connection file (adjust the path as needed)
include 'db_connection.php';

// Get the raw POST data
$inputData = file_get_contents('php://input');
$data = json_decode($inputData, true);

// Check if batchIds are passed in the request
if (isset($data['batchIds']) && is_array($data['batchIds'])) {
    $batchIds = $data['batchIds'];

    // Prepare the placeholders for the SQL query (to handle multiple batch IDs)
    $placeholders = implode(',', array_fill(0, count($batchIds), '?'));

    // Prepare the SQL query to delete batches based on IDs
    $sql = "DELETE FROM batches WHERE id IN ($placeholders)";

    // Prepare the statement
    if ($stmt = $conn->prepare($sql)) {
        // Bind the batch IDs to the prepared statement
        $stmt->bind_param(str_repeat('i', count($batchIds)), ...$batchIds);

        // Execute the statement
        if ($stmt->execute()) {
            // Return success response
            echo json_encode(['success' => true, 'message' => 'Batches deleted successfully.']);
        } else {
            // Return error if something went wrong
            echo json_encode(['success' => false, 'message' => 'Failed to delete batches.']);
        }

        // Close the statement
        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to prepare the SQL query.']);
    }

} else {
    // If no batch IDs are provided
    echo json_encode(['success' => false, 'message' => 'No batch IDs provided.']);
}

// Close the database connection
$conn->close();
?>
