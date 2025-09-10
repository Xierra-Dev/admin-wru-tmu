<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'WRU Admin Dashboard' ?></title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        
        /* CSS Reset for backgrounds */
        html, body {
            background: transparent !important;
        }
        
        :root {
            --global-navbar-height: 70px;
            --global-spacing: 20px;
            --sidebar-width-expanded: 140px;
            --sidebar-width-collapsed: 60px; /* Ukuran sidebar saat terlipat (lebih kecil) */
        }
        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            padding-top: 0;
            overflow-x: hidden;
        }
        
        /* NEW GLOBAL TOP NAVBAR */
        .global-top-navbar {
            background-color: white;
            padding: 1rem 2rem;
            height: var(--global-navbar-height);
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            border-bottom-left-radius: 20px !important;
            border-bottom-right-radius: 20px !important;
            z-index: 1000;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            width: 100%;
            box-sizing: border-box;
        }
        .global-top-navbar .logo-section {
            display: flex;
            align-items: center;
            gap: 10px; /* Jarak antar logo */
        }
        
        /* New styling for logos in navbar */
        .global-top-navbar .logo-group {
            display: flex;
            flex-direction: column;
            align-items: center; /* Memusatkan secara horizontal */
            gap: 0; 
        }
        .global-top-navbar .logo-group img {
            height: 20px; /* Ukuran logo disesuaikan */
            width: auto;
        }
        .global-top-navbar .logo-group .wru-logo {
            height: 35px; /* WRU lebih besar dari WHR */
            width: auto;
        }
        .global-top-navbar .logo-group .whr-logo {
            height: 15px; /* WHR lebih kecil */
            width: auto;
        }
        .global-top-navbar .logo-section .line-logo {
            height: 52px;
            width: auto;
        }
        .global-top-navbar .logo-section .artimu-img {
            height: 23px; /* Ukuran logo Artimu */
            width: auto;
        }
        
        .global-top-navbar .date-section {
            color: #4a5568;
            font-size: 0.9rem;
            margin-right: 1.5rem;
            font-weight: 500;
        }
        .global-top-navbar .user-profile-dropdown .dropdown-toggle {
            background-color:rgb(58, 47, 211);
            border: none;
            border-radius: 8px;
            padding: 8px 15px;
            color: white;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: background-color 0.3s ease;
            font-weight: 600;
            cursor: pointer;
        }
        .global-top-navbar .user-profile-dropdown .dropdown-toggle:hover {
            background-color:rgb(97, 26, 219);
        }
        .global-top-navbar .user-profile-dropdown .dropdown-menu {
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            padding: 0.25rem 0;
            position: absolute;
            top: calc(100% + 1px);
            right: 0;
            background-color: #0A00B1;
            z-index: 110;
            display: none;
            min-width: 200px;
            border: none;
            margin-top: 8px;
        }
        .global-top-navbar .user-profile-dropdown.show .dropdown-menu {
            display: block;
        }
        .global-top-navbar .user-profile-dropdown .dropdown-item {
            padding: 0.5rem 1rem;
            color: white;
            text-decoration: none;
            display: block;
            transition: background-color 0.3s ease;
            text-align: center;
            font-weight: 500;
        }
        .global-top-navbar .user-profile-dropdown .dropdown-item:hover {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
        }
        .global-top-navbar .user-profile-dropdown .dropdown-divider {
            height: 1px;
            margin: 0.25rem 1rem;
            background-color: rgba(255, 255, 255, 0.3);
            border: none;
        }

        /* WRAPPER FOR SIDEBAR AND MAIN CONTENT */
        .main-layout-wrapper {
            display: flex;
            flex-grow: 1;
            width: 100%;
            padding-top: calc(var(--global-navbar-height) + 10px); 
            padding-bottom: var(--global-spacing);
            background-image: url('<?= base_url('img/gedung_dalam.jpg') ?>');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            position: relative;
        }
        .main-layout-wrapper::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5); 
            z-index: 1;
        }

        /* Flash Notification Styles */
        .flash-notification {
            position: fixed;
            top: 70px; /* Fixed navbar height */
            left: var(--sidebar-width-expanded);
            right: 0;
            z-index: 9999;
            width: calc(100% - var(--sidebar-width-expanded));
            animation: slideDown 0.3s ease-out;
        }
        
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .flash-notification .alert {
            margin-bottom: 0;
            border: none;
            border-radius: 0 0 15px 15px;
            font-weight: 500;
            padding: 15px 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            color: white;
            width: 100%;
            box-sizing: border-box;
        }
        
        .flash-notification .alert-success {
            background-color: #28a745;
        }
        
        .flash-notification .alert-danger {
            background-color: #dc3545;
        }
        
        .flash-notification .alert-warning {
            background-color: #ffc107;
            color: #212529;
        }
        
        .flash-notification .alert-info {
            background-color: #17a2b8;
        }
        
        .flash-notification .alert i {
            font-size: 1.2rem;
            margin-right: 10px;
        }
        
        .flash-notification .notification-content {
            display: flex;
            align-items: center;
            flex: 1;
        }
        
        .flash-notification .notification-icon {
            font-size: 1.5rem;
            margin-left: auto;
        }
        
        /* Responsive adjustments for flash notifications */
        @media (max-width: 768px) {
            .flash-notification {
                top: 70px; /* Fixed navbar height for mobile */
                left: 0;
                right: 0;
                width: 100%;
            }
            
            .flash-notification .alert {
                padding: 12px 20px;
            }
        }
        
        /* Adjust for collapsed sidebar */
        .sidebar.collapsed ~ .main-layout-wrapper .flash-notification {
            left: var(--sidebar-width-collapsed);
            width: calc(100% - var(--sidebar-width-collapsed));
        }

        /* NEW SIDEBAR STYLES */
        .sidebar {
            width: var(--sidebar-width-expanded);
            background-color: #0953a3ff;
            color: #fff;
            padding: 20px 0;
            display: flex;
            flex-direction: column;
            border-top-right-radius: 15px;
            border-bottom-right-radius: 15px;
            box-shadow: 2px 0 5px rgba(0,0,0,0.1);
            z-index: 2;
            transition: width 0.3s ease-in-out;
            overflow-x: hidden;
            margin-top: 10px;
            /* margin-left: var(--global-spacing); */
            max-width: var(--sidebar-width-expanded); /* Ensure sidebar never exceeds its defined width */
            box-sizing: border-box;
        }
        .sidebar * {
            max-width: 100%; /* Force all children to respect sidebar width */
            box-sizing: border-box;
        }
        .sidebar.collapsed {
            width: var(--sidebar-width-collapsed);
        }
        .sidebar .logo {
            text-align: center;
            margin-bottom: 30px;
            padding: 0 5px; /* Disesuaikan untuk lebar baru */
        }
        .sidebar .logo .wru-text {
            font-size: 1.3rem; 
            color: white;
            font-weight: 700;
            transition: opacity 0.3s ease-in-out;
        }
        .sidebar.collapsed .logo .wru-text {
            opacity: 0;
            width: 0;
        }
        .sidebar .logo .artimu-img-sidebar {
            height: 22px; 
            width: auto;
            filter: brightness(0) invert(1);
            margin-right: 0.25rem;
            transition: margin-right 0.3s ease-in-out;
        }
        .sidebar.collapsed .logo .artimu-img-sidebar {
            margin-right: 0;
        }
        .sidebar .nav-item {
            margin-bottom: 10px;
            position: relative;
            text-align: center;
        }
        .sidebar .nav-item.schedule-expanded,
        .sidebar .nav-item.schedule-active {
            border: 2px solid #FFA200;
            border-radius: 8px; /* Smaller border radius for compact look */
            padding: 0px;
            margin: 2px 8px; /* Reduced margin for 140px width */
            overflow: hidden;
            width: calc(100% - 20px); /* Adjusted for 140px width with border */
            box-sizing: border-box;
        }
        .sidebar .nav-item.history-expanded,
        .sidebar .nav-item.history-active {
            border: 2px solid #17a2b8; /* Cyan color for History */
            border-radius: 8px;
            padding: 0px;
            margin: 2px 8px;
            overflow: hidden;
            width: calc(100% - 20px);
            box-sizing: border-box;
            background-color: rgba(23, 162, 184, 0.1); /* Subtle background for active state */
        }
        .sidebar .nav-link {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 6px 8px; /* Reduced padding for 140px width */
            color: #ffffffff;
            text-decoration: none;
            border-radius: 8px; /* Smaller border radius for compact look */
            transition: background-color 0.3s ease;
            font-weight: 500;
            cursor: pointer;
            position: relative;
            margin: 0 8px; /* Reduced margin for 140px width */
        }
        .sidebar .nav-item.schedule-expanded .nav-link,
        .sidebar .nav-item.schedule-active .nav-link {
            margin: 0px;
            padding: 6px 8px; /* Reduced padding for 140px width */
            width: 100%;
            box-sizing: border-box;
        }
        .sidebar .nav-item.history-expanded .nav-link,
        .sidebar .nav-item.history-active .nav-link {
            margin: 0px;
            padding: 6px 8px;
            width: 100%;
            box-sizing: border-box;
        }
        .sidebar.collapsed .nav-link {
            padding: 8px 0;
            margin: 0 8px;
        }
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            background-color: #FFA200;
        }
        .sidebar .nav-link i {
            margin: 0;
            font-size: 1.2rem; /* Smaller icon for 140px width */
        }
        .sidebar .nav-link span {
            font-size: 0.7rem; /* Smaller font for 140px width */
            margin-top: 3px; /* Reduced margin */
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            transition: opacity 0.3s ease-in-out;
            display: flex;
            align-items: center;
            gap: 3px; /* Reduced gap */
        }
        .sidebar.collapsed .nav-link span {
            opacity: 0;
            width: 0;
        }
        .sidebar.collapsed .nav-link .dropdown-arrow {
            display: none;
        }
        .sidebar .nav-link.dropdown-toggle::after {
            display: none;
        }
        .sidebar .nav-link .dropdown-arrow {
            font-size: 0.7rem;
            transition: transform 0.3s ease;
            flex-shrink: 0;
        }
        .sidebar .nav-link:not(.collapsed) .dropdown-arrow {
            transform: rotate(180deg);
        }
        .sidebar .dropdown-menu {
            background-color: transparent;
            border: none;
            padding: 8px 0px; /* Add padding for gap between schedule button and dropdown items */
            border-radius: 0;
            width: calc(100% - 16px); /* Adjusted for 140px width */
            display: none;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-in-out;
            margin-top: 6px; /* Increased margin for better gap */
            margin-left: 8px; /* Reduced margin for 140px width */
            margin-right: 8px;
            position: relative;
            box-sizing: border-box;
        }
        .sidebar .nav-item.schedule-expanded .dropdown-menu,
        .sidebar .nav-item.schedule-active .dropdown-menu {
            width: calc(100% - 20px); /* Adjusted for bordered container in 140px width */
            margin-left: 0px; /* Centered within the bordered container */
            margin-right: 10px;
            padding: 8px 0px; /* Add padding for gap between schedule button and dropdown items */
        }
        .sidebar .nav-item.history-expanded .dropdown-menu,
        .sidebar .nav-item.history-active .dropdown-menu {
            width: calc(100% - 20px);
            margin-left: 0px;
            margin-right: 10px;
            padding: 8px 0px;
        }
        .sidebar .dropdown-menu.show {
            display: block;
            max-height: 80px; /* Increased height to accommodate padding and gaps */
        }
        .sidebar .dropdown-menu .dropdown-item {
            color: #fff;
            padding: 4px 6px; /* Slightly increased padding for better touch target */
            border-radius: 6px; /* Smaller border radius */
            transition: all 0.3s ease;
            font-weight: 500;
            text-align: center;
            background-color: #6c757d;
            margin-bottom: 6px; /* Increased margin for better gap between items */
            border: 1px solid rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            width: calc(100% - 55px); /* Fixed width calculation */
            box-sizing: border-box;
            font-size: 0.7rem; /* Smaller font for compact look */
            margin-left: 6px; /* Centered margins */
            margin-right: 6px;
            min-height: 22px; /* Slightly increased height for better readability */
        }
        .sidebar .dropdown-menu .dropdown-item.active {
            background-color: #FFA200; /* Orange color for active item */
            color: #fff;
            border-color: rgba(255, 255, 255, 0.3);
        }
        /* Enhanced orange border for active schedule items */
        .sidebar .nav-item.schedule-active {
            border: 2px solid #FFA200;
            border-radius: 8px; /* Smaller border radius for compact look */
            padding: 0px;
            margin: 2px 8px; /* Reduced margin for 140px width */
            overflow: hidden;
            width: calc(100% - 20px); /* Adjusted for 140px width with border */
            background-color: rgba(255, 162, 0, 0.1); /* Subtle background for active state */
            box-sizing: border-box;
        }
        /* Enhanced cyan border for active history items */
        .sidebar .nav-item.history-active {
            border: 2px solid #FFA200;
            border-radius: 8px;
            padding: 0px;
            margin: 2px 8px;
            overflow: hidden;
            width: calc(100% - 20px);
            background-color: rgba(23, 162, 184, 0.1);
            box-sizing: border-box;
        }
        .sidebar .dropdown-menu .dropdown-item:hover {
            /* Hover effects removed for cleaner appearance */
        }
        .sidebar.collapsed .dropdown-menu {
            position: absolute;
            left: var(--sidebar-width-collapsed);
            top: 0;
            width: 120px; /* Slightly reduced width for more compact look */
            box-shadow: 2px 2px 5px rgba(0,0,0,0.2);
            z-index: 10;
            background-color: #0953a3ff;
            border-radius: 8px; /* Smaller border radius */
            padding: 6px; /* Reduced padding for compact look */
            margin-left: 0; /* Reset margin for collapsed state */
            margin-right: 0;
        }
        .sidebar.collapsed .dropdown-menu .dropdown-item {
            margin-left: 0;
            margin-right: 0;
            width: 100%;
        }


        .main-content {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            z-index: 2; 
            overflow-y: auto;
            margin-left: var(--global-spacing); 
            border-radius: 15px;
        }
        
        .sidebar-toggle-absolute {
            position: absolute;
            top: 15px;
            left: 15px;
            z-index: 5;
            background-color: #031d38ff;
            border-color: #031d38ff;
            border-radius: 8px;
            padding: 8px 12px;
            color: white;
            display: none;
        }

        .content-wrapper {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 2rem;
            width: 100%;
        }

        .hero-section {
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            align-items: flex-start;
            text-align: left;
            color: #fff;
            position: relative;
            z-index: 1;
            height: 100vh;
            padding: 10rem;
        }
        .hero-section .artimu-large-img {
            width: auto;
            height: 120px;
            margin-bottom: 1rem;
            margin-left: -100px;
        }
        .hero-section h1 {
            font-size: 1.5rem;
            font-weight: 400;
            margin-bottom: 0.5rem;
            margin-left: -100px;
        }
        .hero-section h2 {
            font-size: 3rem;
            font-weight: 700;
            margin-top: 0;
            margin-left: -100px;
        }

        /* Mobile adjustments */
        @media (max-width: 768px) {
            .global-top-navbar {
                padding: 0.75rem 1rem;
                justify-content: flex-end;
                border-bottom-left-radius: 15px !important;
                border-bottom-right-radius: 15px !important;
            }
            .global-top-navbar .logo-section {
                display: none;
            }
            .global-top-navbar .date-section {
                display: none;
            }
            .main-layout-wrapper {
                flex-direction: column;
                padding: 0;
            }
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
                transform: translateX(-100%);
                border-radius: 0;
                box-shadow: none;
                padding-bottom: 20px;
                top: 0;
                margin: 0;
                transition: transform 0.3s ease-in-out;
            }
            .sidebar.show-sidebar {
                transform: translateX(0);
            }
            .main-content {
                margin-left: 0;
                min-height: calc(100vh - var(--global-navbar-height));
            }
            .sidebar-toggle-absolute {
                display: block;
            }
            .hero-section .artimu-large {
                font-size: 3rem;
            }
            .hero-section h1 {
                font-size: 2.5rem;
            }
            .hero-section h2 {
                font-size: 1.8rem;
            }
            .content-wrapper {
                padding: 1rem;
            }
            .hero-section {
                padding: 1rem;
            }
        }

        /* Fix for modal visibility */
        .modal {
            z-index: 1050 !important;
        }
    </style>
</head>
<body>
    <nav class="global-top-navbar" id="global-top-navbar">
        <div class="logo-section">
            <a href="<?= base_url('dashboard') ?>" style="text-decoration: none; display: flex; align-items: center; gap: 10px;">
                <div class="logo-group">
                    <img src="<?= base_url('img/wru.png') ?>" alt="WRU Logo" class="wru-logo uin-logo">
                    <img src="<?= base_url('img/whr.png') ?>" alt="UIN Jakarta Logo" class="whr-logo uin-logo">
                </div>
                <img src="<?= base_url('img/line.png') ?>" alt="Separator Line" class="line-logo">
                <img src="<?= base_url('img/artimu.png') ?>" alt="Artimu Logo" class="artimu-img">
            </a>
        </div>
        <div class="d-flex align-items-center gap-3">
            <span class="date-section" id="currentDate"></span>
            <div class="user-profile-dropdown dropdown relative">
                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" aria-expanded="false">
                    <i class="bi bi-person-fill"></i> <?= session()->get('admin_name') ?? 'Admin' ?>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink">
                    <li><a class="dropdown-item" href="<?= base_url('profile') ?>">Profiles</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="<?= base_url('auth/logout') ?>">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Flash Notification Display Area -->
    <?php if (session()->getFlashdata('notification_type') && session()->getFlashdata('notification_message')): ?>
        <div class="flash-notification" id="flash-notification">
            <div class="alert alert-<?= session()->getFlashdata('notification_type') ?>" role="alert">
                <div class="notification-content">
                    <?= session()->getFlashdata('notification_message') ?>
                </div>
                <div class="notification-icon">
                    <?php 
                    $type = session()->getFlashdata('notification_type');
                    $message = session()->getFlashdata('notification_message');
                    
                    if (strpos($message, 'edited') !== false): ?>
                        <i class="bi bi-pencil-square"></i>
                    <?php elseif (strpos($message, 'deleted') !== false): ?>
                        <i class="bi bi-trash"></i>
                    <?php elseif (strpos($message, 'added') !== false): ?>
                        <i class="bi bi-folder-plus"></i>
                    <?php elseif ($type === 'danger'): ?>
                        <i class="bi bi-folder-x"></i>
                    <?php else: ?>
                        <i class="bi bi-check-circle"></i>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <div class="main-layout-wrapper">
        <div class="sidebar" id="sidebar">
            <ul class="nav flex-column flex-grow-1">
                <li class="nav-item">
                    <a class="nav-link <?= (url_is('people*')) ? 'active' : '' ?>" href="<?= base_url('people') ?>">
                        <i class="bi bi-person"></i>
                        <span>Personil</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= (url_is('destinations*')) ? 'active' : '' ?>" href="<?= base_url('destinations') ?>">
                        <i class="bi bi-geo-alt"></i>
                        <span>Destination</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= (url_is('vehicles*')) ? 'active' : '' ?>" href="<?= base_url('vehicles') ?>">
                        <i class="bi bi-truck"></i>
                        <span>Vehicle</span>
                    </a>
                </li>
                <?php
                    $scheduleActive = url_is('mloc*') || url_is('vtrip*');
                    $isScheduleCollapsed = $scheduleActive ? '' : 'collapsed';
                    $isScheduleExpanded = $scheduleActive ? 'true' : 'false';
                    $isScheduleShow = $scheduleActive ? 'show' : '';
                ?>
                <li class="nav-item <?= $scheduleActive ? 'schedule-active' : '' ?>">
                    <a class="nav-link dropdown-toggle <?= $scheduleActive ? 'active' : '' ?> <?= $isScheduleCollapsed ?>" href="#" id="scheduleDropdown" role="button" aria-expanded="<?= $isScheduleExpanded ?>">
                        <i class="bi bi-calendar-event"></i>
                        <span>Schedule <i class="bi bi-chevron-down dropdown-arrow"></i></span>
                    </a>
                    <ul class="dropdown-menu <?= $isScheduleShow ?>" aria-labelledby="scheduleDropdown">
                        <li>
                            <a class="dropdown-item <?= url_is('mloc*') ? 'active' : '' ?>" href="<?= base_url('mloc') ?>">M-Loc</a>
                        </li>
                        <li>
                            <a class="dropdown-item <?= url_is('vtrip*') ? 'active' : '' ?>" href="<?= base_url('vtrip') ?>">V-Trip</a>
                        </li>
                    </ul>
                </li>
                <?php
                    $historyActive = url_is('history*');
                    $isHistoryCollapsed = $historyActive ? '' : 'collapsed';
                    $isHistoryExpanded = $historyActive ? 'true' : 'false';
                    $isHistoryShow = $historyActive ? 'show' : '';
                ?>
                <li class="nav-item <?= $historyActive ? 'history-active' : '' ?>">
                    <a class="nav-link dropdown-toggle <?= $historyActive ? 'active' : '' ?> <?= $isHistoryCollapsed ?>" href="#" id="historyDropdown" role="button" aria-expanded="<?= $isHistoryExpanded ?>">
                        <i class="bi bi-clock-history"></i>
                        <span>History <i class="bi bi-chevron-down dropdown-arrow"></i></span>
                    </a>
                    <ul class="dropdown-menu <?= $isHistoryShow ?>" aria-labelledby="historyDropdown">
                        <li>
                            <a class="dropdown-item <?= url_is('history/mloc*') ? 'active' : '' ?>" href="<?= base_url('history/mloc') ?>">M-Loc</a>
                        </li>
                        <li>
                            <a class="dropdown-item <?= url_is('history/vtrip*') ? 'active' : '' ?>" href="<?= base_url('history/vtrip') ?>">V-Trip</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>

        <div class="main-content" id="main-content">
            <button class="btn btn-primary d-block d-md-none sidebar-toggle-absolute" id="sidebarToggle">
                <i class="bi bi-list"></i>
            </button>
            <div class="content-fluid">
                <?= $this->renderSection('content') ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-hide flash notifications after 5 seconds
            const flashNotification = document.getElementById('flash-notification');
            if (flashNotification) {
                // Adjust notification position based on sidebar state
                function adjustNotificationPosition() {
                    const sidebar = document.getElementById('sidebar');
                    if (sidebar) {
                        if (window.innerWidth <= 768) {
                            // Mobile: full width
                            flashNotification.style.left = '0';
                            flashNotification.style.width = '100%';
                        } else if (sidebar.classList.contains('collapsed')) {
                            // Desktop collapsed sidebar
                            flashNotification.style.left = '60px';
                            flashNotification.style.width = 'calc(100% - 60px)';
                        } else {
                            // Desktop expanded sidebar
                            flashNotification.style.left = '150px';
                            flashNotification.style.width = 'calc(100% - 150px)';
                        }
                    }
                }
                
                // Initial adjustment
                adjustNotificationPosition();
                
                // Watch for sidebar changes
                const sidebar = document.getElementById('sidebar');
                if (sidebar) {
                    const observer = new MutationObserver(adjustNotificationPosition);
                    observer.observe(sidebar, { attributes: true, attributeFilter: ['class'] });
                }
                
                // Watch for window resize
                window.addEventListener('resize', adjustNotificationPosition);
                
                setTimeout(function() {
                    flashNotification.style.opacity = '0';
                    flashNotification.style.transform = 'translateY(-20px)';
                    setTimeout(function() {
                        if (flashNotification.parentNode) {
                            flashNotification.remove();
                        }
                    }, 300);
                }, 5000); // 5 seconds
            }
            // --- Current date (if present) ---
            const dateElement = document.getElementById('currentDate');
            if (dateElement) {
                const options = { weekday: 'short', year: 'numeric', month: 'short', day: 'numeric' };
                const today = new Date();
                dateElement.textContent = today.toLocaleDateString('en-US', options);
            }

            // --- Profile dropdown (defensive) ---
            const userDropdownToggle = document.getElementById('dropdownMenuLink');
            const userDropdown = userDropdownToggle ? userDropdownToggle.closest('.dropdown') : null;
            if (userDropdownToggle && userDropdown) {
                userDropdownToggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    userDropdown.classList.toggle('show');
                });
                // close when clicking outside
                document.addEventListener('click', function(e) {
                    if (!userDropdown.contains(e.target)) {
                        userDropdown.classList.remove('show');
                    }
                });
            }

            // --- Sidebar / mobile controls ---
            const sidebar = document.getElementById('sidebar');
            const desktopSidebarToggle = document.getElementById('sidebarToggle');
            const mobileSidebarToggle = document.getElementById('mobileSidebarToggle');
            const sidebarCloseBtn = document.getElementById('sidebarCloseBtn');
            const mobileOverlay = document.getElementById('mobileOverlay'); 

            function openSidebar() {
                if (!sidebar) return;
                sidebar.classList.remove('collapsed');
                sidebar.classList.add('show-sidebar');
                if (mobileOverlay) mobileOverlay.classList.add('show');
                document.body.style.overflow = 'hidden';
            }

            function closeSidebar() {
                if (!sidebar) return;
                sidebar.classList.add('collapsed');
                sidebar.classList.remove('show-sidebar');
                if (mobileOverlay) mobileOverlay.classList.remove('show');
                document.body.style.overflow = '';
            }

            function toggleSidebar() {
                if (!sidebar) return;
                const isCollapsed = sidebar.classList.contains('collapsed');
                if (isCollapsed) openSidebar(); else closeSidebar();
            }

            if (desktopSidebarToggle) {
                desktopSidebarToggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    toggleSidebar();
                });
            }

            if (mobileSidebarToggle) {
                mobileSidebarToggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    openSidebar();
                });
            }

            if (sidebarCloseBtn) {
                sidebarCloseBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    closeSidebar();
                });
            }

            if (mobileOverlay) {
                mobileOverlay.addEventListener('click', function() {
                    closeSidebar();
                });
            }

            if (sidebar) {
                sidebar.querySelectorAll('.nav-link').forEach(function(link) {
                    link.addEventListener('click', function() {
                        if (window.innerWidth <= 768) closeSidebar();
                    });
                });
            }
            
            // close sidebar when clicking outside (mobile)
            document.addEventListener('click', function(event) {
                if (window.innerWidth <= 768 && sidebar) {
                    const clickInsideSidebar = sidebar.contains(event.target);
                    const clickOnToggles = (desktopSidebarToggle && desktopSidebarToggle.contains(event.target)) || (mobileSidebarToggle && mobileSidebarToggle.contains(event.target));
                    if (!clickInsideSidebar && !clickOnToggles && sidebar.classList.contains('show-sidebar')) {
                        closeSidebar();
                    }
                }
            });

            // --- Schedule dropdown in sidebar (defensive) ---
            const scheduleDropdownToggle = document.getElementById('scheduleDropdown');
            const scheduleDropdownMenu = scheduleDropdownToggle ? scheduleDropdownToggle.nextElementSibling : null;
            const scheduleNavItem = scheduleDropdownToggle ? scheduleDropdownToggle.closest('.nav-item') : null;
            if (scheduleDropdownToggle && scheduleDropdownMenu && scheduleNavItem) {
                scheduleDropdownToggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    scheduleDropdownMenu.classList.toggle('show');
                    this.classList.toggle('collapsed');
                    const isExpanded = this.getAttribute('aria-expanded') === 'true';
                    this.setAttribute('aria-expanded', (!isExpanded).toString());
                    
                    // Enhanced border styling for dropdown states
                    if (scheduleDropdownMenu.classList.contains('show')) {
                        scheduleNavItem.classList.add('schedule-expanded');
                        scheduleNavItem.classList.remove('schedule-active');
                    } else {
                        scheduleNavItem.classList.remove('schedule-expanded');
                        // Restore schedule-active class if current page is schedule-related (exclude history)
                        if ((window.location.pathname.includes('mloc') || window.location.pathname.includes('vtrip')) && !window.location.pathname.includes('history')) {
                            scheduleNavItem.classList.add('schedule-active');
                        }
                    }
                });
                
                // Initialize proper active state on page load (exclude history pages)
                if ((window.location.pathname.includes('mloc') || window.location.pathname.includes('vtrip')) && !window.location.pathname.includes('history')) {
                    scheduleNavItem.classList.add('schedule-active');
                    scheduleDropdownMenu.classList.add('show');
                    scheduleDropdownToggle.classList.remove('collapsed');
                    scheduleDropdownToggle.setAttribute('aria-expanded', 'true');
                }
            }

            // --- History dropdown in sidebar (defensive) ---
            const historyDropdownToggle = document.getElementById('historyDropdown');
            const historyDropdownMenu = historyDropdownToggle ? historyDropdownToggle.nextElementSibling : null;
            const historyNavItem = historyDropdownToggle ? historyDropdownToggle.closest('.nav-item') : null;
            if (historyDropdownToggle && historyDropdownMenu && historyNavItem) {
                historyDropdownToggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    historyDropdownMenu.classList.toggle('show');
                    this.classList.toggle('collapsed');
                    const isExpanded = this.getAttribute('aria-expanded') === 'true';
                    this.setAttribute('aria-expanded', (!isExpanded).toString());
                    
                    // Enhanced border styling for dropdown states
                    if (historyDropdownMenu.classList.contains('show')) {
                        historyNavItem.classList.add('history-expanded');
                        historyNavItem.classList.remove('history-active');
                    } else {
                        historyNavItem.classList.remove('history-expanded');
                        // Restore history-active class if current page is history-related
                        if (window.location.pathname.includes('history')) {
                            historyNavItem.classList.add('history-active');
                        }
                    }
                });
                
                // Initialize proper active state on page load
                if (window.location.pathname.includes('history')) {
                    historyNavItem.classList.add('history-active');
                    historyDropdownMenu.classList.add('show');
                    historyDropdownToggle.classList.remove('collapsed');
                    historyDropdownToggle.setAttribute('aria-expanded', 'true');
                }
            }

            // --- Global keyboard handlers (Escape) ---
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' || e.key === 'Esc') {
                    if (sidebar && sidebar.classList.contains('show-sidebar')) closeSidebar();
                    if (userDropdown) userDropdown.classList.remove('show');
                    if (scheduleDropdownMenu && scheduleDropdownMenu.classList.contains('show')) {
                        scheduleDropdownMenu.classList.remove('show');
                        if (scheduleNavItem) {
                            scheduleNavItem.classList.remove('schedule-expanded');
                            // Restore schedule-active class if current page is schedule-related (exclude history)
                            if ((window.location.pathname.includes('mloc') || window.location.pathname.includes('vtrip')) && !window.location.pathname.includes('history')) {
                                scheduleNavItem.classList.add('schedule-active');
                            }
                        }
                        if (scheduleDropdownToggle) {
                            scheduleDropdownToggle.classList.add('collapsed');
                            scheduleDropdownToggle.setAttribute('aria-expanded', 'false');
                        }
                    }
                    if (historyDropdownMenu && historyDropdownMenu.classList.contains('show')) {
                        historyDropdownMenu.classList.remove('show');
                        if (historyNavItem) {
                            historyNavItem.classList.remove('history-expanded');
                            // Restore history-active class if current page is history-related
                            if (window.location.pathname.includes('history')) {
                                historyNavItem.classList.add('history-active');
                            }
                        }
                        if (historyDropdownToggle) {
                            historyDropdownToggle.classList.add('collapsed');
                            historyDropdownToggle.setAttribute('aria-expanded', 'false');
                        }
                    }
                }
            });
        });
    </script>
</body>
</html>
