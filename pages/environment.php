<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Environmental Conditions Management</title>
  <!-- Favicon -->
<link rel="icon" type="image/png" href="/assests/image/logo.jpeg" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
  <style>
    body {
      background-color: #f4f6f9;
    }
    .table-responsive {
      background: white;
      border-radius: 10px;
      padding: 20px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
    .btn-success {
      background-color: #198754;
    }
  </style>
</head>
<body>

<div class="container-fluid mt-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <a href="/pages/admin.html" class="btn btn-outline-success">
      <i class="bi bi-arrow-left-circle"></i> Dashboard
    </a>
    <h3 class="text-success mb-0"><i class="bi bi-thermometer-half me-2"></i>Environmental Conditions</h3>
    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addEnvironmentModal">
      <i class="bi bi-plus-circle"></i> Add Record
    </button>
  </div>

  <!-- Search / Filter -->
  <div class="row mb-3">
    <div class="col-md-4">
      <input type="text" class="form-control" placeholder="Search by Enclosure ID or Date..." />
    </div>
  </div>

  <!-- Environmental Conditions Table -->
  <div class="table-responsive">
    <table class="table table-bordered table-hover align-middle">
      <thead class="table-success">
        <tr>
          <th>Record ID</th>
          <th>Enclosure/Incubator ID</th>
          <th>Date</th>
          <th>Temperature (°C)</th>
          <th>Humidity (%)</th>
          <th>Water Quality</th>
          <th>Other Notes</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <!-- Sample Row -->
        <tr>
          <td>ENV001</td>
          <td>ENC001</td>
          <td>2025-07-20</td>
          <td>28</td>
          <td>60</td>
          <td>Good</td>
          <td>All parameters normal</td>
          <td>
            <button class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></button>
            <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
          </td>
        </tr>
        <!-- Add more rows dynamically -->
      </tbody>
    </table>
  </div>
</div>

<!-- Add Environmental Condition Modal -->
<div class="modal fade" id="addEnvironmentModal" tabindex="-1" aria-labelledby="addEnvironmentModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form>
        <div class="modal-header bg-success text-white">
          <h5 class="modal-title" id="addEnvironmentModalLabel">Add Environmental Record</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-6">
              <label for="enclosureId" class="form-label">Enclosure/Incubator ID</label>
              <input type="text" id="enclosureId" class="form-control" required />
            </div>
            <div class="col-md-6">
              <label for="date" class="form-label">Date</label>
              <input type="date" id="date" class="form-control" required />
            </div>
            <div class="col-md-4">
              <label for="temperature" class="form-label">Temperature (°C)</label>
              <input type="number" step="0.1" id="temperature" class="form-control" required />
            </div>
            <div class="col-md-4">
              <label for="humidity" class="form-label">Humidity (%)</label>
              <input type="number" step="0.1" id="humidity" class="form-control" required />
            </div>
            <div class="col-md-4">
              <label for="waterQuality" class="form-label">Water Quality</label>
              <input type="text" id="waterQuality" class="form-control" placeholder="e.g., Good, Fair, Poor" />
            </div>
            <div class="col-12">
              <label for="notes" class="form-label">Other Notes</label>
              <textarea id="notes" class="form-control" rows="2"></textarea>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Save</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
