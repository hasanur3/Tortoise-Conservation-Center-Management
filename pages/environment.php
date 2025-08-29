<?php
// DB Connection
$conn = new mysqli("localhost", "root", "", "tortoise_db");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

// Add Record
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add'])) {
    $enclosure = $_POST['enclosure'];
    $date = $_POST['date'];
    $temp = $_POST['temperature'];
    $humidity = $_POST['humidity'];
    $water = $_POST['water'];
    $notes = $_POST['notes'];
    $optimal = $_POST['optimal'];

    $conn->query("INSERT INTO Environment 
        (EnclosureID, RecordDate, Temperature, Humidity, WaterQuality, OtherNotes, OptimalCondition)
        VALUES ('$enclosure', '$date', '$temp', '$humidity', '$water', '$notes', '$optimal')");
    header("Location: environment.php");
    exit;
}

// Update Record
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    $id = $_POST['id'];
    $enclosure = $_POST['enclosure'];
    $date = $_POST['date'];
    $temp = $_POST['temperature'];
    $humidity = $_POST['humidity'];
    $water = $_POST['water'];
    $notes = $_POST['notes'];
    $optimal = $_POST['optimal'];

    $conn->query("UPDATE Environment SET 
        EnclosureID='$enclosure',
        RecordDate='$date',
        Temperature='$temp',
        Humidity='$humidity',
        WaterQuality='$water',
        OtherNotes='$notes',
        OptimalCondition='$optimal'
        WHERE RecordID=$id");
    header("Location: environment.php");
    exit;
}

// Delete Record
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM Environment WHERE RecordID=$id");
    header("Location: environment.php");
    exit;
}

// Search + Pagination
$search = isset($_GET['search']) ? $_GET['search'] : "";
$per_page = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $per_page;

$where = $search ? "WHERE EnclosureID LIKE '%$search%' OR WaterQuality LIKE '%$search%'" : "";

$total = $conn->query("SELECT COUNT(*) as cnt FROM Environment $where")->fetch_assoc()['cnt'];
$pages = ceil($total / $per_page);

$result = $conn->query("SELECT * FROM Environment $where ORDER BY RecordDate DESC LIMIT $start, $per_page");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Environment Management</title>
  <link rel="icon" type="image/png" href="/assests/image/logo.jpeg" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
  <style>
    body { background-color: #f4f6f9; }
    .wrapper { max-width: 1200px; margin: auto; }
    .table-responsive { background: white; border-radius: 10px; padding: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
    .btn-success { background-color: #198754; }
  </style>
</head>
<body>
<div class="container-fluid mt-4 wrapper">

  <div class="d-flex justify-content-between align-items-center mb-3">
    <a href="/pages/admin.php" class="btn btn-outline-success"><i class="bi bi-arrow-left-circle"></i> Dashboard</a>
    <h3 class="text-success mb-0"><i class="bi bi-cloud-sun-fill me-2"></i>Environment Records</h3>
    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addEnvironmentModal"><i class="bi bi-plus-circle"></i> Add Record</button>
  </div>

  <!-- Search -->
  <form method="get" class="row mb-3">
    <div class="col-md-4">
      <input type="text" name="search" class="form-control" placeholder="Search by Enclosure ID or Water Quality..." value="<?= $search ?>">
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
          <th>Record ID</th>
          <th>Enclosure/Incubator ID</th>
          <th>Date</th>
          <th>Temperature (°C)</th>
          <th>Humidity (%)</th>
          <th>Water Quality</th>
          <th>Other Notes</th>
          <th>Optimal Condition</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php while($row=$result->fetch_assoc()): ?>
        <tr>
          <td><?= $row['RecordID'] ?></td>
          <td><?= $row['EnclosureID'] ?></td>
          <td><?= $row['RecordDate'] ?></td>
          <td><?= $row['Temperature'] ?></td>
          <td><?= $row['Humidity'] ?></td>
          <td><?= $row['WaterQuality'] ?></td>
          <td><?= $row['OtherNotes'] ?></td>
          <td><?= $row['OptimalCondition'] ?></td>
          <td>
            <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editEnvironmentModal" onclick='setEdit(<?= json_encode($row) ?>)'><i class="bi bi-pencil"></i></button>
            <a href="?delete=<?= $row['RecordID'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this record?')"><i class="bi bi-trash"></i></a>
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
<div class="modal fade" id="addEnvironmentModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <form method="post" class="modal-content">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title">Add Environment Record</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="add" value="1">
        <div class="row g-3">
          <div class="col-md-4"><label class="form-label">Enclosure/Incubator ID</label><input type="number" name="enclosure" class="form-control" required></div>
          <div class="col-md-4"><label class="form-label">Date & Time</label><input type="datetime-local" name="date" class="form-control" required></div>
          <div class="col-md-4"><label class="form-label">Temperature (°C)</label><input type="number" step="0.1" name="temperature" class="form-control" required></div>
          <div class="col-md-4"><label class="form-label">Humidity (%)</label><input type="number" step="0.1" name="humidity" class="form-control" required></div>
          <div class="col-md-4"><label class="form-label">Water Quality</label><input type="text" name="water" class="form-control" required></div>
          <div class="col-md-4"><label class="form-label">Optimal Condition</label><input type="text" name="optimal" class="form-control" required></div>
          <div class="col-12"><label class="form-label">Other Notes</label><textarea name="notes" class="form-control" rows="2"></textarea></div>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-success">Save</button>
      </div>
    </form>
  </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editEnvironmentModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <form method="post" class="modal-content">
      <div class="modal-header bg-warning">
        <h5 class="modal-title">Edit Environment Record</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="update" value="1">
        <input type="hidden" name="id" id="edit-id">
        <div class="row g-3">
          <div class="col-md-4"><label class="form-label">Enclosure/Incubator ID</label><input type="number" name="enclosure" id="edit-enclosure" class="form-control" required></div>
          <div class="col-md-4"><label class="form-label">Date & Time</label><input type="datetime-local" name="date" id="edit-date" class="form-control" required></div>
          <div class="col-md-4"><label class="form-label">Temperature (°C)</label><input type="number" step="0.1" name="temperature" id="edit-temperature" class="form-control" required></div>
          <div class="col-md-4"><label class="form-label">Humidity (%)</label><input type="number" step="0.1" name="humidity" id="edit-humidity" class="form-control" required></div>
          <div class="col-md-4"><label class="form-label">Water Quality</label><input type="text" name="water" id="edit-water" class="form-control" required></div>
          <div class="col-md-4"><label class="form-label">Optimal Condition</label><input type="text" name="optimal" id="edit-optimal" class="form-control" required></div>
          <div class="col-12"><label class="form-label">Other Notes</label><textarea name="notes" id="edit-notes" class="form-control" rows="2"></textarea></div>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-warning">Update</button>
      </div>
    </form>
  </div>
</div>

<script>
function setEdit(data){
  document.getElementById('edit-id').value = data.RecordID;
  document.getElementById('edit-enclosure').value = data.EnclosureID;
  document.getElementById('edit-date').value = data.RecordDate.replace(' ', 'T');
  document.getElementById('edit-temperature').value = data.Temperature;
  document.getElementById('edit-humidity').value = data.Humidity;
  document.getElementById('edit-water').value = data.WaterQuality;
  document.getElementById('edit-notes').value = data.OtherNotes;
  document.getElementById('edit-optimal').value = data.OptimalCondition;
}
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
