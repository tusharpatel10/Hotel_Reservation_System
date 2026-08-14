<?php
session_start();
if ($_SESSION['user_email'] == '') {
    header("Location: ../login.php");
}
$currentPage = basename($_SERVER['PHP_SELF']);
if (isset($_SESSION['user_id']) && $_SESSION['user_roles'] == 'Users') {
    header("Location: ../index.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="adminHMD professional admin dashboard template">
    <title><?php echo $title; ?></title>

    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/vendors/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <div class="admin-shell">
        <div class="sidebar-backdrop" data-sidebar-close></div>

        <aside class="admin-sidebar" id="adminSidebar" aria-label="Main navigation">
            <div class="sidebar-header">
                <a class="brand-mark" href="index.html" aria-label="adminHMD dashboard">
                    <span class="brand-icon"><i class="bi bi-grid-1x2-fill" aria-hidden="true"></i></span>
                    <span class="brand-copy">
                        <span class="brand-title">Hotel Reservation</span>
                        <span class="brand-subtitle">Admin</span>
                    </span>
                </a>
            </div>

            <nav class="sidebar-nav">
                <a class="nav-link <?php echo $currentPage == "index.php" ? 'active' : ''; ?>" href="index.php" aria-current="page">
                    <span class="nav-icon"><i class="bi bi-speedometer2" aria-hidden="true"></i></span>
                    <span class="nav-text">Dashboard</span>
                </a>
                <a class="nav-link <?php echo $currentPage == "Add_Hotel.php" ? 'active' : ''; ?> " href="Add_Hotel.php">
                    <span class="nav-icon"><i class="bi bi-people" aria-hidden="true"></i></span>
                    <span class="nav-text">Add Hotels</span>
                </a>
                <a class="nav-link <?php echo $currentPage == "view_hotels.php" ? 'active' : ''; ?> " href="view_hotels.php">
                    <span class="nav-icon"><i class="bi bi-list" aria-hidden="true"></i></span>
                    <span class="nav-text">View Hotels</span>
                </a>
                <a class="nav-link <?php echo $currentPage == "Add_Rooms.php" ? 'active' : ''; ?> " href="Add_Rooms.php">
                    <span class="nav-icon"><i class="bi bi-person-plus" aria-hidden="true"></i></span>
                    <span class="nav-text">Add Rooms</span>
                </a>
                <a class="nav-link" href="profile.html">
                    <span class="nav-icon"><i class="bi bi-person-badge" aria-hidden="true"></i></span>
                    <span class="nav-text">Profile</span>
                </a>
            </nav>


            <div class="sidebar-footer">
                <span class="status-dot"></span>
                <span class="sidebar-footer-text">System running smoothly</span>
            </div>
        </aside>

        <div class="admin-main">
            <nav class="navbar admin-navbar navbar-expand bg-white">
                <div class="container-fluid px-3 px-lg-4">
                    <button class="sidebar-toggle" type="button" data-sidebar-toggle aria-controls="adminSidebar" aria-expanded="true" aria-label="Toggle sidebar">
                        <span></span>
                        <span></span>
                        <span></span>
                    </button>



                    <div class="navbar-actions ms-auto">
                        <!-- <button class="icon-button theme-toggle" type="button" data-theme-toggle aria-label="Switch color theme" title="Switch color theme">
                            <i class="bi bi-moon-stars" data-theme-icon aria-hidden="true"></i>
                        </button> -->
                        <div class="dropdown">
                            <!-- <button class="icon-button" type="button" data-bs-toggle="dropdown" aria-expanded="false" aria-label="Notifications">
                                <span class="notification-dot"></span>
                                <i class="bi bi-bell" aria-hidden="true"></i>
                            </button> -->
                            <div class="dropdown-menu dropdown-menu-end notification-menu">
                                <div class="dropdown-header fw-bold text-body">Notifications</div>
                                <a class="dropdown-item" href="users.html">
                                    <span class="notification-title">New user registered</span>
                                    <span class="notification-time">4 minutes ago</span>
                                </a>
                                <a class="dropdown-item" href="charts.html">
                                    <span class="notification-title">Revenue target reached</span>
                                    <span class="notification-time">32 minutes ago</span>
                                </a>
                                <a class="dropdown-item" href="settings.html">
                                    <span class="notification-title">Security review completed</span>
                                    <span class="notification-time">1 hour ago</span>
                                </a>
                            </div>
                        </div>

                        <div class="dropdown">
                            <button class="profile-button dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="profile-name d-none d-sm-inline"><?php if (isset($_SESSION['user_email'])) echo $_SESSION['user_email']; ?></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="profile.html">Profile</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="../logout.php">Sign out</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>