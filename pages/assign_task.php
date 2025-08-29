<?php
$conn = new mysqli("localhost", "root", "", "tortoise_db");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $staffId = $_POST['staffId'];
    $taskId = $_POST['taskId'];
    $status = $_POST['status'];
    $assignedAt = $_POST['assignedAt'];

    $sql = "INSERT INTO StaffTasks (StaffID, TaskID, Status, AssignedAt) 
            VALUES ('$staffId', '$taskId', '$status', '$assignedAt')";

    if ($conn->query($sql) === TRUE) {
        header("Location: staff.php?success=1");
        exit;
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
