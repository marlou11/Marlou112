<?php
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $batchId = $_GET['batchId'];

    $sql = "SELECT * FROM distribution_records WHERE batch_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $batchId);
    $stmt->execute();
    $result = $stmt->get_result();

    $distributions = [];
    while ($row = $result->fetch_assoc()) {
        $distributions[] = $row;
    }

    echo json_encode($distributions);

    $stmt->close();
    $conn->close();
}
?>
