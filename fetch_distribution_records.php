<?php
include 'db_connection.php';

$sql = "SELECT d.distribution_id, b.batch_name, d.distributed_quantity, d.distribution_date
        FROM distribution_records d
        JOIN batches b ON d.batch_id = b.batch_id";

$result = $conn->query($sql);
$records = [];

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $records[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($records);
$conn->close();
?>
