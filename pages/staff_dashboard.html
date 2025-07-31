<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Staff Dashboard - Tortoise Conservation</title>
  <!-- Favicon -->
  <link rel="icon" type="image/png" href="/assests/image/logo.jpeg" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
  <style>
    body {
      background-color: #e9f5ea;
    }
    .sidebar {
      height: 100vh;
      background-color: #198754;
      color: white;
      position: fixed;
      width: 220px;
      transition: width 0.3s;
    }
    .sidebar.collapsed {
      width: 70px;
    }
    .sidebar .nav-link {
      color: white;
      font-weight: 500;
      padding: 12px 20px;
    }
    .sidebar .nav-link:hover,
    .sidebar .nav-link.active {
      background-color: #145c32;
      color: #fff;
    }
    .sidebar .nav-link i {
      font-size: 1.3rem;
      margin-right: 12px;
      vertical-align: middle;
    }
    .sidebar.collapsed .nav-link span {
      display: none;
    }
    .sidebar.collapsed .nav-link i {
      margin-right: 0;
      text-align: center;
      width: 100%;
    }
    main {
      margin-left: 220px;
      padding: 20px;
      transition: margin-left 0.3s;
    }
    main.collapsed {
      margin-left: 70px;
    }
    .navbar-toggler {
      border: none;
      background: transparent;
      color: white;
      font-size: 1.5rem;
    }
    @media (max-width: 768px) {
      .sidebar {
        position: fixed;
        left: -220px;
        z-index: 1030;
      }
      .sidebar.show {
        left: 0;
      }
      main {
        margin-left: 0;
      }
      main.collapsed {
        margin-left: 0;
      }
    }
  </style>
</head>
<body>

  <!-- Sidebar -->
  <nav id="sidebar" class="sidebar d-flex flex-column">
    <div class="d-flex align-items-center justify-content-between px-3 py-3 border-bottom border-success">
      <span class="fs-4 fw-bold">Tortoise Staff</span>
      <button id="sidebarCollapse" class="btn btn-sm btn-success d-md-none">
        <i class="bi bi-x"></i>
      </button>
    </div>
    <ul class="nav flex-column mt-3">
      <li class="nav-item">
        <a href="#" class="nav-link active" data-page="dashboard">
          <i class="bi bi-speedometer2"></i> <span>Dashboard</span>
        </a>
      </li>
      <li class="nav-item">
        <a href="#" class="nav-link" data-page="tortoise">
          <i class="bi bi-bug"></i> <span>Tortoise</span>
        </a>
      </li>
      <li class="nav-item">
        <a href="#" class="nav-link" data-page="feeding">
          <i class="bi bi-basket-fill"></i> <span>Feeding</span>
        </a>
      </li>
      <li class="nav-item">
        <a href="#" class="nav-link" data-page="tasks">
          <i class="bi bi-list-task"></i> <span>Tasks</span>
        </a>
      </li>
      <li class="nav-item mt-auto">
        <a href="/index.html" class="nav-link text-white">
          <i class="bi bi-box-arrow-right"></i> <span>Logout</span>
        </a>
      </li>
    </ul>

    <button id="toggleSidebarBtn" class="btn btn-success mt-auto mx-3 mb-3 d-none d-md-block">
      <i class="bi bi-chevron-left"></i>
    </button>
  </nav>

  <!-- Main content -->
  <main id="mainContent">
    <nav class="navbar navbar-expand-lg navbar-dark bg-success mb-4">
      <div class="container-fluid">
        <button id="sidebarToggle" class="btn btn-success d-md-none">
          <i class="bi bi-list"></i>
        </button>
        <span class="navbar-brand ms-2">Staff Dashboard</span>
      </div>
    </nav>

    <div id="pageContent">
      <h2>Dashboard</h2>
      <p>Welcome to the Staff Dashboard. Select a menu item to get started.</p>
    </div>
  </main>

  <script>
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('mainContent');
    const toggleSidebarBtn = document.getElementById('toggleSidebarBtn');
    const sidebarCollapse = document.getElementById('sidebarCollapse');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const navLinks = sidebar.querySelectorAll('.nav-link');

    // Toggle sidebar collapse on desktop
    toggleSidebarBtn.addEventListener('click', () => {
      sidebar.classList.toggle('collapsed');
      mainContent.classList.toggle('collapsed');
      toggleSidebarBtn.querySelector('i').classList.toggle('bi-chevron-left');
      toggleSidebarBtn.querySelector('i').classList.toggle('bi-chevron-right');
    });

    // Close sidebar on mobile
    sidebarCollapse.addEventListener('click', () => {
      sidebar.classList.remove('show');
    });

    // Open sidebar on mobile
    sidebarToggle.addEventListener('click', () => {
      sidebar.classList.add('show');
    });

    // Navigation click handler (simple example)
    navLinks.forEach(link => {
      link.addEventListener('click', (e) => {
        e.preventDefault();

        // Remove active class
        navLinks.forEach(l => l.classList.remove('active'));
        link.classList.add('active');

        const page = link.getAttribute('data-page');
        const content = document.getElementById('pageContent');

        // Simple content replacement for demo
        switch(page) {
          case 'dashboard':
            content.innerHTML = '<h2>Dashboard</h2><p>Welcome to the Staff Dashboard. Select a menu item to get started.</p>';
            break;
          case 'tortoise':
            content.innerHTML = '<h2>Tortoise Records</h2><p>Manage tortoise details, identification, and health status.</p>';
            break;
          case 'feeding':
            content.innerHTML = '<h2>Feeding Schedule</h2><p>Track and log feeding times and dietary requirements.</p>';
            break;
          case 'tasks':
            content.innerHTML = '<h2>Tasks</h2><p>Manage and track your daily tasks and assignments.</p>';
            break;
          default:
            content.innerHTML = '<h2>Page not found</h2>';
        }

        // Close sidebar on mobile after click
        if(window.innerWidth < 768){
          sidebar.classList.remove('show');
        }
      });
    });
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
