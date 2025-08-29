<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "tortoise_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Insert new tortoise
if (isset($_POST['add_tortoise'])) {
    $name = $_POST['name'];
    $species = $_POST['species'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $history = $_POST['history'];
    $enclosure = $_POST['enclosure'];
    $status = $_POST['status'];

    $sql = "INSERT INTO tortoise (Name, Species, Age, Gender, `History of Care`, Enclosure, `Health Status`) 
            VALUES ('$name', '$species', '$age', '$gender', '$history', '$enclosure', '$status')";
    $conn->query($sql);
    header("Location: tortoise.php");
    exit;
}

// Update tortoise
if (isset($_POST['update_tortoise'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $species = $_POST['species'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $history = $_POST['history'];
    $enclosure = $_POST['enclosure'];
    $status = $_POST['status'];

    $sql = "UPDATE tortoise SET 
        Name='$name', Species='$species', Age='$age', Gender='$gender', 
        `History of Care`='$history', Enclosure='$enclosure', `Health Status`='$status' 
        WHERE ID=$id";
    $conn->query($sql);
    header("Location: tortoise.php");
    exit;
}

// Delete tortoise
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM tortoise WHERE ID=$id");
    header("Location: tortoise.php");
    exit;
}

// Search + Filter
$search = isset($_GET['search']) ? $_GET['search'] : '';
$filter = isset($_GET['filter']) ? $_GET['filter'] : '';

// Pagination
$limit = 10; // records per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$where = "WHERE 1";
if ($search != '') {
    $where .= " AND (Name LIKE '%$search%' OR Species LIKE '%$search%' OR Enclosure LIKE '%$search%')";
}
if ($filter != '') {
    $where .= " AND `Health Status`='$filter'";
}

// Total records
$total_result = $conn->query("SELECT COUNT(*) AS total FROM tortoise $where");
$total_row = $total_result->fetch_assoc();
$total_records = $total_row['total'];
$total_pages = ceil($total_records / $limit);

// Fetch records with limit
$query = "SELECT * FROM tortoise $where LIMIT $offset, $limit";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Tortoise Management</title>
<link rel="icon" type="image/png" href="../assests/image/logo.jpeg" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<style>
  /* Sidebar styling */
  nav.sidebar { min-width: 220px; min-height: 100vh; }
  @media (max-width:768px){ nav.sidebar { min-width: 100px; font-size:14px; } }
</style>
</head>
<body>

<div class="d-flex" style="max-width:1200px; margin:auto;">
  <!-- Main Content -->
  <div class="container-fluid mt-4" style="max-width:1200px; margin:auto;">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <a href="admin.php" class="btn btn-outline-success"><i class="bi bi-arrow-left-circle"></i> Dashboard</a>
      <h3 class="text-success mb-0"><i class="bi bi-bug-fill me-2"></i>Tortoise Records</h3>
      <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addTortoiseModal"><i class="bi bi-plus-circle"></i> Add Tortoise</button>
    </div>

    <!-- Search + Filter -->
    <form method="GET" class="row mb-3">
      <div class="col-md-4"><input type="text" name="search" class="form-control" placeholder="Search by Name, Species, Enclosure" value="<?= htmlspecialchars($search) ?>"></div>
      <div class="col-md-3">
        <select name="filter" class="form-select">
          <option value="">Filter by Health</option>
          <option value="Healthy" <?= $filter=="Healthy"?"selected":"" ?>>Healthy</option>
          <option value="Sick" <?= $filter=="Sick"?"selected":"" ?>>Sick</option>
          <option value="Under Observation" <?= $filter=="Under Observation"?"selected":"" ?>>Under Observation</option>
        </select>
      </div>
      <div class="col-md-2"><button type="submit" class="btn btn-primary"><i class="bi bi-search"></i> Apply</button></div>
    </form>

    <!-- Table -->
    <div class="table-responsive"style="max-width:1200px; margin:auto;">
      <table class="table table-bordered table-hover align-middle">
        <thead class="table-success">
          <tr>
            <th>ID</th><th>Name</th><th>Species</th><th>Age</th><th>Gender</th><th>History of Care</th><th>Enclosure</th><th>Health Status</th><th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php while($row=$result->fetch_assoc()): ?>
  <tr>
    <td><?= $row['ID'] ?></td>
    <td><?= $row['Name'] ?></td>
    <td><?= $row['Species'] ?></td>
    <td><?= $row['Age'] ?></td>
    <td><?= $row['Gender'] ?></td>
    <td><?= $row['History of Care'] ?></td>
    <td><?= $row['Enclosure'] ?></td>
    <td>
      <span class="badge bg-<?= $row['Health Status']=='Healthy'?'success':($row['Health Status']=='Sick'?'danger':'warning') ?>">
        <?= $row['Health Status'] ?>
      </span>
    </td>
    <td>
      <button class="btn btn-sm btn-warning" 
              data-bs-toggle="modal" 
              data-bs-target="#editTortoiseModal" 
              onclick='setEdit(<?= json_encode($row) ?>)'>
        <i class="bi bi-pencil"></i>
      </button>
      <a href="tortoise.php?delete=<?= $row['ID'] ?>" 
         class="btn btn-sm btn-danger" 
         onclick="return confirm('Delete this record?')">
        <i class="bi bi-trash"></i>
      </a>
    </td>
  </tr>
<?php endwhile; ?>

        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    <nav>
      <ul class="pagination">
        <?php for($p=1;$p<=$total_pages;$p++): ?>
        <li class="page-item <?= $p==$page?'active':'' ?>">
          <a class="page-link" href="?search=<?= urlencode($search) ?>&filter=<?= urlencode($filter) ?>&page=<?= $p ?>"><?= $p ?></a>
        </li>
        <?php endfor; ?>
      </ul>
    </nav>
  </div>
</div>

<!-- Add Tortoise Modal -->
<div class="modal fade" id="addTortoiseModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST">
        <div class="modal-header bg-success text-white">
          <h5 class="modal-title">Add New Tortoise</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-2"><label class="form-label">Name</label><input type="text" name="name" class="form-control" required></div>
          <div class="mb-2"><label class="form-label">Species</label><input type="text" name="species" class="form-control" required></div>
          <div class="mb-2"><label class="form-label">Age</label><input type="number" name="age" class="form-control" min="0" required></div>
          <div class="mb-2"><label class="form-label">Gender</label>
            <select class="form-select" name="gender">
              <option>Male</option><option>Female</option><option>Unknown</option>
            </select>
          </div>
          <div class="mb-2"><label class="form-label">History of Care</label>
            <textarea name="history" class="form-control" rows="2"></textarea>
          </div>
          <div class="mb-2"><label class="form-label">Enclosure</label>
            <input type="text" name="enclosure" class="form-control" required>
          </div>
          <div class="mb-2"><label class="form-label">Health Status</label>
            <select class="form-select" name="status" required>
              <option>Healthy</option><option>Sick</option><option>Under Observation</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" name="add_tortoise" class="btn btn-success">Save</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Edit Tortoise Modal -->
<div class="modal fade" id="editTortoiseModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST">
        <div class="modal-header bg-warning text-dark">
          <h5 class="modal-title">Edit Tortoise</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id" id="edit-id">
          <div class="mb-2"><label class="form-label">Name</label><input type="text" name="name" id="edit-name" class="form-control" required></div>
          <div class="mb-2"><label class="form-label">Species</label><input type="text" name="species" id="edit-species" class="form-control" required></div>
          <div class="mb-2"><label class="form-label">Age</label><input type="number" name="age" id="edit-age" class="form-control" required></div>
          <div class="mb-2"><label class="form-label">Gender</label>
            <select name="gender" id="edit-gender" class="form-select" required>
              <option value="Male">Male</option><option value="Female">Female</option><option value="Unknown">Unknown</option>
            </select>
          </div>
          <div class="mb-2"><label class="form-label">History of Care</label>
            <textarea name="history" id="edit-history" class="form-control" rows="2"></textarea>
          </div>
          <div class="mb-2"><label class="form-label">Enclosure</label>
            <input type="text" name="enclosure" id="edit-enclosure" class="form-control" required>
          </div>
          <div class="mb-2"><label class="form-label">Health Status</label>
            <select name="status" id="edit-status" class="form-select" required>
              <option value="Healthy">Healthy</option><option value="Sick">Sick</option><option value="Under Observation">Under Observation</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" name="update_tortoise" class="btn btn-warning">Update</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
function setEdit(data){
  document.getElementById('edit-id').value = data.ID;
  document.getElementById('edit-name').value = data.Name;
  document.getElementById('edit-species').value = data.Species;
  document.getElementById('edit-age').value = data.Age;
  document.getElementById('edit-gender').value = data.Gender;
  document.getElementById('edit-history').value = data["History of Care"];
  document.getElementById('edit-enclosure').value = data.Enclosure;
  document.getElementById('edit-status').value = data["Health Status"];
}
</script>


</body>
</html>
