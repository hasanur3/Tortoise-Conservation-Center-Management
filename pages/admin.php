<?php
session_start();
$conn = new mysqli("localhost", "root", "", "tortoise_db");
if ($conn->connect_error) die("DB connection failed: " . $conn->connect_error);

// Admin session check
if (!isset($_SESSION['userId']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Function to get top stats
function getStats($conn) {
    $today = date('Y-m-d');
    $totalTortoises = $conn->query("SELECT COUNT(*) AS total FROM tortoise")->fetch_assoc()['total'];
    $activeBreeding = $conn->query("SELECT COUNT(*) AS total FROM breeding WHERE HatchingSuccessRate IS NOT NULL")->fetch_assoc()['total'];
    $feedingToday = $conn->query("SELECT COUNT(*) AS total FROM feeding WHERE DATE(DateTime) = '$today'")->fetch_assoc()['total'];
    return ['tortoises'=>$totalTortoises, 'breeding'=>$activeBreeding, 'feeding'=>$feedingToday];
}

// Handle AJAX request for stats
if (isset($_GET['action']) && $_GET['action'] === 'stats') {
    echo json_encode(getStats($conn));
    exit();
}

// Initial stats for page load
$stats = getStats($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Tortoise Conservation Admin Dashboard</title>
<link rel="icon" type="image/png" href="/assests/image/logo.jpeg" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
<link rel="stylesheet" href="/assests/Style/adminDashboard.css" />
<style>
  body {
    background-color: #f8f9fa;
    font-family: 'Segoe UI', sans-serif;
  }
  .sidebar {
    background-color: #198754;
    min-height: 100vh;
  }
  .sidebar .nav-link {
    color: white;
  }
  .sidebar .nav-link:hover,
  .sidebar .nav-link.active {
    background-color: #157347;
    color: #fff;
  }
  .content {
    padding: 2rem;
  }

  body { background-color: #e9f5ea; /* same as example */ } /* Sidebar */ #sidebar { height: 100vh; background-color: #198754; /* green */ color: white; position: fixed; width: 220px; transition: width 0.3s, left 0.3s; display: flex; flex-direction: column; padding-top: 1rem; z-index: 1040; } #sidebar.collapsed { width: 70px; } #sidebar .nav-link { color: white; font-weight: 500; padding: 12px 20px; display: flex; align-items: center; gap: 12px; white-space: nowrap; } #sidebar .nav-link:hover, #sidebar .nav-link.active { background-color: #145c32; color: #fff; } #sidebar.collapsed .nav-link span { display: none; } #sidebar.collapsed .nav-link i { margin-right: 0; text-align: center; width: 100%; } /* Sidebar header */ #sidebar .sidebar-header { display: flex; justify-content: space-between; align-items: center; padding: 0 1rem 1rem 1rem; border-bottom: 1px solid rgba(255,255,255,0.3); } #sidebar .sidebar-header span { font-size: 1.5rem; font-weight: 700; color: white; user-select: none; } /* Main content */ main#mainContent { margin-left: 220px; padding: 20px; transition: margin-left 0.3s; } main#mainContent.collapsed { margin-left: 70px; } /* Toggle button desktop */ #toggleSidebarBtn { background-color: transparent; border: none; color: white; font-size: 1.5rem; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; cursor: pointer; user-select: none; } /* Mobile styles */ @media (max-width: 768px) { #sidebar { left: -220px; width: 220px; position: fixed; top: 0; bottom: 0; transition: left 0.3s; } #sidebar.show { left: 0; } main#mainContent, main#mainContent.collapsed { margin-left: 0; padding: 20px 10px; } /* Show hamburger toggle in navbar */ #mobileSidebarToggle { display: inline-flex !important; } } /* Hide mobile toggle button by default */ #mobileSidebarToggle { display: none; background-color: transparent; border: none; color: white; font-size: 1.5rem; user-select: none; } /* Sidebar close button on mobile */ #sidebarCloseBtn { background: transparent; border: none; color: white; font-size: 1.5rem; padding: 0.25rem 0.75rem; align-self: flex-end; cursor: pointer; user-select: none; }

  
</style>
</head>
<body>

<!-- Sidebar (unchanged) -->
<nav id="sidebar" class="d-flex flex-column">
  <div class="sidebar-header">
    <span>Admin Panel</span>
    <button id="sidebarCloseBtn" class="d-md-none">
      <i class="bi bi-x"></i>
    </button>
  </div>
  <ul class="nav flex-column mt-3">
    <li class="nav-item"><a href="#" class="nav-link active"><i class="bi bi-house-door"></i> <span>Dashboard</span></a></li>
    <li class="nav-item"><a href="/pages/tortoise.php" class="nav-link"><i class="bi bi-bug"></i> <span>Tortoises</span></a></li>
    <li class="nav-item"><a href="/pages/enclosure.php" class="nav-link"><i class="bi bi-tree"></i> <span>Enclosures</span></a></li>
    <li class="nav-item"><a href="/pages/breeding.php" class="nav-link"><i class="bi bi-egg"></i> <span>Breeding</span></a></li>
    <li class="nav-item"><a href="/pages/feeding.php" class="nav-link"><i class="bi bi-nut"></i> <span>Feeding</span></a></li>
    <li class="nav-item"><a href="/pages/health.php" class="nav-link"><i class="bi bi-heart-pulse"></i> <span>Health</span></a></li>
    <li class="nav-item"><a href="/pages/environment.php" class="nav-link"><i class="bi bi-thermometer-half"></i> <span>Environment</span></a></li>
    <li class="nav-item"><a href="/pages/staff.php" class="nav-link"><i class="bi bi-people"></i> <span>Staff</span></a></li>
    <li class="nav-item"><a href="/pages/reports.php" class="nav-link"><i class="bi bi-pie-chart"></i> <span>Reports</span></a></li>
    <li class="nav-item mt-auto"><a href="/index.php" class="nav-link"><i class="bi bi-box-arrow-right"></i> <span>Logout</span></a></li>
  </ul>
  <button id="toggleSidebarBtn" class="d-none d-md-flex align-items-center justify-content-center mx-auto mb-3">
    <i class="bi bi-chevron-left"></i>
  </button>
</nav>

<main id="mainContent">
  <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #198754;">
    <div class="container-fluid">
      <button id="mobileSidebarToggle" class="btn d-md-none">
        <i class="bi bi-list"></i>
      </button>
      <span class="navbar-brand ms-2">Admin Dashboard</span>
    </div>
  </nav>

  <div class="container-fluid pt-3">
    <div class="row g-4">
      <div class="col-md-6 col-lg-4">
        <div class="card border-success">
          <div class="card-body">
            <h5 class="card-title text-success">Total Tortoises</h5>
            <p class="card-text fs-4" id="totalTortoises"><?= $stats['tortoises'] ?></p>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-lg-4">
        <div class="card border-success">
          <div class="card-body">
            <h5 class="card-title text-success">Active Breeding Pairs</h5>
            <p class="card-text fs-4" id="activeBreeding"><?= $stats['breeding'] ?></p>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-lg-4">
        <div class="card border-success">
          <div class="card-body">
            <h5 class="card-title text-success">Feeding Tasks Today</h5>
            <p class="card-text fs-4" id="feedingToday"><?= $stats['feeding'] ?></p>
          </div>
        </div>
      </div>
    </div>

    <!-- Charts -->
    <div class="row mt-5">
      <div class="col-lg-6"><canvas id="barChart"></canvas></div>
      <div class="col-lg-6"><canvas id="pieChart"></canvas></div>
    </div>
  </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="/Js/adminDashboard.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
  const sidebar = document.getElementById('sidebar');
  const mainContent = document.getElementById('mainContent');
  const toggleSidebarBtn = document.getElementById('toggleSidebarBtn');
  const mobileSidebarToggle = document.getElementById('mobileSidebarToggle');
  const sidebarCloseBtn = document.getElementById('sidebarCloseBtn');

  toggleSidebarBtn?.addEventListener('click', () => {
    sidebar.classList.toggle('collapsed');
    mainContent.classList.toggle('collapsed');
    toggleSidebarBtn.querySelector('i').classList.toggle('bi-chevron-left');
    toggleSidebarBtn.querySelector('i').classList.toggle('bi-chevron-right');
  });
  mobileSidebarToggle?.addEventListener('click', () => sidebar.classList.add('show'));
  sidebarCloseBtn?.addEventListener('click', () => sidebar.classList.remove('show'));
  sidebar.querySelectorAll('.nav-link').forEach(link => {
    link.addEventListener('click', () => { if(window.innerWidth < 768) sidebar.classList.remove('show'); });
  });

  // Auto-refresh top cards every 30 seconds
  function refreshStats() {
    fetch('dashboard.php?action=stats')
      .then(res => res.json())
      .then(data => {
        document.getElementById('totalTortoises').textContent = data.tortoises;
        document.getElementById('activeBreeding').textContent = data.breeding;
        document.getElementById('feedingToday').textContent = data.feeding;
      })
      .catch(err => console.error('Error fetching stats:', err));
  }
  setInterval(refreshStats, 30000);
</script>
</body>
</html>
