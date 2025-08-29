<?php
// DB Connection
$conn = new mysqli("localhost", "root", "", "tortoise_db");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

// Add Record
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add'])) {
    $tid = $_POST['tortoiseid'];
    $date = $_POST['date'];
    $weight = $_POST['weight'];
    $status = $_POST['status'];
    $treatment = $_POST['treatment'];
    $vaccine = $_POST['vaccine'];
    $incidents = $_POST['incidents'];
    $notes = $_POST['notes'];

    $conn->query("INSERT INTO Health (TortoiseID, AssessmentDate, Weight, HealthStatus, MedicalTreatment, VaccinationRecord, Incidents, Notes)
                  VALUES ('$tid','$date','$weight','$status','$treatment','$vaccine','$incidents','$notes')");
    header("Location: health.php");
    exit;
}

// Update Record
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    $id = $_POST['id'];
    $tid = $_POST['tortoiseid'];
    $date = $_POST['date'];
    $weight = $_POST['weight'];
    $status = $_POST['status'];
    $treatment = $_POST['treatment'];
    $vaccine = $_POST['vaccine'];
    $incidents = $_POST['incidents'];
    $notes = $_POST['notes'];

    $conn->query("UPDATE Health SET
        TortoiseID='$tid',
        AssessmentDate='$date',
        Weight='$weight',
        HealthStatus='$status',
        MedicalTreatment='$treatment',
        VaccinationRecord='$vaccine',
        Incidents='$incidents',
        Notes='$notes'
        WHERE HealthID=$id");
    header("Location: health.php");
    exit;
}

// Delete
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM Health WHERE HealthID=$id");
    header("Location: health.php");
    exit;
}

// Search + Pagination
$search = isset($_GET['search']) ? $_GET['search'] : "";
$per_page = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $per_page;

$where = $search ? "WHERE TortoiseID LIKE '%$search%' OR HealthStatus LIKE '%$search%' OR AssessmentDate LIKE '%$search%'" : "";
$total = $conn->query("SELECT COUNT(*) as cnt FROM Health $where")->fetch_assoc()['cnt'];
$pages = ceil($total / $per_page);

$result = $conn->query("SELECT * FROM Health $where ORDER BY AssessmentDate DESC LIMIT $start, $per_page");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Health Management</title>
<link rel="icon" type="image/png" href="/assests/image/logo.jpeg" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
<style>
body { background-color: #f4f6f9; }
.wrapper { max-width: 1200px; margin: auto; }
.table-responsive { background: white; border-radius: 10px; padding: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
</style>
</head>
<body>

<div class="container-fluid mt-4 wrapper">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <a href="/pages/admin.php" class="btn btn-outline-success"><i class="bi bi-arrow-left-circle"></i> Dashboard</a>
    <h3 class="text-success mb-0"><i class="bi bi-heart-pulse-fill me-2"></i>Health Records</h3>
    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addHealthModal"><i class="bi bi-plus-circle"></i> Add Record</button>
  </div>

  <!-- Search -->
  <form method="get" class="row mb-3">
    <div class="col-md-4">
      <input type="text" name="search" class="form-control" placeholder="Search by Tortoise ID, Status, or Date..." value="<?= $search ?>">
    </div>
    <div class="col-md-2">
      <button class="btn btn-outline-success" type="submit">Search</button>
    </div>
  </form>

  <!-- Table -->
  <div class="table-responsive">
    <table class="table table-bordered table-hover align-middle">
      <thead class="table-success">
        <tr>
          <th>Health ID</th>
          <th>Tortoise ID</th>
          <th>Assessment Date</th>
          <th>Weight</th>
          <th>Health Status</th>
          <th>Medical Treatment</th>
          <th>Vaccination Record</th>
          <th>Incidents</th>
          <th>Notes</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php while($row=$result->fetch_assoc()): ?>
        <tr>
          <td><?= $row['HealthID'] ?></td>
          <td><?= $row['TortoiseID'] ?></td>
          <td><?= $row['AssessmentDate'] ?></td>
          <td><?= $row['Weight'] ?></td>
          <td><?= $row['HealthStatus'] ?></td>
          <td><?= $row['MedicalTreatment'] ?></td>
          <td><?= $row['VaccinationRecord'] ?></td>
          <td><?= $row['Incidents'] ?></td>
          <td><?= $row['Notes'] ?></td>
          <td>
            <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editHealthModal"
              onclick='setEdit(<?= json_encode($row) ?>)'><i class="bi bi-pencil"></i></button>
            <a href="health.php?delete=<?= $row['HealthID'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this record?')"><i class="bi bi-trash"></i></a>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>

  <!-- Pagination -->
  <nav class="mt-3">
    <ul class="pagination">
      <?php for($i=1;$i<=$pages;$i++): ?>
        <li class="page-item <?= $i==$page?'active':'' ?>"><a class="page-link" href="?page=<?= $i ?>&search=<?= $search ?>"><?= $i ?></a></li>
      <?php endfor; ?>
    </ul>
  </nav>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addHealthModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <form method="post" class="modal-content">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title">Add Health Record</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body row g-3">
        <input type="hidden" name="add" value="1">
        <div class="col-md-3"><label class="form-label">Tortoise ID</label><input type="number" name="tortoiseid" class="form-control" required></div>
        <div class="col-md-3"><label class="form-label">Assessment Date</label><input type="datetime-local" name="date" class="form-control" required></div>
        <div class="col-md-2"><label class="form-label">Weight (kg)</label><input type="number" step="0.01" name="weight" class="form-control" required></div>
        <div class="col-md-2"><label class="form-label">Health Status</label><input type="text" name="status" class="form-control" required></div>
        <div class="col-md-12"><label class="form-label">Medical Treatment</label><input type="text" name="treatment" class="form-control" required></div>
        <div class="col-md-12"><label class="form-label">Vaccination Record</label><input type="text" name="vaccine" class="form-control" required></div>
        <div class="col-md-12"><label class="form-label">Incidents</label><input type="text" name="incidents" class="form-control" required></div>
        <div class="col-md-12"><label class="form-label">Notes</label><textarea name="notes" class="form-control" rows="2"></textarea></div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-success">Save</button>
      </div>
    </form>
  </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editHealthModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <form method="post" class="modal-content">
      <div class="modal-header bg-warning">
        <h5 class="modal-title">Edit Health Record</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body row g-3">
        <input type="hidden" name="update" value="1">
        <input type="hidden" name="id" id="edit-id">
        <div class="col-md-3"><label class="form-label">Tortoise ID</label><input type="number" name="tortoiseid" id="edit-tid" class="form-control" required></div>
        <div class="col-md-3"><label class="form-label">Assessment Date</label><input type="datetime-local" name="date" id="edit-date" class="form-control" required></div>
        <div class="col-md-2"><label class="form-label">Weight (kg)</label><input type="number" step="0.01" name="weight" id="edit-weight" class="form-control" required></div>
        <div class="col-md-2"><label class="form-label">Health Status</label><input type="text" name="status" id="edit-status" class="form-control" required></div>
        <div class="col-md-12"><label class="form-label">Medical Treatment</label><input type="text" name="treatment" id="edit-treatment" class="form-control" required></div>
        <div class="col-md-12"><label class="form-label">Vaccination Record</label><input type="text" name="vaccine" id="edit-vaccine" class="form-control" required></div>
        <div class="col-md-12"><label class="form-label">Incidents</label><input type="text" name="incidents" id="edit-incidents" class="form-control" required></div>
        <div class="col-md-12"><label class="form-label">Notes</label><textarea name="notes" id="edit-notes" class="form-control" rows="2"></textarea></div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-warning">Update</button>
      </div>
    </form>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
function setEdit(data){
  document.getElementById('edit-id').value = data.HealthID;
  document.getElementById('edit-tid').value = data.TortoiseID;
  document.getElementById('edit-date').value = data.AssessmentDate.replace(' ','T');
  document.getElementById('edit-weight').value = data.Weight;
  document.getElementById('edit-status').value = data.HealthStatus;
  document.getElementById('edit-treatment').value = data.MedicalTreatment;
  document.getElementById('edit-vaccine').value = data.VaccinationRecord;
  document.getElementById('edit-incidents').value = data.Incidents;
  document.getElementById('edit-notes').value = data.Notes;
}
</script>
</body>
</html>
