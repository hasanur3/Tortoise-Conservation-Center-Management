<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Researcher - Environment</title>
  <link rel="icon" type="image/png" href="/assests/image/logo.jpeg" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet"/>
  <style>
    body {
      display: flex;
      min-height: 100vh;
    }
    .sidebar {
      min-width: 220px;
      background-color: #198754;
      color: white;
    }
    .sidebar a {
      color: white;
      padding: 12px 16px;
      display: block;
      text-decoration: none;
    }
    .sidebar a:hover {
      background-color: #145c32;
    }
    .content {
      flex-grow: 1;
      padding: 20px;
    }
    @media (max-width: 768px) {
      .sidebar {
        position: absolute;
        left: -220px;
        top: 0;
        height: 100%;
        z-index: 1000;
        transition: left 0.3s ease;
      }
      .sidebar.show {
        left: 0;
      }
    }
  </style>
</head>
<body>
  <!-- Sidebar -->
  <div class="sidebar" id="sidebar">
    <h5 class="text-center py-3 border-bottom border-secondary">Researcher</h5>
    <a href="/pages/researcher_dashboard.html"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a>
    <a href="/pages/researcher-tortoise.html"><i class="bi bi-bug"></i> Tortoise Data</a>
    <a href="/pages/researcher-breeding.html"><i class="bi bi-gender-ambiguous me-2"></i>Breeding</a>
    <a href="#" class="bg-success"><i class="bi bi-globe2 me-2"></i>Environment</a>
    <a href="/pages/researcher-report.html"><i class="bi bi-file-earmark-text"></i> Reports</a>
    <a href="/index.html"><i class="bi bi-box-arrow-right me-2"></i>Logout</a>
  </div>

  <!-- Page Content -->
  <div class="content">
    <!-- Top Nav for Mobile -->
    <nav class="navbar navbar-expand-lg navbar-light bg-success text-white mb-4">
      <div class="container-fluid">
        <button class="btn btn-outline-light d-md-none" onclick="toggleSidebar()">
          <i class="bi bi-list"></i>
        </button>
        <span class="navbar-brand mb-0 h5 text-white">Environment Monitoring</span>
      </div>
    </nav>

    <!-- Table Section -->
    <div class="card shadow-sm">
      <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
        <span>Environment Conditions</span>
        <button class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#addRecordModal">
          <i class="bi bi-plus-circle me-1"></i>Add Record
        </button>
      </div>
      <div class="card-body">
        <table class="table table-bordered table-striped table-hover" id="envTable">
          <thead class="table-success">
            <tr>
              <th>Enclosure ID</th>
              <th>Temperature (°C)</th>
              <th>Humidity (%)</th>
              <th>Water Quality</th>
              <th>Date</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>ENC001</td>
              <td>29.5</td>
              <td>70</td>
              <td>Good</td>
              <td>2025-07-30</td>
              <td>
                <button class="btn btn-sm btn-danger" onclick="deleteRow(this)">
                  <i class="bi bi-trash"></i>
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Add Record Modal -->
  <div class="modal fade" id="addRecordModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form id="recordForm">
          <div class="modal-header bg-success text-white">
            <h5 class="modal-title">Add Environment Record</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <div class="mb-2">
              <label class="form-label">Enclosure ID</label>
              <input type="text" class="form-control" id="enclosureId" required>
            </div>
            <div class="mb-2">
              <label class="form-label">Temperature (°C)</label>
              <input type="number" step="0.1" class="form-control" id="temperature" required>
            </div>
            <div class="mb-2">
              <label class="form-label">Humidity (%)</label>
              <input type="number" class="form-control" id="humidity" required>
            </div>
            <div class="mb-2">
              <label class="form-label">Water Quality</label>
              <input type="text" class="form-control" id="waterQuality" required>
            </div>
            <div class="mb-2">
              <label class="form-label">Date</label>
              <input type="date" class="form-control" id="date" required>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-success">Add Record</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    function toggleSidebar() {
      const sidebar = document.getElementById('sidebar');
      sidebar.classList.toggle('show');
    }

    // Add record
    document.getElementById("recordForm").addEventListener("submit", function (e) {
      e.preventDefault();
      const enclosureId = document.getElementById("enclosureId").value;
      const temp = document.getElementById("temperature").value;
      const humidity = document.getElementById("humidity").value;
      const waterQuality = document.getElementById("waterQuality").value;
      const date = document.getElementById("date").value;

      const table = document.getElementById("envTable").getElementsByTagName("tbody")[0];
      const newRow = table.insertRow();

      newRow.innerHTML = `
        <td>${enclosureId}</td>
        <td>${temp}</td>
        <td>${humidity}</td>
        <td>${waterQuality}</td>
        <td>${date}</td>
        <td>
          <button class="btn btn-sm btn-danger" onclick="deleteRow(this)">
            <i class="bi bi-trash"></i>
          </button>
        </td>
      `;

      document.getElementById("recordForm").reset();
      const modal = bootstrap.Modal.getInstance(document.getElementById('addRecordModal'));
      modal.hide();
    });

    // Delete row
    function deleteRow(button) {
      button.closest("tr").remove();
    }
  </script>
</body>
</html>
