<?php
// vet_vaccinations.php
$conn = new mysqli("localhost","root","","tortoise_db");
if($conn->connect_error) die("DB Connection failed: ".$conn->connect_error);

// Add/Edit Vaccination
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $id = $_POST['vaccinationId'] ?? null;
    $tortoise = $_POST['tortoiseID'];
    $vaccine = $_POST['vaccineType'];
    $date = $_POST['vaccineDate'];

    if($id){
        $stmt = $conn->prepare("UPDATE vet_vaccinations SET TortoiseID=?, VaccineType=?, VaccinationDate=? WHERE VaccinationID=?");
        $stmt->bind_param("sssi",$tortoise,$vaccine,$date,$id);
        $stmt->execute();
    }else{
        $stmt = $conn->prepare("INSERT INTO vet_vaccinations (TortoiseID, VaccineType, VaccinationDate) VALUES (?,?,?)");
        $stmt->bind_param("sss",$tortoise,$vaccine,$date);
        $stmt->execute();
    }
    header("Location: ".$_SERVER['PHP_SELF']); exit;
}

// Delete Vaccination
if(isset($_GET['delete'])){
    $id = (int)$_GET['delete'];
    $conn->query("DELETE FROM vet_vaccinations WHERE VaccinationID=$id");
    header("Location: ".$_SERVER['PHP_SELF']); exit;
}

// Fetch records
$result = $conn->query("SELECT * FROM vet_vaccinations ORDER BY VaccinationDate DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Vaccinations - Veterinarian</title>
<link rel="icon" href="/assests/image/logo.jpeg">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<style>
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

<nav id="sidebar" class="sidebar d-flex flex-column">
<div class="d-flex align-items-center justify-content-between px-3 py-3 border-bottom border-success">
<span class="fs-4 fw-bold">Vet Dashboard</span>
<button id="sidebarCollapse" class="btn btn-sm btn-success d-md-none"><i class="bi bi-x"></i></button>
</div>
<ul class="nav flex-column mt-3">
<li class="nav-item"><a href="/pages/veterinarian_dashboard.php" class="nav-link"><i class="bi bi-speedometer2"></i> <span>Dashboard</span></a></li>
<li class="nav-item"><a href="/pages/vet-health-records.php" class="nav-link"><i class="bi bi-file-medical"></i> <span>Health Records</span></a></li>
<li class="nav-item"><a href="/pages/vet-medical-treatments.php" class="nav-link"><i class="bi bi-heart-pulse"></i> <span>Medical Treatments</span></a></li>
<li class="nav-item"><a href="#" class="nav-link active"><i class="bi bi-capsule"></i> <span>Vaccinations</span></a></li>
<li class="nav-item mt-auto"><a href="/index.php" class="nav-link"><i class="bi bi-box-arrow-right"></i> <span>Logout</span></a></li>
</ul>
<button id="toggleSidebarBtn" class="btn btn-success mt-auto mx-3 mb-3 d-none d-md-block"><i class="bi bi-chevron-left"></i></button>
</nav>

<main id="mainContent">
<nav class="navbar navbar-expand-lg navbar-dark bg-success mb-4">
<div class="container-fluid">
<button id="sidebarToggle" class="btn btn-success d-md-none"><i class="bi bi-list"></i></button>
<span class="navbar-brand ms-2">Vaccinations</span>
</div>
</nav>

<div class="container-fluid">
<h3 class="mb-3">Manage Vaccination Records</h3>

<div class="card mb-4">
<div class="card-header bg-success text-white">Add / Edit Vaccination</div>
<div class="card-body">
<form id="vaccineForm" method="POST">
<input type="hidden" name="vaccinationId" id="vaccinationId">
<div class="row g-3">
<div class="col-md-4"><label class="form-label">Tortoise ID</label><input type="text" class="form-control" name="tortoiseID" id="tortoiseID" required></div>
<div class="col-md-4"><label class="form-label">Vaccine Type</label><input type="text" class="form-control" name="vaccineType" id="vaccineType" required></div>
<div class="col-md-4"><label class="form-label">Date</label><input type="date" class="form-control" name="vaccineDate" id="vaccineDate" required></div>
</div>
<div class="mt-3">
<button type="submit" class="btn btn-success"><i class="bi bi-plus-circle"></i> Save Vaccination</button>
<button type="button" id="resetForm" class="btn btn-secondary">Reset</button>
</div>
</form>
</div>
</div>

<div class="card">
<div class="card-header bg-secondary text-white">All Vaccination Records</div>
<div class="card-body table-responsive">
<table class="table table-bordered table-hover align-middle">
<thead class="table-success"><tr>
<th>Tortoise ID</th><th>Vaccine Type</th><th>Date</th><th>Actions</th>
</tr></thead>
<tbody>
<?php while($row=$result->fetch_assoc()): ?>
<tr>
<td><?= htmlspecialchars($row['TortoiseID']) ?></td>
<td><?= htmlspecialchars($row['VaccineType']) ?></td>
<td><?= $row['VaccinationDate'] ?></td>
<td>
<button class="btn btn-sm btn-outline-primary editBtn"
data-id="<?= $row['VaccinationID'] ?>"
data-tortoise="<?= htmlspecialchars($row['TortoiseID']) ?>"
data-vaccine="<?= htmlspecialchars($row['VaccineType']) ?>"
data-date="<?= $row['VaccinationDate'] ?>"><i class="bi bi-pencil-square"></i></button>
<a href="?delete=<?= $row['VaccinationID'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this vaccination?')"><i class="bi bi-trash"></i></a>
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
const sidebar=document.getElementById('sidebar');
const mainContent=document.getElementById('mainContent');
document.getElementById('toggleSidebarBtn').addEventListener('click',()=>{sidebar.classList.toggle('collapsed');mainContent.classList.toggle('collapsed');document.getElementById('toggleSidebarBtn').querySelector('i').classList.toggle('bi-chevron-left');document.getElementById('toggleSidebarBtn').querySelector('i').classList.toggle('bi-chevron-right');});
document.getElementById('sidebarCollapse').addEventListener('click',()=>sidebar.classList.remove('show'));
document.getElementById('sidebarToggle').addEventListener('click',()=>sidebar.classList.add('show'));

// Edit buttons
document.querySelectorAll('.editBtn').forEach(btn=>{
btn.addEventListener('click',()=>{
document.getElementById('vaccinationId').value=btn.dataset.id;
document.getElementById('tortoiseID').value=btn.dataset.tortoise;
document.getElementById('vaccineType').value=btn.dataset.vaccine;
document.getElementById('vaccineDate').value=btn.dataset.date;
window.scrollTo({top:0,behavior:'smooth'});
});
});

// Reset form
document.getElementById('resetForm').addEventListener('click',()=>{
document.getElementById('vaccineForm').reset();
document.getElementById('vaccinationId').value='';
});
</script>
</body>
</html>
