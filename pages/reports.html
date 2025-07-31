<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Reports Dashboard</title>
  <!-- Favicon -->
  <link rel="icon" type="image/png" href="/assests/image/logo.jpeg" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    body {
      background-color: #f4f6f9;
    }
    .card {
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
      border-radius: 10px;
    }
    .filter-bar {
      margin-bottom: 20px;
    }
    .chart-container {
      position: relative;
      max-width: 100%;
      height: 300px;
    }
  </style>
</head>
<body>

<div class="container-fluid mt-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <a href="/pages/admin.html" class="btn btn-outline-success">
      <i class="bi bi-arrow-left-circle"></i> Dashboard
    </a>
    <h3 class="text-success mb-0"><i class="bi bi-graph-up"></i> Reports</h3>
    <button class="btn btn-danger" onclick="downloadPDF()">
      <i class="bi bi-download"></i> Download PDF
    </button>
  </div>

  <!-- Filters -->
  <div class="row filter-bar">
    <div class="col-md-3 mb-2">
      <select id="reportType" class="form-select">
        <option value="tortoise">Tortoise Stats</option>
        <option value="breeding">Breeding Programs</option>
        <option value="feeding">Feeding Logs</option>
        <option value="health">Health Records</option>
        <option value="staff">Staff Tasks</option>
        <option value="environment">Environment Conditions</option>
      </select>
    </div>
    <div class="col-md-3 mb-2">
      <input type="date" id="startDate" class="form-control" placeholder="Start Date" />
    </div>
    <div class="col-md-3 mb-2">
      <input type="date" id="endDate" class="form-control" placeholder="End Date" />
    </div>
    <div class="col-md-3 mb-2">
      <button id="filterBtn" class="btn btn-success w-100">Filter</button>
    </div>
  </div>

  <!-- Charts -->
  <div class="row g-4" id="reportContent">
    <div class="col-lg-6 col-md-12">
      <div class="card p-3">
        <h5 class="card-title text-success">Tortoise Population by Species</h5>
        <div class="chart-container">
          <canvas id="speciesChart"></canvas>
        </div>
      </div>
    </div>

    <div class="col-lg-6 col-md-12">
      <div class="card p-3">
        <h5 class="card-title text-success">Breeding Success Rate</h5>
        <div class="chart-container">
          <canvas id="breedingChart"></canvas>
        </div>
      </div>
    </div>

    <div class="col-lg-6 col-md-12">
      <div class="card p-3">
        <h5 class="card-title text-success">Feeding Log Overview</h5>
        <div class="chart-container">
          <canvas id="feedingChart"></canvas>
        </div>
      </div>
    </div>

    <div class="col-lg-6 col-md-12">
      <div class="card p-3">
        <h5 class="card-title text-success">Health Issues Summary</h5>
        <div class="chart-container">
          <canvas id="healthChart"></canvas>
        </div>
      </div>
    </div>

    <div class="col-lg-6 col-md-12">
      <div class="card p-3">
        <h5 class="card-title text-success">Staff Task Completion</h5>
        <div class="chart-container">
          <canvas id="staffChart"></canvas>
        </div>
      </div>
    </div>

    <div class="col-lg-6 col-md-12">
      <div class="card p-3">
        <h5 class="card-title text-success">Environmental Condition Trends</h5>
        <div class="chart-container">
          <canvas id="environmentChart"></canvas>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Chart Data & Script -->
<script>
  const speciesData = {
    labels: ['Species A', 'Species B', 'Species C', 'Species D'],
    datasets: [{
      label: 'Number of Tortoises',
      data: [30, 15, 40, 20],
      backgroundColor: ['#198754', '#0d6efd', '#ffc107', '#dc3545']
    }]
  };

  const breedingData = {
    labels: ['Successful', 'Failed', 'Pending'],
    datasets: [{
      label: 'Breeding Outcomes',
      data: [60, 25, 15],
      backgroundColor: ['#198754', '#dc3545', '#ffc107']
    }]
  };

  const feedingData = {
    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
    datasets: [{
      label: 'Feeding Logs',
      data: [100, 120, 90, 150, 130, 140],
      borderColor: '#198754',
      backgroundColor: 'rgba(25, 135, 84, 0.3)',
      fill: true,
      tension: 0.4
    }]
  };

  const healthData = {
    labels: ['Healthy', 'Minor Issues', 'Serious Issues'],
    datasets: [{
      label: 'Health Status',
      data: [80, 15, 5],
      backgroundColor: ['#198754', '#ffc107', '#dc3545']
    }]
  };

  const staffData = {
    labels: ['Completed', 'In Progress', 'Pending'],
    datasets: [{
      label: 'Tasks',
      data: [50, 30, 20],
      backgroundColor: ['#198754', '#0d6efd', '#ffc107']
    }]
  };

  const environmentData = {
    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
    datasets: [{
      label: 'Avg Temperature (°C)',
      data: [27, 28, 29, 28, 27, 26],
      borderColor: '#dc3545',
      fill: false,
      tension: 0.4
    },
    {
      label: 'Avg Humidity (%)',
      data: [60, 62, 65, 63, 61, 60],
      borderColor: '#0d6efd',
      fill: false,
      tension: 0.4
    }]
  };

  // Chart creation
  new Chart(document.getElementById('speciesChart'), { type: 'bar', data: speciesData, options: { responsive: true, plugins: { legend: { display: false }}}});
  new Chart(document.getElementById('breedingChart'), { type: 'pie', data: breedingData, options: { responsive: true }});
  new Chart(document.getElementById('feedingChart'), { type: 'line', data: feedingData, options: { responsive: true }});
  new Chart(document.getElementById('healthChart'), { type: 'doughnut', data: healthData, options: { responsive: true }});
  new Chart(document.getElementById('staffChart'), { type: 'pie', data: staffData, options: { responsive: true }});
  new Chart(document.getElementById('environmentChart'), { type: 'line', data: environmentData, options: { responsive: true }});

  document.getElementById('filterBtn').addEventListener('click', () => {
    alert('Filter functionality to be implemented.');
  });
</script>

<!-- PDF Export -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script>
  function downloadPDF() {
    const report = document.getElementById('reportContent');
    const opt = {
      margin: 0.3,
      filename: 'tortoise-report.pdf',
      image: { type: 'jpeg', quality: 0.98 },
      html2canvas: { scale: 2 },
      jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' }
    };
    html2pdf().set(opt).from(report).save();
  }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
