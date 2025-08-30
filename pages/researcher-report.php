<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tortoise_db"; 

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }

// Add or Edit
if(isset($_POST['action'])) {
    $reportId = $_POST['reportId'];
    $tortoiseId = $_POST['tortoiseId'];
    $date = $_POST['date'];
    $category = $_POST['category'];
    $notes = $_POST['notes'];

    if($_POST['action'] == "add"){
        $stmt = $conn->prepare("INSERT INTO researcher_reports (ReportID, TortoiseID, Date, Category, Notes) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $reportId, $tortoiseId, $date, $category, $notes);
        $stmt->execute();
        $stmt->close();
    } elseif($_POST['action'] == "edit"){
        $stmt = $conn->prepare("UPDATE researcher_reports SET TortoiseID=?, Date=?, Category=?, Notes=? WHERE ReportID=?");
        $stmt->bind_param("sssss", $tortoiseId, $date, $category, $notes, $reportId);
        $stmt->execute();
        $stmt->close();
    }
    header("Location: " . $_SERVER['PHP_SELF']); exit;
}

// Delete
if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM researcher_reports WHERE ReportID=?");
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $stmt->close();
    header("Location: " . $_SERVER['PHP_SELF']); exit;
}

// Fetch all reports
$result = $conn->query("SELECT * FROM researcher_reports ORDER BY Date DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Researcher Reports</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<style>
    body { background:#f4f6f9; }
    .sidebar {
      height:100vh; width:210px; position:fixed; top:0; left:0;
      background:#198754; color:#fff; padding-top:20px;
    }
    .sidebar a { color:#fff; text-decoration:none; padding:10px 20px; display:block; }
    .sidebar a:hover { background:#145c32; }
    .content { margin-left:240px; padding:20px; }
    .note-cell { max-width:420px; white-space:pre-wrap; word-wrap:break-word; }
  </style>
</head>
<body>
  <!-- Sidebar (unchanged UI) -->
  <div class="sidebar">
    <h4 class="text-center mb-4">Researcher</h4>
    <a href="/pages/researcher_dashboard.php">Dashboard</a>
    <a href="#" class="bg-secondary"><i class="bi bi-bug-fill"></i> Tortoise Data</a>
    <a href="/pages/researcher-breeding.php"><i class="bi bi-gender-ambiguous me-2"></i>Breeding</a>
    <a href="/pages/researcher-environment.php"><i class="bi bi-tree"></i>Environment</a>
    <a href="/pages/researcher-report.php"><i class="bi bi-file-earmark-text"></i>Reports</a>
    <a href="/index.php"><i class="bi bi-box-arrow-right"></i>Logout</a>
  </div>

<div class="container mt-4" style="margin-left: 210px;">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="text-center flex-grow-1">Researcher Reports</h2>
    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#reportModal" onclick="openAddModal()">
      Add Report
    </button>
  </div>

  <!-- Reports Table -->
  <table class="table table-bordered table-hover">
    <thead class="table-success">
      <tr>
        <th>Report ID</th>
        <th>Tortoise ID</th>
        <th>Date</th>
        <th>Category</th>
        <th>Notes</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php while($row = $result->fetch_assoc()): ?>
      <tr>
        <td><?= $row['ReportID'] ?></td>
        <td><?= $row['TortoiseID'] ?></td>
        <td><?= $row['Date'] ?></td>
        <td><?= $row['Category'] ?></td>
        <td><?= $row['Notes'] ?></td>
        <td>
          <button class="btn btn-warning btn-sm" 
            onclick="openEditModal('<?= $row['ReportID'] ?>','<?= $row['TortoiseID'] ?>','<?= $row['Date'] ?>','<?= $row['Category'] ?>','<?= $row['Notes'] ?>')">
            <i class="bi bi-pencil"></i>
          </button>
          <a href="?delete=<?= $row['ReportID'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete this report?')">
            <i class="bi bi-trash"></i>
          </a>
        </td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>


<!-- Modal -->
<div class="modal fade" id="reportModal" tabindex="-1">
  <div class="modal-dialog">
    <form class="modal-content" method="post">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title" id="modalTitle">Add Report</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="action" name="action" value="add">
        <div class="mb-3">
          <label>Report ID</label>
          <input type="text" class="form-control" id="reportId" name="reportId" required>
        </div>
        <div class="mb-3">
          <label>Tortoise ID</label>
          <input type="text" class="form-control" id="tortoiseId" name="tortoiseId" required>
        </div>
        <div class="mb-3">
          <label>Date</label>
          <input type="date" class="form-control" id="date" name="date" required>
        </div>
        <div class="mb-3">
          <label>Category</label>
          <input type="text" class="form-control" id="category" name="category" required>
        </div>
        <div class="mb-3">
          <label>Notes</label>
          <textarea class="form-control" id="notes" name="notes" required></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success">Save</button>
      </div>
    </form>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
function openAddModal(){
    document.getElementById('modalTitle').innerText = "Add Report";
    document.getElementById('action').value = "add";
    document.getElementById('reportId').readOnly = false;
    document.getElementById('reportId').value = "";
    document.getElementById('tortoiseId').value = "";
    document.getElementById('date').value = "";
    document.getElementById('category').value = "";
    document.getElementById('notes').value = "";
}

function openEditModal(id, tid, date, category, notes){
    document.getElementById('modalTitle').innerText = "Edit Report";
    document.getElementById('action').value = "edit";
    document.getElementById('reportId').value = id;
    document.getElementById('reportId').readOnly = true;
    document.getElementById('tortoiseId').value = tid;
    document.getElementById('date').value = date;
    document.getElementById('category').value = category;
    document.getElementById('notes').value = notes;
    var modal = new bootstrap.Modal(document.getElementById('reportModal'));
    modal.show();
}
</script>
</body>
</html>
