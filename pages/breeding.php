<?php
// DB Connection
$conn = new mysqli("localhost", "root", "", "tortoise_db");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

// Add Breeding Record
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add'])) {
    $male = $_POST['male'];
    $female = $_POST['female'];
    $date = $_POST['date'];
    $eggs = $_POST['eggs'];
    $incubation = $_POST['incubation'];
    $hatchRate = $_POST['hatchRate'];
    $obs = $_POST['obs'];

    $conn->query("INSERT INTO Breeding (MaleTortoiseID, FemaleTortoiseID, NestingDate, EggCount, IncubationPeriod, HatchingSuccessRate, Observations)
                  VALUES ('$male','$female','$date','$eggs','$incubation','$hatchRate','$obs')");
    header("Location: breeding.php");
    exit;
}

// Update Breeding Record
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    $id = $_POST['id'];
    $male = $_POST['male'];
    $female = $_POST['female'];
    $date = $_POST['date'];
    $eggs = $_POST['eggs'];
    $incubation = $_POST['incubation'];
    $hatchRate = $_POST['hatchRate'];
    $obs = $_POST['obs'];

    $conn->query("UPDATE Breeding SET 
        MaleTortoiseID='$male',
        FemaleTortoiseID='$female',
        NestingDate='$date',
        EggCount='$eggs',
        IncubationPeriod='$incubation',
        HatchingSuccessRate='$hatchRate',
        Observations='$obs'
        WHERE PairID=$id");
    header("Location: breeding.php");
    exit;
}

// Delete
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM Breeding WHERE PairID=$id");
    header("Location: breeding.php");
    exit;
}

// Search + Pagination
$search = isset($_GET['search']) ? $_GET['search'] : "";
$per_page = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $per_page;

$where = $search ? "WHERE PairID LIKE '%$search%' OR MaleTortoiseID LIKE '%$search%' OR FemaleTortoiseID LIKE '%$search%' OR NestingDate LIKE '%$search%'" : "";

$total = $conn->query("SELECT COUNT(*) as cnt FROM Breeding $where")->fetch_assoc()['cnt'];
$pages = ceil($total / $per_page);

$result = $conn->query("SELECT * FROM Breeding $where LIMIT $start, $per_page");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Breeding Management</title>
<link rel="icon" type="image/png" href="/assests/image/logo.jpeg" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
<style>
body { background-color: #f4f6f9; }
.wrapper { max-width: 1200px; margin: auto; }
.table-responsive {
    background: white;
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}
</style>
</head>
<body>
<div class="container-fluid mt-4 wrapper">

<div class="d-flex justify-content-between align-items-center mb-3">
    <a href="/pages/admin.php" class="btn btn-outline-success">
      <i class="bi bi-arrow-left-circle"></i> Dashboard
    </a>
    <h3 class="text-success mb-0"><i class="bi bi-heart-pulse-fill me-2"></i>Breeding Records</h3>
    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addBreedingModal">
      <i class="bi bi-plus-circle"></i> Add Record
    </button>
</div>

<!-- Search -->
<form method="get" class="row mb-3">
    <div class="col-md-4">
        <input type="text" name="search" class="form-control" placeholder="Search by Pair ID, Tortoise ID or Date..." value="<?= $search ?>">
    </div>
    <div class="col-md-2">
        <button class="btn btn-outline-success">Search</button>
    </div>
</form>

<!-- Table -->
<div class="table-responsive">
<table class="table table-bordered table-hover align-middle">
<thead class="table-success">
<tr>
<th>Pair ID</th>
<th>Male Tortoise ID</th>
<th>Female Tortoise ID</th>
<th>Nesting Date</th>
<th>Egg Count</th>
<th>Incubation Period (days)</th>
<th>Hatching Success Rate (%)</th>
<th>Observations</th>
<th>Actions</th>
</tr>
</thead>
<tbody>
<?php while($row=$result->fetch_assoc()): ?>
<tr>
<td><?= $row['PairID'] ?></td>
<td><?= $row['MaleTortoiseID'] ?></td>
<td><?= $row['FemaleTortoiseID'] ?></td>
<td><?= $row['NestingDate'] ?></td>
<td><?= $row['EggCount'] ?></td>
<td><?= $row['IncubationPeriod'] ?></td>
<td><?= $row['HatchingSuccessRate'] ?></td>
<td><?= $row['Observations'] ?></td>
<td>
<button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editBreedingModal"
onclick='setEdit(<?= json_encode($row) ?>)'><i class="bi bi-pencil"></i></button>
<a href="breeding.php?delete=<?= $row['PairID'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this record?')"><i class="bi bi-trash"></i></a>
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
<div class="modal fade" id="addBreedingModal" tabindex="-1">
<div class="modal-dialog modal-lg">
<form method="post" class="modal-content">
<div class="modal-header bg-success text-white">
<h5 class="modal-title">Add Breeding Record</h5>
<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
</div>
<div class="modal-body">
<input type="hidden" name="add" value="1">
<div class="row g-3">
<div class="col-md-4"><label class="form-label">Male Tortoise ID</label><input type="number" name="male" class="form-control" min="1" required></div>
<div class="col-md-4"><label class="form-label">Female Tortoise ID</label><input type="number" name="female" class="form-control" min="1" required></div>
<div class="col-md-4"><label class="form-label">Nesting Date</label><input type="date" name="date" class="form-control" required></div>
<div class="col-md-3"><label class="form-label">Egg Count</label><input type="number" name="eggs" class="form-control" min="0"></div>
<div class="col-md-3"><label class="form-label">Incubation Period</label><input type="number" name="incubation" class="form-control" min="0"></div>
<div class="col-md-3"><label class="form-label">Hatching Success Rate (%)</label><input type="number" name="hatchRate" class="form-control" min="0" max="100"></div>
<div class="col-md-3"><label class="form-label">Observations</label><textarea name="obs" class="form-control" rows="1" required></textarea></div>
</div>
</div>
<div class="modal-footer">
<button class="btn btn-success">Save</button>
<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
</div>
</form>
</div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editBreedingModal" tabindex="-1">
<div class="modal-dialog modal-lg">
<form method="post" class="modal-content">
<div class="modal-header bg-warning">
<h5 class="modal-title">Edit Breeding Record</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>
<div class="modal-body">
<input type="hidden" name="update" value="1">
<input type="hidden" name="id" id="edit-id">
<div class="row g-3">
<div class="col-md-4"><label class="form-label">Male Tortoise ID</label><input type="number" name="male" id="edit-male" class="form-control" min="1" required></div>
<div class="col-md-4"><label class="form-label">Female Tortoise ID</label><input type="number" name="female" id="edit-female" class="form-control" min="1" required></div>
<div class="col-md-4"><label class="form-label">Nesting Date</label><input type="date" name="date" id="edit-date" class="form-control" required></div>
<div class="col-md-3"><label class="form-label">Egg Count</label><input type="number" name="eggs" id="edit-eggs" class="form-control" min="0"></div>
<div class="col-md-3"><label class="form-label">Incubation Period</label><input type="number" name="incubation" id="edit-incubation" class="form-control" min="0"></div>
<div class="col-md-3"><label class="form-label">Hatching Success Rate (%)</label><input type="number" name="hatchRate" id="edit-hatchRate" class="form-control" min="0" max="100"></div>
<div class="col-md-3"><label class="form-label">Observations</label><textarea name="obs" id="edit-obs" class="form-control" rows="1" required></textarea></div>
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
  document.getElementById('edit-id').value = data.PairID;
  document.getElementById('edit-male').value = data.MaleTortoiseID;
  document.getElementById('edit-female').value = data.FemaleTortoiseID;
  document.getElementById('edit-date').value = data.NestingDate;
  document.getElementById('edit-eggs').value = data.EggCount;
  document.getElementById('edit-incubation').value = data.IncubationPeriod;
  document.getElementById('edit-hatchRate').value = data.HatchingSuccessRate;
  document.getElementById('edit-obs').value = data.Observations;
}
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
