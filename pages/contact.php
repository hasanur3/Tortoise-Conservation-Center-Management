<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Contact - Tortoise Tracker</title>
  <!-- Favicon -->
  <link rel="icon" type="image/png" href="/assests/image/logo.jpeg" />
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
    }
    .form-section {
      background-color: #fff;
      padding: 40px;
      border-radius: 10px;
      box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
    }
    .navbar-brand img {
      max-height: 40px;
      margin-right: 10px;
    }
  </style>
</head>
<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-success px-4">
    <a class="navbar-brand d-flex align-items-center" href="/index.html">
      <img src="/assests/image/logo.jpeg" alt="Logo">
      Tortoise Tracker
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item"><a class="nav-link" href="/index.html">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="/about.html">About</a></li>
        <li class="nav-item"><a class="nav-link active" href="/contact.html">Contact</a></li>
      </ul>
    </div>
  </nav>

  <!-- Contact Section -->
  <div class="container my-5">
    <div class="row justify-content-center">
      <div class="col-md-8 form-section">
        <h2 class="text-center text-success mb-4">Get in Touch</h2>
        <form id="contactForm">
          <div class="mb-3">
            <label for="name" class="form-label">Your Name</label>
            <input type="text" class="form-control" id="name" placeholder="Enter your name" required>
          </div>
          <div class="mb-3">
            <label for="email" class="form-label">Your Email</label>
            <input type="email" class="form-control" id="email" placeholder="Enter your email" required>
          </div>
          <div class="mb-3">
            <label for="subject" class="form-label">Subject</label>
            <input type="text" class="form-control" id="subject" placeholder="Subject" required>
          </div>
          <div class="mb-3">
            <label for="message" class="form-label">Your Message</label>
            <textarea class="form-control" id="message" rows="5" placeholder="Write your message..." required></textarea>
          </div>
          <div id="confirmation" class="text-success mb-3" style="display:none;">Thank you! We will get back to you soon.</div>
          <button type="submit" class="btn btn-success w-100">Send Message</button>
        </form>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <footer class="bg-success text-white pt-4 mt-5">
    <div class="container">
      <div class="row text-start text-md-start align-items-center">
        <div class="col-md-4 mb-4">
          <img src="/assests/image/logo.jpeg" alt="Logo" class="img-fluid mb-2" style="max-width: 100px; border-radius: 50%;">
          <h5 class="fw-bold mt-2">Tortoise Tracker</h5>
          <p>Dedicated to the care, research, and conservation of tortoise species.</p>
        </div>
        <div class="col-md-4 mb-4">
          <h5 class="fw-bold">Quick Links</h5>
          <ul class="list-unstyled">
            <li><a href="/index.html" class="text-white text-decoration-none">Home</a></li>
            <li><a href="/dashboard.html" class="text-white text-decoration-none">Dashboard</a></li>
            <li><a href="/about.html" class="text-white text-decoration-none">About</a></li>
            <li><a href="/contact.html" class="text-white text-decoration-none">Contact</a></li>
          </ul>
        </div>
        <div class="col-md-4 mb-4">
          <h5 class="fw-bold">Contact Us</h5>
          <p>Email: info@tortoisecenter.org</p>
          <p>Phone: +880 1234-567890</p>
          <p>Location: Dhaka, Bangladesh</p>
        </div>
      </div>
      <div class="text-center py-3 border-top border-light mt-3">
        &copy; 2025 Tortoise Conservation Center. All rights reserved.
      </div>
    </div>
  </footer>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Success Message Script -->
  <script>
    document.getElementById('contactForm').addEventListener('submit', function(event) {
      event.preventDefault(); // Prevent page reload
      document.getElementById('confirmation').style.display = 'block';
      this.reset();
    });
  </script>
</body>
</html>
