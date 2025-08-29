<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Researcher - Breeding Records</title>
  <link rel="icon" type="image/png" href="/assests/image/logo.jpeg" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      display: flex;
    }
    .sidebar {
      width: 250px;
      height: 100vh;
      background-color: #198754;
      color: white;
      padding-top: 20px;
      position: fixed;
    }
    .sidebar a {
      color: white;
      text-decoration: none;
      padding: 10px 20px;
      display: block;
    }
    .sidebar a:hover {
      background-color: #145c32;
    }
    .content {
      margin-left: 250px;
      padding: 20px;
      width: 100%;
    }
    @media (max-width: 768px) {
      .sidebar {
        position: absolute;
        left: -250px;
        transition: left 0.3s;
      }
      .sidebar.show {
        left: 0;
      }
      .content {
        margin-left: 0;
      }
    }
  </style>
</head>
<body>
  <!-- Sidebar -->
  <div class="sidebar" id="sidebar">
    <h4 class="text-center mb-4">Researcher</h4>
    <a href="/pages/researcher_dashboard.html"><i class="bi bi-speedometer2"></i> Dashboard</a>
    <a href="/pages/researcher-tortoise.html"><i class="bi bi-bug"></i> Tortoise Data</a>
    <a href="#"><i class="bi bi-gender-ambiguous"></i> Breeding</a>
    <a href="/pages/researcher-environment.html"><i class="bi bi-globe"></i> Environment</a>
    <a href="/pages/researcher-report.html"><i class="bi bi-file-earmark-text"></i> Reports</a>
    <a href="/index.html"><i class="bi bi-box-arrow-right"></i> Logout</a>
  </div>

  <!-- Main content -->
  <div class="content">
    <button class="btn btn-outline-success d-md-none mb-3" onclick="toggleSidebar()">
      <i class="bi bi-list"></i>
    </button>

    <div class="bg-success text-white p-3 d-flex justify-content-between align-items-center rounded-top">
      <h4 class="mb-0">Breeding Records</h4>
      <button class="btn btn-outline-light" data-bs-toggle="modal" data-bs-target="#addRecordModal">
        <i class="bi bi-plus-circle"></i> Add Record
      </button>
    </div>

    <table class="table table-bordered table-hover mt-0" id="breedingTable">
      <thead>
        <tr>
          <th>Mating Pair</th>
          <th>Nesting Date</th>
          <th>Egg Count</th>
          <th>Incubation (days)</th>
          <th>Hatch Rate</th>
          <th>Note</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>T001 & T005</td>
          <td>2025-06-12</td>
          <td>8</td>
          <td>70</td>
          <td>75%</td>
          <td>
            <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#noteModal">
              <i class="bi bi-pencil-square"></i> Add Note
            </button>
          </td>
          <td>
            <button class="btn btn-sm btn-danger" onclick="deleteRow(this)">
              <i class="bi bi-trash"></i>
            </button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>

  <!-- Add Record Modal -->
  <div class="modal fade" id="addRecordModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-success text-white">
          <h5 class="modal-title">Add Breeding Record</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <form id="recordForm">
            <div class="mb-2">
              <label class="form-label">Mating Pair</label>
              <input type="text" class="form-control" id="matingPair" required>
            </div>
            <div class="mb-2">
              <label class="form-label">Nesting Date</label>
              <input type="date" class="form-control" id="nestingDate" required>
            </div>
            <div class="mb-2">
              <label class="form-label">Egg Count</label>
              <input type="number" class="form-control" id="eggCount" required>
            </div>
            <div class="mb-2">
              <label class="form-label">Incubation (days)</label>
              <input type="number" class="form-control" id="incubation" required>
            </div>
            <div class="mb-2">
              <label class="form-label">Hatch Rate (%)</label>
              <input type="number" class="form-control" id="hatchRate" required>
            </div>
            <button type="submit" class="btn btn-success">Add Record</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Note Modal -->
  <div class="modal fade" id="noteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-success text-white">
          <h5 class="modal-title">Add Breeding Observation</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <form id="noteForm">
            <div class="mb-3">
              <label class="form-label">Observation Note</label>
              <textarea class="form-control" id="breedingNote" rows="4" required></textarea>
            </div>
            <button type="submit" class="btn btn-success">Save Note</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    function toggleSidebar() {
      document.getElementById('sidebar').classList.toggle('show');
    }

    // Add new record
    document.getElementById("recordForm").addEventListener("submit", function (e) {
      e.preventDefault();
      const pair = document.getElementById("matingPair").value;
      const date = document.getElementById("nestingDate").value;
      const eggs = document.getElementById("eggCount").value;
      const incubation = document.getElementById("incubation").value;
      const hatch = document.getElementById("hatchRate").value + "%";

      const table = document.getElementById("breedingTable").getElementsByTagName("tbody")[0];
      const newRow = table.insertRow();

      newRow.innerHTML = `
        <td>${pair}</td>
        <td>${date}</td>
        <td>${eggs}</td>
        <td>${incubation}</td>
        <td>${hatch}</td>
        <td>
          <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#noteModal">
            <i class="bi bi-pencil-square"></i>
          </button>
        </td>
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
      const row = button.closest("tr");
      row.remove();
    }

    // Save note
    document.getElementById("noteForm").addEventListener("submit", function (e) {
      e.preventDefault();
      const note = document.getElementById("breedingNote").value;
      alert("Breeding Note Saved: " + note);
      document.getElementById("breedingNote").value = "";
      const modal = bootstrap.Modal.getInstance(document.getElementById('noteModal'));
      modal.hide();
    });
  </script>
</body>
</html>
