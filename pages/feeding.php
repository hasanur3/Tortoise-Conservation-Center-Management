<?php
$conn = new mysqli("localhost", "root", "", "tortoise_db");
if($conn->connect_error) die("Connection failed: ".$conn->connect_error);

// Pagination setup
$limit = 10;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$start = ($page - 1) * $limit;

$total = $conn->query("SELECT COUNT(*) as total FROM Feeding")->fetch_assoc()['total'];
$totalPages = ceil($total / $limit);

// Fetch feeding data
$feeding = $conn->query("SELECT * FROM Feeding ORDER BY DateTime DESC LIMIT $start, $limit");

// Fetch inventory
$inventory = $conn->query("SELECT * FROM FoodInventory ORDER BY FoodType ASC");

// Handle add feeding
if(isset($_POST['addFeeding'])){
    $tortoise=$_POST['tortoise'];
    $food=$_POST['food'];
    $qty=$_POST['quantity'];
    $notes=$_POST['notes'];
    $date=$_POST['datetime'];

    $conn->query("INSERT INTO Feeding (TortoiseID, FoodType, QuantityUsed, Notes, DateTime) 
                  VALUES ('$tortoise','$food','$qty','$notes','$date')");
    $conn->query("UPDATE FoodInventory SET QuantityAvailable = QuantityAvailable - $qty, LastUpdated=NOW() WHERE FoodType='$food'");
    header("Location: feeding.php");
    exit;
}

// Handle edit feeding
if(isset($_POST['editFeeding'])){
    $id=$_POST['feedingID'];
    $tortoise=$_POST['tortoise'];
    $food=$_POST['food'];
    $qty=$_POST['quantity'];
    $notes=$_POST['notes'];
    $date=$_POST['datetime'];

    // Get old quantity and food
    $old = $conn->query("SELECT FoodType, QuantityUsed FROM Feeding WHERE FeedingID=$id")->fetch_assoc();
    $conn->query("UPDATE FoodInventory SET QuantityAvailable = QuantityAvailable + {$old['QuantityUsed']} WHERE FoodType='{$old['FoodType']}'");

    // Update feeding
    $conn->query("UPDATE Feeding SET TortoiseID='$tortoise', FoodType='$food', QuantityUsed='$qty', Notes='$notes', DateTime='$date' WHERE FeedingID=$id");
    $conn->query("UPDATE FoodInventory SET QuantityAvailable = QuantityAvailable - $qty, LastUpdated=NOW() WHERE FoodType='$food'");

    header("Location: feeding.php");
    exit;
}

// Handle delete feeding
if(isset($_GET['deleteFeeding'])){
    $id=$_GET['deleteFeeding'];
    $row=$conn->query("SELECT FoodType, QuantityUsed FROM Feeding WHERE FeedingID=$id")->fetch_assoc();
    $conn->query("UPDATE FoodInventory SET QuantityAvailable = QuantityAvailable + {$row['QuantityUsed']} WHERE FoodType='{$row['FoodType']}'");
    $conn->query("DELETE FROM Feeding WHERE FeedingID=$id");
    header("Location: feeding.php");
    exit;
}

// Handle add food
if(isset($_POST['addFood'])){
    $food=$_POST['food'];
    $qty=$_POST['quantity'];
    $unit=$_POST['unit'];
    $conn->query("INSERT INTO FoodInventory (FoodType, QuantityAvailable, Unit, LastUpdated) VALUES ('$food','$qty','$unit',NOW())");
    header("Location: feeding.php");
    exit;
}

// Handle edit food
if(isset($_POST['editFood'])){
    $id=$_POST['foodID'];
    $food=$_POST['food'];
    $qty=$_POST['quantity'];
    $unit=$_POST['unit'];
    $conn->query("UPDATE FoodInventory SET FoodType='$food', QuantityAvailable='$qty', Unit='$unit', LastUpdated=NOW() WHERE FoodID=$id");
    header("Location: feeding.php");
    exit;
}

// Handle delete food
if(isset($_GET['deleteFood'])){
    $id=$_GET['deleteFood'];
    $conn->query("DELETE FROM FoodInventory WHERE FoodID=$id");
    header("Location: feeding.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Feeding & Inventory Management</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<style>
body{background:#f4f6f9;}
.container-fluid{max-width:1200px;}
.table-responsive{background:white;border-radius:10px;padding:20px;box-shadow:0 2px 10px rgba(0,0,0,0.05);}
</style>
</head>
<body>
<div class="container-fluid mt-4">

<div class="d-flex justify-content-between align-items-center mb-3">
<a href="/pages/admin.php" class="btn btn-outline-success"><i class="bi bi-arrow-left-circle"></i> Dashboard</a>
<h3 class="text-success mb-0"><i class="bi bi-basket-fill me-2"></i>Feeding Records</h3>
<button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addFeedingModal"><i class="bi bi-plus-circle"></i> Add Feeding Log</button>
</div>

<div class="table-responsive mb-3">
<table class="table table-bordered table-hover align-middle">
<thead class="table-success">
<tr><th>ID</th><th>Tortoise ID</th><th>Food Type</th><th>Quantity</th><th>Notes</th><th>DateTime</th><th>Actions</th></tr>
</thead>
<tbody>
<?php while($row=$feeding->fetch_assoc()): ?>
<tr>
<td><?= $row['FeedingID'] ?></td>
<td><?= $row['TortoiseID'] ?></td>
<td><?= $row['FoodType'] ?></td>
<td><?= $row['QuantityUsed'] ?></td>
<td><?= $row['Notes'] ?></td>
<td><?= $row['DateTime'] ?></td>
<td>
<button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editFeedingModal" 
onclick='setFeeding(<?= json_encode($row) ?>)'><i class="bi bi-pencil"></i></button>
<a href="?deleteFeeding=<?= $row['FeedingID'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete?')"><i class="bi bi-trash"></i></a>
</td>
</tr>
<?php endwhile; ?>
</tbody>
</table>

<!-- Pagination -->
<nav>
<ul class="pagination justify-content-center">
<?php for($i=1;$i<=$totalPages;$i++): ?>
<li class="page-item <?= ($i==$page)?'active':'' ?>"><a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a></li>
<?php endfor; ?>
</ul>
</nav>
</div>

<h3 class="text-success mb-3"><i class="bi bi-box-seam me-2"></i>Food Inventory</h3>
<button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addFoodModal"><i class="bi bi-plus-circle"></i> Add Food</button>
<div class="table-responsive">
<table class="table table-bordered table-hover align-middle">
<thead class="table-success">
<tr><th>Food ID</th><th>Food Type</th><th>Quantity Available</th><th>Unit</th><th>Last Updated</th><th>Actions</th></tr>
</thead>
<tbody>
<?php while($row=$inventory->fetch_assoc()): ?>
<tr>
<td><?= $row['FoodID'] ?></td>
<td><?= $row['FoodType'] ?></td>
<td><?= $row['QuantityAvailable'] ?></td>
<td><?= $row['Unit'] ?></td>
<td><?= $row['LastUpdated'] ?></td>
<td>
<button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editFoodModal" 
onclick='setFood(<?= json_encode($row) ?>)'><i class="bi bi-pencil"></i></button>
<a href="?deleteFood=<?= $row['FoodID'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete?')"><i class="bi bi-trash"></i></a>
</td>
</tr>
<?php endwhile; ?>
</tbody>
</table>
</div>
</div>

<!-- Add Feeding Modal -->
<div class="modal fade" id="addFeedingModal" tabindex="-1">
<div class="modal-dialog"><form method="post" class="modal-content">
<div class="modal-header bg-success text-white"><h5 class="modal-title">Add Feeding Log</h5><button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button></div>
<div class="modal-body">
<input type="hidden" name="addFeeding" value="1">
<div class="mb-2"><label>Tortoise ID</label><input type="number" name="tortoise" class="form-control" required></div>
<div class="mb-2"><label>Food Type</label><select name="food" class="form-control" required>
<?php 
$foods=$conn->query("SELECT FoodType FROM FoodInventory ORDER BY FoodType ASC");
while($f=$foods->fetch_assoc()){ echo "<option>{$f['FoodType']}</option>"; }
?>
</select></div>
<div class="mb-2"><label>Quantity Used</label><input type="number" step="0.01" name="quantity" class="form-control" required></div>
<div class="mb-2"><label>Notes</label><textarea name="notes" class="form-control" required></textarea></div>
<div class="mb-2"><label>DateTime</label><input type="datetime-local" name="datetime" class="form-control" required></div>
</div>
<div class="modal-footer"><button class="btn btn-success">Save</button></div>
</form></div></div>

<!-- Edit Feeding Modal -->
<div class="modal fade" id="editFeedingModal" tabindex="-1">
<div class="modal-dialog"><form method="post" class="modal-content">
<div class="modal-header bg-warning text-white"><h5 class="modal-title">Edit Feeding Log</h5><button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button></div>
<div class="modal-body">
<input type="hidden" name="editFeeding" value="1">
<input type="hidden" name="feedingID" id="editFeedingID">
<div class="mb-2"><label>Tortoise ID</label><input type="number" name="tortoise" id="editTortoise" class="form-control" required></div>
<div class="mb-2"><label>Food Type</label><select name="food" id="editFood" class="form-control" required>
<?php 
$foods=$conn->query("SELECT FoodType FROM FoodInventory ORDER BY FoodType ASC");
while($f=$foods->fetch_assoc()){ echo "<option>{$f['FoodType']}</option>"; }
?>
</select></div>
<div class="mb-2"><label>Quantity Used</label><input type="number" step="0.01" name="quantity" id="editQuantity" class="form-control" required></div>
<div class="mb-2"><label>Notes</label><textarea name="notes" id="editNotes" class="form-control" required></textarea></div>
<div class="mb-2"><label>DateTime</label><input type="datetime-local" name="datetime" id="editDateTime" class="form-control" required></div>
</div>
<div class="modal-footer"><button class="btn btn-warning">Update</button></div>
</form></div></div>

<!-- Add Food Modal -->
<div class="modal fade" id="addFoodModal" tabindex="-1">
<div class="modal-dialog"><form method="post" class="modal-content">
<div class="modal-header bg-success text-white"><h5 class="modal-title">Add Food</h5><button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button></div>
<div class="modal-body">
<input type="hidden" name="addFood" value="1">
<div class="mb-2"><label>Food Type</label><input type="text" name="food" class="form-control" required></div>
<div class="mb-2"><label>Quantity</label><input type="number" step="0.01" name="quantity" class="form-control" required></div>
<div class="mb-2"><label>Unit</label><input type="text" name="unit" class="form-control" required></div>
</div>
<div class="modal-footer"><button class="btn btn-success">Save</button></div>
</form></div></div>

<!-- Edit Food Modal -->
<div class="modal fade" id="editFoodModal" tabindex="-1">
<div class="modal-dialog"><form method="post" class="modal-content">
<div class="modal-header bg-warning text-white"><h5 class="modal-title">Edit Food</h5><button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button></div>
<div class="modal-body">
<input type="hidden" name="editFood" value="1">
<input type="hidden" name="foodID" id="editFoodID">
<div class="mb-2"><label>Food Type</label><input type="text" name="food" id="editFoodName" class="form-control" required></div>
<div class="mb-2"><label>Quantity</label><input type="number" step="0.01" name="quantity" id="editFoodQty" class="form-control" required></div>
<div class="mb-2"><label>Unit</label><input type="text" name="unit" id="editFoodUnit" class="form-control" required></div>
</div>
<div class="modal-footer"><button class="btn btn-warning">Update</button></div>
</form></div></div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
function setFeeding(data){
    document.getElementById('editFeedingID').value = data.FeedingID;
    document.getElementById('editTortoise').value = data.TortoiseID;
    document.getElementById('editFood').value = data.FoodType;
    document.getElementById('editQuantity').value = data.QuantityUsed;
    document.getElementById('editNotes').value = data.Notes;
    document.getElementById('editDateTime').value = data.DateTime.replace(' ','T');
}
function setFood(data){
    document.getElementById('editFoodID').value = data.FoodID;
    document.getElementById('editFoodName').value = data.FoodType;
    document.getElementById('editFoodQty').value = data.QuantityAvailable;
    document.getElementById('editFoodUnit').value = data.Unit;
}
</script>
</body>
</html>
