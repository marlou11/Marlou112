<?php
include 'db_connection.php';

$sql = "SELECT * FROM batches";
$result = $conn->query($sql);
$batches = [];

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $batches[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($batches);
$conn->close();
?>
