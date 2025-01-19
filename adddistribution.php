<?php
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $batchId = $_POST['batchId'];
    $distributedQuantity = $_POST['distributedQuantity'];
    $distributedTo = $_POST['distributedTo'];
    $dateDistributed = $_POST['dateDistributed'];

    // Insert distribution record
    $sql = "INSERT INTO distribution_records (batch_id, distributed_quantity, distributed_to, date_distributed)
            VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('siss', $batchId, $distributedQuantity, $distributedTo, $dateDistributed);

    if ($stmt->execute()) {
        // Update remaining quantity in the batch
        $updateSql = "UPDATE distribution_batches SET remaining_quantity = remaining_quantity - ? WHERE batch_id = ?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param('is', $distributedQuantity, $batchId);
        $updateStmt->execute();

        echo json_encode(['success' => true, 'message' => 'Distribution added successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error adding distribution']);
    }

    $stmt->close();
    $conn->close();
}
?>
