<?php
session_start();

// Database connection
$conn = new mysqli("localhost", "root", "", "tortoise_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Pagination
$limit = 5;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $limit;

// Fetch environment records
$result = $conn->query("
    SELECT * FROM environment
    ORDER BY RecordDate DESC
    LIMIT $offset, $limit
");

// Count total records
$total_records = $conn->query("SELECT COUNT(*) AS count FROM environment")->fetch_assoc()['count'];
$total_pages = ceil($total_records / $limit);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Researcher - Environment</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<style>
body { display: flex; min-height: 100vh; }
.sidebar {
    min-width: 220px; background-color: #198754; color: white;
}
.sidebar a { color: white; padding: 12px 16px; display: block; text-decoration: none; }
.sidebar a:hover { background-color: #145c32; }
.sidebar a.active { background-color: #145c32; }
.content { flex-grow: 1; padding: 20px; }
.table { background: white; border-radius: 8px; overflow: hidden; }
.pagination { justify-content: center; }
@media (max-width: 768px) {
    .sidebar { position: absolute; left: -220px; top: 0; height: 100%; z-index: 1000; transition: left 0.3s ease; }
    .sidebar.show { left: 0; }
}
</style>
</head>
<body>

<div class="sidebar" id="sidebar">
    <h5 class="text-center py-3 border-bottom border-secondary">Researcher</h5>
    <a href="/pages/researcher_dashboard.php"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a>
    <a href="/pages/researcher-tortoise.php"><i class="bi bi-bug"></i> Tortoise Data</a>
    <a href="/pages/researcher-breeding.php"><i class="bi bi-gender-ambiguous me-2"></i>Breeding</a>
    <a href="#" class="active"><i class="bi bi-globe2 me-2"></i>Environment</a>
    <a href="/pages/researcher-report.php"><i class="bi bi-file-earmark-text"></i> Reports</a>
    <a href="/index.php"><i class="bi bi-box-arrow-right me-2"></i>Logout</a>
</div>

<div class="content">
    <h4 class="mb-3">Environment Conditions</h4>

    <table class="table table-bordered table-striped table-hover">
        <thead class="table-success">
            <tr>
                <th>Enclosure ID</th>
                <th>Temperature (°C)</th>
                <th>Humidity (%)</th>
                <th>Water Quality</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['EnclosureID'] ?></td>
                <td><?= $row['Temperature'] ?></td>
                <td><?= $row['Humidity'] ?></td>
                <td><?= $row['WaterQuality'] ?></td>
                <td><?= $row['RecordDate'] ?></td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>

    <!-- Pagination -->
    <nav>
        <ul class="pagination">
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                    <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
function toggleSidebar() {
    document.getElementById('sidebar').classList.toggle('show');
}
</script>

</body>
</html>
