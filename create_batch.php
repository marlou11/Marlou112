<?php
// Include database connection
include('db_connection.php');

// Check if the required POST data is available
if (isset($_POST['batchName']) && isset($_POST['totalQuantity']) && isset($_POST['batchNumber'])) {
    $batchName = $_POST['batchName'];
    $totalQuantity = $_POST['totalQuantity'];
    $batchNumber = $_POST['batchNumber'];

    // Prepare the SQL statement to insert the new batch
    $sql = "INSERT INTO batches (batch_name, total_quantity, batch_number) 
            VALUES (?, ?, ?)";

    // Prepare the statement
    if ($stmt = $conn->prepare($sql)) {
        // Bind parameters
        $stmt->bind_param("sis", $batchName, $totalQuantity, $batchNumber); // s = string, i = integer

        // Execute the statement
        if ($stmt->execute()) {
            // Send success response
            echo json_encode([
                "status" => "success",
                "message" => "Batch created successfully"
            ]);
        } else {
            // Error creating batch
            echo json_encode([
                "status" => "error",
                "message" => "Failed to create batch"
            ]);
        }

        // Close the statement
        $stmt->close();
    } else {
        // Error preparing the query
        echo json_encode([
            "status" => "error",
            "message" => "Database error: " . $conn->error
        ]);
    }
} else {
    // Required data is missing
    echo json_encode([
        "status" => "error",
        "message" => "Required data missing!"
    ]);
}

// Close the database connection
$conn->close();
?>
