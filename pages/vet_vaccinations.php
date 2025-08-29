<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Vaccinations - Veterinarian</title>
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
      <a href="/pages/vet-health-records.html" class="nav-link">
        <i class="bi bi-file-medical"></i> <span>Health Records</span>
      </a>
    </li>
    <li class="nav-item">
      <a href="/pages/vet-medical-treatments.html" class="nav-link">
        <i class="bi bi-heart-pulse"></i> <span>Medical Treatments</span>
      </a>
    </li>
    <li class="nav-item">
      <a href="#" class="nav-link active">
        <i class="bi bi-capsule"></i> <span>Vaccinations</span>
      </a>
    </li>
    <li class="nav-item">
      <a href="/pages/vet-environment.html" class="nav-link">
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

<!-- Main Content -->
<main id="mainContent">
  <nav class="navbar navbar-expand-lg navbar-dark bg-success mb-4">
    <div class="container-fluid">
      <button id="sidebarToggle" class="btn btn-success d-md-none">
        <i class="bi bi-list"></i>
      </button>
      <span class="navbar-brand ms-2">Vaccinations</span>
    </div>
  </nav>

  <div class="container-fluid">
    <h3 class="mb-3">Manage Vaccination Records</h3>

    <!-- Vaccination Form -->
    <div class="card mb-4">
      <div class="card-header bg-success text-white">Add New Vaccination</div>
      <div class="card-body">
        <form id="vaccineForm">
          <div class="row g-3">
            <div class="col-md-4">
              <label class="form-label">Tortoise ID</label>
              <input type="text" id="tortoiseId" class="form-control" required>
            </div>
            <div class="col-md-4">
              <label class="form-label">Vaccine Type</label>
              <input type="text" id="vaccineType" class="form-control" required>
            </div>
            <div class="col-md-4">
              <label class="form-label">Date</label>
              <input type="date" id="vaccineDate" class="form-control" required>
            </div>
          </div>
          <div class="mt-3">
            <button type="submit" class="btn btn-success">
              <i class="bi bi-plus-circle"></i> Add Vaccination
            </button>
          </div>
        </form>
      </div>
    </div>

    <!-- Vaccination Table -->
    <div class="card">
      <div class="card-header bg-secondary text-white">All Vaccination Records</div>
      <div class="card-body table-responsive">
        <table class="table table-bordered table-hover align-middle" id="vaccineTable">
          <thead class="table-success">
            <tr>
              <th>Tortoise ID</th>
              <th>Vaccine Type</th>
              <th>Date</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>TRT-001</td>
              <td>ShellGuard</td>
              <td>2025-07-15</td>
              <td>
                <button class="btn btn-sm btn-outline-primary edit-btn" title="Edit">
                  <i class="bi bi-pencil-square"></i>
                </button>
                <button class="btn btn-sm btn-outline-danger delete-btn" title="Delete">
                  <i class="bi bi-trash"></i>
                </button>
              </td>
            </tr>
            <!-- More rows added dynamically -->
          </tbody>
        </table>
      </div>
    </div>
  </div>
</main>

<script>
  const sidebar = document.getElementById('sidebar');
  const mainContent = document.getElementById('mainContent');
  const toggleSidebarBtn = document.getElementById('toggleSidebarBtn');
  const sidebarCollapse = document.getElementById('sidebarCollapse');
  const sidebarToggle = document.getElementById('sidebarToggle');

  toggleSidebarBtn.addEventListener('click', () => {
    sidebar.classList.toggle('collapsed');
    mainContent.classList.toggle('collapsed');
    toggleSidebarBtn.querySelector('i').classList.toggle('bi-chevron-left');
    toggleSidebarBtn.querySelector('i').classList.toggle('bi-chevron-right');
  });

  sidebarCollapse.addEventListener('click', () => {
    sidebar.classList.remove('show');
  });

  sidebarToggle.addEventListener('click', () => {
    sidebar.classList.add('show');
  });

  // Vaccination data handling
  const vaccineForm = document.getElementById("vaccineForm");
  const vaccineTableBody = document.querySelector("#vaccineTable tbody");
  let vaccinations = JSON.parse(localStorage.getItem("vaccinations") || "[]");

  function renderVaccinations() {
    vaccineTableBody.innerHTML = `
      <tr>
        <td>TRT-001</td>
        <td>ShellGuard</td>
        <td>2025-07-15</td>
        <td>
          <button class="btn btn-sm btn-outline-primary edit-btn" title="Edit">
            <i class="bi bi-pencil-square"></i>
          </button>
          <button class="btn btn-sm btn-outline-danger delete-btn" title="Delete">
            <i class="bi bi-trash"></i>
          </button>
        </td>
      </tr>`;

    vaccinations.forEach((v, index) => {
      const row = document.createElement('tr');
      row.innerHTML = `
        <td>${v.tortoiseId}</td>
        <td>${v.vaccineType}</td>
        <td>${v.vaccineDate}</td>
        <td>
          <button class="btn btn-sm btn-outline-primary edit-btn" data-index="${index}" title="Edit">
            <i class="bi bi-pencil-square"></i>
          </button>
          <button class="btn btn-sm btn-outline-danger delete-btn" data-index="${index}" title="Delete">
            <i class="bi bi-trash"></i>
          </button>
        </td>`;
      vaccineTableBody.appendChild(row);
    });

    addTableEventListeners();
  }

  function addTableEventListeners() {
    // Edit buttons
    document.querySelectorAll('.edit-btn').forEach(btn => {
      btn.onclick = function() {
        const idx = this.dataset.index;
        if (idx !== undefined) {
          const v = vaccinations[idx];
          document.getElementById('tortoiseId').value = v.tortoiseId;
          document.getElementById('vaccineType').value = v.vaccineType;
          document.getElementById('vaccineDate').value = v.vaccineDate;
          // Change button text to 'Update Vaccination' when editing
          vaccineForm.querySelector('button[type="submit"]').textContent = ' Update Vaccination';
          vaccineForm.querySelector('button[type="submit"]').insertAdjacentHTML('afterbegin', '<i class="bi bi-pencil-square"></i>');
          vaccineForm.dataset.editIndex = idx;
        }
      };
    });

    // Delete buttons
    document.querySelectorAll('.delete-btn').forEach(btn => {
      btn.onclick = function() {
        const idx = this.dataset.index;
        if (idx !== undefined) {
          if (confirm('Are you sure you want to delete this record?')) {
            vaccinations.splice(idx, 1);
            localStorage.setItem("vaccinations", JSON.stringify(vaccinations));
            renderVaccinations();
          }
        }
      };
    });
  }

  vaccineForm.addEventListener("submit", function(e) {
    e.preventDefault();
    const tortoiseId = document.getElementById("tortoiseId").value.trim();
    const vaccineType = document.getElementById("vaccineType").value.trim();
    const vaccineDate = document.getElementById("vaccineDate").value;

    if (vaccineForm.dataset.editIndex !== undefined) {
      // Update existing record
      const idx = vaccineForm.dataset.editIndex;
      vaccinations[idx] = { tortoiseId, vaccineType, vaccineDate };
      delete vaccineForm.dataset.editIndex;
      vaccineForm.querySelector('button[type="submit"]').innerHTML = '<i class="bi bi-plus-circle"></i> Add Vaccination';
    } else {
      // Add new record
      vaccinations.push({ tortoiseId, vaccineType, vaccineDate });
    }

    localStorage.setItem("vaccinations", JSON.stringify(vaccinations));
    vaccineForm.reset();
    renderVaccinations();
  });

  renderVaccinations();
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
