<?php
session_start();
$conn = new mysqli("localhost", "root", "", "tortoise_db");
if ($conn->connect_error) die("DB connection failed: " . $conn->connect_error);

// ✅ Allow only maintenance staff
if (!isset($_SESSION['userId']) || $_SESSION['role'] !== 'maintenance') {
    header("Location: login.php");
    exit();
}

$staffId = $_SESSION['userId']; // userId = StaffID

// Fetch tasks assigned to this maintenance staff
$tasks_sql = "SELECT st.StaffTaskID, t.TaskType, t.Description, 
                     t.EnclosureID, t.ScheduledDate, 
                     st.Status AS StaffTaskStatus, st.AssignedAt
              FROM StaffTasks st
              JOIN Tasks t ON st.TaskID = t.TaskID
              WHERE st.StaffID = ?
              ORDER BY st.AssignedAt DESC";

$stmt = $conn->prepare($tasks_sql);
$stmt->bind_param("s", $staffId);
$stmt->execute();
$tasksResult = $stmt->get_result();

// Mark task as complete
if (isset($_POST['completeTask'])) {
    $taskId = $_POST['taskId'];
    $update = $conn->prepare("UPDATE StaffTasks SET Status='Completed' WHERE StaffTaskID=? AND StaffID=?");
    $update->bind_param("ss", $taskId, $staffId);
    $update->execute();
    header("Location: staff-maintenance.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Maintenance Staff Dashboard</title>
    <link rel="icon" type="image/png" href="/assests/image/logo.jpeg" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
    <style>
        body { background-color: #e9f5ea; }
        .card { margin-bottom: 20px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0,0,0,0.05); padding:15px; }
        .status-pending { background-color: #ffc107; color: #856404; padding: 5px 10px; border-radius: 5px; }
        .status-inprogress { background-color: #0d6efd; color: #fff; padding: 5px 10px; border-radius: 5px; }
        .status-completed { background-color: #198754; color: #fff; padding: 5px 10px; border-radius: 5px; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-success">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold" href="#">Maintenance Staff Dashboard</a>
    <div class="d-flex">
        <a href="/index.php" class="btn btn-outline-light btn-sm">Logout</a>
    </div>
  </div>
</nav>

<div class="container py-4">
    <h3 class="mb-4">My Assigned Maintenance Tasks</h3>
    <div class="row">
        <?php if ($tasksResult->num_rows > 0): ?>
            <?php while($task = $tasksResult->fetch_assoc()): ?>
            <div class="col-md-6 col-lg-4">
                <div class="card">
                    <h5><?= htmlspecialchars($task['Description']) ?></h5>
                    <p><strong>Type:</strong> <?= $task['TaskType'] ?></p>
                    <p><strong>Enclosure:</strong> <?= $task['EnclosureID'] ?></p>
                    <p><strong>Scheduled:</strong> <?= $task['ScheduledDate'] ?></p>
                    <p><strong>Assigned At:</strong> <?= $task['AssignedAt'] ?></p>
                    <span class="<?=
                        strtolower(str_replace(' ','',$task['StaffTaskStatus']))=='pending'?'status-pending':
                        (strtolower(str_replace(' ','',$task['StaffTaskStatus']))=='completed'?'status-completed':'status-inprogress') ?>">
                        <?= $task['StaffTaskStatus'] ?>
                    </span>
                    <?php if($task['StaffTaskStatus'] != 'Completed'): ?>
                    <form method="POST" class="mt-2">
                        <input type="hidden" name="taskId" value="<?= $task['StaffTaskID'] ?>">
                        <button type="submit" name="completeTask" class="btn btn-success btn-sm w-100">Mark Complete</button>
                    </form>
                    <?php endif; ?>
                </div>
            </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No maintenance tasks assigned yet.</p>
        <?php endif; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
