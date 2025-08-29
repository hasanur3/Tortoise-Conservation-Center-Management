<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Feeding Staff Dashboard - Tortoise Management</title>
    <link rel="icon" type="image/png" href="/assests/image/logo.jpeg" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
    <style>
        body {
            background-color: #e9f5ea; /* Matches the background from the provided code */
        }
        .sidebar {
            height: 100vh;
            background-color: #198754; /* Matches sidebar color */
            color: white;
            position: fixed;
            width: 220px;
            transition: width 0.3s;
            overflow-y: auto;
        }
        .sidebar.collapsed {
            width: 70px;
        }
        .sidebar .nav-link {
            color: white;
            font-weight: 500;
            padding: 12px 20px;
            white-space: nowrap;
        }
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background-color: #145c32; /* Matches active/hover state */
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
            min-height: 100vh;
        }
        main.collapsed {
            margin-left: 70px;
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
            main, main.collapsed {
                margin-left: 0;
            }
        }
        .card {
            box-shadow: 0 4px 8px rgba(0,0,0,0.05); /* Adds a subtle shadow to cards */
            border-radius: 10px;
        }
        .card-header {
            background-color: #198754; /* Green header from provided code */
            color: white;
            font-weight: bold;
        }
        .card-shift, .card-notes {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            margin-bottom: 20px;
        }
        .card-shift p {
            margin: 0;
            display: flex;
            justify-content: space-between;
        }
        .card-shift .day-off {
            color: #dc3545;
        }
        /* Badge colors from the previous feeding dashboard */
        .status-pending {
            background-color: #ffc107;
            color: #856404;
        }
        .status-inprogress {
            background-color: #cfe2ff;
            color: #084298;
        }
        .status-completed {
            background-color: #d1e7dd;
            color: #0f5132;
        }
        .status-overdue {
            background-color: #f8d7da;
            color: #842029;
        }
    </style>
</head>
<body>

<nav id="sidebar" class="sidebar d-flex flex-column">
    <div class="d-flex align-items-center justify-content-between px-3 py-3 border-bottom border-success">
        <span class="fs-4 fw-bold">Feeding Staff</span>
        <button id="sidebarCollapse" class="btn btn-sm btn-success d-md-none">
            <i class="bi bi-x"></i>
        </button>
    </div>

    <ul class="nav flex-column mt-3">
        <li class="nav-item">
            <a href="#" class="nav-link active">
                <i class="bi bi-speedometer2"></i> <span>Dashboard</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="bi bi-list-task"></i> <span>My Tasks</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="bi bi-journal-text"></i> <span>Notes</span>
            </a>
        </li>
        <li class="nav-item mt-auto">
            <a href="#" class="nav-link">
                <i class="bi bi-box-arrow-right"></i> <span>Logout</span>
            </a>
        </li>
    </ul>

    <button id="toggleSidebarBtn" class="btn btn-success mt-auto mx-3 mb-3 d-none d-md-block" title="Toggle Sidebar">
        <i class="bi bi-chevron-left"></i>
    </button>
</nav>

<main id="mainContent">
    <nav class="navbar navbar-expand-lg navbar-dark bg-success mb-4">
        <div class="container-fluid">
            <button id="sidebarToggle" class="btn btn-success d-md-none">
                <i class="bi bi-list"></i>
            </button>
            <span class="navbar-brand ms-2">Dashboard Overview</span>
        </div>
    </nav>

    <div class="container-fluid">
        <h3 class="mb-3">My Assigned Tasks</h3>
        <div class="row g-4 mb-5">
            <div class="col-md-6 col-lg-3">
                <div class="card h-100">
                    <div class="card-header">Morning Feeding - Enclosure A</div>
                    <div class="card-body d-flex flex-column justify-content-between">
                        <div>
                            <span class="badge status-pending rounded-pill px-3 py-2">Pending</span>
                            <p class="card-text mt-3 mb-2 text-muted">Enclosure A</p>
                            <p class="card-text text-muted">08:00 AM - 09:00 AM</p>
                        </div>
                        <div class="d-flex justify-content-between mt-3">
                            <button class="btn btn-primary btn-sm">Start Task</button>
                            <button class="btn btn-success btn-sm">Mark as Complete</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card h-100">
                    <div class="card-header">Afternoon Feeding - Enclosure B</div>
                    <div class="card-body d-flex flex-column justify-content-between">
                        <div>
                            <span class="badge status-inprogress rounded-pill px-3 py-2">In progress</span>
                            <p class="card-text mt-3 mb-2 text-muted">Enclosure B</p>
                            <p class="card-text text-muted">01:00 PM - 02:00 PM</p>
                        </div>
                        <div class="d-flex justify-content-end mt-3">
                            <button class="btn btn-success btn-sm">Mark as Complete</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card h-100">
                    <div class="card-header">Special Diet - Tortoise ID 005</div>
                    <div class="card-body d-flex flex-column justify-content-between">
                        <div>
                            <span class="badge status-completed rounded-pill px-3 py-2">Completed</span>
                            <p class="card-text mt-3 mb-2 text-muted">Medical Bay</p>
                            <p class="card-text text-muted">03:30 PM - 04:00 PM</p>
                        </div>
                        <div class="d-flex justify-content-between mt-3">
                            <button class="btn btn-primary btn-sm" disabled>Start Task</button>
                            <button class="btn btn-success btn-sm" disabled>Mark as Complete</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card h-100">
                    <div class="card-header">Evening Supplement - Enclosure C</div>
                    <div class="card-body d-flex flex-column justify-content-between">
                        <div>
                            <span class="badge status-overdue rounded-pill px-3 py-2">Overdue</span>
                            <p class="card-text mt-3 mb-2 text-muted">Enclosure C</p>
                            <p class="card-text text-muted">06:00 PM - 06:30 PM</p>
                        </div>
                        <div class="d-flex justify-content-between mt-3">
                            <button class="btn btn-primary btn-sm">Start Task</button>
                            <button class="btn btn-success btn-sm">Mark as Complete</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <h3 class="mb-3">My Shift Schedule</h3>
        <div class="card-shift mb-4">
            <p>Monday: <span class="text-success">08:00 AM - 04:00 PM</span></p>
            <p>Tuesday: <span class="text-success">08:00 AM - 04:00 PM</span></p>
            <p>Wednesday: <span class="day-off">Day Off</span></p>
            <p>Thursday: <span class="text-success">09:00 AM - 05:00 PM</span></p>
            <p>Friday: <span class="text-success">09:00 AM - 05:00 PM</span></p>
        </div>

        <h3 class="mb-3">Feeding Notes</h3>
        <div class="card-notes">
            <p class="mb-0 text-muted">Remember to check water levels during feeding rounds.</p>
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>