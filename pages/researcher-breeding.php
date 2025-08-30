<?php
session_start();

// Connect to DB
$conn = new mysqli("localhost", "root", "", "tortoise_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Pagination
$limit = 5;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $limit;

// Fetch breeding records (join tortoise table to get names)
$result = $conn->query("
    SELECT b.*, t1.Name AS MaleName, t2.Name AS FemaleName
    FROM breeding b
    JOIN tortoise t1 ON b.MaleTortoiseID = t1.ID
    JOIN tortoise t2 ON b.FemaleTortoiseID = t2.ID
    ORDER BY b.NestingDate DESC
    LIMIT $offset, $limit
");

// Count total records
$total_records = $conn->query("SELECT COUNT(*) AS count FROM breeding")->fetch_assoc()['count'];
$total_pages = ceil($total_records / $limit);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Researcher Breeding Records</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<style>
body { display: flex; }
.sidebar {
    width: 250px; height: 100vh; background-color: #198754; color: white; padding-top: 20px; position: fixed;
}
.sidebar a { color: white; text-decoration: none; padding: 10px 20px; display: block; }
.sidebar a:hover { background-color: #145c32; }
.content { margin-left: 250px; padding: 20px; width: 100%; }
@media (max-width: 768px) {
    .sidebar { position: absolute; left: -250px; transition: left 0.3s; }
    .sidebar.show { left: 0; }
    .content { margin-left: 0; }
}
.table { background: white; border-radius: 8px; overflow: hidden; }
.pagination { justify-content: center; }
</style>
</head>
<body>

<div class="sidebar" id="sidebar">
    <h4 class="text-center mb-4">Researcher</h4>
    <a href="/pages/researcher_dashboard.php"><i class="bi bi-speedometer2"></i> Dashboard</a>
    <a href="/pages/researcher-tortoise.php"><i class="bi bi-bug"></i> Tortoise Data</a>
    <a href="#" class="bg-secondary"><i class="bi bi-gender-ambiguous"></i> Breeding</a>
    <a href="/pages/researcher-environment.php"><i class="bi bi-globe"></i> Environment</a>
    <a href="/pages/researcher-report.php"><i class="bi bi-file-earmark-text"></i> Reports</a>
    <a href="/index.php"><i class="bi bi-box-arrow-right"></i> Logout</a>
</div>

<div class="content">
    <button class="btn btn-outline-success d-md-none mb-3" onclick="toggleSidebar()">
        <i class="bi bi-list"></i>
    </button>

    <h4 class="mb-3">Breeding Records</h4>

    <table class="table table-bordered table-hover">
        <thead class="table-success">
            <tr>
                <th>Mating Pair</th>
                <th>Nesting Date</th>
                <th>Egg Count</th>
                <th>Incubation (days)</th>
                <th>Hatch Rate</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['MaleName'] ?> & <?= $row['FemaleName'] ?></td>
                <td><?= $row['NestingDate'] ?></td>
                <td><?= $row['EggCount'] ?></td>
                <td><?= $row['IncubationPeriod'] ?></td>
                <td><?= $row['HatchingSuccessRate'] ?>%</td>
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
