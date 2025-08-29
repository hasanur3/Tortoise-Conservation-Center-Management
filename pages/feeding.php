<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Feeding Management</title>
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
    <h3 class="text-success mb-0"><i class="bi bi-basket-fill me-2"></i>Feeding Records</h3>
    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addFeedingModal">
      <i class="bi bi-plus-circle"></i> Add Feeding Log
    </button>
  </div>

  <!-- Search / Filter -->
  <div class="row mb-3">
    <div class="col-md-4">
      <input type="text" class="form-control" placeholder="Search by Tortoise ID or Date..." />
    </div>
  </div>

  <!-- Feeding Records Table -->
  <div class="table-responsive">
    <table class="table table-bordered table-hover align-middle">
      <thead class="table-success">
        <tr>
          <th>Log ID</th>
          <th>Tortoise ID</th>
          <th>Feeding Date</th>
          <th>Food Type</th>
          <th>Quantity</th>
          <th>Notes</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <!-- Sample Row -->
        <tr>
          <td>F001</td>
          <td>T001</td>
          <td>2025-07-19</td>
          <td>Leafy Greens</td>
          <td>500g</td>
          <td>Fresh and clean</td>
          <td>
            <button class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></button>
            <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
          </td>
        </tr>
        <!-- More rows dynamically -->
      </tbody>
    </table>
  </div>
</div>

<!-- Add Feeding Log Modal -->
<div class="modal fade" id="addFeedingModal" tabindex="-1" aria-labelledby="addFeedingModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form>
        <div class="modal-header bg-success text-white">
          <h5 class="modal-title" id="addFeedingModalLabel">Add Feeding Log</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="tortoiseId" class="form-label">Tortoise ID</label>
            <input type="text" class="form-control" id="tortoiseId" required />
          </div>
          <div class="mb-3">
            <label for="feedingDate" class="form-label">Feeding Date</label>
            <input type="date" class="form-control" id="feedingDate" required />
          </div>
          <div class="mb-3">
            <label for="foodType" class="form-label">Food Type</label>
            <input type="text" class="form-control" id="foodType" required />
          </div>
          <div class="mb-3">
            <label for="quantity" class="form-label">Quantity</label>
            <input type="text" class="form-control" id="quantity" />
          </div>
          <div class="mb-3">
            <label for="notes" class="form-label">Notes</label>
            <textarea class="form-control" id="notes" rows="2"></textarea>
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
