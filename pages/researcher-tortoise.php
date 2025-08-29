<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Researcher - Tortoise Data</title>
  <!-- Favicon -->
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
    <a href="#"><i class="bi bi-bug"></i> Tortoise Data</a>
    <a href="/pages/researcher-breeding.html"><i class="bi bi-gender-ambiguous"></i> Breeding</a>
    <a href="/pages/researcher-environment.html"><i class="bi bi-globe"></i> Environment</a>
    <a href="/pages/researcher-report.html"><i class="bi bi-file-earmark-text"></i> Reports</a>
    <a href="/index.html"><i class="bi bi-box-arrow-right"></i> Logout</a>
  </div>

  <!-- Main content -->
  <div class="content">
    <button class="btn btn-outline-success d-md-none mb-3" onclick="toggleSidebar()">
      <i class="bi bi-list"></i>
    </button>

    <h3>Tortoise Records</h3>
    <table class="table table-bordered table-hover mt-4 border-success">
      <thead class="table-success">
        <tr>
          <th>ID</th>
          <th>Species</th>
          <th>Age</th>
          <th>Gender</th>
          <th>Health Status</th>
          <th>Note</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>T001</td>
          <td>Galápagos</td>
          <td>25</td>
          <td>Female</td>
          <td>Healthy</td>
          <td>
            <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#noteModal">
              <i class="bi bi-pencil-square"></i> Add Note
            </button>
          </td>
        </tr>
        <td>T002</td>
        <td>Aldabra Giant</td>
        <td>40</td>
        <td>Male</td> 
        <td>Good</td> 
        <td>
          <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#noteModal">
            <i class="bi bi-pencil-square"></i> Add Note
          </button>
        </td>
        </tr>      
        <!-- Add more rows as needed -->
      </tbody>
    </table>
  </div>

  <!-- Note Modal -->
  <div class="modal fade" id="noteModal" tabindex="-1" aria-labelledby="noteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-success text-white">
          <h5 class="modal-title" id="noteModalLabel">Add Research Note</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="noteForm">
            <div class="mb-3">
              <label for="noteText" class="form-label">Note</label>
              <textarea class="form-control" id="noteText" rows="4" required></textarea>
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

    document.getElementById("noteForm").addEventListener("submit", function (e) {
      e.preventDefault();
      const note = document.getElementById("noteText").value;
      alert("Note saved: " + note);
      document.getElementById("noteText").value = "";
      const modal = bootstrap.Modal.getInstance(document.getElementById('noteModal'));
      modal.hide();
    });
  </script>
</body>
</html>
