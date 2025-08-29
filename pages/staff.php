<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Staff Assignments Management</title>
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
    .status-pending {
      color: #ffc107;
      font-weight: 600;
    }
    .status-completed {
      color: #198754;
      font-weight: 600;
    }
    .status-inprogress {
      color: #0d6efd;
      font-weight: 600;
    }
  </style>
</head>
<body>

<div class="container-fluid mt-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <a href="/pages/admin.html" class="btn btn-outline-success">
      <i class="bi bi-arrow-left-circle"></i> Dashboard
    </a>
    <h3 class="text-success mb-0"><i class="bi bi-people-fill me-2"></i>Staff Assignments</h3>
    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addStaffModal">
      <i class="bi bi-plus-circle"></i> Add Staff Member
    </button>
  </div>

  <!-- Search Bar -->
  <div class="row mb-3">
    <div class="col-md-4">
      <input type="text" class="form-control" placeholder="Search by Staff Name or Task..." />
    </div>
  </div>

  <!-- Staff Table -->
  <div class="table-responsive">
    <table class="table table-bordered table-hover align-middle">
      <thead class="table-success">
        <tr>
          <th>Staff ID</th>
          <th>Name</th>
          <th>Role</th>
          <th>Contact</th>
          <th>Assigned Task</th>
          <th>Task Status</th>
          <th>Medical Checkup</th>
          <th>Habitat Maintainance</th>
          <th>Assigned Date</th>
          <th>Due Date</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <!-- Sample Row -->
        <tr>
          <td>S001</td>
          <td>John Doe</td>
          <td>Feeding Staff</td>
          <td>+880123456789</td>
          <td>Daily Feeding</td>
          <td><span class="status-inprogress">In Progress</span></td>
          <td>Last checkup: Jan 2025, Blood test normal</td>
          <td>Cleaned weekly, Temperature controlled</td>
          <td>2025-07-15</td>
          <td>2025-07-19</td>
          <td>
            <button class="btn btn-sm btn-warning" title="Edit"><i class="bi bi-pencil"></i></button>
            <button class="btn btn-sm btn-danger" title="Delete"><i class="bi bi-trash"></i></button>
          </td>
        </tr>
        <!-- More rows dynamically -->
      </tbody>
    </table>
  </div>
</div>

<!-- Add/Edit Staff Modal -->
<div class="modal fade" id="addStaffModal" tabindex="-1" aria-labelledby="addStaffModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form>
        <div class="modal-header bg-success text-white">
          <h5 class="modal-title" id="addStaffModalLabel">Add Staff Member & Assign Task</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-6">
              <label for="staffId" class="form-label">Staff ID</label>
              <input type="text" id="staffId" class="form-control" required />
            </div>
            <div class="col-md-6">
              <label for="staffName" class="form-label">Name</label>
              <input type="text" id="staffName" class="form-control" required />
            </div>
            <div class="col-md-6">
              <label for="staffRole" class="form-label">Role</label>
              <select id="staffRole" class="form-select" required>
                <option value="">Select Role</option>
                <option value="Feeding Staff">Feeding Staff</option>
                <option value="Cleaning Staff">Cleaning Staff</option>
                <option value="Medical Staff">Medical Staff</option>
                <option value="Maintenance Staff">Maintenance Staff</option>
              </select>
            </div>
            <div class="col-md-6">
              <label for="contact" class="form-label">Contact</label>
              <input type="tel" id="contact" class="form-control" placeholder="+880..." required />
            </div>
            <div class="col-md-12">
              <label for="taskName" class="form-label">Task Name</label>
              <input type="text" id="taskName" class="form-control" placeholder="e.g. Daily Feeding" required />
            </div>
            <div class="col-md-14">
              <label for="medicalCheckup" class="form-label">Medical Checkup</label>
              <input type="text" id="medicalCheckup" class="form-control" placeholder="e.g. Last checkup: Jan 2025" required />
            </div>
            <div class="col-md-16">
              <label for="habitatMaintainance" class="form-label">Habitat Maintainance</label>
              <input type="text" id="habitatMaintainance" class="form-control" placeholder="e.g. Cleaned weekly" required />
            </div>
            <div class="col-md-4">
              <label for="taskStatus" class="form-label">Task Status</label>
              <select id="taskStatus" class="form-select" required>
                <option value="">Select Status</option>
                <option value="Pending">Pending</option>
                <option value="In Progress">In Progress</option>
                <option value="Completed">Completed</option>
              </select>
            </div>
            <div class="col-md-4">
              <label for="assignedDate" class="form-label">Assigned Date</label>
              <input type="date" id="assignedDate" class="form-control" required />
            </div>
            <div class="col-md-4">
              <label for="dueDate" class="form-label">Due Date</label>
              <input type="date" id="dueDate" class="form-control" required />
            </div>
            <div class="col-md-12">
              <label for="notes" class="form-label">Notes</label>
              <textarea id="notes" class="form-control" rows="3" placeholder="Optional"></textarea>
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
