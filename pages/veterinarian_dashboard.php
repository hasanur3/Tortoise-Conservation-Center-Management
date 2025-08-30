<?php
// Connect to MySQL database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tortoise_db";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch Health Records
$healthRecords = $conn->query("SELECT * FROM health_records ORDER BY `AssessmentDate` DESC");

// Fetch Medical Treatments
$medicalTreatments = $conn->query("SELECT * FROM medical_treatments ORDER BY `TreatmentDate` DESC");

// Fetch Vaccinations
$vaccinations = $conn->query("SELECT * FROM vet_vaccinations ORDER BY `VaccinationDate` DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Veterinarian Dashboard - Tortoise Conservation</title>
  <!-- Favicon -->
  <link rel="icon" type="image/png" href="/assests/image/logo.jpeg" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      display: flex;
      min-height: 100vh;
      background-color: #f0fdf4;
    }
    .sidebar {
      width: 250px;
      background-color: #198754;
      color: white;
      flex-shrink: 0;
    }
    .sidebar a {
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 12px 20px;
      color: white;
      text-decoration: none;
    }
    .sidebar a:hover, .sidebar .active {
      background-color: #145c32;
    }
    .content {
      flex-grow: 1;
      padding: 20px;
    }
    .card-custom {
      border-radius: 12px;
      overflow: hidden;
    }
    .card-header {
      font-weight: bold;
    }
  </style>
</head>
<body>

  <!-- Sidebar -->
  <div class="sidebar">
    <h4 class="text-center py-3 border-bottom">Veterinarian</h4>
    <a href="#" class="active"><i class="bi bi-speedometer2"></i>Dashboard</a>
    <a href="/pages/vet-health-records.php"><i class="bi bi-journal-medical"></i>Health Records</a>
    <a href="/pages/vet-medical-treatments.php"><i class="bi bi-capsule-pill"></i>Medical Treatments</a>
    <a href="/pages/vet_vaccinations.php"><i class="bi bi-shield-plus"></i>Vaccinations</a>
    <a href="/pages/vet-environment.php"><i class="bi bi-cloud-sun"></i>Environment</a>
    <a href="/index.html" onclick="logout()"><i class="bi bi-box-arrow-right"></i> Logout</a>
  </div>

  <!-- Main Content -->
  <div class="content">
    <h2>Welcome Veterinarian!</h2>
    <p>This dashboard helps you manage health-related records for tortoises.</p>

    <!-- Health Records -->
    <div class="card mb-4 card-custom">
      <div class="card-header bg-success text-white">Health Records</div>
      <div class="card-body table-responsive">
        <table class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>Tortoise ID</th>
              <th>Assessment Date</th>
              <th>Status</th>
              <th>Observations</th>
              <th>Vet Comments</th>
            </tr>
          </thead>
          <tbody>
            <?php if ($healthRecords->num_rows > 0): ?>
              <?php while($row = $healthRecords->fetch_assoc()): ?>
                <tr>
                  <td><?= htmlspecialchars($row['TortoiseID']) ?></td>
                  <td><?= htmlspecialchars($row['AssessmentDate']) ?></td>
                  <td><?= htmlspecialchars($row['HealthStatus']) ?></td>
                  <td><?= htmlspecialchars($row['Observations']) ?></td>
                  <td><?= htmlspecialchars($row['VetComments']) ?></td>
                </tr>
              <?php endwhile; ?>
            <?php else: ?>
              <tr><td colspan="5" class="text-center">No records found</td></tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Medical Treatments -->
    <div class="card mb-4 card-custom">
      <div class="card-header bg-info text-white">Medical Treatments</div>
      <div class="card-body table-responsive">
        <table class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>Tortoise ID</th>
              <th>Treatment Date</th>
              <th>Medication</th>
              <th>Description</th>
              <th>Vet Notes</th>
            </tr>
          </thead>
          <tbody>
            <?php if ($medicalTreatments->num_rows > 0): ?>
              <?php while($row = $medicalTreatments->fetch_assoc()): ?>
                <tr>
                  <td><?= htmlspecialchars($row['TortoiseID']) ?></td>
                  <td><?= htmlspecialchars($row['TreatmentDate']) ?></td>
                  <td><?= htmlspecialchars($row['Medication']) ?></td>
                  <td><?= htmlspecialchars($row['Description']) ?></td>
                  <td><?= htmlspecialchars($row['VetNotes']) ?></td>
                </tr>
              <?php endwhile; ?>
            <?php else: ?>
              <tr><td colspan="5" class="text-center">No records found</td></tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Vaccination Records -->
    <div class="card mb-4 card-custom">
      <div class="card-header bg-warning text-dark">Vaccination Records</div>
      <div class="card-body table-responsive">
        <table class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>Tortoise ID</th>
              <th>Vaccine Type</th>
              <th>Vaccination Date</th>
            </tr>
          </thead>
          <tbody>
            <?php if ($vaccinations->num_rows > 0): ?>
              <?php while($row = $vaccinations->fetch_assoc()): ?>
                <tr>
                  <td><?= htmlspecialchars($row['TortoiseID']) ?></td>
                  <td><?= htmlspecialchars($row['VaccineType']) ?></td>
                  <td><?= htmlspecialchars($row['VaccinationDate']) ?></td>
                </tr>
              <?php endwhile; ?>
            <?php else: ?>
              <tr><td colspan="3" class="text-center">No records found</td></tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>

  </div>

  <script>
    function logout() {
      alert("Logging out...");
      window.location.href = "login.html";
    }
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>
