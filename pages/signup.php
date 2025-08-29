<?php
// Database connection
$servername = "localhost";
$username   = "root";   // default for XAMPP
$password   = "";       // default for XAMPP
$dbname     = "tortoise_db"; // create this DB in phpMyAdmin

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$errorMsg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userId = trim($_POST['userId']);
    $password = trim($_POST['password']);
    $role = $_POST['role'];

    if ($userId == "" || $password == "" || $role == "") {
        $errorMsg = "All fields are required!";
    } else {
        // check duplicate userId
        $check = $conn->prepare("SELECT * FROM users WHERE userId=?");
        $check->bind_param("s", $userId);
        $check->execute();
        $result = $check->get_result();

        if ($result->num_rows > 0) {
            $errorMsg = "User ID already exists!";
        } else {
            $stmt = $conn->prepare("INSERT INTO users (userId, password, role) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $userId, $password, $role);
            if ($stmt->execute()) {
                header("Location: login.php");
                exit();
            } else {
                $errorMsg = "Error: Could not register!";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Sign Up - Tortoise Conservation</title>
  <link rel="icon" type="image/png" href="/assests/image/logo.jpeg" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background-color: #e9f5ea;">
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-success px-4">
    <a class="navbar-brand d-flex align-items-center" href="/index.html">
      <img src="/assests/image/logo.jpeg" alt="Logo" style="height: 40px; width: auto;" class="me-2 rounded" />
      Tortoise Tracker
    </a>
  </nav>

  <div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow p-4 border-success" style="max-width: 400px; width: 100%;">
      <h3 class="text-center text-success mb-4">Create an Account</h3>
      
      <?php if($errorMsg): ?>
        <div class="alert alert-danger"><?= $errorMsg ?></div>
      <?php endif; ?>

      <form method="POST" action="signup.php">
        <div class="mb-3">
          <label for="userId" class="form-label text-success">User ID</label>
          <input type="text" class="form-control" name="userId" required>
        </div>

        <div class="mb-3">
          <label for="password" class="form-label text-success">Password</label>
          <input type="password" class="form-control" name="password" required>
        </div>

        <div class="mb-4">
          <label for="role" class="form-label text-success">Select Role</label>
          <select class="form-select" name="role" required>
            <option selected disabled>Choose your role</option>
            <option value="cleaning">Cleaning Staff</option>
            <option value="feeding">Feeding Staff</option>
            <option value="medical">Medical Staff</option>
            <option value="maintenance">Maintenance Staff</option>
            <option value="admin">Admin</option>
            <option value="researcher">Researcher</option>
            <option value="veterinarian">Veterinarian</option>
          </select>
        </div>

        <div class="d-grid mb-3">
          <button type="submit" class="btn btn-success">Sign Up</button>
        </div>

        <div class="text-center">
          <a href="login.php" class="btn btn-link text-success">Back to Login</a>
        </div>
      </form>
    </div>
  </div>
</body>
</html>
