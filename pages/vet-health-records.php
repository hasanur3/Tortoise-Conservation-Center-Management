<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Health Records - Veterinarian</title>
  <!-- Favicon -->
  <link rel="icon" type="image/png" href="/assests/image/logo.jpeg" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
  <style>
    body {
      background-color: #e9f5ea;
    }
    .sidebar {
      height: 100vh;
      background-color: #198754;
      color: white;
      position: fixed;
      width: 220px;
      transition: width 0.3s;
      overflow-y: auto;
    }
    .sidebar.collapsed {
      width: 70px;
    }
    .sidebar .nav-link {
      color: white;
      font-weight: 500;
      padding: 12px 20px;
      white-space: nowrap;
    }
    .sidebar .nav-link:hover,
    .sidebar .nav-link.active {
      background-color: #145c32;
      color: #fff;
    }
    .sidebar .nav-link i {
      font-size: 1.3rem;
      margin-right: 12px;
      vertical-align: middle;
    }
    .sidebar.collapsed .nav-link span {
      display: none;
    }
    .sidebar.collapsed .nav-link i {
      margin-right: 0;
      text-align: center;
      width: 100%;
    }
    main {
      margin-left: 220px;
      padding: 20px;
      transition: margin-left 0.3s;
      min-height: 100vh;
    }
    main.collapsed {
      margin-left: 70px;
    }
    /* Mobile */
    @media (max-width: 768px) {
      .sidebar {
        position: fixed;
        left: -220px;
        z-index: 1030;
      }
      .sidebar.show {
        left: 0;
      }
      main, main.collapsed {
        margin-left: 0;
      }
    }
  </style>
</head>
<body>

  <!-- Sidebar -->
  <nav id="sidebar" class="sidebar d-flex flex-column">
    <div class="d-flex align-items-center justify-content-between px-3 py-3 border-bottom border-success">
      <span class="fs-4 fw-bold">Vet Dashboard</span>
      <button id="sidebarCollapse" class="btn btn-sm btn-success d-md-none">
        <i class="bi bi-x"></i>
      </button>
    </div>

    <ul class="nav flex-column mt-3">
      <li class="nav-item">
        <a href="/pages/veterinarian_dashboard.html" class="nav-link">
          <i class="bi bi-speedometer2"></i> <span>Dashboard</span>
        </a>
      </li>
      <li class="nav-item">
        <a href="#" class="nav-link active">
          <i class="bi bi-file-medical"></i> <span>Health Records</span>
        </a>
      </li>
      <li class="nav-item">
        <a href="vet-medical-treatments.html" class="nav-link">
          <i class="bi bi-heart-pulse"></i> <span>Medical Treatments</span>
        </a>
      </li>
      <li class="nav-item">
        <a href="vet-vaccinations.html" class="nav-link">
          <i class="bi bi-capsule"></i> <span>Vaccinations</span>
        </a>
      </li>
      <li class="nav-item">
        <a href="vet-environment.html" class="nav-link">
          <i class="bi bi-thermometer-half"></i> <span>Environment</span>
        </a>
      </li>
      <li class="nav-item mt-auto">
        <a href="/index.html" class="nav-link">
          <i class="bi bi-box-arrow-right"></i> <span>Logout</span>
        </a>
      </li>
    </ul>

    <button id="toggleSidebarBtn" class="btn btn-success mt-auto mx-3 mb-3 d-none d-md-block" title="Toggle Sidebar">
      <i class="bi bi-chevron-left"></i>
    </button>
  </nav>

  <!-- Main content -->
  <main id="mainContent">
    <nav class="navbar navbar-expand-lg navbar-dark bg-success mb-4">
      <div class="container-fluid">
        <button id="sidebarToggle" class="btn btn-success d-md-none">
          <i class="bi bi-list"></i>
        </button>
        <span class="navbar-brand ms-2">Health Records</span>
      </div>
    </nav>

    <div class="container-fluid">
      <h3 class="mb-3">Tortoise Health Records</h3>

      <!-- Add Health Record Form -->
      <div class="card mb-4">
        <div class="card-header bg-success text-white">Add New Health Record</div>
        <div class="card-body">
          <form id="healthRecordForm">
            <div class="row g-3">
              <div class="col-md-4">
                <label class="form-label">Tortoise ID</label>
                <input type="text" class="form-control" required />
              </div>
              <div class="col-md-4">
                <label class="form-label">Date of Assessment</label>
                <input type="date" class="form-control" required />
              </div>
              <div class="col-md-4">
                <label class="form-label">Health Status</label>
                <select class="form-select" required>
                  <option selected disabled>Select Status</option>
                  <option value="Good">Good</option>
                  <option value="Fair">Fair</option>
                  <option value="Poor">Poor</option>
                </select>
              </div>
              <div class="col-md-6">
                <label class="form-label">Observations</label>
                <textarea class="form-control" rows="2"></textarea>
              </div>
              <div class="col-md-6">
                <label class="form-label">Vet Comments</label>
                <textarea class="form-control" rows="2"></textarea>
              </div>
            </div>
            <div class="mt-3">
              <button type="submit" class="btn btn-success">
                <i class="bi bi-plus-circle"></i> Add Record
              </button>
            </div>
          </form>
        </div>
      </div>

      <!-- Records Table -->
      <div class="card">
        <div class="card-header bg-secondary text-white">All Health Records</div>
        <div class="card-body table-responsive">
          <table class="table table-bordered table-hover align-middle">
            <thead class="table-success">
              <tr>
                <th>Tortoise ID</th>
                <th>Date</th>
                <th>Status</th>
                <th>Observations</th>
                <th>Vet Comments</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>T001</td>
                <td>2025-07-20</td>
                <td><span class="badge bg-success">Good</span></td>
                <td>Active and eating well</td>
                <td>No issues</td>
                <td>
                  <button class="btn btn-sm btn-outline-primary" title="Edit"><i class="bi bi-pencil-square"></i></button>
                  <button class="btn btn-sm btn-outline-danger" title="Delete"><i class="bi bi-trash"></i></button>
                </td>
              </tr>
              <!-- More records here -->
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </main>

  <!-- Scripts -->
  <script>
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('mainContent');
    const toggleSidebarBtn = document.getElementById('toggleSidebarBtn');
    const sidebarCollapse = document.getElementById('sidebarCollapse');
    const sidebarToggle = document.getElementById('sidebarToggle');

    // Desktop toggle sidebar
    toggleSidebarBtn.addEventListener('click', () => {
      sidebar.classList.toggle('collapsed');
      mainContent.classList.toggle('collapsed');

      const icon = toggleSidebarBtn.querySelector('i');
      icon.classList.toggle('bi-chevron-left');
      icon.classList.toggle('bi-chevron-right');
    });

    // Close sidebar on mobile
    sidebarCollapse.addEventListener('click', () => {
      sidebar.classList.remove('show');
    });

    // Open sidebar on mobile
    sidebarToggle.addEventListener('click', () => {
      sidebar.classList.add('show');
    });
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
