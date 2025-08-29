<?php
$conn = new mysqli("localhost", "root", "", "tortoise_db");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

// Fetch all staff
$staff_sql = "SELECT * FROM Staff ORDER BY CreatedAt DESC";
$staff_result = $conn->query($staff_sql);

// Fetch all assigned tasks joined with staff and task info
$tasks_sql = "SELECT st.StaffTaskID, s.StaffID, s.Name, s.Role,
              t.TaskType, t.Description, t.EnclosureID, t.ScheduledDate, t.Status as TaskStatus,
              st.AssignedAt, st.Status as StaffTaskStatus
              FROM StaffTasks st
              JOIN Staff s ON st.StaffID = s.StaffID
              JOIN Tasks t ON st.TaskID = t.TaskID
              ORDER BY st.AssignedAt DESC";
$tasks_result = $conn->query($tasks_sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Staff Management - Tortoise Center</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<style>
body { background-color: #f4f6f9; }
.table-responsive { background: white; border-radius: 10px; padding: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
.status-pending { color: #ffc107; font-weight: 600; }
.status-completed { color: #198754; font-weight: 600; }
.status-inprogress { color: #0d6efd; font-weight: 600; }
</style>
</head>
<body>
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <a href="/pages/admin.php" class="btn btn-outline-success"><i class="bi bi-arrow-left-circle"></i> Dashboard</a>
        <h3 class="text-success"><i class="bi bi-people-fill"></i> Staff & Assignments</h3>
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#assignTaskModal">
            <i class="bi bi-plus-circle"></i> Assign Task
        </button>
    </div>

    <!-- Staff Tasks Table -->
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-success">
                <tr>
                    <th>Staff Name</th>
                    <th>Role</th>
                    <th>Task</th>
                    <th>Task Type</th>
                    <th>Enclosure</th>
                    <th>Scheduled Date</th>
                    <th>Assigned At</th>
                    <th>Task Status</th>
                </tr>
            </thead>
            <tbody>
            <?php
            if ($tasks_result->num_rows > 0) {
                while ($row = $tasks_result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['Name']}</td>
                            <td>{$row['Role']}</td>
                            <td>{$row['Description']}</td>
                            <td>{$row['TaskType']}</td>
                            <td>{$row['EnclosureID']}</td>
                            <td>{$row['ScheduledDate']}</td>
                            <td>{$row['AssignedAt']}</td>
                            <td><span class='status-".strtolower(str_replace(" ","",$row['StaffTaskStatus']))."'>".$row['StaffTaskStatus']."</span></td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='8' class='text-center'>No tasks assigned yet.</td></tr>";
            }
            ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Assign Task Modal -->
<div class="modal fade" id="assignTaskModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="assign_task.php" method="POST">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">Assign Task to Staff</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="staffId" class="form-label">Staff</label>
                            <select name="staffId" id="staffId" class="form-select" required>
                                <option value="">Select Staff</option>
                                <?php
                                $staff_result->data_seek(0); // reset pointer
                                while ($staff = $staff_result->fetch_assoc()) {
                                    echo "<option value='{$staff['StaffID']}'>{$staff['Name']} ({$staff['Role']})</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="taskId" class="form-label">Task</label>
                            <select name="taskId" id="taskId" class="form-select" required>
                                <option value="">Select Task</option>
                                <?php
                                $task_sql = "SELECT * FROM Tasks";
                                $task_result2 = $conn->query($task_sql);
                                while ($task = $task_result2->fetch_assoc()) {
                                    echo "<option value='{$task['TaskID']}'>{$task['TaskType']} - {$task['Description']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" id="status" class="form-select" required>
                                <option value="Pending">Pending</option>
                                <option value="In Progress">In Progress</option>
                                <option value="Completed">Completed</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="assignedAt" class="form-label">Assigned At</label>
                            <input type="datetime-local" name="assignedAt" id="assignedAt" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Assign Task</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
