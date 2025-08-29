<?php
// DB Connection
$conn = new mysqli("localhost", "root", "", "tortoise_db");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

// Add
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add'])) {
    $size = $_POST['size'];
    $habitat = $_POST['habitat'];
    $occupants = $_POST['occupants'];
    $schedule = $_POST['schedule'];
    $params = $_POST['params'];

    $conn->query("INSERT INTO Enclosure (Size, HabitatType, CurrentOccupants, MaintenanceSchedule, EnvironmentalParameters)
                  VALUES ('$size', '$habitat', '$occupants', '$schedule', '$params')");
    header("Location: enclosure.php");
    exit;
}

// Update
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    $id = $_POST['id'];
    $size = $_POST['size'];
    $habitat = $_POST['habitat'];
    $occupants = $_POST['occupants'];
    $schedule = $_POST['schedule'];
    $params = $_POST['params'];

    $conn->query("UPDATE Enclosure SET 
        Size='$size', 
        HabitatType='$habitat',
        CurrentOccupants='$occupants',
        MaintenanceSchedule='$schedule',
        EnvironmentalParameters='$params'
        WHERE EnclosureID=$id");
    header("Location: enclosure.php");
    exit;
}

// Delete
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM Enclosure WHERE EnclosureID=$id");
    header("Location: enclosure.php");
    exit;
}

// Search + Pagination
$search = isset($_GET['search']) ? $_GET['search'] : "";
$per_page = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $per_page;

$where = $search ? "WHERE EnclosureID LIKE '%$search%' OR HabitatType LIKE '%$search%'" : "";

$total = $conn->query("SELECT COUNT(*) as cnt FROM Enclosure $where")->fetch_assoc()['cnt'];
$pages = ceil($total / $per_page);

$result = $conn->query("SELECT * FROM Enclosure $where LIMIT $start, $per_page");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Enclosure Management</title>
  <link rel="icon" type="image/png" href="/assests/image/logo.jpeg" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
  <style>
    body { background-color: #f4f6f9; }
    .wrapper { max-width: 1200px; margin: auto; }
    .table-responsive {
      background: white;
      border-radius: 10px;
      padding: 10px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
    .btn-success { margin-left: 10px; }
    .table td, .table th {
    padding: 0.45rem 0.75rem; /* smaller than default */
    vertical-align: middle;   /* center content vertically */
}

.table td button {
    padding: 0.25rem 0.5rem; /* smaller button padding */
    margin-right: 3px;        /* spacing between buttons */
}

  </style>
</head>
<body>
<div class="container-fluid mt-4 wrapper">

  <div class="d-flex justify-content-between align-items-center mb-3">
    <a href="admin.php" class="btn btn-outline-success">
      <i class="bi bi-arrow-left-circle"></i> Dashboard
    </a>
    <h3 class="text-success mb-0"><i class="bi bi-house-door-fill me-2"></i>Enclosure Records</h3>
    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addEnclosureModal">
      <i class="bi bi-plus-circle"></i> Add Enclosure
    </button>
  </div>

  <!-- Filter/Search -->
  <form method="get" class="row mb-3">
    <div class="col-md-4">
      <input type="text" name="search" class="form-control" placeholder="Search by ID or Habitat..." value="<?= $search ?>">
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
          <th>ID</th>
          <th>Size (sq.m.)</th>
          <th>Habitat Type</th>
          <th>Current Occupants</th>
          <th>Maintenance Schedule</th>
          <th>Environmental Parameters</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php while($row=$result->fetch_assoc()): ?>
        <tr>
          <td><?= $row['EnclosureID'] ?></td>
          <td><?= $row['Size'] ?></td>
          <td><?= $row['HabitatType'] ?></td>
          <td><?= $row['CurrentOccupants'] ?></td>
          <td><?= $row['MaintenanceSchedule'] ?></td>
          <td><?= $row['EnvironmentalParameters'] ?></td>
          <td>
            <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editEnclosureModal"
              onclick='setEdit(<?= json_encode($row) ?>)'><i class="bi bi-pencil"></i></button>
            <a href="enclosure.php?delete=<?= $row['EnclosureID'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this record?')"><i class="bi bi-trash"></i></a>
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
        <li class="page-item <?= $i==$page?'active':'' ?>">
          <a class="page-link" href="?page=<?= $i ?>&search=<?= $search ?>"><?= $i ?></a>
        </li>
      <?php endfor; ?>
    </ul>
  </nav>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addEnclosureModal" tabindex="-1">
  <div class="modal-dialog">
    <form method="post" class="modal-content">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title">Add Enclosure</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="add" value="1">
        <div class="mb-2"><label class="form-label">Size</label><input type="number" name="size" class="form-control" required></div>
        <div class="mb-2"><label class="form-label">Habitat Type</label><input type="text" name="habitat" class="form-control" required></div>
        <div class="mb-2"><label class="form-label">Occupants</label><input type="text" name="occupants" class="form-control"></div>
        <div class="mb-2"><label class="form-label">Maintenance</label><input type="text" name="schedule" class="form-control"></div>
        <div class="mb-2"><label class="form-label">Parameters</label><textarea name="params" class="form-control"></textarea></div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-success">Save</button>
      </div>
    </form>
  </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editEnclosureModal" tabindex="-1">
  <div class="modal-dialog">
    <form method="post" class="modal-content">
      <div class="modal-header bg-warning">
        <h5 class="modal-title">Edit Enclosure</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="update" value="1">
        <input type="hidden" name="id" id="edit-id">
        <div class="mb-2"><label class="form-label">Size</label><input type="number" name="size" id="edit-size" class="form-control" required></div>
        <div class="mb-2"><label class="form-label">Habitat Type</label><input type="text" name="habitat" id="edit-habitat" class="form-control" required></div>
        <div class="mb-2"><label class="form-label">Occupants</label><input type="text" name="occupants" id="edit-occupants" class="form-control"></div>
        <div class="mb-2"><label class="form-label">Maintenance</label><input type="text" name="schedule" id="edit-schedule" class="form-control"></div>
        <div class="mb-2"><label class="form-label">Parameters</label><textarea name="params" id="edit-params" class="form-control"></textarea></div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-warning">Update</button>
      </div>
    </form>
  </div>
</div>

<script>
function setEdit(data){
  document.getElementById('edit-id').value = data.EnclosureID;
  document.getElementById('edit-size').value = data.Size;
  document.getElementById('edit-habitat').value = data.HabitatType;
  document.getElementById('edit-occupants').value = data.CurrentOccupants;
  document.getElementById('edit-schedule').value = data.MaintenanceSchedule;
  document.getElementById('edit-params').value = data.EnvironmentalParameters;
}
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
