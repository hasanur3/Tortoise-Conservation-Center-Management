<?php
session_start();
$conn = new mysqli("localhost", "root", "", "tortoise_db");
if ($conn->connect_error) die("DB connection failed: " . $conn->connect_error);

if (!isset($_SESSION['userId']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Fetch data (same as your previous code) ...
// 1️⃣ Tortoise stats
$tortoise_sql = "SELECT Species, COUNT(*) AS Count FROM tortoise GROUP BY Species";
$tortoise_result = $conn->query($tortoise_sql);
$tortoise_labels = $tortoise_counts = [];
while ($row = $tortoise_result->fetch_assoc()) {
    $tortoise_labels[] = $row['Species'];
    $tortoise_counts[] = $row['Count'];
}

// 2️⃣ Breeding success rate
$breeding_sql = "SELECT 
    SUM(CASE WHEN HatchingSuccessRate=100 THEN 1 ELSE 0 END) AS Successful,
    SUM(CASE WHEN HatchingSuccessRate<100 AND HatchingSuccessRate>0 THEN 1 ELSE 0 END) AS Partial,
    SUM(CASE WHEN HatchingSuccessRate=0 THEN 1 ELSE 0 END) AS Failed
FROM breeding";
$breeding_result = $conn->query($breeding_sql);
$breeding_row = $breeding_result->fetch_assoc();
$breeding_labels = ['Successful','Partial','Failed'];
$breeding_counts = [(int)$breeding_row['Successful'], (int)$breeding_row['Partial'], (int)$breeding_row['Failed']];

// 3️⃣ Feeding logs
$feeding_sql = "SELECT MONTH(DateTime) AS month, COUNT(*) AS count FROM feeding GROUP BY MONTH(DateTime)";
$feeding_result = $conn->query($feeding_sql);
$feeding_labels = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
$feeding_counts = array_fill(0,12,0);
while ($row = $feeding_result->fetch_assoc()) {
    $feeding_counts[(int)$row['month']-1] = (int)$row['count'];
}

// 4️⃣ Health
$health_sql = "SELECT 
    SUM(CASE WHEN HealthStatus='Healthy' THEN 1 ELSE 0 END) AS Healthy,
    SUM(CASE WHEN HealthStatus='Minor Issues' THEN 1 ELSE 0 END) AS Minor,
    SUM(CASE WHEN HealthStatus='Serious Issues' THEN 1 ELSE 0 END) AS Serious
FROM health";
$health_result = $conn->query($health_sql);
$health_row = $health_result->fetch_assoc();
$health_labels = ['Healthy','Minor Issues','Serious Issues'];
$health_counts = [(int)$health_row['Healthy'], (int)$health_row['Minor'], (int)$health_row['Serious']];

// 5️⃣ Staff tasks
$staff_sql = "SELECT 
    SUM(CASE WHEN Role='feeding' AND EXISTS(SELECT 1 FROM StaffTasks st WHERE st.StaffID=s.StaffID AND st.Status='Completed') THEN 1 ELSE 0 END) AS Completed,
    SUM(CASE WHEN Role='feeding' AND EXISTS(SELECT 1 FROM StaffTasks st WHERE st.StaffID=s.StaffID AND st.Status='In Progress') THEN 1 ELSE 0 END) AS InProgress,
    SUM(CASE WHEN Role='feeding' AND EXISTS(SELECT 1 FROM StaffTasks st WHERE st.StaffID=s.StaffID AND st.Status='Pending') THEN 1 ELSE 0 END) AS Pending
FROM staff s";
$staff_result = $conn->query($staff_sql);
$staff_row = $staff_result->fetch_assoc();
$staff_labels = ['Completed','In Progress','Pending'];
$staff_counts = [(int)$staff_row['Completed'],(int)$staff_row['InProgress'],(int)$staff_row['Pending']];

// 6️⃣ Environment
$env_sql = "SELECT MONTH(RecordDate) AS month, AVG(Temperature) AS temp, AVG(Humidity) AS hum FROM environment GROUP BY MONTH(RecordDate)";
$env_result = $conn->query($env_sql);
$env_temp = array_fill(0,12,null);
$env_hum = array_fill(0,12,null);
while ($row = $env_result->fetch_assoc()) {
    $env_temp[(int)$row['month']-1] = round($row['temp'],2);
    $env_hum[(int)$row['month']-1] = round($row['hum'],2);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Reports Dashboard</title>
<link rel="icon" type="image/png" href="/assests/image/logo.jpeg">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<style>
body { background-color: #f4f6f9; }
.card { padding: 15px; margin-bottom: 20px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
canvas { height: 250px !important; }
.report-container { max-width: 1200px; margin:auto; }
</style>
</head>
<body>

<div class="container-fluid mt-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <a href="/pages/admin.php" class="btn btn-outline-success">Dashboard</a>
    <h3 class="text-success mb-0">Reports</h3>
    <button class="btn btn-danger" onclick="downloadPDF()">Download PDF</button>
  </div>

  <form method="GET" class="row g-2 mb-3">
    <div class="col-md-3"><input type="date" name="startDate" class="form-control" value="<?= htmlspecialchars($startDate) ?>"></div>
    <div class="col-md-3"><input type="date" name="endDate" class="form-control" value="<?= htmlspecialchars($endDate) ?>"></div>
    <div class="col-md-3"><button type="submit" class="btn btn-success w-100">Filter</button></div>
  </form>

  <div id="reportContent" class="report-container row">
      <div class="col-lg-6 col-md-12"><div class="card"><canvas id="speciesChart"></canvas></div></div>
      <div class="col-lg-6 col-md-12"><div class="card"><canvas id="breedingChart"></canvas></div></div>
      <div class="col-lg-6 col-md-12"><div class="card"><canvas id="feedingChart"></canvas></div></div>
      <div class="col-lg-6 col-md-12"><div class="card"><canvas id="healthChart"></canvas></div></div>
      <div class="col-lg-6 col-md-12"><div class="card"><canvas id="staffChart"></canvas></div></div>
      <div class="col-lg-6 col-md-12"><div class="card"><canvas id="environmentChart"></canvas></div></div>
  </div>
</div>

<script>
function createChart(id, type, labels, data, bgColors=['#198754']) {
    return new Chart(document.getElementById(id), {type, data:{labels, datasets:[{data, label:id, backgroundColor:bgColors, borderColor:bgColors, fill:true}]}, options:{responsive:true, maintainAspectRatio:false}});
}

createChart('speciesChart','bar',<?= json_encode($tortoise_labels) ?>,<?= json_encode($tortoise_counts) ?>,['#198754','#0d6efd','#ffc107','#dc3545']);
createChart('breedingChart','pie',<?= json_encode($breeding_labels) ?>,<?= json_encode($breeding_counts) ?>,['#198754','#ffc107','#dc3545']);
createChart('feedingChart','line',['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],<?= json_encode($feeding_counts) ?>,['#198754']);
createChart('healthChart','doughnut',<?= json_encode($health_labels) ?>,<?= json_encode($health_counts) ?>,['#198754','#ffc107','#dc3545']);
createChart('staffChart','pie',<?= json_encode($staff_labels) ?>,<?= json_encode($staff_counts) ?>,['#198754','#0d6efd','#ffc107']);
createChart('environmentChart','line',['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],<?= json_encode($env_temp) ?>,['#dc3545']);

function downloadPDF(){
    const element = document.getElementById('reportContent');
    const opt = {
        margin:0.2,
        filename:'tortoise-report.pdf',
        image:{type:'jpeg', quality:0.98},
        html2canvas:{scale:2, useCORS:true, logging:true},
        jsPDF:{unit:'mm', format:'a4', orientation:'portrait'}
    };
    html2pdf().set(opt).from(element).save();
}
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
