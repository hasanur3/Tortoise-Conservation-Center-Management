<?php
// vet_health_records.php
session_start();
$conn = new mysqli("localhost", "root", "", "tortoise_db");
if ($conn->connect_error) die("DB connection failed: " . $conn->connect_error);

// Handle form submission (Add/Edit)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['healthId'] ?? null;
    $tortoiseID = $_POST['tortoiseID'];
    $date = $_POST['assessmentDate'];
    $status = $_POST['healthStatus'];
    $obs = $_POST['observations'];
    $comments = $_POST['vetComments'];

    if ($id) {
        // Edit
        $stmt = $conn->prepare("UPDATE health_records SET TortoiseID=?, AssessmentDate=?, HealthStatus=?, Observations=?, VetComments=? WHERE HealthID=?");
        $stmt->bind_param("sssssi", $tortoiseID, $date, $status, $obs, $comments, $id);
        $stmt->execute();
    } else {
        // Add
        $stmt = $conn->prepare("INSERT INTO health_records (TortoiseID, AssessmentDate, HealthStatus, Observations, VetComments) VALUES (?,?,?,?,?)");
        $stmt->bind_param("sssss", $tortoiseID, $date, $status, $obs, $comments);
        $stmt->execute();
    }
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Handle delete
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM health_records WHERE HealthID=" . (int)$id);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Fetch records
$result = $conn->query("SELECT * FROM health_records ORDER BY AssessmentDate DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Health Records - Veterinarian</title>
<link rel="icon" href="/assests/image/logo.jpeg">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<style>
/* Sidebar and main content styles same as your HTML */
body {background-color:#e9f5ea;}
.sidebar{height:100vh;background-color:#198754;color:white;position:fixed;width:220px;transition:width 0.3s;overflow-y:auto;}
.sidebar.collapsed{width:70px;}
.sidebar .nav-link{color:white;font-weight:500;padding:12px 20px;white-space:nowrap;}
.sidebar .nav-link:hover,.sidebar .nav-link.active{background-color:#145c32;color:#fff;}
.sidebar .nav-link i{font-size:1.3rem;margin-right:12px;vertical-align:middle;}
.sidebar.collapsed .nav-link span{display:none;}
.sidebar.collapsed .nav-link i{margin-right:0;text-align:center;width:100%;}
main{margin-left:220px;padding:20px;transition:margin-left 0.3s;min-height:100vh;}
main.collapsed{margin-left:70px;}
@media(max-width:768px){.sidebar{position:fixed;left:-220px;z-index:1030}.sidebar.show{left:0}main,main.collapsed{margin-left:0}}
</style>
</head>
<body>

<!-- Sidebar (unchanged) -->
<nav id="sidebar" class="sidebar d-flex flex-column">
  <div class="d-flex align-items-center justify-content-between px-3 py-3 border-bottom border-success">
    <span class="fs-4 fw-bold">Vet Dashboard</span>
    <button id="sidebarCollapse" class="btn btn-sm btn-success d-md-none"><i class="bi bi-x"></i></button>
  </div>
  <ul class="nav flex-column mt-3">
    <li class="nav-item"><a href="veterinarian_dashboard.php" class="nav-link"><i class="bi bi-house"></i> <span>Dashboard</span></a></li>
    <li class="nav-item"><a href="#" class="nav-link active"><i class="bi bi-file-medical"></i> <span>Health Records</span></a></li>
    <li class="nav-item"><a href="vet-medical-treatments.php" class="nav-link"><i class="bi bi-heart-pulse"></i> <span>Medical Treatments</span></a></li>
    <li class="nav-item"><a href="vet-vaccinations.php" class="nav-link"><i class="bi bi-capsule"></i> <span>Vaccinations</span></a></li>
    <li class="nav-item mt-auto"><a href="/index.php" class="nav-link"><i class="bi bi-box-arrow-right"></i> <span>Logout</span></a></li>
  </ul>
  <button id="toggleSidebarBtn" class="btn btn-success mt-auto mx-3 mb-3 d-none d-md-block"><i class="bi bi-chevron-left"></i></button>
</nav>

<main id="mainContent">
<nav class="navbar navbar-expand-lg navbar-dark bg-success mb-4">
  <div class="container-fluid">
    <button id="sidebarToggle" class="btn btn-success d-md-none"><i class="bi bi-list"></i></button>
    <span class="navbar-brand ms-2">Health Records</span>
  </div>
</nav>

<div class="container-fluid">
<h3 class="mb-3">Tortoise Health Records</h3>

<!-- Health Record Form -->
<div class="card mb-4">
  <div class="card-header bg-success text-white">Add / Edit Health Record</div>
  <div class="card-body">
    <form id="healthRecordForm" method="POST">
      <input type="hidden" name="healthId" id="healthId">
      <div class="row g-3">
        <div class="col-md-4">
          <label class="form-label">Tortoise ID</label>
          <input type="text" class="form-control" name="tortoiseID" id="tortoiseID" required>
        </div>
        <div class="col-md-4">
          <label class="form-label">Date of Assessment</label>
          <input type="date" class="form-control" name="assessmentDate" id="assessmentDate" required>
        </div>
        <div class="col-md-4">
          <label class="form-label">Health Status</label>
          <select class="form-select" name="healthStatus" id="healthStatus" required>
            <option selected disabled>Select Status</option>
            <option value="Good">Good</option>
            <option value="Fair">Fair</option>
            <option value="Poor">Poor</option>
          </select>
        </div>
        <div class="col-md-6">
          <label class="form-label">Observations</label>
          <textarea class="form-control" name="observations" id="observations" rows="2"></textarea>
        </div>
        <div class="col-md-6">
          <label class="form-label">Vet Comments</label>
          <textarea class="form-control" name="vetComments" id="vetComments" rows="2"></textarea>
        </div>
      </div>
      <div class="mt-3">
        <button type="submit" class="btn btn-success"><i class="bi bi-plus-circle"></i> Save Record</button>
        <button type="button" id="resetForm" class="btn btn-secondary">Reset</button>
      </div>
    </form>
  </div>
</div>

<!-- Records Table -->
<div class="card">
  <div class="card-header bg-secondary text-white">All Health Records</div>
  <div class="card-body table-responsive">
    <table class="table table-bordered table-hover align-middle" id="recordsTable">
      <thead class="table-success">
        <tr>
          <th>Tortoise ID</th>
          <th>Date</th>
          <th>Status</th>
          <th>Observations</th>
          <th>Vet Comments</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?= htmlspecialchars($row['TortoiseID']) ?></td>
          <td><?= $row['AssessmentDate'] ?></td>
          <td>
            <?php 
              $status = $row['HealthStatus'];
              $badge = $status=='Good'?'bg-success':($status=='Fair'?'bg-warning':'bg-danger');
            ?>
            <span class="badge <?= $badge ?>"><?= $status ?></span>
          </td>
          <td><?= htmlspecialchars($row['Observations']) ?></td>
          <td><?= htmlspecialchars($row['VetComments']) ?></td>
          <td>
            <button class="btn btn-sm btn-outline-primary editBtn" 
              data-id="<?= $row['HealthID'] ?>" 
              data-tortoise="<?= htmlspecialchars($row['TortoiseID']) ?>" 
              data-date="<?= $row['AssessmentDate'] ?>" 
              data-status="<?= $row['HealthStatus'] ?>" 
              data-obs="<?= htmlspecialchars($row['Observations']) ?>" 
              data-comments="<?= htmlspecialchars($row['VetComments']) ?>"><i class="bi bi-pencil-square"></i></button>

            <a href="?delete=<?= $row['HealthID'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this record?')"><i class="bi bi-trash"></i></a>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>

</div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
const sidebar = document.getElementById('sidebar');
const mainContent = document.getElementById('mainContent');
const toggleSidebarBtn = document.getElementById('toggleSidebarBtn');
const sidebarCollapse = document.getElementById('sidebarCollapse');
const sidebarToggle = document.getElementById('sidebarToggle');

// Sidebar toggle
toggleSidebarBtn.addEventListener('click', () => {sidebar.classList.toggle('collapsed'); mainContent.classList.toggle('collapsed'); toggleSidebarBtn.querySelector('i').classList.toggle('bi-chevron-left'); toggleSidebarBtn.querySelector('i').classList.toggle('bi-chevron-right');});
sidebarCollapse.addEventListener('click', () => sidebar.classList.remove('show'));
sidebarToggle.addEventListener('click', () => sidebar.classList.add('show'));

// Edit button functionality
document.querySelectorAll('.editBtn').forEach(btn => {
  btn.addEventListener('click', () => {
    document.getElementById('healthId').value = btn.dataset.id;
    document.getElementById('tortoiseID').value = btn.dataset.tortoise;
    document.getElementById('assessmentDate').value = btn.dataset.date;
    document.getElementById('healthStatus').value = btn.dataset.status;
    document.getElementById('observations').value = btn.dataset.obs;
    document.getElementById('vetComments').value = btn.dataset.comments;
    window.scrollTo({top:0,behavior:'smooth'});
  });
});

// Reset form
document.getElementById('resetForm').addEventListener('click', () => {
  document.getElementById('healthRecordForm').reset();
  document.getElementById('healthId').value = '';
});
</script>
</body>
</html>
