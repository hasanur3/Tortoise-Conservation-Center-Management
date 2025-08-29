<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login - Tortoise Tracker</title>
  <!-- Favicon -->
  <link rel="icon" type="image/png" href="/assests/image/logo.jpeg" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background-color: #e9f5ea;">

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-success px-4">
    <a class="navbar-brand d-flex align-items-center" href="/index.php">
      <img src="/assests/image/logo.jpeg" alt="Logo" style="height: 40px; width: auto;" class="me-2 rounded" />
  Tortoise Tracker
</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link active" href="/index.html">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="/index.html">About</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Login</a></li>
        <li class="nav-item"><a class="nav-link" href="/pages/signup.html">Signup</a></li>
      </ul>
    </div>
  </nav>

  <div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow p-4 border-success" style="max-width: 400px; width: 100%;">
      <h3 class="text-center text-success mb-4">Login</h3>

      <form id="loginForm">
        <div class="mb-3">
          <label for="userId" class="form-label text-success">User ID</label>
          <input type="text" class="form-control" id="userId" required>
        </div>
        <div class="mb-3">
          <label for="password" class="form-label text-success">Password</label>
          <input type="password" class="form-control" id="password" required>
        </div>
        <div class="mb-4">
          <label for="role" class="form-label text-success">Select Role</label>
          <select class="form-select" id="role" required>
            <option selected disabled>Choose your role</option>
            <option value="admin">Admin</option>
            <option value="staff">Staff</option>
            <option value="vet">Veterinarian</option>
            <option value="researcher">Researcher</option>
          </select>
        </div>
        <div class="d-grid mb-3">
          <button type="submit" class="btn btn-success">Login</button>
        </div>
        <div class="text-center">
          <a href="signup.html" class="btn btn-link text-success">Sign Up</a>
        </div>
      </form>
    </div>
  </div>

  <!-- Footer Start -->
<footer class="bg-success text-white pt-4 mt-5">
  <div class="container">
    <div class="row text-start text-md-start align-items-center">
      <!-- Logo and Info -->
      <div class="col-md-4 mb-4">
        <img src="/assests/image/logo.jpeg" alt="Logo" class="img-fluid mb-2" style="max-width: 100px; border-radius: 50%;">
        <h5 class="fw-bold mt-2">Tortoise Tracker</h5>
        <p>Dedicated to the care, research, and conservation of tortoise species.</p>
      </div>

      <!-- Quick Links -->
      <div class="col-md-4 mb-4">
        <h5 class="fw-bold">Quick Links</h5>
        <ul class="list-unstyled">
          <li><a href="index.html" class="text-white text-decoration-none">Home</a></li>
          <li><a href="#" class="text-white text-decoration-none">Dashboard</a></li>
          <li><a href="#about" class="text-white text-decoration-none">About</a></li>
          <li><a href="/pages/contact.html" class="text-white text-decoration-none">Contact</a></li>
        </ul>
      </div>

      <!-- Contact Info -->
      <div class="col-md-4 mb-4">
        <h5 class="fw-bold">Contact Us</h5>
        <p>Email: info@tortoisetracker.org</p>
        <p>Phone: +880 1234-567890</p>
        <p>Location: Dhaka, Bangladesh</p>
      </div>
    </div>

    <!-- Copyright -->
    <div class="text-center py-3 border-top border-light mt-3">
      &copy; 2025 Tortoise Conservation Center. All rights reserved.
    </div>
  </div>
</footer>
<!-- Footer End -->

  <script>
    document.getElementById("loginForm").addEventListener("submit", function (e) {
      e.preventDefault();
      const userId = document.getElementById("userId").value.trim();
      const password = document.getElementById("password").value;
      const role = document.getElementById("role").value;

      const userData = JSON.parse(localStorage.getItem("users")) || [];
      const user = userData.find(u => u.userId === userId && u.password === password && u.role === role);

      if (user) {
        // Optional: Save login session
        localStorage.setItem("loggedInUser", JSON.stringify(user));

        // Redirect based on role
        switch (role) {
          case "admin":
            window.location.href = "/pages/admin.php";
            break;
          case "staff":
            window.location.href = "/pages/staff_dashboard.php";
            break;
          case "vet":
            window.location.href = "/pages/veterinarian_dashboard.php";
            break;
          case "researcher":
            window.location.href = "/pages/researcher_dashboard.php";
            break;
          default:
            alert("Role not recognized.");
        }
      } else {
        alert("Invalid credentials or role.");
      }
    });
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>