<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Researcher - Reports</title>
  <!-- Favicon -->
  <link rel="icon" type="image/png" href="/assests/image/logo.jpeg" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      display: flex;
    }
    .sidebar {
      width: 250px;
      background-color: #198754;
      color: white;
      min-height: 100vh;
    }
    .sidebar h4 {
      padding: 15px;
      margin: 0;
      background-color: #145c38;
    }
    .sidebar a {
      display: block;
      color: white;
      padding: 12px 20px;
      text-decoration: none;
    }
    .sidebar a:hover {
      background-color: #157347;
    }
    .content {
      flex: 1;
      padding: 20px;
    }
    @media (max-width: 768px) {
      .sidebar {
        position: absolute;
        transform: translateX(-100%);
        transition: transform 0.3s ease;
      }
      .sidebar.active {
        transform: translateX(0);
      }
    }
  </style>
</head>
<body>

  <!-- Sidebar -->
  <div class="sidebar" id="sidebar">
    <h4 class="text-center">Researcher</h4>
    <a href="/pages/researcher_dashboard.html"><i class="bi bi-speedometer2"></i> Dashboard</a>
    <a href="/pages/researcher-tortoise.html"><i class="bi bi-bug"></i> Tortoise Data</a>
    <a href="/pages/researcher-breeding.html"><i class="bi bi-heart-pulse"></i> Breeding</a>
    <a href="/pages/researcher-environment.html"><i class="bi bi-cloud-sun"></i> Environment</a>
    <a href="#"><i class="bi bi-file-earmark-text"></i> Reports</a>
    <a href="/index.html"><i class="bi bi-box-arrow-right"></i> Logout</a>
  </div>

  <!-- Content -->
  <div class="content">
    <button class="btn btn-outline-success d-md-none mb-3" onclick="toggleSidebar()">
      <i class="bi bi-list"></i>
    </button>
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h3>Research Reports</h3>
      <button class="btn btn-success" id="addReportBtn" data-bs-toggle="modal" data-bs-target="#reportModal">
        <i class="bi bi-plus-circle"></i> Add Report
      </button>
    </div>

    <table class="table table-bordered table-hover">
      <thead class="table-success">
        <tr>
          <th>Report ID</th>
          <th>Tortoise ID</th>
          <th>Date</th>
          <th>Category</th>
          <th>Research Notes</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody id="reportTableBody">
        <tr>
          <td>R001</td>
          <td>T101</td>
          <td>2025-07-25</td>
          <td>Breeding</td>
          <td>Observed new mating behavior in enclosure 3.</td>
          <td>
            <button class="btn btn-sm btn-warning" onclick="editReport(this)"><i class="bi bi-pencil"></i></button>
            <button class="btn btn-sm btn-danger" onclick="deleteReport(this)"><i class="bi bi-trash"></i></button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="reportModal" tabindex="-1" aria-labelledby="reportModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <form class="modal-content" onsubmit="saveReport(event)">
        <div class="modal-header bg-success text-white">
          <h5 class="modal-title" id="reportModalLabel">Add/Edit Report</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" id="editingRow" />
          <div class="mb-3">
            <label class="form-label">Report ID</label>
            <input type="text" class="form-control" id="reportId" required />
          </div>
          <div class="mb-3">
            <label class="form-label">Tortoise ID</label>
            <input type="text" class="form-control" id="tortoiseId" required />
          </div>
          <div class="mb-3">
            <label class="form-label">Date</label>
            <input type="date" class="form-control" id="reportDate" required />
          </div>
          <div class="mb-3">
            <label class="form-label">Category</label>
            <input type="text" class="form-control" id="reportCategory" required />
          </div>
          <div class="mb-3">
            <label class="form-label">Notes</label>
            <textarea class="form-control" id="reportNotes" required></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Save Report</button>
        </div>
      </form>
    </div>
  </div>

  <script>
    function toggleSidebar() {
      document.getElementById("sidebar").classList.toggle("active");
    }

    // Clear modal when clicking Add Report
    document.getElementById('addReportBtn').addEventListener('click', () => {
      document.getElementById("reportModalLabel").textContent = "Add Report";
      document.getElementById("editingRow").value = "";
      document.getElementById("reportId").value = "";
      document.getElementById("tortoiseId").value = "";
      document.getElementById("reportDate").value = "";
      document.getElementById("reportCategory").value = "";
      document.getElementById("reportNotes").value = "";
    });

    function saveReport(event) {
      event.preventDefault();
      const id = document.getElementById("reportId").value.trim();
      const tid = document.getElementById("tortoiseId").value.trim();
      const date = document.getElementById("reportDate").value;
      const category = document.getElementById("reportCategory").value.trim();
      const notes = document.getElementById("reportNotes").value.trim();
      const editingIndex = document.getElementById("editingRow").value;

      const tbody = document.getElementById("reportTableBody");

      if (editingIndex === "") {
        // Add new row
        const newRow = tbody.insertRow();
        newRow.innerHTML = `
          <td>${id}</td>
          <td>${tid}</td>
          <td>${date}</td>
          <td>${category}</td>
          <td>${notes}</td>
          <td>
            <button class="btn btn-sm btn-warning" onclick="editReport(this)"><i class="bi bi-pencil"></i></button>
            <button class="btn btn-sm btn-danger" onclick="deleteReport(this)"><i class="bi bi-trash"></i></button>
          </td>`;
      } else {
        // Edit existing row
        const row = tbody.rows[editingIndex];
        row.cells[0].innerText = id;
        row.cells[1].innerText = tid;
        row.cells[2].innerText = date;
        row.cells[3].innerText = category;
        row.cells[4].innerText = notes;
      }

      document.getElementById("reportModal").querySelector("form").reset();
      document.getElementById("editingRow").value = "";
      const modal = bootstrap.Modal.getInstance(document.getElementById("reportModal"));
      modal.hide();
    }

    function editReport(btn) {
      const row = btn.closest("tr");
      const index = row.rowIndex - 1;

      document.getElementById("reportModalLabel").textContent = "Edit Report";
      document.getElementById("reportId").value = row.cells[0].innerText;
      document.getElementById("tortoiseId").value = row.cells[1].innerText;
      document.getElementById("reportDate").value = row.cells[2].innerText;
      document.getElementById("reportCategory").value = row.cells[3].innerText;
      document.getElementById("reportNotes").value = row.cells[4].innerText;
      document.getElementById("editingRow").value = index;

      new bootstrap.Modal(document.getElementById("reportModal")).show();
    }

    function deleteReport(btn) {
      if (confirm("Are you sure you want to delete this report?")) {
        const row = btn.closest("tr");
        row.remove();
      }
    }
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
