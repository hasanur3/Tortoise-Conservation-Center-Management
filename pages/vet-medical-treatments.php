<?php
// vet_medical_treatments.php
session_start();
$conn = new mysqli("localhost", "root", "", "tortoise_db");
if ($conn->connect_error) die("DB connection failed: " . $conn->connect_error);

// Handle Add/Edit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['treatmentId'] ?? null;
    $tortoiseID = $_POST['tortoiseID'];
    $date = $_POST['treatmentDate'];
    $med = $_POST['medication'];
    $desc = $_POST['description'];
    $notes = $_POST['vetNotes'];

    if ($id) {
        $stmt = $conn->prepare("UPDATE medical_treatments SET TortoiseID=?, TreatmentDate=?, Medication=?, Description=?, VetNotes=? WHERE TreatmentID=?");
        $stmt->bind_param("sssssi", $tortoiseID, $date, $med, $desc, $notes, $id);
        $stmt->execute();
    } else {
        $stmt = $conn->prepare("INSERT INTO medical_treatments (TortoiseID, TreatmentDate, Medication, Description, VetNotes) VALUES (?,?,?,?,?)");
        $stmt->bind_param("sssss", $tortoiseID, $date, $med, $desc, $notes);
        $stmt->execute();
    }
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Handle Delete
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM medical_treatments WHERE TreatmentID=" . (int)$id);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Fetch Treatments
$result = $conn->query("SELECT * FROM medical_treatments ORDER BY TreatmentDate DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Medical Treatments - Veterinarian</title>
<link rel="icon" href="/assests/image/logo.jpeg">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<style>
/* Sidebar and main content same as your HTML */
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

<!-- Sidebar -->
<nav id="sidebar" class="sidebar d-flex flex-column">
  <div class="d-flex align-items-center justify-content-between px-3 py-3 border-bottom border-success">
    <span class="fs-4 fw-bold">Vet Dashboard</span>
    <button id="sidebarCollapse" class="btn btn-sm btn-success d-md-none"><i class="bi bi-x"></i></button>
  </div>
  <ul class="nav flex-column mt-3">
    <li class="nav-item"><a href="/pages/veterinarian_dashboard.php" class="nav-link"><i class="bi bi-speedometer2"></i> <span>Dashboard</span></a></li>
    <li class="nav-item"><a href="/pages/vet-health-records.php" class="nav-link"><i class="bi bi-file-medical"></i> <span>Health Records</span></a></li>
    <li class="nav-item"><a href="#" class="nav-link active"><i class="bi bi-heart-pulse"></i> <span>Medical Treatments</span></a></li>
    <li class="nav-item mt-auto"><a href="/index.php" class="nav-link"><i class="bi bi-box-arrow-right"></i> <span>Logout</span></a></li>
  </ul>
  <button id="toggleSidebarBtn" class="btn btn-success mt-auto mx-3 mb-3 d-none d-md-block"><i class="bi bi-chevron-left"></i></button>
</nav>

<main id="mainContent">
<nav class="navbar navbar-expand-lg navbar-dark bg-success mb-4">
  <div class="container-fluid">
    <button id="sidebarToggle" class="btn btn-success d-md-none"><i class="bi bi-list"></i></button>
    <span class="navbar-brand ms-2">Medical Treatments</span>
  </div>
</nav>

<div class="container-fluid">
<h3 class="mb-3">Manage Medical Treatments</h3>

<!-- Add / Edit Form -->
<div class="card mb-4">
  <div class="card-header bg-success text-white">Add / Edit Treatment</div>
  <div class="card-body">
    <form id="treatmentForm" method="POST">
      <input type="hidden" name="treatmentId" id="treatmentId">
      <div class="row g-3">
        <div class="col-md-4">
          <label class="form-label">Tortoise ID</label>
          <input type="text" class="form-control" name="tortoiseID" id="tortoiseID" required>
        </div>
        <div class="col-md-4">
          <label class="form-label">Treatment Date</label>
          <input type="date" class="form-control" name="treatmentDate" id="treatmentDate" required>
        </div>
        <div class="col-md-4">
          <label class="form-label">Medication</label>
          <input type="text" class="form-control" name="medication" id="medication" placeholder="Medication name" required>
        </div>
        <div class="col-md-12">
          <label class="form-label">Treatment Description</label>
          <textarea class="form-control" name="description" id="description" rows="2" required></textarea>
        </div>
        <div class="col-md-12">
          <label class="form-label">Vet Notes</label>
          <textarea class="form-control" name="vetNotes" id="vetNotes" rows="2"></textarea>
        </div>
      </div>
      <div class="mt-3">
        <button type="submit" class="btn btn-success"><i class="bi bi-plus-circle"></i> Save Treatment</button>
        <button type="button" id="resetForm" class="btn btn-secondary">Reset</button>
      </div>
    </form>
  </div>
</div>

<!-- Treatments Table -->
<div class="card">
  <div class="card-header bg-secondary text-white">All Medical Treatments</div>
  <div class="card-body table-responsive">
    <table class="table table-bordered table-hover align-middle" id="treatmentsTable">
      <thead class="table-success">
        <tr>
          <th>Tortoise ID</th>
          <th>Date</th>
          <th>Medication</th>
          <th>Description</th>
          <th>Vet Notes</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?= htmlspecialchars($row['TortoiseID']) ?></td>
          <td><?= $row['TreatmentDate'] ?></td>
          <td><?= htmlspecialchars($row['Medication']) ?></td>
          <td><?= htmlspecialchars($row['Description']) ?></td>
          <td><?= htmlspecialchars($row['VetNotes']) ?></td>
          <td>
            <button class="btn btn-sm btn-outline-primary editBtn"
              data-id="<?= $row['TreatmentID'] ?>"
              data-tortoise="<?= htmlspecialchars($row['TortoiseID']) ?>"
              data-date="<?= $row['TreatmentDate'] ?>"
              data-med="<?= htmlspecialchars($row['Medication']) ?>"
              data-desc="<?= htmlspecialchars($row['Description']) ?>"
              data-notes="<?= htmlspecialchars($row['VetNotes']) ?>"><i class="bi bi-pencil-square"></i></button>
            <a href="?delete=<?= $row['TreatmentID'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this treatment?')"><i class="bi bi-trash"></i></a>
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
// Sidebar toggle
const sidebar = document.getElementById('sidebar');
const mainContent = document.getElementById('mainContent');
const toggleSidebarBtn = document.getElementById('toggleSidebarBtn');
const sidebarCollapse = document.getElementById('sidebarCollapse');
const sidebarToggle = document.getElementById('sidebarToggle');
toggleSidebarBtn.addEventListener('click', ()=>{sidebar.classList.toggle('collapsed'); mainContent.classList.toggle('collapsed'); toggleSidebarBtn.querySelector('i').classList.toggle('bi-chevron-left'); toggleSidebarBtn.querySelector('i').classList.toggle('bi-chevron-right');});
sidebarCollapse.addEventListener('click', ()=>sidebar.classList.remove('show'));
sidebarToggle.addEventListener('click', ()=>sidebar.classList.add('show'));

// Edit button functionality
document.querySelectorAll('.editBtn').forEach(btn=>{
  btn.addEventListener('click', ()=>{
    document.getElementById('treatmentId').value=btn.dataset.id;
    document.getElementById('tortoiseID').value=btn.dataset.tortoise;
    document.getElementById('treatmentDate').value=btn.dataset.date;
    document.getElementById('medication').value=btn.dataset.med;
    document.getElementById('description').value=btn.dataset.desc;
    document.getElementById('vetNotes').value=btn.dataset.notes;
    window.scrollTo({top:0,behavior:'smooth'});
  });
});

// Reset form
document.getElementById('resetForm').addEventListener('click', ()=>{
  document.getElementById('treatmentForm').reset();
  document.getElementById('treatmentId').value='';
});
</script>
</body>
</html>
