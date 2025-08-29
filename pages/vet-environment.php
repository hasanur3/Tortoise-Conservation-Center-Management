<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Environment Monitoring - Veterinarian</title>
  <!-- Favicon -->
  <link rel="icon" type="image/png" href="/assests/image/logo.jpeg" />
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      display: flex;
      min-height: 100vh;
      background-color: #f5f5f5;
    }
    .sidebar {
      width: 300px;
      background-color: #198754;
      padding: 20px;
    }
    .sidebar a {
      display: block;
      padding: 12px;
      color: #fff;
      text-decoration: none;
      border-radius: 8px;
      margin-bottom: 10px;
    }
    .sidebar a:hover, .sidebar a.active {
      background-color: #166534;
    }
    .main-content {
      flex-grow: 1;
      padding: 20px;
    }
    .navbar {
      background-color: #198754;
    }
    .navbar-brand, .navbar-toggler {
      color: white !important;
    }
    .navbar-toggler-icon {
      filter: invert(1);
    }
    .table th {
      background-color: #e2e8f0;
    }
  </style>
</head>
<body>

  <!-- Sidebar -->
  <div class="sidebar d-lg-block collapse" id="sideNavbar">
    <h4 class="text-white mb-4">Veterinarian</h4>
    <a href="/pages/veterinarian_dashboard.html"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a>
    <a href="/pages/vet-health-records.html"><i class="bi bi-journal-medical me-2"></i>Health Records</a>
    <a href="/pages/vet-medical-treatments.html"><i class="bi bi-heart-pulse me-2"></i>Medical Treatments</a>
    <a href="/pages/vet_vaccinations.html"><i class="bi bi-capsule me-2"></i>Vaccinations</a>
    <a href="#" class="active"><i class="bi bi-cloud-sun me-2"></i>Environment</a>
    <a href="/index.html"><i class="bi bi-box-arrow-right me-2"></i>Logout</a>
  </div>

  <!-- Main Content -->
  <div class="main-content w-100">

    <!-- Top Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark px-3">
      <div class="container-fluid">
        <a class="navbar-brand" href="#">Environment Monitoring</a>
        <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#sideNavbar">
          <span class="navbar-toggler-icon"></span>
        </button>
      </div>
    </nav>

    <!-- Page Content -->
    <div class="container mt-4">
      <h3 class="mb-4">Environment Conditions by Enclosure</h3>
      <div class="table-responsive">
        <table class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>Enclosure ID</th>
              <th>Habitat Type</th>
              <th>Temperature (°C)</th>
              <th>Humidity (%)</th>
              <th>Water Quality</th>
              <th>Last Inspection</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>ENC001</td>
              <td>Tropical</td>
              <td>28</td>
              <td>75</td>
              <td>Good</td>
              <td>2025-07-20</td>
            </tr>
            <!-- More data rows can be added here -->
          </tbody>
        </table>
      </div>
    </div>

  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
