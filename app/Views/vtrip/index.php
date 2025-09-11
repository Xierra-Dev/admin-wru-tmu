<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<style>
    /* ===========================
   CSS Kustom untuk Halaman V-Trip - New Design
   =========================== */

    /* Page Layout */
    .page-container {
        max-width: 100%;
        margin: 0;
        padding: 10px 15px;
        width: 100%;
        box-sizing: border-box;
    }

    /* Main search bar (always visible above title) */
    .main-search-container {
        position: relative;
        max-width: 600px;
        margin: 0 auto 30px auto;
        text-align: center;
        width: 100%;
    }

    .main-search-input {
        width: 100%;
        padding: 12px 50px 12px 20px;
        border: 1px solid #ddd;
        border-radius: 25px;
        outline: none;
        background: white;
        font-size: 14px;
        box-sizing: border-box;
        color: #333;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .main-search-input::placeholder {
        color: #999;
    }

    .main-search-icon {
        position: absolute;
        right: 20px;
        top: 50%;
        transform: translateY(-50%);
        color: #666;
        font-size: 16px;
    }

    /* Page title (centered above filter buttons) */
    .page-title {
        font-size: 2.5rem;
        font-weight: 600;
        color: #333;
        margin: 0 0 20px 0;
        text-align: center;
    }

    /* Filter buttons (positioned to the right) */
    .filter-buttons {
        display: flex;
        gap: 12px;
        justify-content: flex-end;
        margin-bottom: 30px;
        width: 100%;
        position: relative;
        z-index: 1000;
        /* Ensure filter buttons are above content */
    }

    .filter-buttons .dropdown {
        position: relative;
        z-index: 1001;
        /* Higher than filter-buttons */
    }

    .filter-btn {
        background: #FFA500;
        color: white;
        border: 2px solid transparent;
        border-radius: 20px;
        padding: 10px 20px;
        font-weight: 500;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 14px;
        min-width: 80px;
        justify-content: center;
        transition: all 0.3s ease;
        position: relative;
        z-index: 1002;
        /* Higher than dropdown container */
    }

    .filter-btn:hover {
        background: #FF8C00;
        color: white;
    }

    .filter-btn.active {
        border-color: #FF6600;
        box-shadow: 0 0 0 1px #FF6600;
    }

    /* Filter dropdown menus */
    .filter-buttons .dropdown-menu {
        position: absolute;
        top: 100%;
        right: 0;
        /* Align dropdown to the right edge of button */
        left: auto;
        /* Remove left alignment */
        z-index: 1050 !important;
        /* Very high z-index for dropdown menus */
        display: none;
        float: left;
        min-width: 10rem;
        padding: 0.5rem 0;
        margin: 0.125rem 0 0;
        font-size: 0.875rem;
        color: #212529;
        text-align: left;
        list-style: none;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid rgba(0, 0, 0, 0.15);
        border-radius: 8px;
        /* Match M-Loc design */
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        /* Match M-Loc design */
    }

    .filter-buttons .dropdown-menu.show {
        display: block;
    }

    .filter-buttons .dropdown-item {
        display: block;
        width: 100%;
        padding: 0.25rem 1rem;
        clear: both;
        font-weight: 400;
        color: #212529;
        text-align: inherit;
        text-decoration: none;
        white-space: nowrap;
        background-color: transparent;
        border: 0;
        cursor: pointer;
    }

    .filter-buttons .dropdown-item:hover,
    .filter-buttons .dropdown-item:focus {
        color: #1e2125;
        background-color: #e9ecef;
    }

    /* Override Bootstrap dropdown styles to ensure proper z-index */
    .dropdown-menu {
        z-index: 1050 !important;
        border-radius: 8px;
        /* Match M-Loc design */
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        /* Match M-Loc design */
    }

    .dropdown-toggle::after {
        margin-left: 0.5em;
    }

    /* Ensure dropdown positioning is correct */
    .filter-buttons .dropdown {
        position: relative;
    }

    .filter-buttons .dropdown-menu {
        position: absolute !important;
        will-change: transform;
        top: 100% !important;
        right: 0 !important;
        /* Align to right edge */
        left: auto !important;
        /* Remove left alignment */
        transform: translate3d(0px, 0px, 0px) !important;
    }

    /* White background container starting from V-Trip title */
    .content-wrapper {
        background: rgba(255, 255, 255, 0.7);
        border-radius: 15px;
        padding: 25px 40px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        backdrop-filter: blur(1px);
        width: 100%;
        margin: 0 auto;
        max-width: 100%;
    }

    /* Configuration Header (only visible in config mode) */
    .config-header {
        display: none;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0;
        padding: 25px 1px;
        position: sticky;
        top: 0;
        left: 0;
        right: 0;
        z-index: 10000;
        background: transparent;
        border-radius: 10px;
        width: 100%;
    }

    .config-header.visible {
        display: flex;
    }

    .btn-back {
        background: rgba(92, 92, 92, 1);
        color: white;
        border: none;
        border-radius: 8px 50px 50px 8px;
        padding: 8px 20px;
        text-decoration: none;
        font-weight: 500;
        display: flex;
        align-items: center;
    }

    .search-container {
        position: relative;
        flex: 1;
        max-width: 500px;
        margin: 0 15px;
    }

    .search-input {
        width: 100%;
        padding: 10px 40px 10px 15px;
        border: 1px solid #ddd;
        border-radius: 20px;
        outline: none;
        background: white;
    }

    .search-icon {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #999;
    }

    .btn-add {
        background: rgba(0, 157, 255, 1);
        color: white;
        border: none;
        border-radius: 50px 8px 8px 50px;
        padding: 8px 20px;
        text-decoration: none;
        font-weight: 500;
        display: flex;
        align-items: center;
    }

    /* Main Container */
    .vtrip-main-container {
        background: white;
        border-radius: 15px;
        padding: 0;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        width: 100%;
        max-width: none;
        border: 3px solid #007bff;
        /* Blue border around container */
    }

    .today-header {
        background: #007bff;
        color: white;
        padding: 15px 20px;
        font-size: 1.2rem;
        font-weight: 600;
        margin: 0;
        border-top-left-radius: 12px;
        /* Match the container border radius minus border width */
        border-top-right-radius: 12px;
    }

    .vtrip-content {
        padding: 20px;
        width: 100%;
        box-sizing: border-box;
        background: white;
        border-bottom-left-radius: 12px;
        /* Match the container border radius minus border width */
        border-bottom-right-radius: 12px;
    }

    /* Person Cards */
    .person-card {
        margin-bottom: 20px;
        border: 2px solid #FFA500;
        border-radius: 10px;
        overflow: hidden;
        width: 100%;
        box-sizing: border-box;
    }

    .person-header {
        background: #FFA500;
        color: white;
        padding: 12px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: relative;
    }

    .person-name {
        font-weight: 600;
        font-size: 1.1rem;
        color: #000;
        /* Black color for vehicle name visibility on orange background */
    }

    .header-right {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .schedule-count {
        font-size: 0.9rem;
        opacity: 0.9;
        color: #000;
    }

    .person-actions {
        display: flex;
        align-items: center;
    }

    .delete-person-btn {
        background: #dc3545;
        color: white;
        border: none;
        border-radius: 50%;
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .delete-person-btn:hover {
        background: #c82333;
        color: white;
    }

    /* Schedule Container */
    .schedules-container {
        padding: 15px;
        background: white;
        display: grid;
        grid-template-columns: 1fr 1fr;
        /* 2 columns layout */
        gap: 15px;
        width: 100%;
        box-sizing: border-box;
    }

    /* Schedule Card Wrapper (contains both card and buttons) */
    .schedule-card-wrapper {
        position: relative;
        display: flex;
        align-items: center;
        width: 100%;
    }

    /* Schedule Cards */
    .schedule-card {
        background: white;
        border: 1px solid #eee;
        border-radius: 8px;
        padding: 0;
        /* Remove padding to allow full-width sections */
        flex: 1;
        min-width: 280px;
        display: flex;
        align-items: stretch;
        /* Make sections same height */
        gap: 0;
        /* Remove gap between sections */
        position: relative;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        box-sizing: border-box;
        height: 80px;
        /* Fixed height for consistency */
        overflow: hidden;
        /* Ensure clean borders */
    }

    @media (max-width: 1200px) {
        .schedules-container {
            grid-template-columns: 1fr;
            /* Single column on smaller screens */
        }

        .schedule-card {
            min-width: 250px;
        }
    }

    @media (min-width: 769px) and (max-width: 1024px) {
        .schedules-container {
            grid-template-columns: 1fr 1fr;
            /* 2 columns on medium screens */
            gap: 12px;
        }
    }

    .schedule-number {
        background: #007bff;
        color: white;
        width: 5%;
        /* 5% left section */
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 1.2rem;
        flex-shrink: 0;
    }

    .schedule-content {
        width: 95%;
        /* Changed from 90% to 95% to fill the space */
        padding: 15px;
        display: flex;
        align-items: center;
        gap: 15px;
        background: white;
        flex: 1;
    }

    .schedule-info {
        flex: 1;
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: flex-start;
        gap: 8px;
    }

    .schedule-dates {
        text-align: right;
        font-size: 0.8rem;
        color: #000;
        /* Black text for better visibility */
        min-width: 120px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }



    .destination-name {
        font-weight: 600;
        color: #000;
        /* Black text for better visibility */
        margin-bottom: 0;
        font-size: 1rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .request-info {
        color: #000;
        /* Black text for better visibility */
        font-size: 0.85rem;
        font-weight: 500;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        position: relative;
    }

    .request-info::before {
        content: '|';
        color: #999;
        margin-right: 8px;
        font-weight: normal;
    }

    .schedule-dates-info {
        margin-top: 5px;
        color: #000;
        /* Black text for better visibility */
        font-size: 0.75rem;
    }

    .date-info {
        margin-bottom: 3px;
    }

    .date-info small {
        color: #000;
        /* Black text for better visibility */
    }

    /* Action Buttons */
    .schedule-actions {
        display: flex;
        flex-direction: column;
        gap: 12px;
        margin-left: 15px;
        z-index: 5;
    }

    .action-btn {
        background: white;
        border: 2px solid;
        border-radius: 6px;
        width: 26px;
        height: 26px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: 11px;
        margin-bottom: 8px;
    }

    .action-btn:last-child {
        margin-bottom: 0;
    }

    .edit-btn {
        background: #28a745;
        border-color: #28a745;
        color: white;
    }

    .edit-btn:hover {
        background: #218838;
        border-color: #1e7e34;
        color: white;
    }

    .delete-btn {
        background: #dc3545;
        border-color: #dc3545;
        color: white;
    }

    .delete-btn:hover {
        background: #c82333;
        border-color: #bd2130;
        color: white;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #666;
    }

    /* Empty Today State */
    .empty-today-state {
        border-bottom-left-radius: 12px;
        border-bottom-right-radius: 12px;
    }

    .empty-today-state h5 {
        color: #6c757d;
        font-weight: 500;
    }

    .empty-today-state p {
        color: #8d9498;
        font-size: 0.95rem;
        margin: 0;
    }

    .empty-today-state i {
        color: #adb5bd;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .page-container {
            padding: 10px;
        }

        .content-wrapper {
            padding: 20px;
            border-radius: 10px;
            margin: 0;
        }

        .main-search-container {
            margin-bottom: 20px;
        }

        .page-title {
            font-size: 2rem;
            margin-bottom: 15px;
        }

        .filter-buttons {
            justify-content: center;
            margin-bottom: 20px;
            flex-wrap: wrap;
            z-index: 1000 !important;
            /* Maintain high z-index on mobile */
        }

        .filter-btn {
            min-width: 70px;
            padding: 8px 16px;
            z-index: 1002 !important;
            /* Maintain high z-index on mobile */
        }

        /* Ensure dropdowns still work properly on mobile */
        .filter-buttons .dropdown-menu {
            z-index: 1050 !important;
            position: absolute !important;
        }

        .schedules-container {
            grid-template-columns: 1fr;
            /* Single column on mobile */
        }

        .schedule-card {
            min-width: 250px;
            height: 90px;
            /* Slightly taller on mobile */
        }

        .schedule-content {
            flex-direction: column;
            align-items: stretch;
            gap: 8px;
            padding: 10px;
        }

        .schedule-dates {
            text-align: center;
            min-width: auto;
            font-size: 0.7rem;
        }

        .schedule-number {
            font-size: 1rem;
            /* Smaller font on mobile */
        }



        /* Mobile: Stack person name and destination vertically if needed */
        .schedule-info {
            flex-direction: column;
            align-items: flex-start;
            gap: 3px;
        }

        .destination-name,
        .request-info {
            white-space: normal;
            font-size: 0.8rem;
        }

        .request-info::before {
            display: none;
            /* Hide separator on mobile */
        }

        .schedule-card-wrapper {
            flex-direction: column;
            align-items: stretch;
        }

        .schedule-actions {
            margin-left: 0;
            margin-top: 10px;
            flex-direction: row;
            justify-content: center;
            align-self: center;
            gap: 12px;
        }

        .action-btn {
            margin-bottom: 0;
        }

        .config-header {
            flex-direction: column;
            gap: 15px;
            position: relative;
            top: auto;
            left: auto;
            right: auto;
            padding: 15px;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 10px;
            margin-bottom: 20px;
            width: 100%;
        }

        .search-container {
            margin: 0;
            max-width: 100%;
        }

        /* Mobile modal adjustments */
        .modal.show {
            padding-top: calc(var(--global-navbar-height) - 10px) !important;
            /* Reduced padding for mobile */
        }

        .modal-dialog {
            margin: 1rem;
            /* Smaller margin on mobile */
        }
    }

    @media (min-width: 769px) {
        .page-container {
            padding: 10px 20px;
        }

        .content-wrapper {
            margin: 0;
            width: 100%;
        }

        /* Ensure horizontal layout on larger screens */
        .schedule-info {
            flex-direction: row;
            gap: 8px;
        }

        .destination-name,
        .request-info {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .request-info::before {
            display: inline;
        }
    }

    /* Configuration mode adjustments */
    .page-container.config-mode {
        padding-top: 20px;
    }

    .page-container.config-mode .main-search-container {
        display: none;
    }

    @media (max-width: 768px) {
        .page-container.config-mode {
            padding-top: 20px;
        }

        .config-header {
            padding: 20px;
        }
    }

    /* ===========================
   PERBAIKAN Z-INDEX (Modal di atas elemen lainnya)
   =========================== */
    /* Pastikan backdrop dan modal lebih tinggi dari alert / fab / dropdown */
    .modal-backdrop {
        z-index: 99998 !important;
    }

    .modal,
    .modal.show {
        z-index: 99999 !important;
        position: fixed !important;
        pointer-events: auto !important;
    }

    .modal-dialog {
        z-index: 99999 !important;
        position: relative;
        pointer-events: auto !important;
    }

    .modal-content {
        z-index: 100000 !important;
        position: relative;
        pointer-events: auto !important;
        background: white !important;
    }

    /* CRITICAL: Force semua elemen di dalam modal bisa diinteraksi */
    .modal *,
    .modal input,
    .modal button,
    .modal select,
    .modal textarea,
    .modal .form-control,
    .modal .btn,
    .modal .search-input-dropdown {
        pointer-events: auto !important;
        z-index: inherit !important;
    }

    /* Override z-index inheritance for dropdown components */
    .modal .searchable-dropdown {
        z-index: 2147483640 !important;
        position: relative;
    }

    .modal .searchable-dropdown-menu {
        z-index: 2147483647 !important;
        pointer-events: auto !important;
        position: absolute !important;
        top: 100% !important;
        left: 0 !important;
        right: 0 !important;
    }

    .modal .searchable-dropdown-input,
    .modal .searchable-dropdown-display-input,
    .modal .searchable-dropdown-search-input {
        z-index: 2147483641 !important;
        position: relative;
    }

    .modal .searchable-dropdown-arrow {
        z-index: 2147483642 !important;
        position: absolute;
    }

    /* Ensure dropdown menus attached to body are always on top */
    body>.searchable-dropdown-menu {
        z-index: 2147483647 !important;
        position: fixed !important;
        pointer-events: auto !important;
        background: white !important;
        border: 1px solid #ced4da !important;
        border-radius: 0.375rem !important;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.25) !important;
        max-height: 250px !important;
        overflow-y: auto !important;
        min-width: 200px !important;
    }

    body>.searchable-dropdown-menu .searchable-dropdown-item {
        padding: 0.5rem 0.75rem !important;
        cursor: pointer !important;
        border-bottom: 1px solid #f8f9fa !important;
        font-size: 0.95rem !important;
        color: #212529 !important;
        background-color: transparent !important;
        transition: background-color 0.15s ease-in-out !important;
        pointer-events: auto !important;
    }

    body>.searchable-dropdown-menu .searchable-dropdown-item:hover {
        background-color: #e9ecef !important;
    }

    body>.searchable-dropdown-menu .searchable-dropdown-item:last-child {
        border-bottom: none !important;
    }

    body>.searchable-dropdown-menu .searchable-dropdown-item.selected {
        background-color: #0d6efd !important;
        color: white !important;
    }

    body>.searchable-dropdown-menu .searchable-dropdown-item.add-new-item {
        background-color: #f8f9fa !important;
        border-top: 1px solid #dee2e6 !important;
        color: #007bff !important;
        font-weight: 500 !important;
    }

    body>.searchable-dropdown-menu .searchable-dropdown-item.add-new-item:hover {
        background-color: #e9ecef !important;
        color: #0056b3 !important;
    }

    /* Specific override for search input in dropdowns */
    .modal .search-input-dropdown {
        pointer-events: auto !important;
        user-select: text !important;
        -webkit-user-select: text !important;
        -moz-user-select: text !important;
        -ms-user-select: text !important;
        cursor: text !important;
        background: white !important;
        color: #495057 !important;
    }

    /* Additional override to ensure input field is always editable */
    input.search-input-dropdown {
        pointer-events: auto !important;
        user-select: text !important;
        -webkit-user-select: text !important;
        cursor: text !important;
        background: white !important;
        color: #495057 !important;
        border: 1px solid #ced4da !important;
        padding: 8px 35px 8px 12px !important;
        font-size: 0.9rem !important;
        width: 100% !important;
    }

    /* Override any conflicting styles */
    .search-input-dropdown:focus {
        border-color: #007bff !important;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25) !important;
        background: white !important;
        color: #495057 !important;
        outline: none !important;
    }

    .search-input-dropdown:hover {
        border-color: #86b7fe !important;
        background: white !important;
        color: #495057 !important;
    }

    /* Turunkan notifikasi / elemen lain agar tidak menutupi modal */
    .alert-notification {
        position: fixed;
        top: calc(70px + 20px);
        /* Navbar height + 20px margin */
        left: 50%;
        transform: translateX(-50%);
        z-index: 1800;
        /* < modal z-index */
        min-width: 300px;
        border-radius: 10px;
    }

    /* Search suggestions dan FAB agar tetap di bawah modal */
    .search-suggestions {
        z-index: 1700;
        /* < modal z-index */
    }

    .fab {
        z-index: 1600;
        /* < modal z-index */
    }

    /* Jika elemen vtrip-card tidak perlu berada di atas, beri z-index rendah */
    .vtrip-card {
        z-index: 1;
        position: relative;
        /* tetap relative untuk layout, tapi z-index kecil */
    }

    /* ===========================
   Modal Styles
   =========================== */
    /* Custom modal overlay that doesn't block interactions */
    .modal.show {
        background: rgba(0, 0, 0, 0.4) !important;
        padding-top: calc(var(--global-navbar-height) + 10px) !important;
        /* Add top padding to avoid navbar overlap */
    }

    .modal-dialog {
        margin-top: 2rem;
        /* Additional margin to ensure clearance from navbar */
    }

    .modal-header {
        background: #007bff;
        color: white;
        border-bottom: none;
    }

    .modal-header .btn-close {
        filter: invert(1);
    }

    .modal-content {
        border-radius: 8px;
        overflow: hidden;
        position: relative;
        z-index: 100000 !important;
    }



    .modal-form-row {
        display: flex;
        gap: 15px;
        margin-bottom: 1rem;
    }

    /* 3 columns layout for top row */
    .modal-form-row-3-cols {
        display: flex;
        gap: 15px;
        margin-bottom: 1.5rem;
    }

    .modal-form-col-3 {
        flex: 1;
        min-width: 0;
        /* Allow columns to shrink */
    }

    /* 2 columns layout for bottom row */
    .modal-form-row-2-cols {
        display: flex;
        gap: 20px;
        margin-bottom: 1rem;
    }

    .modal-form-col-2 {
        flex: 1;
        min-width: 0;
        border: 2px solid #e9ecef;
        border-radius: 15px;
        padding: 20px;
        background-color: #f8f9fa;
    }

    /* Section titles for From and Until */
    .form-section-title {
        color: #007bff;
        font-weight: 600;
        margin-bottom: 15px;
        text-align: center;
        font-size: 1rem;
        padding-bottom: 8px;
        border-bottom: 2px solid #007bff;
    }

    /* Inline form groups for date and time */
    .form-group-inline {
        display: flex;
        gap: 10px;
        align-items: stretch;
    }

    .form-group-inline .form-field-group {
        flex: 1;
    }

    /* Form labels styling */
    .form-label {
        font-weight: 600;
        color: #333;
        margin-bottom: 8px;
        display: block;
        font-size: 0.9rem;
    }

    /* Form field group styling */
    .form-field-group {
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    /* Form controls spacing */
    .form-control,
    .form-select {
        margin-bottom: 0;
    }

    /* Section specific styling */
    .modal-form-col-3 .form-label {
        color: #007bff;
        font-weight: 600;
    }

    .modal-form-col-2 .form-label {
        color: #495057;
        font-size: 0.85rem;
    }

    /* ===========================
   Searchable Dropdown Styles (from M-Loc)
   =========================== */

    /* Searchable dropdown styles */
    .searchable-dropdown {
        position: relative;
        width: 100%;
        z-index: 2147483640;
        /* Very high z-index */
    }

    .searchable-dropdown-input {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #ced4da;
        border-radius: 0.375rem;
        font-size: 1rem;
        line-height: 1.5;
        color: #212529;
        background-color: #fff;
        background-clip: padding-box;
        cursor: pointer;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        position: relative;
        z-index: 2147483641 !important;
        /* Override inherit */
    }

    .searchable-dropdown-input:focus {
        color: #212529;
        background-color: #fff;
        border-color: #86b7fe;
        outline: 0;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }

    .searchable-dropdown-input::placeholder {
        color: #6c757d;
        opacity: 1;
    }

    .searchable-dropdown-menu {
        position: absolute;
        background: white;
        border: 1px solid #ced4da;
        border-radius: 0.375rem;
        max-height: 250px;
        overflow-y: auto;
        z-index: 2147483647 !important;
        /* Maximum z-index - appears in front of everything */
        display: none;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.25);
        pointer-events: auto !important;
        min-width: 200px;
        width: 100%;
    }

    .searchable-dropdown-menu.show {
        display: block;
        visibility: visible;
        opacity: 1;
    }

    .searchable-dropdown-item {
        padding: 0.5rem 0.75rem;
        cursor: pointer;
        border-bottom: 1px solid #f8f9fa;
        font-size: 0.95rem;
        color: #212529;
        background-color: transparent;
        transition: background-color 0.15s ease-in-out;
    }

    .searchable-dropdown-item:hover {
        background-color: #e9ecef;
    }

    .searchable-dropdown-item:last-child {
        border-bottom: none;
    }

    .searchable-dropdown-item.selected {
        background-color: #0d6efd;
        color: white;
    }

    .searchable-dropdown-item.no-results {
        padding: 1rem 0.75rem;
        color: #6c757d;
        font-style: italic;
        text-align: center;
        cursor: default;
    }

    .searchable-dropdown-item.no-results:hover {
        background-color: transparent;
    }

    .searchable-dropdown-arrow {
        position: absolute;
        right: 0.75rem;
        top: 50%;
        transform: translateY(-50%);
        pointer-events: none;
        color: #6c757d;
        transition: transform 0.15s ease-in-out;
        z-index: 2147483642 !important;
        /* Override inherit */
    }

    .searchable-dropdown.open .searchable-dropdown-arrow {
        transform: translateY(-50%) rotate(180deg);
    }

    /* New styles for separated display and search fields */
    .searchable-dropdown-display {
        position: relative;
        width: 100%;
        cursor: pointer;
    }

    .searchable-dropdown-display-input {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #ced4da;
        border-radius: 0.375rem;
        font-size: 1rem;
        line-height: 1.5;
        color: #212529;
        background-color: #fff;
        cursor: pointer;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        z-index: 2147483643 !important;
        /* Override inherit */
        position: relative;
    }

    .searchable-dropdown-display-input:focus {
        border-color: #86b7fe;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }

    .searchable-dropdown-search-container {
        width: 100%;
        margin-top: 5px;
    }

    .searchable-dropdown-search-input {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #ced4da;
        border-radius: 0.375rem;
        font-size: 1rem;
        line-height: 1.5;
        color: #212529;
        background-color: #fff;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        z-index: 2147483644 !important;
        /* Override inherit */
        position: relative;
    }

    .searchable-dropdown-search-input:focus {
        border-color: #86b7fe;
        outline: 0;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .modal-form-row-3-cols {
            flex-direction: column;
            gap: 10px;
        }

        .modal-form-row-2-cols {
            flex-direction: column;
            gap: 15px;
        }

        .form-group-inline {
            flex-direction: column;
            gap: 10px;
        }

        .form-field-group {
            margin-bottom: 15px;
        }

        .form-section-title {
            font-size: 0.9rem;
            margin-bottom: 10px;
        }
    }

    .modal-form-col {
        flex: 1;
    }

    /* Buttons */
    .btn-primary-custom {
        background: #007bff;
        border: #007bff;
        border-radius: 25px;
        padding: 10px 30px;
        min-width: 0;
        flex: 1;
    }

    .btn-warning-custom {
        background: #ffc107;
        border: #ffc107;
        color: #000;
        border-radius: 25px;
        padding: 10px 30px;
        min-width: 0;
        flex: 1;
    }

    /* Ensure equal width for single mode buttons */
    #singleModeButtons {
        display: flex;
        gap: 15px;
    }

    #singleModeButtons .btn {
        flex: 1;
        min-width: 0;
        width: 50%;
    }

    /* Multiple data mode buttons */
    .btn-add-multiple {
        background: #20B2AA;
        /* Dark Turquoise/Tosca */
        border: 2px solid #20B2AA;
        color: white;
        border-radius: 25px;
        padding: 12px 40px;
        font-weight: 500;
        transition: all 0.3s ease;
        width: 100%;
        /* Full width */
    }

    .btn-add-multiple:hover {
        background: #1a9b96;
        border-color: #1a9b96;
        color: white;
        transform: translateY(-1px);
    }

    .save-all-container {
        position: absolute;
        bottom: 20px;
        right: 20px;
        z-index: 100001;
    }

    /* Target the modal specifically */
    #addVtripModal .save-all-container {
        position: absolute;
        bottom: 20px;
        right: 20px;
        z-index: 100001;
    }

    /* Ensure positioning context */
    #addVtripModal .modal-dialog {
        position: relative;
    }

    #addVtripModal .modal-content {
        position: relative;
    }

    .btn-save-all {
        background: #28a745;
        border: 2px solid #28a745;
        color: white;
        border-radius: 50%;
        /* Circular button */
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 8px rgba(40, 167, 69, 0.3);
        transition: all 0.3s ease;
        font-size: 18px;
        position: relative;
    }

    .btn-save-all:hover {
        background: #218838;
        border-color: #218838;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 6px 12px rgba(40, 167, 69, 0.4);
    }

    .multiple-mode-buttons {
        position: static;
        min-height: 80px;
        width: 100%;
    }

    /* Ensure the modal body has relative positioning for absolute positioning context */
    .modal-body {
        position: relative;
        padding-bottom: 80px;
        /* Add padding to prevent overlap with save button */
    }

    .modal-content {
        position: relative;
    }

    .modal-dialog {
        position: relative;
    }

    /* Force button visibility control */
    .single-mode-hidden {
        display: none !important;
        visibility: hidden !important;
        opacity: 0 !important;
    }

    .multiple-mode-visible {
        display: block !important;
        visibility: visible !important;
        opacity: 1 !important;
    }

    /* Responsive design for modal buttons */
    @media (max-width: 768px) {
        .save-all-container {
            position: absolute;
            bottom: 15px;
            right: 15px;
            z-index: 100001;
        }

        #addVtripModal .save-all-container {
            position: absolute;
            bottom: 15px;
            right: 15px;
            z-index: 100001;
        }

        .btn-add-multiple {
            padding: 10px 30px;
            font-size: 14px;
            width: 100%;
            /* Maintain full width on mobile */
        }

        .btn-save-all {
            width: 45px;
            height: 45px;
            font-size: 16px;
        }

        .multiple-mode-buttons {
            min-height: 80px;
            position: relative;
        }

        .modal-body {
            position: relative;
            padding-bottom: 70px;
            /* Add padding to prevent overlap with save button */
        }
    }

    /* Warning Modal Styles */
    .warning-modal .modal-content {
        text-align: center;
        padding: 20px;
    }

    .warning-icon {
        font-size: 4rem;
        color: #ffc107;
        margin-bottom: 20px;
    }

    .delete-icon {
        font-size: 4rem;
        color: #dc3545;
        margin-bottom: 20px;
    }

    .warning-text {
        font-size: 1.1rem;
        margin-bottom: 20px;
        color: #333;
    }

    .warning-subtext {
        color: #666;
        margin-bottom: 30px;
    }

    .btn-secondary-custom {
        background: #6c757d;
        border: #6c757d;
        border-radius: 25px;
        padding: 10px 30px;
    }

    .btn-danger-custom {
        background: #dc3545;
        border: #dc3545;
        border-radius: 25px;
        padding: 10px 30px;
    }

    /* V-Trip Card / Items */
    .vtrip-card {
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
        padding: 20px;
        /* z-index: 1; defined earlier in "PERBAIKAN" */
    }

    /* Kelas untuk menyembunyikan elemen */
    .hidden {
        display: none !important;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.3s ease;
    }

    /* Kelas untuk menyembunyikan trigger button */
    .floating-trigger-container.hidden {
        display: none !important;
    }

    /* Kelas untuk menampilkan elemen dengan animasi */
    .visible {
        display: flex !important;
        opacity: 1;
        pointer-events: auto;
    }

    .btn.visible {
        display: inline-block !important;
    }

    .schedule-actions.visible {
        display: block !important;
    }

    .person-actions.visible {
        display: block !important;
    }

    .btn.visible {
        display: inline-block !important;
    }

    .vtrip-actions.visible {
        display: block !important;
    }

    /* Data Preview Table */
    .data-preview-table {
        max-height: 400px;
        overflow-y: auto;
        margin-top: 20px;
    }

    .data-preview-table table {
        font-size: 0.85rem;
        width: 100%;
    }

    .data-preview-table .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
    }

    /* Center align all table content */
    .data-preview-table table th,
    .data-preview-table table td {
        text-align: center !important;
        vertical-align: middle !important;
        white-space: nowrap;
    }

    .data-preview-table tbody tr {
        text-align: center !important;
        vertical-align: middle !important;
    }

    /* Adjust column widths for better space utilization */
    .data-preview-table table th:nth-child(1),
    .data-preview-table table td:nth-child(1) {
        width: 25%;
        /* Vehicle column - wider for number_plate */
    }

    .data-preview-table table th:nth-child(2),
    .data-preview-table table td:nth-child(2) {
        width: 15%;
        /* Personil column */
    }

    .data-preview-table table th:nth-child(3),
    .data-preview-table table td:nth-child(3) {
        width: 20%;
        /* Destination column */
    }

    .data-preview-table table th:nth-child(4),
    .data-preview-table table td:nth-child(4) {
        width: 15%;
        /* From column */
    }

    .data-preview-table table th:nth-child(5),
    .data-preview-table table td:nth-child(5) {
        width: 15%;
        /* Until column */
    }

    .data-preview-table table th:nth-child(6),
    .data-preview-table table td:nth-child(6) {
        width: 10%;
        /* Action column */
    }

    /* Force all other elements to have lower z-index */
    .page-container {
        z-index: 1 !important;
        position: relative;
    }

    .content-wrapper {
        z-index: 2 !important;
        position: relative;
    }

    .config-header {
        z-index: 3 !important;
        position: relative;
    }

    .main-search-container {
        z-index: 4 !important;
        position: relative;
    }

    .vtrip-main-container {
        z-index: 10 !important;
        /* Lower than filter buttons */
        position: relative;
    }

    .person-card {
        z-index: 11 !important;
        position: relative;
    }

    .schedule-card {
        z-index: 12 !important;
        position: relative;
    }

    /* Bootstrap dropdown overrides */
    .dropdown-menu {
        z-index: 1000 !important;
    }

    .dropdown {
        z-index: 999 !important;
        position: relative;
    }

    /* Navigation and header elements */
    nav {
        z-index: 100 !important;
    }

    header {
        z-index: 100 !important;
    }

    /* Any other potential interfering elements */
    .btn {
        z-index: 200 !important;
        position: relative;
    }

    .card {
        z-index: 50 !important;
        position: relative;
    }

    .container,
    .container-fluid {
        z-index: 10 !important;
        position: relative;
    }

    /* Override any Bootstrap or other framework z-indexes */
    .navbar {
        z-index: 100 !important;
    }

    .tooltip {
        z-index: 1500 !important;
    }

    .popover {
        z-index: 1500 !important;
    }

    .modal {
        z-index: 1050 !important;
    }

    .modal-backdrop {
        z-index: 1049 !important;
    }

    .modal-content {
        position: relative;
        z-index: 1051 !important;
        overflow: visible !important;
        /* Allow dropdowns to overflow */
    }

    .modal-body {
        position: relative;
        z-index: 1052 !important;
        overflow: visible !important;
        /* Allow dropdowns to overflow */
    }

    .modal-header {
        z-index: 1052 !important;
    }

    .modal-footer {
        z-index: 1052 !important;
    }

    /* Ensure modal form elements have lower z-index than dropdowns */
    .modal-form-row {
        position: relative;
        z-index: 1053 !important;
    }

    .modal-form-col {
        position: relative;
        z-index: 1053 !important;
    }

    .form-control {
        position: relative;
        z-index: 1053 !important;
    }

    .form-check {
        position: relative;
        z-index: 1053 !important;
    }

    /* Button containers should have lower z-index than dropdowns */
    .modal-buttons-container {
        z-index: 1054 !important;
        position: relative;
    }

    .modal-buttons-container .btn {
        z-index: 1054 !important;
        position: relative;
    }

    .btn-add-multiple {
        z-index: 1054 !important;
        position: relative;
    }

    .btn-save-all {
        z-index: 1054 !important;
        position: relative;
    }

    /* Data preview table should be below dropdowns */
    .data-preview-table {
        z-index: 1055 !important;
        position: relative;
    }

    /* Multiple mode buttons */
    .multiple-mode-buttons {
        pointer-events: none;
        z-index: 1054 !important;
    }

    .multiple-mode-buttons .btn {
        pointer-events: auto;
        z-index: 1054 !important;
    }

    .save-all-container {
        z-index: 1054 !important;
        position: absolute;
    }

    .save-all-container .btn {
        pointer-events: auto;
        z-index: 1054 !important;
    }

    /* Search with autocomplete */
    .search-dropdown {
        position: relative;
    }

    .search-suggestions {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: white;
        border: 1px solid #ddd;
        border-radius: 0 0 8px 8px;
        max-height: 200px;
        overflow-y: auto;
        /* z-index adjusted earlier */
        display: none;
    }

    .search-suggestion-item {
        padding: 10px 15px;
        cursor: pointer;
        border-bottom: 1px solid #eee;
    }

    .search-suggestion-item:hover {
        background-color: #f8f9fa;
    }

    .search-suggestion-item:last-child {
        border-bottom: none;
    }

    .btn-back:hover {
        background: #5a6268;
        color: white;
        text-decoration: none;
        transform: translateX(-2px);
    }

    .btn-back.hidden {
        display: none;
    }

    .btn-back.visible {
        display: flex;
    }

    .search-container {
        flex: 1;
        max-width: 500px;
        margin: 0 15px;
        position: relative;
    }

    .search-input {
        width: 100%;
        padding: 10px 40px 10px 15px;
        border: 1px solid #ddd;
        border-radius: 25px;
        font-size: 1rem;
        outline: none;
        background: white;
        color: #333;
    }

    .search-input:focus {
        background: white;
        border-color: #007bff;
        box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.25);
    }

    .search-icon {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #666;
        font-size: 1.2rem;
    }

    .btn-add {
        color: white;
        text-decoration: none;
        display: flex;
        align-items: center;
        font-weight: 500;
        padding: 8px 16px;
        transition: all 0.3s ease;
        border: none;
        background: rgba(0, 157, 255, 1);
        /* Blue color */
        border-radius: 50px 8px 8px 50px;
        /* Right rounded, left straight */
    }

    .btn-add:hover {
        background: #0056b3;
        color: white;
        text-decoration: none;
        transform: translateY(-1px);
    }

    .btn-add.hidden {
        display: none;
    }

    .btn-add.visible {
        display: flex;
    }

    /* Search suggestions for config header */
    .search-suggestions {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: white;
        border: 1px solid #ddd;
        border-radius: 0 0 15px 15px;
        max-height: 200px;
        overflow-y: auto;
        z-index: 10001;
        display: none;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .search-suggestion-item {
        padding: 10px 15px;
        cursor: pointer;
        border-bottom: 1px solid #eee;
        color: #333;
    }

    .search-suggestion-item:hover {
        background-color: #f8f9fa;
    }

    .search-suggestion-item:last-child {
        border-bottom: none;
    }

    /* Page container configuration mode styles */
    .page-container.config-mode {
        padding-top: 0;
    }

    .page-container.config-mode .main-search-container {
        display: none;
    }

    /* Floating Action Button */
    .fab {
        position: fixed;
        bottom: 30px;
        right: 30px;
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: #007bff;
        color: white;
        border: none;
        box-shadow: 0 4px 12px rgba(0, 123, 255, 0.3);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        transition: all 0.3s ease;
        z-index: 10000;
    }

    .fab:hover {
        transform: scale(1.1);
        box-shadow: 0 6px 16px rgba(0, 123, 255, 0.4);
    }

    /* Floating Trigger Container */
    .floating-trigger-container {
        position: fixed;
        bottom: 2rem;
        right: 2rem;
        z-index: 10001 !important;
        transition: all 0.3s ease;
        width: 60px;
        height: 60px;
        border-radius: 50%;
        border: none;
        background-color: #007bff;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 12px rgba(0, 123, 255, 0.3);
        cursor: pointer;
        pointer-events: auto !important;
    }

    .floating-trigger-container:hover {
        transform: scale(1.1);
        box-shadow: 0 6px 16px rgba(0, 123, 255, 0.4);
        background-color: #0056b3;
    }

    .floating-trigger-container.hidden {
        display: none;
    }

    .floating-trigger-icon {
        width: 30px;
        height: auto;
        cursor: pointer;
        transition: transform 0.2s ease;
        margin-left: 4px;
        pointer-events: none;
    }
</style>

<!-- Alert Notifications -->
<div id="alertContainer"></div>

<div class="page-container">
    <!-- Configuration Mode Header -->
    <div class="config-header" id="config-header">
        <a href="#" class="btn-back hidden" id="back-button">
            <i class="bi bi-chevron-left me-2"></i>Kembali
        </a>
        <div class="search-container">
            <input type="text" class="search-input" id="searchInput" placeholder="Search..." autocomplete="off">
            <i class="bi bi-search search-icon"></i>
            <div class="search-suggestions" id="searchSuggestions"></div>
        </div>
        <a href="#" class="btn-add hidden" id="add-vtrip-btn" data-bs-toggle="modal" data-bs-target="#addVtripModal">
            <i class="bi bi-plus me-2"></i>Tambah
        </a>
    </div>

    <!-- Main search bar (always visible) -->
    <div class="main-search-container">
        <input type="text" class="main-search-input" id="mainSearchInput" placeholder="Search..." autocomplete="off">
        <i class="bi bi-search main-search-icon"></i>
    </div>

    <!-- Content wrapper with white background -->
    <div class="content-wrapper">
        <!-- Page title (centered) -->
        <h1 class="page-title" id="page-title">V-Trip</h1>

        <!-- Filter buttons (positioned to the right) -->
        <div class="filter-buttons">
            <div class="dropdown">
                <button class="filter-btn" type="button" id="sortDropdown" data-bs-toggle="dropdown">
                    A - Z <i class="bi bi-chevron-down"></i>
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#" data-sort="asc">A - Z</a></li>
                    <li><a class="dropdown-item" href="#" data-sort="desc">Z - A</a></li>
                </ul>
            </div>
            <div class="dropdown">
                <button class="filter-btn" type="button" id="filterDropdown" data-bs-toggle="dropdown">
                    All <i class="bi bi-chevron-down"></i>
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#" data-filter="today">Today</a></li>
                    <li><a class="dropdown-item" href="#" data-filter="week">1 week</a></li>
                    <li><a class="dropdown-item" href="#" data-filter="month">1 month</a></li>
                    <li><a class="dropdown-item" href="#" data-filter="3month">3 month</a></li>
                    <li><a class="dropdown-item" href="#" data-filter="all">All</a></li>
                </ul>
            </div>
        </div>

        <?php if (empty($groupedVtrips)): ?>
            <div class="empty-state">
                <i class="bi bi-calendar-x text-muted" style="font-size: 3rem;"></i>
                <h5 class="text-muted mt-3">Belum ada data V-Trip</h5>
                <p class="text-muted">Klik tombol "Tambah" untuk menambahkan data baru.</p>
            </div>
        <?php else: ?>
            <?php
            // Group data by leaving date
            $dateGroups = [];
            $today = date('Y-m-d');

            foreach ($groupedVtrips as $vehicleKey => $vtrips) {
                foreach ($vtrips as $vtrip) {
                    $leaveDate = date('Y-m-d', strtotime($vtrip['leave_date']));
                    $dateKey = ($leaveDate === $today) ? 'today' : $leaveDate;

                    if (!isset($dateGroups[$dateKey])) {
                        $dateGroups[$dateKey] = [];
                    }
                    if (!isset($dateGroups[$dateKey][$vehicleKey])) {
                        $dateGroups[$dateKey][$vehicleKey] = [];
                    }
                    $dateGroups[$dateKey][$vehicleKey][] = $vtrip;
                }
            }

            // Sort date groups: today first, then by date
            uksort($dateGroups, function ($a, $b) {
                if ($a === 'today') return -1;
                if ($b === 'today') return 1;
                return strcmp($a, $b);
            });

            // Remove any duplicate today entries (e.g., if today's date appears as both 'today' and actual date)
            $todayDateKey = $today;
            if (isset($dateGroups['today']) && isset($dateGroups[$todayDateKey])) {
                // Merge today's date entries into the 'today' section
                foreach ($dateGroups[$todayDateKey] as $vehicleKey => $vtrips) {
                    if (!isset($dateGroups['today'][$vehicleKey])) {
                        $dateGroups['today'][$vehicleKey] = [];
                    }
                    $dateGroups['today'][$vehicleKey] = array_merge($dateGroups['today'][$vehicleKey], $vtrips);
                }
                // Remove the duplicate date section
                unset($dateGroups[$todayDateKey]);
            }

            // Ensure "today" section always exists, but only if it's not empty or if there are no other sections
            if (!isset($dateGroups['today']) && (empty($dateGroups) || count($dateGroups) === 0)) {
                $dateGroups = ['today' => []] + $dateGroups;
            }
            ?>

            <?php foreach ($dateGroups as $dateKey => $dateGroupData): ?>
                <div class="vtrip-main-container" style="margin-bottom: 20px;">
                    <div class="today-header">
                        <?php if ($dateKey === 'today'): ?>
                            Today
                        <?php else: ?>
                            <?= date('d M Y', strtotime($dateKey)) ?>
                        <?php endif; ?>
                    </div>
                    <div class="vtrip-content" id="vtripContainer">
                        <?php if ($dateKey === 'today' && empty($dateGroupData)): ?>
                            <!-- Empty state for Today -->
                            <div class="empty-today-state" style="padding: 40px 20px; text-align: center; background: white;">
                                <i class="bi bi-calendar-check text-muted" style="font-size: 3rem;"></i>
                                <h5 class="text-muted mt-3">No trips for today</h5>
                                <p class="text-muted">There are no V-Trip trips planned for today.</p>
                            </div>
                        <?php else: ?>
                            <?php foreach ($dateGroupData as $vehicleKey => $vtrips): ?>
                                <div class="person-card" data-vehicle="<?= esc($vehicleKey) ?>">
                                    <div class="person-header">
                                        <span class="person-name"><?= esc($vehicleKey) ?></span>
                                        <div class="header-right">
                                            <span class="schedule-count">(<?= count($vtrips) ?> Schedule)s</span>
                                            <div class="person-actions hidden">
                                                <a href="#" class="delete-person-btn" title="Delete All Trips">
                                                    <i class="bi bi-trash-fill"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="schedules-container">
                                        <?php foreach ($vtrips as $idx => $vtrip): ?>
                                            <div class="schedule-card-wrapper">
                                                <div class="schedule-card" data-id="<?= isset($vtrip['original_id']) ? $vtrip['original_id'] : $vtrip['id'] ?>" data-date="<?= $vtrip['leave_date'] ?>">
                                                    <div class="schedule-number"><?= $idx + 1 ?></div>
                                                    <div class="schedule-content">
                                                        <div class="schedule-info">
                                                            <div class="destination-name"><?= esc($vtrip['people_name']) ?></div>
                                                            <div class="request-info"><?= esc($vtrip['destination_name']) ?></div>
                                                        </div>
                                                        <div class="schedule-dates">
                                                            <small>From<br><?= date('d-M-Y H:i', strtotime($vtrip['leave_date'])) ?></small>
                                                            <small class="d-block mt-2">Until<br><?= date('d-M-Y H:i', strtotime($vtrip['return_date'])) ?></small>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="schedule-actions hidden">
                                                    <a href="#" class="action-btn edit-btn" data-bs-toggle="modal" data-bs-target="#editVtripModal"
                                                        data-id="<?= isset($vtrip['original_id']) ? $vtrip['original_id'] : $vtrip['id'] ?>"
                                                        data-person="<?= esc($vtrip['people_name']) ?>"
                                                        data-person-id="<?= esc($vtrip['people_id']) ?>"
                                                        data-vehicle="<?= esc($vtrip['vehicle_name']) ?>"
                                                        data-vehicle-id="<?= esc($vtrip['vehicle_id']) ?>"
                                                        data-destination="<?= esc($vtrip['destination_name']) ?>"
                                                        data-destination-id="<?= esc($vtrip['destination_id']) ?>"
                                                        data-leave="<?= $vtrip['leave_date'] ?>"
                                                        data-return="<?= $vtrip['return_date'] ?>">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    <a href="#" class="action-btn delete-btn" data-bs-toggle="modal" data-bs-target="#deleteVtripModal"
                                                        data-id="<?= isset($vtrip['original_id']) ? $vtrip['original_id'] : $vtrip['id'] ?>"
                                                        data-person="<?= esc($vtrip['people_name']) ?>"
                                                        data-vehicle="<?= esc($vtrip['vehicle_name']) ?>"
                                                        data-destination="<?= esc($vtrip['destination_name']) ?>">
                                                        <i class="bi bi-trash"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<!-- Floating Action Button for Configuration -->
<div class="floating-trigger-container">
    <img src="<?= base_url('img/Group.png') ?>" alt="Configuration Trigger" class="floating-trigger-icon" id="actionTrigger">
</div>

<!-- Add V-TRIP Modal -->
<div class="modal fade" id="addVtripModal" tabindex="-1" aria-labelledby="addVtripModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title w-100 text-center" id="addVtripModalLabel">Add V-TRIP</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addVtripForm" action="<?= base_url('vtrip/storeWithFlash') ?>" method="post">
                    <?= csrf_field() ?>
                    <input type="hidden" id="addConfigMode" name="config_mode" value="0">
                    <!-- Top row: 3 columns (Vehicle, Personil, Destination) -->
                    <div class="modal-form-row modal-form-row-3-cols">
                        <div class="modal-form-col modal-form-col-3">
                            <label for="vehicle_id" class="form-label">Vehicle</label>
                            <div class="searchable-dropdown" id="add-vehicle-dropdown">
                                <!-- Display field that shows selected value -->
                                <div class="searchable-dropdown-display" id="add-vehicle-display">
                                    <input type="text" class="searchable-dropdown-display-input"
                                        id="add-vehicle-display-input"
                                        placeholder="Click to select vehicle"
                                        readonly
                                        data-target="vehicle_id">
                                    <div class="searchable-dropdown-arrow">
                                        <i class="bi bi-chevron-down"></i>
                                    </div>
                                </div>
                                <!-- Search field that appears below when clicked -->
                                <div class="searchable-dropdown-search-container" id="add-vehicle-search-container" style="display: none;">
                                    <input type="text" class="searchable-dropdown-search-input"
                                        id="add-vehicle-search"
                                        placeholder="Search vehicles..."
                                        autocomplete="off">
                                </div>
                                <!-- Options list -->
                                <div class="searchable-dropdown-menu" id="add-vehicle-menu" style="display: none;">
                                    <?php if (!empty($vehicles)): foreach ($vehicles as $v): ?>
                                            <div class="searchable-dropdown-item" data-value="<?= esc($v['id']) ?>" data-text="<?= esc($v['vehicle_name']) ?> (<?= esc($v['number_plate']) ?>)"><?= esc($v['vehicle_name']) ?> (<?= esc($v['number_plate']) ?>)</div>
                                    <?php endforeach;
                                    endif; ?>
                                </div>
                            </div>
                            <div class="form-text text-muted mt-1">
                                <small><i class="bi bi-info-circle me-1"></i>Tip: Type "Name - Plate" or "Name (Plate)" to add new vehicle instantly</small>
                            </div>
                            <input type="hidden" id="vehicle_id" name="vehicle_id" required>
                        </div>
                        <div class="modal-form-col modal-form-col-3">
                            <label for="people_id" class="form-label">Personil Name</label>
                            <div class="searchable-dropdown" id="add-people-dropdown">
                                <!-- Display field that shows selected value -->
                                <div class="searchable-dropdown-display" id="add-people-display">
                                    <input type="text" class="searchable-dropdown-display-input"
                                        id="add-people-display-input"
                                        placeholder="Click to select personnel"
                                        readonly
                                        data-target="people_id">
                                    <div class="searchable-dropdown-arrow">
                                        <i class="bi bi-chevron-down"></i>
                                    </div>
                                </div>
                                <!-- Search field that appears below when clicked -->
                                <div class="searchable-dropdown-search-container" id="add-people-search-container" style="display: none;">
                                    <input type="text" class="searchable-dropdown-search-input"
                                        id="add-people-search"
                                        placeholder="Search personnel..."
                                        autocomplete="off">
                                </div>
                                <!-- Options list -->
                                <div class="searchable-dropdown-menu" id="add-people-menu" style="display: none;">
                                    <?php if (!empty($people)): foreach ($people as $p): ?>
                                            <div class="searchable-dropdown-item" data-value="<?= esc($p['id']) ?>" data-text="<?= esc($p['name']) ?>"><?= esc($p['name']) ?></div>
                                    <?php endforeach;
                                    endif; ?>
                                </div>
                            </div>
                            <input type="hidden" id="people_id" name="people_id" required>
                        </div>
                        <div class="modal-form-col modal-form-col-3">
                            <label for="destination_id" class="form-label">Destination</label>
                            <div class="searchable-dropdown" id="add-destination-dropdown">
                                <!-- Display field that shows selected value -->
                                <div class="searchable-dropdown-display" id="add-destination-display">
                                    <input type="text" class="searchable-dropdown-display-input"
                                        id="add-destination-display-input"
                                        placeholder="Click to select destination"
                                        readonly
                                        data-target="destination_id">
                                    <div class="searchable-dropdown-arrow">
                                        <i class="bi bi-chevron-down"></i>
                                    </div>
                                </div>
                                <!-- Search field that appears below when clicked -->
                                <div class="searchable-dropdown-search-container" id="add-destination-search-container" style="display: none;">
                                    <input type="text" class="searchable-dropdown-search-input"
                                        id="add-destination-search"
                                        placeholder="Search destinations..."
                                        autocomplete="off">
                                </div>
                                <!-- Options list -->
                                <div class="searchable-dropdown-menu" id="add-destination-menu" style="display: none;">
                                    <?php if (!empty($destinations)): foreach ($destinations as $d): ?>
                                            <div class="searchable-dropdown-item" data-value="<?= esc($d['id']) ?>" data-text="<?= esc($d['destination_name']) ?>"><?= esc($d['destination_name']) ?></div>
                                    <?php endforeach;
                                    endif; ?>
                                </div>
                            </div>
                            <input type="hidden" id="destination_id" name="destination_id" required>
                        </div>
                    </div>

                    <!-- Bottom row: 2 columns (From and Until) -->
                    <div class="modal-form-row modal-form-row-2-cols">
                        <div class="modal-form-col modal-form-col-2">
                            <h6 class="form-section-title">From</h6>
                            <div class="form-group-inline">
                                <div class="form-field-group">
                                    <label for="leavingDate" class="form-label">Leaving Date</label>
                                    <input type="date" class="form-control" id="leavingDate" name="leaving_date" required>
                                </div>
                                <div class="form-field-group">
                                    <label for="leavingTime" class="form-label">Leaving Time</label>
                                    <input type="time" class="form-control" id="leavingTime" name="leaving_time" required>
                                </div>
                            </div>
                        </div>
                        <div class="modal-form-col modal-form-col-2">
                            <h6 class="form-section-title">Until</h6>
                            <div class="form-group-inline">
                                <div class="form-field-group">
                                    <label for="returnDate" class="form-label">Return Date</label>
                                    <input type="date" class="form-control" id="returnDate" name="return_date" required>
                                </div>
                                <div class="form-field-group">
                                    <label for="returnTime" class="form-label">Return Time</label>
                                    <input type="time" class="form-control" id="returnTime" name="return_time" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-buttons-container mt-4">
                        <!-- Single mode buttons -->
                        <div class="d-flex gap-3" id="singleModeButtons">
                            <button type="button" class="btn btn-warning-custom flex-fill" id="addMultipleBtn">
                                Add Multiple Data
                            </button>
                            <button type="submit" class="btn btn-primary-custom flex-fill" id="submitSingleBtn">
                                Save
                            </button>
                        </div>

                        <!-- Multiple mode buttons -->
                        <div class="multiple-mode-buttons" id="multipleModeButtons" style="display: none;">
                            <div class="d-flex justify-content-center mb-3">
                                <button type="button" class="btn btn-add-multiple w-100" id="addToListBtn">
                                    Add
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Data Preview Table -->
                    <div class="data-preview-table" id="dataPreviewTable" style="display: none;">
                        <h6 class="w-100 text-center">V-Trip data to be added</h6>
                        <table class="table table-sm table-bordered text-center">
                            <thead>
                                <tr>
                                    <th style="text-align: center; vertical-align: middle;">Vehicle</th>
                                    <th style="text-align: center; vertical-align: middle;">Personil</th>
                                    <th style="text-align: center; vertical-align: middle;">Destination</th>
                                    <th style="text-align: center; vertical-align: middle;">From</th>
                                    <th style="text-align: center; vertical-align: middle;">Until</th>
                                    <th style="text-align: center; vertical-align: middle;">Action</th>
                                </tr>
                            </thead>
                            <tbody id="dataPreviewBody" style="text-align: center; vertical-align: middle;">
                            </tbody>
                        </table>
                    </div>

                    <!-- Save All Button Container (positioned relative to modal content) -->
                    <div class="save-all-container" id="saveAllContainer" style="display: none;">
                        <button type="button" class="btn btn-save-all" id="submitMultipleBtn">
                            💾
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit V-TRIP Modal -->
<div class="modal fade" id="editVtripModal" tabindex="-1" aria-labelledby="editVtripModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title w-100 text-center" id="editVtripModalLabel">Edit V-TRIP</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editVtripForm" action="<?= base_url('vtrip/updateWithFlash') ?>" method="post">
                    <?= csrf_field() ?>
                    <input type="hidden" id="editVtripId" name="vtrip_id">
                    <input type="hidden" id="editConfigMode" name="config_mode" value="0">

                    <!-- Top row: 3 columns (Vehicle, Personil, Destination) -->
                    <div class="modal-form-row modal-form-row-3-cols">
                        <div class="modal-form-col modal-form-col-3">
                            <label for="editVehicleId" class="form-label">Vehicle</label>
                            <div class="searchable-dropdown" id="edit-vehicle-dropdown">
                                <!-- Display field that shows selected value -->
                                <div class="searchable-dropdown-display" id="edit-vehicle-display">
                                    <input type="text" class="searchable-dropdown-display-input"
                                        id="edit-vehicle-display-input"
                                        placeholder="Click to select vehicle"
                                        readonly
                                        data-target="editVehicleId">
                                    <div class="searchable-dropdown-arrow">
                                        <i class="bi bi-chevron-down"></i>
                                    </div>
                                </div>
                                <!-- Search field that appears below when clicked -->
                                <div class="searchable-dropdown-search-container" id="edit-vehicle-search-container" style="display: none;">
                                    <input type="text" class="searchable-dropdown-search-input"
                                        id="edit-vehicle-search"
                                        placeholder="Search vehicles..."
                                        autocomplete="off">
                                </div>
                                <!-- Options list -->
                                <div class="searchable-dropdown-menu" id="edit-vehicle-menu" style="display: none;">
                                    <?php if (!empty($vehicles)): foreach ($vehicles as $v): ?>
                                            <div class="searchable-dropdown-item" data-value="<?= esc($v['id']) ?>" data-text="<?= esc($v['vehicle_name']) ?> (<?= esc($v['number_plate']) ?>)"><?= esc($v['vehicle_name']) ?> (<?= esc($v['number_plate']) ?>)</div>
                                    <?php endforeach;
                                    endif; ?>
                                </div>
                            </div>
                            <div class="form-text text-muted mt-1">
                                <small><i class="bi bi-info-circle me-1"></i>Tip: Type "Name - Plate" or "Name (Plate)" to add new vehicle instantly</small>
                            </div>
                            <input type="hidden" id="editVehicleId" name="vehicle_id" required>
                        </div>
                        <div class="modal-form-col modal-form-col-3">
                            <label for="editPeopleId" class="form-label">Personil Name</label>
                            <div class="searchable-dropdown" id="edit-people-dropdown">
                                <!-- Display field that shows selected value -->
                                <div class="searchable-dropdown-display" id="edit-people-display">
                                    <input type="text" class="searchable-dropdown-display-input"
                                        id="edit-people-display-input"
                                        placeholder="Click to select personnel"
                                        readonly
                                        data-target="editPeopleId">
                                    <div class="searchable-dropdown-arrow">
                                        <i class="bi bi-chevron-down"></i>
                                    </div>
                                </div>
                                <!-- Search field that appears below when clicked -->
                                <div class="searchable-dropdown-search-container" id="edit-people-search-container" style="display: none;">
                                    <input type="text" class="searchable-dropdown-search-input"
                                        id="edit-people-search"
                                        placeholder="Search personnel..."
                                        autocomplete="off">
                                </div>
                                <!-- Options list -->
                                <div class="searchable-dropdown-menu" id="edit-people-menu" style="display: none;">
                                    <?php if (!empty($people)): foreach ($people as $p): ?>
                                            <div class="searchable-dropdown-item" data-value="<?= esc($p['id']) ?>" data-text="<?= esc($p['name']) ?>"><?= esc($p['name']) ?></div>
                                    <?php endforeach;
                                    endif; ?>
                                </div>
                            </div>
                            <input type="hidden" id="editPeopleId" name="people_id" required>
                        </div>
                        <div class="modal-form-col modal-form-col-3">
                            <label for="editDestinationId" class="form-label">Destination</label>
                            <div class="searchable-dropdown" id="edit-destination-dropdown">
                                <!-- Display field that shows selected value -->
                                <div class="searchable-dropdown-display" id="edit-destination-display">
                                    <input type="text" class="searchable-dropdown-display-input"
                                        id="edit-destination-display-input"
                                        placeholder="Click to select destination"
                                        readonly
                                        data-target="editDestinationId">
                                    <div class="searchable-dropdown-arrow">
                                        <i class="bi bi-chevron-down"></i>
                                    </div>
                                </div>
                                <!-- Search field that appears below when clicked -->
                                <div class="searchable-dropdown-search-container" id="edit-destination-search-container" style="display: none;">
                                    <input type="text" class="searchable-dropdown-search-input"
                                        id="edit-destination-search"
                                        placeholder="Search destinations..."
                                        autocomplete="off">
                                </div>
                                <!-- Options list -->
                                <div class="searchable-dropdown-menu" id="edit-destination-menu" style="display: none;">
                                    <?php if (!empty($destinations)): foreach ($destinations as $d): ?>
                                            <div class="searchable-dropdown-item" data-value="<?= esc($d['id']) ?>" data-text="<?= esc($d['destination_name']) ?>"><?= esc($d['destination_name']) ?></div>
                                    <?php endforeach;
                                    endif; ?>
                                </div>
                            </div>
                            <input type="hidden" id="editDestinationId" name="destination_id" required>
                        </div>
                    </div>

                    <!-- Bottom row: 2 columns (From and Until) -->
                    <div class="modal-form-row modal-form-row-2-cols">
                        <div class="modal-form-col modal-form-col-2">
                            <h6 class="form-section-title">From</h6>
                            <div class="form-group-inline">
                                <div class="form-field-group">
                                    <label for="editLeavingDate" class="form-label">Leaving Date</label>
                                    <input type="date" class="form-control" id="editLeavingDate" name="leaving_date" required>
                                </div>
                                <div class="form-field-group">
                                    <label for="editLeavingTime" class="form-label">Leaving Time</label>
                                    <input type="time" class="form-control" id="editLeavingTime" name="leaving_time" required>
                                </div>
                            </div>
                        </div>
                        <div class="modal-form-col modal-form-col-2">
                            <h6 class="form-section-title">Until</h6>
                            <div class="form-group-inline">
                                <div class="form-field-group">
                                    <label for="editReturnDate" class="form-label">Return Date</label>
                                    <input type="date" class="form-control" id="editReturnDate" name="return_date" required>
                                </div>
                                <div class="form-field-group">
                                    <label for="editReturnTime" class="form-label">Return Time</label>
                                    <input type="time" class="form-control" id="editReturnTime" name="return_time" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-center mt-4">
                        <button type="submit" class="btn btn-primary-custom px-5">
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade warning-modal" id="deleteVtripModal" tabindex="-1" aria-labelledby="deleteVtripModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="delete-icon">
                    <i class="bi bi-trash"></i>
                </div>
                <h5 class="warning-text">WARNING!</h5>
                <p class="warning-subtext">This action will result in the permanent deletion of the selected data. Once deleted, the data cannot be recovered.</p>

                <div class="d-flex gap-3 justify-content-center">
                    <button type="button" class="btn btn-secondary-custom" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger-custom" id="confirmDeleteBtn">Delete</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Vehicle Conflict Warning Modal -->
<div class="modal fade warning-modal" id="vehicleConflictModal" tabindex="-1" aria-labelledby="vehicleConflictModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body" style="padding: 30px 40px;">
                <h5 class="warning-text">WARNING!</h5>
                <div class="warning-icon">
                    <i class="bi bi-car-front" style="color: #dc3545; font-size: 4rem;"></i>
                </div>
                <p id="vehicleConflictMessage" class="warning-subtext"></p>
                <p class="warning-subtext text-danger">Please choose another vehicle</p>

                <div class="d-flex justify-content-center">
                    <button type="button" class="btn btn-secondary-custom" data-bs-dismiss="modal">Back</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Schedule Conflict Warning Modal -->
<div class="modal fade warning-modal" id="scheduleWarningModal" tabindex="-1" aria-labelledby="scheduleWarningModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="warning-icon">
                    <i class="bi bi-exclamation-triangle"></i>
                </div>
                <h5 class="warning-text">WARNING!</h5>
                <p id="warningMessage" class="warning-subtext"></p>
                <p class="warning-subtext">Are you sure you want to add this schedule?</p>

                <div class="d-flex gap-3 justify-content-center">
                    <button type="button" class="btn btn-secondary-custom" data-bs-dismiss="modal">No</button>
                    <button type="button" class="btn btn-primary-custom" id="confirmAddBtn">Yes</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Schedule Conflict Error Modal -->
<div class="modal fade warning-modal" id="scheduleErrorModal" tabindex="-1" aria-labelledby="scheduleErrorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="warning-icon">
                    <i class="bi bi-person-x"></i>
                </div>
                <h5 class="warning-text">WARNING!</h5>
                <p id="errorMessage" class="warning-subtext"></p>
                <p class="warning-subtext text-danger">Please add another schedule</p>

                <div class="d-flex justify-content-center">
                    <button type="button" class="btn btn-secondary-custom" data-bs-dismiss="modal">Back</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete All Trips Confirmation Modal -->
<div class="modal fade warning-modal" id="deleteAllTripsModal" tabindex="-1" aria-labelledby="deleteAllTripsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="delete-icon">
                    <i class="bi bi-trash"></i>
                </div>
                <h5 class="warning-text">WARNING!</h5>
                <p class="warning-subtext" id="deleteAllMessage">This action will result in the permanent deletion of all trips for this vehicle. Once deleted, the data cannot be recovered.</p>

                <div class="d-flex gap-3 justify-content-center">
                    <button type="button" class="btn btn-secondary-custom" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger-custom" id="confirmDeleteAllBtn">Delete All</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Configuration mode detection and management
    const urlParams = new URLSearchParams(window.location.search);
    const isConfigMode = urlParams.get('config') === '1';

    // Update config mode in forms
    function updateFormConfigMode(configMode) {
        const addConfigInput = document.getElementById('addConfigMode');
        const editConfigInput = document.getElementById('editConfigMode');

        if (addConfigInput) {
            addConfigInput.value = configMode ? '1' : '0';
        }
        if (editConfigInput) {
            editConfigInput.value = configMode ? '1' : '0';
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Global variables
        let currentDeleteId = null;
        let currentDeleteAllData = null;
        let multipleDataMode = false;
        let pendingData = [];
        let peopleData = <?= json_encode($people) ?>;
        let vehiclesData = <?= json_encode($vehicles) ?>;
        let destinationsData = <?= json_encode($destinations) ?>;

        // ===========================
        // Searchable Dropdown Implementation (M-Loc Style)
        // ===========================

        console.log('Initializing V-Trip with M-Loc style dropdowns...');

        // SearchableDropdown class
        class SearchableDropdown {
            constructor(element) {
                this.element = element;
                this.displayInput = element.querySelector('.searchable-dropdown-display-input');
                this.searchContainer = element.querySelector('.searchable-dropdown-search-container');
                this.searchInput = element.querySelector('.searchable-dropdown-search-input');
                this.menu = element.querySelector('.searchable-dropdown-menu');
                this.arrow = element.querySelector('.searchable-dropdown-arrow');
                this.items = element.querySelectorAll('.searchable-dropdown-item');
                this.targetInput = document.getElementById(this.displayInput.dataset.target);
                this.isOpen = false;
                this.toggleTimeout = null;

                this.init();
            }

            init() {
                // Remove readonly attribute to prevent click interference but keep it functionally readonly
                this.displayInput.removeAttribute('readonly');

                // Make the input functionally readonly by preventing text input
                this.displayInput.addEventListener('keydown', (e) => {
                    // Allow navigation keys but prevent typing
                    if (!['Tab', 'Escape', 'Enter', 'ArrowLeft', 'ArrowRight', 'ArrowUp', 'ArrowDown'].includes(e.key)) {
                        e.preventDefault();
                    }
                });

                this.displayInput.addEventListener('keypress', (e) => {
                    e.preventDefault(); // Prevent all character input
                });

                this.displayInput.addEventListener('input', (e) => {
                    e.preventDefault(); // Prevent any input changes
                });

                // Display input mousedown handler - immediate response
                this.displayInput.addEventListener('mousedown', (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    this.toggle();
                });

                // Display input click handler - backup for touch devices
                this.displayInput.addEventListener('click', (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                });

                // Display input focus handler - only opens (not toggle) to prevent conflicts with click
                this.displayInput.addEventListener('focus', (e) => {
                    e.stopPropagation();
                    if (!this.isOpen) {
                        this.open();
                    }
                });

                // Search input keyup handler for filtering
                if (this.searchInput) {
                    this.searchInput.addEventListener('keyup', (e) => {
                        if (e.key === 'Escape') {
                            this.close();
                            return;
                        }
                        this.filter(this.searchInput.value);
                    });

                    this.searchInput.addEventListener('input', (e) => {
                        this.filter(this.searchInput.value);
                    });
                }

                // Arrow mousedown handler - immediate response
                if (this.arrow) {
                    this.arrow.addEventListener('mousedown', (e) => {
                        e.preventDefault();
                        e.stopPropagation();
                        this.toggle();
                    });

                    this.arrow.addEventListener('click', (e) => {
                        e.preventDefault();
                        e.stopPropagation();
                    });
                }

                // Item click handlers
                this.items.forEach(item => {
                    item.addEventListener('click', (e) => {
                        e.preventDefault();
                        e.stopPropagation();
                        this.selectItem(item);
                    });
                });

                // Close when clicking outside - use more specific targeting
                document.addEventListener('click', (e) => {
                    // Only close if click is truly outside and not on any dropdown element
                    // Check for both regular dropdown elements and body-attached menus
                    const isClickInsideDropdown = e.target.closest('.searchable-dropdown') ||
                        e.target.closest('.searchable-dropdown-menu') ||
                        (e.target.classList && e.target.classList.contains('searchable-dropdown-item'));

                    if (!isClickInsideDropdown) {
                        this.close();
                    }
                }, true); // Use capture phase to ensure we catch events first

                // Prevent modal backdrop from closing dropdown
                this.displayInput.addEventListener('blur', (e) => {
                    // Only close on blur if the new focus target is not related to this dropdown
                    setTimeout(() => {
                        const activeElement = document.activeElement;
                        if (!this.element.contains(activeElement) &&
                            !this.menu.contains(activeElement)) {
                            this.close();
                        }
                    }, 150);
                });

                if (this.searchInput) {
                    this.searchInput.addEventListener('blur', (e) => {
                        // Only close on blur if the new focus target is not related to this dropdown
                        setTimeout(() => {
                            const activeElement = document.activeElement;
                            if (!this.element.contains(activeElement) &&
                                !this.menu.contains(activeElement)) {
                                this.close();
                            }
                        }, 150);
                    });
                }

                // Reposition on window resize and scroll
                window.addEventListener('resize', () => {
                    if (this.isOpen) {
                        // Delay repositioning to allow layout to settle
                        setTimeout(() => {
                            this.positionMenu();
                        }, 10);
                    }
                });

                window.addEventListener('scroll', () => {
                    if (this.isOpen) {
                        // Delay repositioning to allow scroll to settle
                        setTimeout(() => {
                            this.positionMenu();
                        }, 10);
                    }
                }, true); // Use capture phase to catch all scroll events
            }

            toggle() {
                // Timeout mechanism to prevent rapid toggling issues
                if (this.toggleTimeout) {
                    clearTimeout(this.toggleTimeout);
                }

                this.toggleTimeout = setTimeout(() => {
                    if (this.isOpen) {
                        this.close();
                    } else {
                        this.open();
                    }
                    this.toggleTimeout = null;
                }, 50);
            }

            open() {
                // Prevent opening if already open
                if (this.isOpen) {
                    return;
                }

                // Close other dropdowns first
                document.querySelectorAll('.searchable-dropdown').forEach(dropdown => {
                    if (dropdown !== this.element) {
                        const instance = dropdown.searchableDropdownInstance;
                        if (instance && instance.isOpen) {
                            instance.close();
                        }
                    }
                });

                // Also close any body-attached dropdown menus
                document.querySelectorAll('body > .searchable-dropdown-menu').forEach(menu => {
                    if (menu !== this.menu) {
                        menu.style.display = 'none';
                        menu.classList.remove('show');
                    }
                });

                this.isOpen = true;
                this.element.classList.add('open');

                // Show search container and menu
                if (this.searchContainer) {
                    this.searchContainer.style.display = 'block';
                }
                this.menu.style.display = 'block';
                this.menu.classList.add('show');

                // Position the menu
                this.positionMenu();

                // Focus search input
                if (this.searchInput) {
                    this.searchInput.focus();
                }
            }

            close() {
                // Prevent closing if already closed
                if (!this.isOpen) {
                    return;
                }

                this.isOpen = false;
                this.element.classList.remove('open');
                this.menu.classList.remove('show');

                // Hide search container and menu
                if (this.searchContainer) {
                    this.searchContainer.style.display = 'none';
                }
                this.menu.style.display = 'none';

                // Remove menu from body if it was attached there
                if (this.menu.parentElement === document.body) {
                    this.menu.remove();
                    // Re-attach to original parent (the dropdown element)
                    this.element.appendChild(this.menu);
                }

                // Clear search input
                if (this.searchInput) {
                    this.searchInput.value = '';
                }

                // Reset all items to visible
                this.items.forEach(item => {
                    item.style.display = 'block';
                });

                // Remove any add-new items
                const addNewItems = this.menu.querySelectorAll('.add-new-item');
                addNewItems.forEach(item => item.remove());
            }

            positionMenu() {
                if (this.searchContainer) {
                    // Get the position of the search container relative to the viewport
                    const containerRect = this.searchContainer.getBoundingClientRect();
                    const viewportWidth = window.innerWidth;
                    const viewportHeight = window.innerHeight;

                    // Check if we should attach to body for better z-index positioning
                    const shouldAttachToBody = true; // Always attach to body for maximum z-index

                    if (shouldAttachToBody) {
                        // Remove menu from current parent and attach to body
                        if (this.menu.parentElement !== document.body) {
                            this.menu.remove();
                            document.body.appendChild(this.menu);
                        }

                        // Position menu below the search container with fixed positioning
                        this.menu.style.position = 'fixed';
                        this.menu.style.top = (containerRect.bottom + 5) + 'px';
                        this.menu.style.left = containerRect.left + 'px';
                        this.menu.style.width = containerRect.width + 'px';
                        this.menu.style.zIndex = '2147483647'; // Maximum z-index
                        this.menu.style.maxHeight = Math.min(250, viewportHeight - containerRect.bottom - 20) + 'px';
                    } else {
                        // Position menu below the search container with absolute positioning
                        this.menu.style.position = 'absolute';
                        this.menu.style.top = '100%';
                        this.menu.style.left = '0';
                        this.menu.style.right = '0';
                        this.menu.style.zIndex = '2147483647';
                        this.menu.style.marginTop = '5px';
                    }
                }
            }

            filter(query) {
                const lowerQuery = query.toLowerCase();
                let hasVisibleItems = false;

                this.items.forEach(item => {
                    const text = item.textContent.toLowerCase();
                    const isMatch = text.includes(lowerQuery);
                    item.style.display = isMatch ? 'block' : 'none';
                    if (isMatch) hasVisibleItems = true;
                });

                // Remove existing add-new or no-results items
                let addNewItem = this.menu.querySelector('.add-new-item');
                let noResultsItem = this.menu.querySelector('.no-results');
                if (addNewItem) {
                    addNewItem.remove();
                }
                if (noResultsItem) {
                    noResultsItem.remove();
                }

                // Show add-new option or no results if needed
                if (!hasVisibleItems && query.trim() !== '') {
                    // Determine dropdown type and show appropriate add-new option
                    const dropdownId = this.element.id;

                    if (dropdownId === 'add-vehicle-dropdown' || dropdownId === 'edit-vehicle-dropdown') {
                        // Add new vehicle option
                        addNewItem = document.createElement('div');
                        addNewItem.className = 'searchable-dropdown-item add-new-item';
                        addNewItem.innerHTML = `<i class="bi bi-plus-circle me-2"></i>Add new vehicle: "${query}"`;
                        addNewItem.style.color = '#007bff';
                        addNewItem.style.fontWeight = '500';
                        addNewItem.style.borderTop = '1px solid #dee2e6';

                        addNewItem.addEventListener('click', (e) => {
                            e.preventDefault();
                            e.stopPropagation();
                            this.addNewVehicle(query);
                        });

                        this.menu.appendChild(addNewItem);
                    } else if (dropdownId === 'add-people-dropdown' || dropdownId === 'edit-people-dropdown') {
                        // Add new person option
                        addNewItem = document.createElement('div');
                        addNewItem.className = 'searchable-dropdown-item add-new-item';
                        addNewItem.innerHTML = `<i class="bi bi-person-plus me-2"></i>Add new person: "${query}"`;
                        addNewItem.style.color = '#007bff';
                        addNewItem.style.fontWeight = '500';
                        addNewItem.style.borderTop = '1px solid #dee2e6';

                        addNewItem.addEventListener('click', (e) => {
                            e.preventDefault();
                            e.stopPropagation();
                            this.addNewPerson(query);
                        });

                        this.menu.appendChild(addNewItem);
                    } else if (dropdownId === 'add-destination-dropdown' || dropdownId === 'edit-destination-dropdown') {
                        // Add new destination option
                        addNewItem = document.createElement('div');
                        addNewItem.className = 'searchable-dropdown-item add-new-item';
                        addNewItem.innerHTML = `<i class="bi bi-plus-circle me-2"></i>Add new destination: "${query}"`;
                        addNewItem.style.color = '#007bff';
                        addNewItem.style.fontWeight = '500';
                        addNewItem.style.borderTop = '1px solid #dee2e6';

                        addNewItem.addEventListener('click', (e) => {
                            e.preventDefault();
                            e.stopPropagation();
                            this.addNewDestination(query);
                        });

                        this.menu.appendChild(addNewItem);
                    } else {
                        // Show "No results" for other dropdowns
                        noResultsItem = document.createElement('div');
                        noResultsItem.className = 'searchable-dropdown-item no-results';
                        noResultsItem.textContent = 'No results found';
                        noResultsItem.style.fontStyle = 'italic';
                        noResultsItem.style.color = '#6c757d';
                        this.menu.appendChild(noResultsItem);
                    }
                }
            }

            selectItem(item) {
                const value = item.dataset.value;
                const text = item.dataset.text || item.textContent;

                // Update display input
                this.displayInput.value = text;

                // Update hidden input
                if (this.targetInput) {
                    this.targetInput.value = value;
                }

                // Close dropdown
                this.close();

                console.log('Selected:', {
                    value,
                    text
                });
            }

            selectItemByElement(element) {
                const value = element.dataset.value;
                const text = element.dataset.text || element.textContent;

                this.displayInput.value = text;
                if (this.targetInput) {
                    this.targetInput.value = value;
                }

                this.close();

                // Trigger change event on hidden input
                const changeEvent = new Event('change', {
                    bubbles: true
                });
                if (this.targetInput) {
                    this.targetInput.dispatchEvent(changeEvent);
                }

                console.log('Selected item by element:', {
                    value,
                    text
                });
            }

            setValue(value, text) {
                this.displayInput.value = text || '';
                if (this.targetInput) {
                    this.targetInput.value = value || '';
                }
            }

            reset() {
                this.setValue('', '');
                this.displayInput.placeholder = this.displayInput.getAttribute('placeholder') || '';
            }

            showModalNotification(message, type) {
                // Create notification element specifically for modal
                const notification = document.createElement('div');
                notification.className = 'modal-notification';
                notification.style.position = 'fixed';
                notification.style.top = '20px';
                notification.style.left = '50%';
                notification.style.transform = 'translateX(-50%)';
                notification.style.zIndex = '999999999'; // Above modal
                notification.style.minWidth = '300px';
                notification.innerHTML = `
                <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            `;

                // Add to document body
                document.body.appendChild(notification);

                // Auto remove after 5 seconds
                setTimeout(() => {
                    if (notification.parentElement) {
                        notification.style.opacity = '0';
                        notification.style.transform = 'translateX(-50%) translateY(-20px)';
                        setTimeout(() => {
                            if (notification.parentElement) {
                                notification.remove();
                            }
                        }, 300);
                    }
                }, 5000);
            }

            addNewVehicle(vehicleName) {
                console.log('Adding new vehicle:', vehicleName);

                // Try to parse vehicle name and number plate from search query
                let parsedName = vehicleName.trim();
                let parsedPlate = '';

                // Check for various formats: "Name | Plate", "Name (Plate)", "Name - Plate"
                const pipeMatch = vehicleName.match(/^(.+?)\s*\|\s*(.+)$/);
                const parenMatch = vehicleName.match(/^(.+?)\s*\(\s*(.+?)\s*\)$/);
                const dashMatch = vehicleName.match(/^(.+?)\s*-\s*(.+)$/);

                if (pipeMatch) {
                    parsedName = pipeMatch[1].trim();
                    parsedPlate = pipeMatch[2].trim();
                } else if (parenMatch) {
                    parsedName = parenMatch[1].trim();
                    parsedPlate = parenMatch[2].trim();
                } else if (dashMatch) {
                    parsedName = dashMatch[1].trim();
                    parsedPlate = dashMatch[2].trim();
                }

                // If both name and plate are parsed, proceed directly with AJAX
                if (parsedName && parsedPlate) {
                    // Show loading state in the add-new item and keep dropdown open
                    const loadingAddNewItem = this.menu.querySelector('.add-new-item');
                    if (loadingAddNewItem) {
                        loadingAddNewItem.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Adding vehicle...';
                        loadingAddNewItem.style.pointerEvents = 'none';
                    }

                    // Ensure dropdown stays open during operation
                    this.isOpen = true;
                    this.element.classList.add('open');
                    this.menu.classList.add('show');
                    this.positionMenu();

                    // Get CSRF token
                    const csrfToken = document.querySelector('input[name="<?= csrf_token() ?>"]')?.value;

                    // AJAX request to add new vehicle
                    fetch('<?= base_url('vehicles/addQuick') ?>', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': csrfToken
                            },
                            body: JSON.stringify({
                                vehicle_name: parsedName,
                                number_plate: parsedPlate,
                                '<?= csrf_token() ?>': csrfToken
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                console.log('Vehicle added successfully:', data);

                                // Add new option to dropdown
                                const newItem = document.createElement('div');
                                newItem.className = 'searchable-dropdown-item';
                                newItem.dataset.value = data.vehicle.id;
                                newItem.dataset.text = `${data.vehicle.vehicle_name} (${data.vehicle.number_plate})`;
                                newItem.textContent = `${data.vehicle.vehicle_name} (${data.vehicle.number_plate})`;

                                // Add click event to new item
                                newItem.addEventListener('click', (e) => {
                                    e.preventDefault();
                                    e.stopPropagation();
                                    this.selectItem(newItem);
                                });

                                // Insert into menu (before any add-new items)
                                const existingAddNewItem = this.menu.querySelector('.add-new-item');
                                if (existingAddNewItem) {
                                    this.menu.insertBefore(newItem, existingAddNewItem);
                                } else {
                                    this.menu.appendChild(newItem);
                                }

                                // Update items array
                                this.items = this.menu.querySelectorAll('.searchable-dropdown-item:not(.add-new-item):not(.no-results)');

                                // Select the new item
                                this.setValue(data.vehicle.id, `${data.vehicle.vehicle_name} (${data.vehicle.number_plate})`);

                                // Update global vehicles data
                                vehiclesData.push({
                                    id: data.vehicle.id,
                                    vehicle_name: data.vehicle.vehicle_name,
                                    number_plate: data.vehicle.number_plate
                                });

                                // Also update the edit modal dropdown if it exists
                                const editDropdown = document.getElementById('edit-vehicle-dropdown');
                                if (editDropdown) {
                                    const editMenu = editDropdown.querySelector('.searchable-dropdown-menu');
                                    if (editMenu) {
                                        const editNewItem = document.createElement('div');
                                        editNewItem.className = 'searchable-dropdown-item';
                                        editNewItem.dataset.value = data.vehicle.id;
                                        editNewItem.dataset.text = `${data.vehicle.vehicle_name} (${data.vehicle.number_plate})`;
                                        editNewItem.textContent = `${data.vehicle.vehicle_name} (${data.vehicle.number_plate})`;

                                        // Add click event to edit dropdown item
                                        editNewItem.addEventListener('click', (e) => {
                                            e.preventDefault();
                                            e.stopPropagation();
                                            const editDropdownInstance = editDropdown.searchableDropdownInstance;
                                            if (editDropdownInstance) {
                                                editDropdownInstance.selectItem(editNewItem);
                                            }
                                        });

                                        // Insert into edit menu
                                        editMenu.appendChild(editNewItem);
                                    }
                                }

                                // Close dropdown
                                this.close();

                                // Remove the add-new-item element to prevent stale loading states
                                const addNewItemForRemoval = this.menu.querySelector('.add-new-item');
                                if (addNewItemForRemoval) {
                                    addNewItemForRemoval.remove();
                                }

                                // Show success notification
                                this.showModalNotification(`Vehicle "${data.vehicle.vehicle_name} (${data.vehicle.number_plate})" successfully added!`, 'success');

                            } else {
                                console.error('Failed to add vehicle:', data.message);
                                this.showModalNotification(data.message || 'Failed to add new vehicle', 'danger');

                                // Reset add new item on error
                                if (loadingAddNewItem) {
                                    loadingAddNewItem.innerHTML = `<i class="bi bi-plus-circle me-2"></i>Add new vehicle: "${vehicleName}"`;
                                    loadingAddNewItem.style.pointerEvents = 'auto';
                                }
                            }
                        })
                        .catch(error => {
                            console.error('Error adding vehicle:', error);
                            this.showModalNotification('An error occurred while adding the vehicle', 'danger');

                            // Reset add new item on error
                            if (loadingAddNewItem) {
                                loadingAddNewItem.innerHTML = `<i class="bi bi-plus-circle me-2"></i>Add new vehicle: "${vehicleName}"`;
                                loadingAddNewItem.style.pointerEvents = 'auto';
                            }
                        });

                    return; // Exit early for direct AJAX approach
                }

                // If format is not complete, show modal for manual input
                // Show modal for vehicle name and number plate input
                const modal = document.createElement('div');
                modal.className = 'modal fade';
                modal.id = 'addVehicleModal';
                modal.innerHTML = `
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Add New Vehicle</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Vehicle Name</label>
                                <input type="text" class="form-control" id="newVehicleName" value="${parsedName}">
                                <div class="form-text">Tip: You can search "Name | Plate" or "Name (Plate)" for instant creation</div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Number Plate</label>
                                <input type="text" class="form-control" id="newVehiclePlate" value="${parsedPlate}" placeholder="Enter number plate">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-primary" id="saveVehicleBtn">Save Vehicle</button>
                        </div>
                    </div>
                </div>
            `;

                document.body.appendChild(modal);
                const bootstrapModal = new bootstrap.Modal(modal);
                bootstrapModal.show();

                // Focus on the appropriate field
                modal.addEventListener('shown.bs.modal', () => {
                    if (parsedPlate) {
                        // If plate was parsed, focus on save button or name field for editing
                        document.getElementById('newVehicleName').focus();
                    } else {
                        // If no plate, focus on plate input
                        document.getElementById('newVehiclePlate').focus();
                    }
                });

                // Handle save button
                document.getElementById('saveVehicleBtn').addEventListener('click', () => {
                    const name = document.getElementById('newVehicleName').value.trim();
                    const plate = document.getElementById('newVehiclePlate').value.trim();

                    if (!name || !plate) {
                        alert('Please fill in both vehicle name and number plate');
                        return;
                    }

                    // Show loading state
                    const saveBtn = document.getElementById('saveVehicleBtn');
                    saveBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Adding...';
                    saveBtn.disabled = true;

                    // Get CSRF token
                    const csrfToken = document.querySelector('input[name="<?= csrf_token() ?>"]')?.value;

                    // AJAX request to add new vehicle
                    fetch('<?= base_url('vehicles/addQuick') ?>', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': csrfToken
                            },
                            body: JSON.stringify({
                                vehicle_name: name,
                                number_plate: plate,
                                '<?= csrf_token() ?>': csrfToken
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                console.log('Vehicle added successfully:', data);

                                // Add new option to dropdown
                                const newItem = document.createElement('div');
                                newItem.className = 'searchable-dropdown-item';
                                newItem.dataset.value = data.vehicle.id;
                                newItem.dataset.text = `${data.vehicle.vehicle_name} (${data.vehicle.number_plate})`;
                                newItem.textContent = `${data.vehicle.vehicle_name} (${data.vehicle.number_plate})`;

                                // Add click event to new item
                                newItem.addEventListener('click', (e) => {
                                    e.preventDefault();
                                    e.stopPropagation();
                                    this.selectItem(newItem);
                                });

                                // Insert into menu (before any add-new items)
                                const modalAddNewItem = this.menu.querySelector('.add-new-item');
                                if (modalAddNewItem) {
                                    this.menu.insertBefore(newItem, modalAddNewItem);
                                } else {
                                    this.menu.appendChild(newItem);
                                }

                                // Update items array
                                this.items = this.menu.querySelectorAll('.searchable-dropdown-item:not(.add-new-item):not(.no-results)');

                                // Select the new item
                                this.setValue(data.vehicle.id, `${data.vehicle.vehicle_name} (${data.vehicle.number_plate})`);

                                // Update global vehicles data
                                vehiclesData.push({
                                    id: data.vehicle.id,
                                    vehicle_name: data.vehicle.vehicle_name,
                                    number_plate: data.vehicle.number_plate
                                });

                                // Also update the edit modal dropdown if it exists
                                const editDropdown = document.getElementById('edit-vehicle-dropdown');
                                if (editDropdown) {
                                    const editMenu = editDropdown.querySelector('.searchable-dropdown-menu');
                                    if (editMenu) {
                                        const editNewItem = document.createElement('div');
                                        editNewItem.className = 'searchable-dropdown-item';
                                        editNewItem.dataset.value = data.vehicle.id;
                                        editNewItem.dataset.text = `${data.vehicle.vehicle_name} (${data.vehicle.number_plate})`;
                                        editNewItem.textContent = `${data.vehicle.vehicle_name} (${data.vehicle.number_plate})`;

                                        // Add click event to edit dropdown item
                                        editNewItem.addEventListener('click', (e) => {
                                            e.preventDefault();
                                            e.stopPropagation();
                                            const editDropdownInstance = editDropdown.searchableDropdownInstance;
                                            if (editDropdownInstance) {
                                                editDropdownInstance.selectItem(editNewItem);
                                            }
                                        });

                                        // Insert into edit menu
                                        editMenu.appendChild(editNewItem);
                                    }
                                }

                                // Close dropdown and modal
                                this.close();
                                bootstrapModal.hide();

                                // Show success notification
                                this.showModalNotification(`Vehicle "${data.vehicle.vehicle_name}" successfully added!`, 'success');

                            } else {
                                console.error('Failed to add vehicle:', data.message);
                                this.showModalNotification(data.message || 'Failed to add new vehicle', 'danger');

                                // Reset save button
                                saveBtn.innerHTML = 'Save Vehicle';
                                saveBtn.disabled = false;
                            }
                        })
                        .catch(error => {
                            console.error('Error adding vehicle:', error);
                            this.showModalNotification('An error occurred while adding the vehicle', 'danger');

                            // Reset save button
                            saveBtn.innerHTML = 'Save Vehicle';
                            saveBtn.disabled = false;
                        });
                });

                // Clean up modal when hidden
                modal.addEventListener('hidden.bs.modal', () => {
                    modal.remove();
                });
            }

            addNewPerson(personName) {
                console.log('Adding new person:', personName);

                // Show loading state and keep dropdown open
                const personLoadingItem = this.menu.querySelector('.add-new-item');
                if (personLoadingItem) {
                    personLoadingItem.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Adding person...';
                    personLoadingItem.style.pointerEvents = 'none';
                }

                // Ensure dropdown stays open during operation
                this.isOpen = true;
                this.element.classList.add('open');
                this.menu.classList.add('show');
                this.positionMenu();

                // Get CSRF token
                const csrfToken = document.querySelector('input[name="<?= csrf_token() ?>"]')?.value;

                // AJAX request to add new person
                fetch('<?= base_url('people/addQuick') ?>', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({
                            name: personName.trim(),
                            '<?= csrf_token() ?>': csrfToken
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            console.log('Person added successfully:', data);

                            // Add new option to dropdown
                            const newItem = document.createElement('div');
                            newItem.className = 'searchable-dropdown-item';
                            newItem.dataset.value = data.person.id;
                            newItem.dataset.text = data.person.name;
                            newItem.textContent = data.person.name;

                            // Add click event to new item
                            newItem.addEventListener('click', (e) => {
                                e.preventDefault();
                                e.stopPropagation();
                                this.selectItem(newItem);
                            });

                            // Insert before "Add new" item
                            const personAddNewItem = this.menu.querySelector('.add-new-item');
                            this.menu.insertBefore(newItem, personAddNewItem);

                            // Update items array
                            this.items = this.menu.querySelectorAll('.searchable-dropdown-item:not(.add-new-item):not(.no-results)');

                            // Select the new item
                            this.setValue(data.person.id, data.person.name);

                            // Update global people data
                            peopleData.push({
                                id: data.person.id,
                                name: data.person.name
                            });

                            // Also update the edit modal dropdown if it exists
                            const editDropdown = document.getElementById('edit-people-dropdown');
                            if (editDropdown) {
                                const editMenu = editDropdown.querySelector('.searchable-dropdown-menu');
                                if (editMenu) {
                                    const editNewItem = document.createElement('div');
                                    editNewItem.className = 'searchable-dropdown-item';
                                    editNewItem.dataset.value = data.person.id;
                                    editNewItem.dataset.text = data.person.name;
                                    editNewItem.textContent = data.person.name;

                                    // Add click event to edit dropdown item
                                    editNewItem.addEventListener('click', (e) => {
                                        e.preventDefault();
                                        e.stopPropagation();
                                        const editDropdownInstance = editDropdown.searchableDropdownInstance;
                                        if (editDropdownInstance) {
                                            editDropdownInstance.selectItem(editNewItem);
                                        }
                                    });

                                    // Insert into edit menu
                                    editMenu.appendChild(editNewItem);
                                }
                            }

                            // Close dropdown
                            this.close();

                            // Remove the add-new-item element to prevent stale loading states
                            const addNewItemToRemove = this.menu.querySelector('.add-new-item');
                            if (addNewItemToRemove) {
                                addNewItemToRemove.remove();
                            }

                            // Show success notification
                            this.showModalNotification(`Person "${data.person.name}" successfully added!`, 'success');

                        } else {
                            console.error('Failed to add person:', data.message);
                            this.showModalNotification(data.message || 'Failed to add new person', 'danger');

                            // Reset add new item
                            if (personLoadingItem) {
                                personLoadingItem.innerHTML = `<i class="bi bi-person-plus me-2"></i>Add new person: "${personName}"`;
                                personLoadingItem.style.pointerEvents = 'auto';
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Error adding person:', error);
                        this.showModalNotification('An error occurred while adding the person', 'danger');

                        // Reset add new item
                        if (personLoadingItem) {
                            personLoadingItem.innerHTML = `<i class="bi bi-person-plus me-2"></i>Add new person: "${personName}"`;
                            personLoadingItem.style.pointerEvents = 'auto';
                        }
                    });
            }

            addNewDestination(destinationName) {
                console.log('Adding new destination:', destinationName);

                // Show loading state and keep dropdown open
                const destLoadingItem = this.menu.querySelector('.add-new-item');
                if (destLoadingItem) {
                    destLoadingItem.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Adding destination...';
                    destLoadingItem.style.pointerEvents = 'none';
                }

                // Ensure dropdown stays open during operation
                this.isOpen = true;
                this.element.classList.add('open');
                this.menu.classList.add('show');
                this.positionMenu();

                // Get CSRF token
                const csrfToken = document.querySelector('input[name="<?= csrf_token() ?>"]')?.value;

                // AJAX request to add new destination
                fetch('<?= base_url('destinations/addQuick') ?>', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({
                            destination_name: destinationName.trim(),
                            '<?= csrf_token() ?>': csrfToken
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            console.log('Destination added successfully:', data);

                            // Add new option to dropdown
                            const newItem = document.createElement('div');
                            newItem.className = 'searchable-dropdown-item';
                            newItem.dataset.value = data.destination.id;
                            newItem.dataset.text = data.destination.destination_name;
                            newItem.textContent = data.destination.destination_name;

                            // Add click event to new item
                            newItem.addEventListener('click', (e) => {
                                e.preventDefault();
                                e.stopPropagation();
                                this.selectItem(newItem);
                            });

                            // Insert before "Add new" item
                            const destAddNewItem = this.menu.querySelector('.add-new-item');
                            this.menu.insertBefore(newItem, destAddNewItem);

                            // Update items array
                            this.items = this.menu.querySelectorAll('.searchable-dropdown-item:not(.add-new-item):not(.no-results)');

                            // Select the new item
                            this.setValue(data.destination.id, data.destination.destination_name);

                            // Update global destinations data
                            destinationsData.push({
                                id: data.destination.id,
                                destination_name: data.destination.destination_name
                            });

                            // Also update the edit modal dropdown if it exists
                            const editDropdown = document.getElementById('edit-destination-dropdown');
                            if (editDropdown) {
                                const editMenu = editDropdown.querySelector('.searchable-dropdown-menu');
                                if (editMenu) {
                                    const editNewItem = document.createElement('div');
                                    editNewItem.className = 'searchable-dropdown-item';
                                    editNewItem.dataset.value = data.destination.id;
                                    editNewItem.dataset.text = data.destination.destination_name;
                                    editNewItem.textContent = data.destination.destination_name;

                                    // Add click event to edit dropdown item
                                    editNewItem.addEventListener('click', (e) => {
                                        e.preventDefault();
                                        e.stopPropagation();
                                        const editDropdownInstance = editDropdown.searchableDropdownInstance;
                                        if (editDropdownInstance) {
                                            editDropdownInstance.selectItem(editNewItem);
                                        }
                                    });

                                    // Insert into edit menu
                                    editMenu.appendChild(editNewItem);
                                }
                            }

                            // Close dropdown
                            this.close();

                            // Remove the add-new-item element to prevent stale loading states
                            const addNewItemToRemove = this.menu.querySelector('.add-new-item');
                            if (addNewItemToRemove) {
                                addNewItemToRemove.remove();
                            }

                            // Show success notification
                            this.showModalNotification(`Destination "${data.destination.destination_name}" successfully added!`, 'success');

                        } else {
                            console.error('Failed to add destination:', data.message);
                            this.showModalNotification(data.message || 'Failed to add new destination', 'danger');

                            // Reset add new item
                            if (destLoadingItem) {
                                destLoadingItem.innerHTML = `<i class="bi bi-plus-circle me-2"></i>Add new destination: "${destinationName}"`;
                                destLoadingItem.style.pointerEvents = 'auto';
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Error adding destination:', error);
                        this.showModalNotification('An error occurred while adding the destination', 'danger');

                        // Reset add new item
                        if (destLoadingItem) {
                            destLoadingItem.innerHTML = `<i class="bi bi-plus-circle me-2"></i>Add new destination: "${destinationName}"`;
                            destLoadingItem.style.pointerEvents = 'auto';
                        }
                    });
            }
        }

        // Global storage for dropdown instances
        const searchableDropdowns = {};

        // Initialize searchable dropdowns for both add and edit modals
        document.querySelectorAll('.searchable-dropdown').forEach(element => {
            const dropdown = new SearchableDropdown(element);
            searchableDropdowns[element.id] = dropdown;
            element.searchableDropdownInstance = dropdown; // Store reference on element
        });

        // Floating trigger functionality for configuration mode
        console.log('Setting up floating trigger functionality...');
        const floatingTriggerContainer = document.querySelector('.floating-trigger-container');
        console.log('Floating trigger container element:', floatingTriggerContainer);

        // Add debugging for z-index and visibility
        if (floatingTriggerContainer) {
            const computedStyle = window.getComputedStyle(floatingTriggerContainer);
            console.log('Floating trigger z-index:', computedStyle.zIndex);
            console.log('Floating trigger pointer-events:', computedStyle.pointerEvents);
            console.log('Floating trigger visibility:', computedStyle.visibility);
            console.log('Floating trigger display:', computedStyle.display);
        }

        if (floatingTriggerContainer) {
            console.log('Adding click event listener to floating trigger');
            floatingTriggerContainer.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();

                console.log('=== CONFIGURATION TRIGGER CLICKED ===');
                console.log('Event:', e);
                console.log('Target:', e.target);
                console.log('Current target:', e.currentTarget);

                const addButton = document.getElementById('add-vtrip-btn');
                const configHeader = document.getElementById('config-header');
                const isVisible = addButton && addButton.classList.contains('visible');
                const isConfigMode = configHeader && configHeader.classList.contains('visible');

                console.log('Current config mode state:', {
                    isVisible,
                    isConfigMode,
                    addButton: !!addButton,
                    configHeader: !!configHeader,
                    configHeaderClasses: configHeader ? configHeader.className : 'not found',
                    addButtonClasses: addButton ? addButton.className : 'not found'
                });

                if (isVisible || isConfigMode) {
                    // Return to initial state and update URL
                    console.log('=== RETURNING TO INITIAL STATE ===');
                    returnToInitialState();
                    window.history.pushState({}, '', window.location.pathname);
                    updateFormConfigMode(false);
                } else {
                    // Show configuration mode and update URL
                    console.log('=== ENTERING CONFIGURATION MODE ===');
                    showConfigurationMode();
                    window.history.pushState({}, '', window.location.pathname + '?config=1');
                    updateFormConfigMode(true);
                }
            });

            console.log('Floating trigger event listener attached successfully');
        } else {
            console.error('Floating trigger container element not found!');
        }

        // Back button functionality
        const backButton = document.getElementById('back-button');
        if (backButton) {
            backButton.addEventListener('click', function(e) {
                e.preventDefault();
                console.log('Back button clicked');
                returnToInitialState();
                window.history.pushState({}, '', window.location.pathname);
                updateFormConfigMode(false);
            });
            console.log('Back button event listener attached successfully');
        }

        // Initialize configuration mode on page load
        console.log('Initializing configuration mode...');
        initializeConfigMode();

        // Re-initialize dropdowns when edit modal is shown
        document.getElementById('editVtripModal').addEventListener('shown.bs.modal', function() {
            console.log('Edit modal shown, reinitializing dropdowns...');

            // Re-initialize dropdowns for edit modal immediately
            document.querySelectorAll('#editVtripModal .searchable-dropdown').forEach(element => {
                // Remove existing instance
                if (searchableDropdowns[element.id]) {
                    delete searchableDropdowns[element.id];
                    element.searchableDropdownInstance = null;
                }

                // Create new instance
                const dropdown = new SearchableDropdown(element);
                searchableDropdowns[element.id] = dropdown;
                element.searchableDropdownInstance = dropdown;
            });
        });



        // Multiple data mode functionality
        document.getElementById('addMultipleBtn').addEventListener('click', function() {
            console.log('Add Multiple Data button clicked');

            // Enter multiple data mode
            multipleDataMode = true;

            // Load existing temporary data when entering multiple mode
            loadTempDataToPreview();

            // Show data preview table
            document.getElementById('dataPreviewTable').style.display = 'block';

            // Hide single mode buttons with strong CSS classes
            const singleModeButtons = document.getElementById('singleModeButtons');
            singleModeButtons.style.display = 'none';
            singleModeButtons.classList.add('single-mode-hidden');

            // Show multiple mode buttons
            const multipleModeButtons = document.getElementById('multipleModeButtons');
            multipleModeButtons.style.display = 'block';
            multipleModeButtons.classList.add('multiple-mode-visible');

            console.log('Multiple data mode activated');
        });

        // Add to list functionality
        document.getElementById('addToListBtn').addEventListener('click', function() {
            console.log('Add to list button clicked');

            const formData = getFormData();
            if (validateFormData(formData)) {
                // Check for conflicts before adding to list
                checkConflictForMultiple(formData);
            }
        });

        // Function to check conflicts for multiple data mode
        function checkConflictForMultiple(formData) {
            console.log('Starting conflict check for multiple data mode');
            console.log('Form data:', formData);

            // Get vehicle name for display
            const selectedVehicle = vehiclesData.find(v => v.id == formData.vehicle_id);
            const vehicleName = selectedVehicle ? selectedVehicle.vehicle_name : 'Unknown';

            console.log('Checking conflicts for vehicle:', vehicleName);

            // Check for existing conflicts via AJAX
            checkVehicleConflict(formData.vehicle_id, formData.leaving_date, formData.return_date)
                .then(data => {
                    // Fix: Check the correct response structure
                    if (!data.success && data.has_conflict) {
                        console.log('Conflict detected:', data.conflict_details);

                        // Show conflict modal with details
                        const conflictMessage = document.getElementById('vehicleConflictMessage');
                        conflictMessage.innerHTML = `
                    Vehicle <strong>${data.conflict_details.vehicle_name} (${data.conflict_details.number_plate})</strong> is already scheduled:<br>
                    <strong>Used until:</strong> ${data.conflict_details.used_until}<br>
                    <strong>Used by:</strong> ${data.conflict_details.used_by}
                `;

                        const vehicleConflictModal = new bootstrap.Modal(document.getElementById('vehicleConflictModal'), {
                            backdrop: false
                        });
                        vehicleConflictModal.show();

                        // Do NOT add to list when there's a conflict
                        showFlashNotification('Vehicle conflict detected. Please select a different vehicle.', 'warning');
                        return;
                    } else {
                        console.log('No conflict detected, adding to list');
                        addToListDirectly(formData);
                    }
                })
                .catch(error => {
                    console.error('Error checking conflict for multiple data:', error);
                    // If error checking, allow addition anyway
                    addToListDirectly(formData);
                });
        }

        // Function to add data to list directly
        function addToListDirectly(formData, forceAdd = false) {
            console.log('Adding data to temporary storage:', formData);

            // Show loading state on add button
            const addButton = document.getElementById('addToListBtn');
            const originalText = addButton.innerHTML;
            addButton.disabled = true;
            addButton.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Adding...';

            // Send data to backend temporary storage
            fetch('<?= base_url('vtrip/addToTempData') ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('input[name="<?= csrf_token() ?>"]').value
                    },
                    body: new URLSearchParams({
                        vehicle_id: formData.vehicle_id,
                        people_id: formData.people_id,
                        destination_id: formData.destination_id,
                        leaving_date: formData.leaving_date,
                        return_date: formData.return_date,
                        request_by: formData.request_by || '-',
                        '<?= csrf_token() ?>': document.querySelector('input[name="<?= csrf_token() ?>"]').value
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        console.log('Data successfully added to temporary storage:', data.data);

                        // Format data for preview table
                        const formattedData = {
                            id: data.data.id,
                            vehicle_id: data.data.vehicle_id,
                            vehicle_name: data.data.vehicle_name,
                            number_plate: data.data.number_plate,
                            people_id: data.data.people_id,
                            people_name: data.data.people_name,
                            leaveDate: data.data.leave_date,
                            returnDate: data.data.return_date,
                            destination_id: data.data.destination_id,
                            destination_name: data.data.destination_name,
                            _forceAdded: forceAdd
                        };

                        // Add to preview table
                        const currentIndex = document.getElementById('dataPreviewBody').children.length;
                        addToPreviewTableFromTemp(formattedData, currentIndex);

                        // Reset form
                        document.getElementById('addVtripForm').reset();
                        resetDropdowns();

                        // Set default dates and times after reset
                        const today = new Date();
                        const todayStr = today.toISOString().slice(0, 10);
                        const currentTime = today.toTimeString().slice(0, 5);
                        document.getElementById('leavingDate').value = todayStr;
                        document.getElementById('leavingTime').value = currentTime;
                        document.getElementById('returnDate').value = todayStr;
                        document.getElementById('returnTime').value = currentTime;

                        // Show save button
                        const saveContainer = document.getElementById('saveAllContainer');
                        saveContainer.style.display = 'block';

                        // Show success message
                        showFlashNotification('Data added to temporary list', 'success');
                    } else {
                        console.error('Failed to add data to temporary storage:', data.message);
                        showFlashNotification(data.message || 'Failed to add data to temporary list', 'danger');
                    }
                })
                .catch(error => {
                    console.error('Error adding data to temporary storage:', error);
                    showFlashNotification('Error adding data to temporary list', 'danger');
                })
                .finally(() => {
                    // Reset button state
                    addButton.disabled = false;
                    addButton.innerHTML = originalText;
                });
        }

        // Get form data
        function getFormData() {
            const peopleId = document.getElementById('people_id').value;
            const vehicleId = document.getElementById('vehicle_id').value;
            const destinationId = document.getElementById('destination_id').value;

            const peopleDataItem = peopleData?.find(p => p.id == peopleId);
            const vehicleDataItem = vehiclesData?.find(v => v.id == vehicleId);
            const destinationDataItem = destinationsData?.find(d => d.id == destinationId);

            // Combine date and time for leaving and return
            const leavingDate = document.getElementById('leavingDate').value;
            const leavingTime = document.getElementById('leavingTime').value;
            const returnDate = document.getElementById('returnDate').value;
            const returnTime = document.getElementById('returnTime').value;

            const leavingDateTime = leavingDate && leavingTime ? `${leavingDate}T${leavingTime}` : '';
            const returnDateTime = returnDate && returnTime ? `${returnDate}T${returnTime}` : '';

            return {
                people_id: peopleId,
                people_name: peopleDataItem?.name || '',
                vehicle_id: vehicleId,
                vehicle_name: vehicleDataItem?.vehicle_name || '',
                destination_id: destinationId,
                destination_name: destinationDataItem?.destination_name || '',
                leaving_date: leavingDateTime,
                return_date: returnDateTime
            };
        }

        // Validate form data
        function validateFormData(data) {
            if (!data.people_id || !data.vehicle_id || !data.destination_id ||
                !data.leaving_date || !data.return_date) {
                alert('Please fill in all fields');
                return false;
            }

            if (new Date(data.leaving_date) >= new Date(data.return_date)) {
                alert('Return date must be after leaving date');
                return false;
            }

            return true;
        }

        // Reset dropdowns function
        function resetDropdowns() {
            // Reset searchable dropdowns
            const addVehicleDropdown = searchableDropdowns['add-vehicle-dropdown'];
            const addPeopleDropdown = searchableDropdowns['add-people-dropdown'];
            const addDestinationDropdown = searchableDropdowns['add-destination-dropdown'];

            if (addVehicleDropdown) {
                addVehicleDropdown.reset();
            }
            if (addPeopleDropdown) {
                addPeopleDropdown.reset();
            }
            if (addDestinationDropdown) {
                addDestinationDropdown.reset();
            }
        }

        // Submit multiple data
        document.getElementById('submitMultipleBtn').addEventListener('click', function() {
            console.log('Save All button clicked');

            // Show loading state
            const submitBtn = this;
            const originalContent = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';

            // Save all temporary data to main table
            fetch('<?= base_url('vtrip/saveAllTempData') ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('input[name="<?= csrf_token() ?>"]').value
                    },
                    body: JSON.stringify({
                        '<?= csrf_token() ?>': document.querySelector('input[name="<?= csrf_token() ?>"]').value
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Show success notification
                        showFlashNotification(data.message || 'All V-Trip data successfully saved!', 'success');

                        // Reset form and mode with clearing temp data
                        resetMultipleDataMode(true);
                        document.getElementById('addVtripForm').reset();

                        // Close modal
                        const modal = bootstrap.Modal.getInstance(document.getElementById('addVtripModal'));
                        if (modal) {
                            modal.hide();
                        }

                        // Refresh page after a short delay to show notification
                        setTimeout(() => {
                            location.reload();
                        }, 2000);
                    } else {
                        // Show error notification
                        showFlashNotification(data.message || 'Failed to save all data', 'danger');
                        // Re-enable button
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = originalContent;
                    }
                })
                .catch(error => {
                    console.error('Error saving multiple data:', error);
                    showFlashNotification('An error occurred while saving multiple data', 'danger');
                    // Re-enable button
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalContent;
                });
        });

        // Function to check vehicle conflict
        function checkVehicleConflict(vehicleId, leavingDate, returnDate) {
            return fetch('<?= base_url('vtrip/checkVehicleConflict') ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: new URLSearchParams({
                        vehicle_id: vehicleId,
                        leaving_date: leavingDate,
                        return_date: returnDate,
                        '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
                    })
                })
                .then(response => response.json());
        }

        // Single form submission
        document.getElementById('addVtripForm').addEventListener('submit', function(e) {
            e.preventDefault(); // Always prevent default submission to handle conflict checking

            // In multiple mode, prevent normal form submission since we have separate buttons
            if (multipleDataMode) {
                return;
            }

            const form = this;
            const vehicleId = document.getElementById('vehicle_id').value;
            const leavingDate = document.getElementById('leavingDate').value;
            const leavingTime = document.getElementById('leavingTime').value;
            const returnDate = document.getElementById('returnDate').value;
            const returnTime = document.getElementById('returnTime').value;

            // Validate required fields
            if (!vehicleId || !leavingDate || !leavingTime || !returnDate || !returnTime) {
                showFlashNotification('Please fill in all required fields', 'danger');
                return;
            }

            // Combine date and time
            const combinedLeavingDate = `${leavingDate}T${leavingTime}`;
            const combinedReturnDate = `${returnDate}T${returnTime}`;

            // Check for vehicle conflicts first
            checkVehicleConflict(vehicleId, combinedLeavingDate, combinedReturnDate)
                .then(response => {
                    if (response.has_conflict) {
                        // Show vehicle conflict modal
                        const conflictDetails = response.conflict_details;
                        const message = `"${conflictDetails.vehicle_name} - ${conflictDetails.number_plate}" is being used until '${conflictDetails.used_until}' by other personil.`;
                        document.getElementById('vehicleConflictMessage').textContent = message;

                        // Use the same modal configuration as other modals
                        const vehicleConflictModal = bootstrap.Modal.getInstance(document.getElementById('vehicleConflictModal')) ||
                            new bootstrap.Modal(document.getElementById('vehicleConflictModal'), {
                                backdrop: false,
                                keyboard: true,
                                focus: true
                            });
                        vehicleConflictModal.show();
                        return; // Stop submission
                    }

                    // No conflict, proceed with form submission
                    submitFormWithCombinedDates(form, combinedLeavingDate, combinedReturnDate);
                })
                .catch(error => {
                    console.error('Error checking vehicle conflict:', error);
                    // On error, proceed with submission anyway
                    submitFormWithCombinedDates(form, combinedLeavingDate, combinedReturnDate);
                });
        });

        // Helper function to submit form with combined dates
        function submitFormWithCombinedDates(form, leavingDateCombined, returnDateCombined) {
            // Create hidden inputs for combined datetime values
            let leavingHidden = form.querySelector('input[name="leaving_date_combined"]');
            let returnHidden = form.querySelector('input[name="return_date_combined"]');

            if (!leavingHidden) {
                leavingHidden = document.createElement('input');
                leavingHidden.type = 'hidden';
                leavingHidden.name = 'leaving_date_combined';
                form.appendChild(leavingHidden);
            }

            if (!returnHidden) {
                returnHidden = document.createElement('input');
                returnHidden.type = 'hidden';
                returnHidden.name = 'return_date_combined';
                form.appendChild(returnHidden);
            }

            // Set combined values
            leavingHidden.value = leavingDateCombined;
            returnHidden.value = returnDateCombined;

            // Submit the form normally (this will use storeWithFlash and refresh page)
            form.submit();
        }


        // Edit V-Trip Form submission
        document.getElementById('editVtripForm').addEventListener('submit', function(e) {
            e.preventDefault(); // Always prevent default to handle conflict checking

            const form = this;
            const editVtripId = document.getElementById('editVtripId').value;
            const vehicleId = document.getElementById('editVehicleId').value;
            const editLeavingDate = document.getElementById('editLeavingDate').value;
            const editLeavingTime = document.getElementById('editLeavingTime').value;
            const editReturnDate = document.getElementById('editReturnDate').value;
            const editReturnTime = document.getElementById('editReturnTime').value;

            // Validate required fields
            if (!vehicleId || !editLeavingDate || !editLeavingTime || !editReturnDate || !editReturnTime) {
                showFlashNotification('Please fill in all required fields', 'danger');
                return;
            }

            // Combine date and time
            const combinedLeavingDate = `${editLeavingDate}T${editLeavingTime}`;
            const combinedReturnDate = `${editReturnDate}T${editReturnTime}`;

            // Check for vehicle conflicts (excluding current record)
            checkVehicleConflictForEdit(vehicleId, combinedLeavingDate, combinedReturnDate, editVtripId)
                .then(response => {
                    if (response.has_conflict) {
                        // Show vehicle conflict modal
                        const conflictDetails = response.conflict_details;
                        const message = `"${conflictDetails.vehicle_name} - ${conflictDetails.number_plate}" is being used until '${conflictDetails.used_until}' by other personil.`;
                        document.getElementById('vehicleConflictMessage').textContent = message;

                        // Use the same modal configuration as other modals
                        const vehicleConflictModal = bootstrap.Modal.getInstance(document.getElementById('vehicleConflictModal')) ||
                            new bootstrap.Modal(document.getElementById('vehicleConflictModal'), {
                                backdrop: false,
                                keyboard: true,
                                focus: true
                            });
                        vehicleConflictModal.show();
                        return; // Stop submission
                    }

                    // No conflict, proceed with form submission
                    submitEditFormWithCombinedDates(form, combinedLeavingDate, combinedReturnDate);
                })
                .catch(error => {
                    console.error('Error checking vehicle conflict:', error);
                    // On error, proceed with submission anyway
                    submitEditFormWithCombinedDates(form, combinedLeavingDate, combinedReturnDate);
                });
        });

        // Function to check vehicle conflict for edit (excluding current record)
        function checkVehicleConflictForEdit(vehicleId, leavingDate, returnDate, excludeId) {
            return fetch('<?= base_url('vtrip/checkVehicleConflict') ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: new URLSearchParams({
                        vehicle_id: vehicleId,
                        leaving_date: leavingDate,
                        return_date: returnDate,
                        exclude_id: excludeId,
                        '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
                    })
                })
                .then(response => response.json());
        }

        // Helper function to submit edit form with combined dates
        function submitEditFormWithCombinedDates(form, leavingDateCombined, returnDateCombined) {
            // Create hidden inputs for combined datetime values
            let leavingHidden = form.querySelector('input[name="leaving_date_combined"]');
            let returnHidden = form.querySelector('input[name="return_date_combined"]');

            if (!leavingHidden) {
                leavingHidden = document.createElement('input');
                leavingHidden.type = 'hidden';
                leavingHidden.name = 'leaving_date_combined';
                form.appendChild(leavingHidden);
            }

            if (!returnHidden) {
                returnHidden = document.createElement('input');
                returnHidden.type = 'hidden';
                returnHidden.name = 'return_date_combined';
                form.appendChild(returnHidden);
            }

            // Set combined values
            leavingHidden.value = leavingDateCombined;
            returnHidden.value = returnDateCombined;

            // Submit the form normally (this will use updateWithFlash and refresh page)
            form.submit();
        }

        // Edit button click handler
        document.addEventListener('click', function(e) {
            if (e.target.closest('.edit-btn')) {
                const btn = e.target.closest('.edit-btn');
                document.getElementById('editVtripId').value = btn.dataset.id;

                // Set people dropdown value using SearchableDropdown
                const personName = btn.dataset.person;
                const personId = btn.dataset.personId;
                if (personName && personId) {
                    // Update the display input
                    const peopleDisplayInput = document.getElementById('edit-people-display-input');
                    if (peopleDisplayInput) {
                        peopleDisplayInput.value = personName;
                    }
                    // Update the hidden input
                    const peopleHiddenInput = document.getElementById('editPeopleId');
                    if (peopleHiddenInput) {
                        peopleHiddenInput.value = personId;
                    }
                }

                // Set vehicle dropdown value using SearchableDropdown
                const vehicleName = btn.dataset.vehicle;
                const vehicleId = btn.dataset.vehicleId;
                if (vehicleName && vehicleId) {
                    // Find the vehicle data to get the number plate
                    const vehicleDataItem = vehiclesData.find(v => v.id == vehicleId);
                    const displayText = vehicleDataItem ? `${vehicleName} (${vehicleDataItem.number_plate})` : vehicleName;

                    // Update the display input
                    const vehicleDisplayInput = document.getElementById('edit-vehicle-display-input');
                    if (vehicleDisplayInput) {
                        vehicleDisplayInput.value = displayText;
                    }
                    // Update the hidden input
                    const vehicleHiddenInput = document.getElementById('editVehicleId');
                    if (vehicleHiddenInput) {
                        vehicleHiddenInput.value = vehicleId;
                    }
                }

                // Set destination dropdown value using SearchableDropdown
                const destinationName = btn.dataset.destination;
                const destinationId = btn.dataset.destinationId;
                if (destinationName && destinationId) {
                    // Update the display input
                    const destinationDisplayInput = document.getElementById('edit-destination-display-input');
                    if (destinationDisplayInput) {
                        destinationDisplayInput.value = destinationName;
                    }
                    // Update the hidden input
                    const destinationHiddenInput = document.getElementById('editDestinationId');
                    if (destinationHiddenInput) {
                        destinationHiddenInput.value = destinationId;
                    }
                }

                // Split leaving datetime into date and time
                const leavingDateTime = btn.dataset.leave;
                if (leavingDateTime) {
                    const leavingDate = new Date(leavingDateTime);
                    // Use local date formatting to avoid timezone conversion issues
                    const year = leavingDate.getFullYear();
                    const month = String(leavingDate.getMonth() + 1).padStart(2, '0');
                    const day = String(leavingDate.getDate()).padStart(2, '0');
                    document.getElementById('editLeavingDate').value = `${year}-${month}-${day}`;
                    document.getElementById('editLeavingTime').value = leavingDate.toTimeString().slice(0, 5);
                }

                // Split return datetime into date and time
                const returnDateTime = btn.dataset.return;
                if (returnDateTime) {
                    const returnDate = new Date(returnDateTime);
                    // Use local date formatting to avoid timezone conversion issues
                    const year = returnDate.getFullYear();
                    const month = String(returnDate.getMonth() + 1).padStart(2, '0');
                    const day = String(returnDate.getDate()).padStart(2, '0');
                    document.getElementById('editReturnDate').value = `${year}-${month}-${day}`;
                    document.getElementById('editReturnTime').value = returnDate.toTimeString().slice(0, 5);
                }
            }
        });

        // Delete button click handler
        document.addEventListener('click', function(e) {
            if (e.target.closest('.delete-btn')) {
                const btn = e.target.closest('.delete-btn');
                currentDeleteId = btn.dataset.id;
            }

            // Handle delete all trips button
            if (e.target.closest('.delete-person-btn')) {
                e.preventDefault();
                const btn = e.target.closest('.delete-person-btn');
                const personCard = btn.closest('.person-card');
                const vehicleKey = personCard.dataset.vehicle;

                // Parse vehicle name and number plate from the key
                const parts = vehicleKey.split(' - ');
                if (parts.length === 2) {
                    const vehicleName = parts[0];
                    const numberPlate = parts[1];

                    // Store data for deletion
                    currentDeleteAllData = {
                        vehicle_name: vehicleName,
                        number_plate: numberPlate,
                        vehicle_key: vehicleKey
                    };

                    // Update modal message
                    document.getElementById('deleteAllMessage').textContent =
                        `This action will result in the permanent deletion of all trips for ${vehicleKey}. Once deleted, the data cannot be recovered.`;

                    // Show modal
                    const modal = new bootstrap.Modal(document.getElementById('deleteAllTripsModal'));
                    modal.show();
                } else {
                    console.log('Invalid vehicle information');
                }
            }
        });

        // Confirm delete button
        document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
            if (currentDeleteId) {
                // Add config_mode parameter to delete URL
                const currentConfigMode = isConfigMode || (document.querySelector('.config-header') && document.querySelector('.config-header').classList.contains('visible'));
                const deleteUrl = '<?= base_url('vtrip/deleteWithFlash/') ?>' + currentDeleteId + (currentConfigMode ? '?config_mode=1' : '');
                window.location.href = deleteUrl;
            } else {
                console.log('No currentDeleteId set');
            }
        });

        // Confirm delete all button
        document.getElementById('confirmDeleteAllBtn').addEventListener('click', function() {
            if (currentDeleteAllData) {
                // Close modal first
                const modal = bootstrap.Modal.getInstance(document.getElementById('deleteAllTripsModal'));
                if (modal) {
                    modal.hide();
                }

                // Create form and submit to flash message endpoint
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '<?= base_url('vtrip/deleteAllByVehicleWithFlash') ?>';

                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '<?= csrf_token() ?>';
                csrfInput.value = '<?= csrf_hash() ?>';
                form.appendChild(csrfInput);

                const vehicleNameInput = document.createElement('input');
                vehicleNameInput.type = 'hidden';
                vehicleNameInput.name = 'vehicle_name';
                vehicleNameInput.value = currentDeleteAllData.vehicle_name;
                form.appendChild(vehicleNameInput);

                const numberPlateInput = document.createElement('input');
                numberPlateInput.type = 'hidden';
                numberPlateInput.name = 'number_plate';
                numberPlateInput.value = currentDeleteAllData.number_plate;
                form.appendChild(numberPlateInput);

                document.body.appendChild(form);
                form.submit();
            } else {
                console.log('No data selected for deletion');
            }
        });

        // Add to preview table function
        function addToPreviewTable(data, index) {
            const tbody = document.getElementById('dataPreviewBody');
            const row = document.createElement('tr');
            row.style.textAlign = 'center';
            row.style.verticalAlign = 'middle';

            // Find vehicle data to get number_plate
            const vehicleDataItem = vehiclesData?.find(v => v.id == data.vehicle_id);
            const vehicleDisplay = vehicleDataItem ? `${data.vehicle_name} (${vehicleDataItem.number_plate})` : data.vehicle_name;

            row.innerHTML = `
            <td style="text-align: center; vertical-align: middle;">${vehicleDisplay}</td>
            <td style="text-align: center; vertical-align: middle;">${data.people_name}</td>
            <td style="text-align: center; vertical-align: middle;">${data.destination_name}</td>
            <td style="text-align: center; vertical-align: middle;">${formatDateTime(data.leaving_date)}</td>
            <td style="text-align: center; vertical-align: middle;">${formatDateTime(data.return_date)}</td>
            <td style="text-align: center; vertical-align: middle;">
                <button class="btn btn-sm btn-outline-danger" onclick="removeFromPreview(${index})">
                    <i class="bi bi-trash"></i>
                </button>
            </td>
        `;
            tbody.appendChild(row);
        }

        // Format date time function
        function formatDateTime(dateTimeString) {
            const date = new Date(dateTimeString);
            return date.toLocaleDateString('id-ID', {
                day: '2-digit',
                month: 'short',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
        }

        // Remove from preview function
        window.removeFromPreview = function(index) {
            pendingData.splice(index, 1);
            rebuildPreviewTable();
        };

        // Rebuild preview table
        function rebuildPreviewTable() {
            const tbody = document.getElementById('dataPreviewBody');
            tbody.innerHTML = '';
            pendingData.forEach((data, index) => {
                addToPreviewTable(data, index);
            });

            // Hide save button if no data
            if (pendingData.length === 0) {
                document.getElementById('saveAllContainer').style.display = 'none';
            }
        }

        // Reset multiple data mode
        function resetMultipleDataMode(clearTempData = false) {
            console.log('Resetting multiple data mode, clearTempData:', clearTempData);

            document.getElementById('dataPreviewTable').style.display = 'none';
            multipleDataMode = false;

            // Show single mode buttons and remove hidden classes
            const singleModeButtons = document.getElementById('singleModeButtons');
            singleModeButtons.style.display = 'flex';
            singleModeButtons.classList.remove('single-mode-hidden');

            // Hide multiple mode buttons
            const multipleModeButtons = document.getElementById('multipleModeButtons');
            multipleModeButtons.style.display = 'none';
            multipleModeButtons.classList.remove('multiple-mode-visible');

            // Hide save button
            document.getElementById('saveAllContainer').style.display = 'none';

            // Clear preview table
            document.getElementById('dataPreviewBody').innerHTML = '';

            // Only clear temporary storage if explicitly requested (e.g., after successful save)
            if (clearTempData) {
                fetch('<?= base_url('vtrip/clearAllTempData') ?>', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('input[name="<?= csrf_token() ?>"]').value
                        },
                        body: JSON.stringify({
                            '<?= csrf_token() ?>': document.querySelector('input[name="<?= csrf_token() ?>"]').value
                        })
                    })
                    .catch(error => {
                        console.error('Error clearing temporary data:', error);
                    });
            }

            console.log('Multiple data mode reset completed');
        }

        // Show flash-style notification
        function showFlashNotification(message, type) {
            // Create notification element
            const notification = document.createElement('div');
            notification.className = 'flash-notification';
            notification.id = 'flash-notification';
            notification.innerHTML = `
            <div class="alert alert-${type}" role="alert">
                <div class="notification-content">
                    ${message}
                </div>
                <div class="notification-icon">
                    ${type === 'success' ? '<i class="bi bi-check-circle"></i>' : ''}
                    ${type === 'danger' ? '<i class="bi bi-folder-x"></i>' : ''}
                    ${type === 'warning' ? '<i class="bi bi-exclamation-triangle"></i>' : ''}
                    ${type === 'info' ? '<i class="bi bi-info-circle"></i>' : ''}
                </div>
            </div>
        `;

            // Add to document
            document.body.appendChild(notification);

            // Auto-hide after 5 seconds
            setTimeout(function() {
                if (notification.parentNode) {
                    notification.style.opacity = '0';
                    notification.style.transform = 'translateY(-20px)';
                    setTimeout(function() {
                        if (notification.parentNode) {
                            notification.remove();
                        }
                    }, 300);
                }
            }, 5000);
        }

        // Reset form when modal is closed
        document.getElementById('addVtripModal').addEventListener('hidden.bs.modal', function() {
            document.getElementById('addVtripForm').reset();

            // Reset searchable dropdowns
            const addVehicleDropdown = searchableDropdowns['add-vehicle-dropdown'];
            const addPeopleDropdown = searchableDropdowns['add-people-dropdown'];
            const addDestinationDropdown = searchableDropdowns['add-destination-dropdown'];

            if (addVehicleDropdown) {
                addVehicleDropdown.reset();
            }
            if (addPeopleDropdown) {
                addPeopleDropdown.reset();
            }
            if (addDestinationDropdown) {
                addDestinationDropdown.reset();
            }

            resetMultipleDataMode(false); // Don't clear temp data when modal closes
        });

        // Load temporary data when modal is shown (for persistence after refresh)
        document.getElementById('addVtripModal').addEventListener('shown.bs.modal', function() {
            // If there's existing temporary data, load it
            if (!multipleDataMode) {
                // Check if there's any temporary data that should be loaded
                fetch('<?= base_url('vtrip/getTempData') ?>', {
                        method: 'GET',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('input[name="<?= csrf_token() ?>"]').value
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success && data.data.length > 0) {
                            console.log('Found existing temporary data, entering multiple mode automatically');
                            // Automatically enter multiple data mode
                            multipleDataMode = true;

                            // Show data preview table
                            document.getElementById('dataPreviewTable').style.display = 'block';

                            // Hide single mode buttons
                            const singleModeButtons = document.getElementById('singleModeButtons');
                            singleModeButtons.style.display = 'none';
                            singleModeButtons.classList.add('single-mode-hidden');

                            // Show multiple mode buttons
                            const multipleModeButtons = document.getElementById('multipleModeButtons');
                            multipleModeButtons.style.display = 'block';
                            multipleModeButtons.classList.add('multiple-mode-visible');

                            // Load the data
                            loadTempDataToPreview();
                        }
                    })
                    .catch(error => {
                        console.log('No existing temporary data or error loading:', error);
                    });
            }
        });

        // Set default dates to today
        const today = new Date();
        const todayStr = today.toISOString().slice(0, 10);
        const currentTime = today.toTimeString().slice(0, 5);
        document.getElementById('leavingDate').value = todayStr;
        document.getElementById('leavingTime').value = currentTime;
        document.getElementById('returnDate').value = todayStr;
        document.getElementById('returnTime').value = currentTime;

        // Multiple Data Mode button handlers
        document.getElementById('addMultipleBtn').addEventListener('click', function() {
            console.log('Switching to multiple data mode');
            multipleDataMode = true;

            // Hide single mode buttons
            const singleModeButtons = document.getElementById('singleModeButtons');
            singleModeButtons.style.display = 'none';
            singleModeButtons.classList.add('single-mode-hidden');

            // Show multiple mode buttons
            const multipleModeButtons = document.getElementById('multipleModeButtons');
            multipleModeButtons.style.display = 'block';
            multipleModeButtons.classList.add('multiple-mode-visible');

            // Show data preview table if it has data
            if (pendingData.length > 0) {
                document.getElementById('dataPreviewTable').style.display = 'block';
                document.getElementById('saveAllContainer').style.display = 'block';
            }

            console.log('Multiple data mode activated');
        });


        // Configuration mode functions
        function initializeConfigMode() {
            updateFormConfigMode(isConfigMode);

            if (isConfigMode) {
                showConfigurationMode();
            } else {
                returnToInitialState();
            }
        }

        function showConfigurationMode() {
            console.log('Entering configuration mode');

            // Change title
            const pageTitle = document.getElementById('page-title');
            if (pageTitle) {
                console.log('Changing page title to "Konfigurasi V-Trip"');
                pageTitle.textContent = 'Konfigurasi V-Trip';
            } else {
                console.error('Page title element not found!');
            }

            // Add configuration mode class to page container
            const pageContainer = document.querySelector('.page-container');
            if (pageContainer) {
                console.log('Adding config-mode class to page container');
                pageContainer.classList.add('config-mode');
            } else {
                console.error('Page container not found!');
            }

            // Show configuration header
            const configHeader = document.getElementById('config-header');
            if (configHeader) {
                console.log('Adding visible class to config header');
                configHeader.classList.add('visible');
                console.log('Config header classes after adding visible:', configHeader.className);
            } else {
                console.error('Config header element not found!');
            }

            // Show action buttons
            const addButton = document.getElementById('add-vtrip-btn');
            const backButton = document.getElementById('back-button');
            if (addButton) {
                console.log('Showing add button');
                addButton.classList.remove('hidden');
                addButton.classList.add('visible');
            } else {
                console.error('Add button element not found!');
            }
            if (backButton) {
                console.log('Showing back button');
                backButton.classList.remove('hidden');
                backButton.classList.add('visible');
            } else {
                console.error('Back button element not found!');
            }

            // Show all edit/delete actions
            const scheduleActions = document.querySelectorAll('.schedule-actions');
            scheduleActions.forEach(actions => {
                console.log('Showing schedule action:', actions);
                actions.classList.remove('hidden');
                actions.classList.add('visible');
            });

            // Show vehicle delete actions
            const personActions = document.querySelectorAll('.person-actions');
            personActions.forEach(actions => {
                console.log('Showing person action:', actions);
                actions.classList.remove('hidden');
                actions.classList.add('visible');
            });

            // Hide trigger
            const floatingTriggerContainer = document.querySelector('.floating-trigger-container');
            if (floatingTriggerContainer) {
                console.log('Hiding floating trigger');
                floatingTriggerContainer.classList.add('hidden');
            } else {
                console.error('Floating trigger container not found!');
            }

            // Hide main search container in config mode
            const mainSearchContainer = document.querySelector('.main-search-container');
            if (mainSearchContainer) {
                console.log('Hiding main search container');
                mainSearchContainer.style.display = 'none';
            } else {
                console.error('Main search container not found!');
            }

            console.log('Configuration mode activated');
        }

        function returnToInitialState() {
            console.log('Returning to initial state');

            // Change title back
            const pageTitle = document.getElementById('page-title');
            if (pageTitle) {
                pageTitle.textContent = 'V-Trip';
            }

            // Remove configuration mode class from page container
            const pageContainer = document.querySelector('.page-container');
            if (pageContainer) {
                pageContainer.classList.remove('config-mode');
            }

            // Hide configuration header
            const configHeader = document.getElementById('config-header');
            if (configHeader) {
                configHeader.classList.remove('visible');
            }

            // Hide action buttons
            const addButton = document.getElementById('add-vtrip-btn');
            const backButton = document.getElementById('back-button');
            if (addButton) {
                addButton.classList.remove('visible');
                addButton.classList.add('hidden');
            }
            if (backButton) {
                backButton.classList.remove('visible');
                backButton.classList.add('hidden');
            }

            // Hide all edit/delete actions
            const scheduleActions = document.querySelectorAll('.schedule-actions');
            scheduleActions.forEach(actions => {
                actions.classList.remove('visible');
                actions.classList.add('hidden');
            });

            // Hide vehicle delete actions
            const personActions = document.querySelectorAll('.person-actions');
            personActions.forEach(actions => {
                actions.classList.remove('visible');
                actions.classList.add('hidden');
            });

            // Show trigger
            const floatingTriggerContainer = document.querySelector('.floating-trigger-container');
            if (floatingTriggerContainer) {
                console.log('Showing floating trigger');
                floatingTriggerContainer.classList.remove('hidden');
            } else {
                console.error('Floating trigger container not found!');
            }

            // Show main search container
            const mainSearchContainer = document.querySelector('.main-search-container');
            if (mainSearchContainer) {
                console.log('Showing main search container');
                mainSearchContainer.style.display = 'block';
            } else {
                console.error('Main search container not found!');
            }

            console.log('Initial state restored');
        }

        // Date validation for add form
        document.getElementById('leavingDate').addEventListener('change', function() {
            const returnDateInput = document.getElementById('returnDate');
            if (this.value && returnDateInput.value && new Date(this.value) > new Date(returnDateInput.value)) {
                returnDateInput.value = this.value;
            }
        });

        document.getElementById('returnDate').addEventListener('change', function() {
            const leavingDateInput = document.getElementById('leavingDate');
            if (this.value && leavingDateInput.value && new Date(this.value) < new Date(leavingDateInput.value)) {
                alert('Return date cannot be earlier than leaving date');
                this.value = leavingDateInput.value;
            }
        });

        // Time validation for add form - ensure return time is after leaving time on same date
        function validateDateTime() {
            const leavingDate = document.getElementById('leavingDate').value;
            const leavingTime = document.getElementById('leavingTime').value;
            const returnDate = document.getElementById('returnDate').value;
            const returnTime = document.getElementById('returnTime').value;

            if (leavingDate && leavingTime && returnDate && returnTime) {
                const leavingDateTime = new Date(`${leavingDate}T${leavingTime}`);
                const returnDateTime = new Date(`${returnDate}T${returnTime}`);

                if (returnDateTime <= leavingDateTime) {
                    alert('Return date and time must be after leaving date and time');
                    return false;
                }
            }
            return true;
        }

        document.getElementById('leavingTime').addEventListener('change', validateDateTime);
        document.getElementById('returnTime').addEventListener('change', validateDateTime);

        // Edit form date and time validation
        document.getElementById('editLeavingDate').addEventListener('change', function() {
            const returnDateInput = document.getElementById('editReturnDate');
            if (this.value && returnDateInput.value && new Date(this.value) > new Date(returnDateInput.value)) {
                returnDateInput.value = this.value;
            }
        });

        document.getElementById('editReturnDate').addEventListener('change', function() {
            const leavingDateInput = document.getElementById('editLeavingDate');
            if (this.value && leavingDateInput.value && new Date(this.value) < new Date(leavingDateInput.value)) {
                alert('Return date cannot be earlier than leaving date');
                this.value = leavingDateInput.value;
            }
        });

        // Edit form time validation - ensure return time is after leaving time
        function validateEditDateTime() {
            const leavingDate = document.getElementById('editLeavingDate').value;
            const leavingTime = document.getElementById('editLeavingTime').value;
            const returnDate = document.getElementById('editReturnDate').value;
            const returnTime = document.getElementById('editReturnTime').value;

            if (leavingDate && leavingTime && returnDate && returnTime) {
                const leavingDateTime = new Date(`${leavingDate}T${leavingTime}`);
                const returnDateTime = new Date(`${returnDate}T${returnTime}`);

                if (returnDateTime <= leavingDateTime) {
                    alert('Return date and time must be after leaving date and time');
                    return false;
                }
            }
            return true;
        }

        document.getElementById('editLeavingTime').addEventListener('change', validateEditDateTime);
        document.getElementById('editReturnTime').addEventListener('change', validateEditDateTime);

        // Filter functionality
        document.querySelectorAll('[data-filter]').forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                const filterType = this.dataset.filter;
                const today = new Date();

                // Get all date group containers
                const dateContainers = document.querySelectorAll('.vtrip-main-container');

                dateContainers.forEach(container => {
                    const personCards = container.querySelectorAll('.person-card');
                    let hasVisibleContent = false;

                    // First, reset all cards and schedules to be visible
                    personCards.forEach(card => {
                        card.style.display = 'block';
                        const schedules = card.querySelectorAll('.schedule-card');
                        schedules.forEach(schedule => {
                            schedule.style.display = 'flex';
                        });
                    });

                    // Then apply the filter
                    personCards.forEach(card => {
                        const schedules = card.querySelectorAll('.schedule-card');
                        let hasVisibleSchedule = false;

                        schedules.forEach(schedule => {
                            const scheduleDate = new Date(schedule.dataset.date);
                            let show = true;

                            // Create comparable date strings (YYYY-MM-DD format)
                            const todayString = today.getFullYear() + '-' +
                                String(today.getMonth() + 1).padStart(2, '0') + '-' +
                                String(today.getDate()).padStart(2, '0');
                            const scheduleDateString = scheduleDate.getFullYear() + '-' +
                                String(scheduleDate.getMonth() + 1).padStart(2, '0') + '-' +
                                String(scheduleDate.getDate()).padStart(2, '0');

                            switch (filterType) {
                                case 'today':
                                    // For today filter, check if we're in the Today section OR if the date matches today
                                    const isInTodaySection = container.querySelector('.today-header')?.textContent.trim() === 'Today';
                                    show = isInTodaySection || scheduleDateString === todayString;
                                    break;
                                case 'week':
                                    const weekFromNow = new Date(today.getTime() + 7 * 24 * 60 * 60 * 1000);
                                    // Special case: if in Today section, always show regardless of date comparison
                                    const isInTodaySectionWeek = container.querySelector('.today-header')?.textContent.trim() === 'Today';
                                    if (isInTodaySectionWeek) {
                                        show = true; // Always show cards in Today section
                                    } else {
                                        show = scheduleDate >= today && scheduleDate <= weekFromNow;
                                    }
                                    break;
                                case 'month':
                                    const monthFromNow = new Date(today.getTime() + 30 * 24 * 60 * 60 * 1000);
                                    // Special case: if in Today section, always show regardless of date comparison
                                    const isInTodaySectionMonth = container.querySelector('.today-header')?.textContent.trim() === 'Today';
                                    if (isInTodaySectionMonth) {
                                        show = true; // Always show cards in Today section
                                    } else {
                                        show = scheduleDate >= today && scheduleDate <= monthFromNow;
                                    }
                                    break;
                                case '3month':
                                    const threeMonthFromNow = new Date(today.getTime() + 90 * 24 * 60 * 60 * 1000);
                                    // Special case: if in Today section, always show regardless of date comparison
                                    const isInTodaySection3Month = container.querySelector('.today-header')?.textContent.trim() === 'Today';
                                    if (isInTodaySection3Month) {
                                        show = true; // Always show cards in Today section
                                    } else {
                                        show = scheduleDate >= today && scheduleDate <= threeMonthFromNow;
                                    }
                                    break;
                                case 'all':
                                default:
                                    // Special case: if in Today section, always show regardless of date comparison
                                    const isInTodaySectionAll = container.querySelector('.today-header')?.textContent.trim() === 'Today';
                                    if (isInTodaySectionAll) {
                                        show = true; // Always show cards in Today section
                                    } else {
                                        show = scheduleDate >= today; // Only show future schedules for 'all'
                                    }
                            }

                            schedule.style.display = show ? 'flex' : 'none';
                            if (show) hasVisibleSchedule = true;
                        });

                        card.style.display = hasVisibleSchedule ? 'block' : 'none';
                        if (hasVisibleSchedule) hasVisibleContent = true;
                    });

                    // Show/hide entire date container
                    const isToday = container.querySelector('.today-header')?.textContent.trim() === 'Today';
                    let shouldShow = hasVisibleContent;

                    // Special logic for different filters
                    if (filterType === 'today') {
                        // For today filter: only show Today section, hide other sections
                        shouldShow = isToday;
                    } else {
                        // For other filters: show if has content
                        // Special case: Always show Today section if it exists and filter is not 'today'
                        if (isToday) {
                            // Always show Today section for non-today filters, regardless of content
                            shouldShow = true;
                        } else {
                            // For future date sections, show only if has visible content
                            shouldShow = hasVisibleContent;
                        }
                    }

                    container.style.display = shouldShow ? 'block' : 'none';
                });

                // Update button text and add active state
                const filterButton = document.getElementById('filterDropdown');
                filterButton.innerHTML = this.textContent + ' <i class="bi bi-chevron-down"></i>';

                // Remove active class from all filter buttons
                document.querySelectorAll('[data-filter]').forEach(btn => {
                    btn.parentElement.parentElement.querySelector('.filter-btn').classList.remove('active');
                });

                // Add active class to current button
                filterButton.classList.add('active');
            });
        });

        // Search functionality (for both search inputs)
        const searchInput = document.getElementById('searchInput');
        const mainSearchInput = document.getElementById('mainSearchInput');
        const searchSuggestions = document.getElementById('searchSuggestions');

        function performSearch(query) {
            const dateContainers = document.querySelectorAll('.vtrip-main-container');

            dateContainers.forEach(container => {
                const personCards = container.querySelectorAll('.person-card');
                let hasVisibleInContainer = false;

                personCards.forEach(card => {
                    const vehicleName = card.dataset.vehicle.toLowerCase();
                    const scheduleCards = card.querySelectorAll('.schedule-card');
                    let hasMatch = false;

                    scheduleCards.forEach(schedule => {
                        const personName = schedule.querySelector('.destination-name').textContent.toLowerCase();
                        const destination = schedule.querySelector('.request-info').textContent.toLowerCase();

                        if (vehicleName.includes(query) || personName.includes(query) || destination.includes(query)) {
                            schedule.style.display = 'flex';
                            hasMatch = true;
                        } else {
                            schedule.style.display = 'none';
                        }
                    });

                    card.style.display = hasMatch || query === '' ? 'block' : 'none';
                    if (hasMatch || query === '') hasVisibleInContainer = true;
                });

                // Hide entire date container if no visible content
                // Exception: Always show Today section even if empty
                const isToday = container.querySelector('.today-header')?.textContent.trim() === 'Today';
                const shouldShow = hasVisibleInContainer || (isToday && query === '');
                container.style.display = shouldShow ? 'block' : 'none';
            });
        }

        if (searchInput) {
            searchInput.addEventListener('input', function() {
                const query = this.value.toLowerCase();
                performSearch(query);
                // Sync with main search input
                if (mainSearchInput) {
                    mainSearchInput.value = this.value;
                }
            });
        }

        if (mainSearchInput) {
            mainSearchInput.addEventListener('input', function() {
                const query = this.value.toLowerCase();
                performSearch(query);
                // Sync with config search input
                if (searchInput) {
                    searchInput.value = this.value;
                }
            });
        }

        // Sort functionality
        document.querySelectorAll('[data-sort]').forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                const sortType = this.dataset.sort;

                // Get all date containers and sort vehicles within each container
                const dateContainers = document.querySelectorAll('.vtrip-main-container');

                dateContainers.forEach(container => {
                    const vtripContent = container.querySelector('.vtrip-content');
                    const cards = Array.from(vtripContent.querySelectorAll('.person-card'));

                    cards.sort((a, b) => {
                        const nameA = a.dataset.vehicle.toLowerCase();
                        const nameB = b.dataset.vehicle.toLowerCase();
                        return sortType === 'asc' ? nameA.localeCompare(nameB) : nameB.localeCompare(nameA);
                    });

                    cards.forEach(card => vtripContent.appendChild(card));
                });

                // Update button text and add active state
                const sortButton = document.getElementById('sortDropdown');
                sortButton.innerHTML = this.textContent + ' <i class="bi bi-chevron-down"></i>';

                // Remove active class from all sort buttons
                document.querySelectorAll('[data-sort]').forEach(btn => {
                    btn.parentElement.parentElement.querySelector('.filter-btn').classList.remove('active');
                });

                // Add active class to current button
                sortButton.classList.add('active');
            });
        });

        function validateEditDateTime() {
            const leavingDate = document.getElementById('editLeavingDate').value;
            const leavingTime = document.getElementById('editLeavingTime').value;
            const returnDate = document.getElementById('editReturnDate').value;
            const returnTime = document.getElementById('editReturnTime').value;

            if (leavingDate && leavingTime && returnDate && returnTime) {
                const leavingDateTime = new Date(`${leavingDate}T${leavingTime}`);
                const returnDateTime = new Date(`${returnDate}T${returnTime}`);

                if (returnDateTime <= leavingDateTime) {
                    alert('Return date and time must be after leaving date and time');
                    return false;
                }
            }
            return true;
        }

        document.getElementById('editLeavingTime').addEventListener('change', validateEditDateTime);
        document.getElementById('editReturnTime').addEventListener('change', validateEditDateTime);

        // Force modal elements to be clickable when modals are shown
        const modals = ['addVtripModal', 'editVtripModal', 'deleteVtripModal', 'deleteAllTripsModal', 'scheduleWarningModal', 'scheduleErrorModal', 'vehicleConflictModal'];

        modals.forEach(modalId => {
            const modalElement = document.getElementById(modalId);
            if (modalElement) {
                // Remove any existing modal instances
                const existingInstance = bootstrap.Modal.getInstance(modalElement);
                if (existingInstance) {
                    existingInstance.dispose();
                }

                // Create new modal instance WITHOUT backdrop
                const modalInstance = new bootstrap.Modal(modalElement, {
                    backdrop: false, // DISABLE BACKDROP COMPLETELY
                    keyboard: true,
                    focus: true
                });

                modalElement.addEventListener('shown.bs.modal', function() {
                    console.log('Modal shown:', modalId);

                    // Clean up any backdrop elements that might have been created
                    document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());

                    // Force all modal elements to be interactive
                    const modalElements = modalElement.querySelectorAll('input, button, select, textarea, .form-control, .btn, .form-select');
                    modalElements.forEach(element => {
                        element.style.pointerEvents = 'auto';
                        element.style.position = 'relative';
                        element.style.zIndex = '100001';
                    });

                    // Focus on first input if available
                    const firstInput = modalElement.querySelector('input, select, textarea');
                    if (firstInput) {
                        setTimeout(() => {
                            firstInput.focus();
                        }, 150);
                    }
                });

                modalElement.addEventListener('hidden.bs.modal', function() {
                    console.log('Modal hidden:', modalId);
                    // Clean up any remaining backdrop elements
                    document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
                    document.body.classList.remove('modal-open');
                    document.body.style.overflow = '';
                    document.body.style.paddingRight = '';
                });
            }
        });

        // Override default modal trigger behavior to use our custom instances
        document.addEventListener('click', function(e) {
            const trigger = e.target.closest('[data-bs-toggle="modal"]');
            if (trigger) {
                e.preventDefault();
                const targetModal = trigger.getAttribute('data-bs-target');
                if (targetModal) {
                    const modalElement = document.querySelector(targetModal);
                    if (modalElement && modals.includes(modalElement.id)) {
                        const modalInstance = bootstrap.Modal.getInstance(modalElement) || new bootstrap.Modal(modalElement, {
                            backdrop: false,
                            keyboard: true,
                            focus: true
                        });
                        modalInstance.show();
                    }
                }
            }
        });


        // Debug function to test search inputs
        function testSearchInputs() {
            console.log('Testing all search inputs...');
            const searchInputs = document.querySelectorAll('.searchable-dropdown-input');
            searchInputs.forEach((input, index) => {
                console.log(`Input ${index}:`, {
                    element: input,
                    readOnly: input.readOnly,
                    disabled: input.disabled,
                    style: input.style.cssText,
                    value: input.value
                });

                // Force enable each input
                input.readOnly = false;
                input.disabled = false;
                input.removeAttribute('readonly');
                input.removeAttribute('disabled');
                input.style.pointerEvents = 'auto';
                input.style.userSelect = 'text';
                input.style.background = 'white';
                input.style.color = '#495057';
            });
        }

        // Test inputs after a delay
        setTimeout(testSearchInputs, 1000);

        // Function to load existing temporary data into preview table
        function loadTempDataToPreview() {
            fetch('<?= base_url('vtrip/getTempData') ?>', {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('input[name="<?= csrf_token() ?>"]').value
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success && data.data.length > 0) {
                        console.log('Loading existing temporary data:', data.data);

                        // Clear existing preview
                        const tbody = document.getElementById('dataPreviewBody');
                        tbody.innerHTML = '';

                        // Add each temp data item to preview
                        data.data.forEach((item, index) => {
                            const formattedItem = {
                                id: item.id,
                                vehicle_id: item.vehicle_id,
                                vehicle_name: item.vehicle_name,
                                number_plate: item.number_plate,
                                people_id: item.people_id,
                                people_name: item.people_name,
                                leaveDate: item.leave_date,
                                returnDate: item.return_date,
                                destination_id: item.destination_id,
                                destination_name: item.destination_name
                            };
                            addToPreviewTableFromTemp(formattedItem, index);
                        });

                        // Show save button if there's data
                        if (data.data.length > 0) {
                            const saveContainer = document.getElementById('saveAllContainer');
                            saveContainer.style.display = 'block';
                        }
                    }
                })
                .catch(error => {
                    console.error('Error loading temporary data:', error);
                });
        }

        // Add to preview table function (from temporary storage)
        function addToPreviewTableFromTemp(data, index) {
            const tbody = document.getElementById('dataPreviewBody');
            const row = document.createElement('tr');
            row.style.textAlign = 'center';
            row.style.verticalAlign = 'middle';
            row.dataset.tempId = data.id; // Store temporary ID for deletion

            // Add visual indicator if this item was force added
            const forceAddedIndicator = data._forceAdded ?
                '<span class="badge bg-warning text-dark ms-1" title="Added despite vehicle conflict">⚠️</span>' : '';

            row.innerHTML = `
            <td style="text-align: center; vertical-align: middle;">${data.vehicle_name} (${data.number_plate})${forceAddedIndicator}</td>
            <td style="text-align: center; vertical-align: middle;">${data.people_name}</td>
            <td style="text-align: center; vertical-align: middle;">${data.destination_name}</td>
            <td style="text-align: center; vertical-align: middle;">${formatDateTime(data.leaveDate)}</td>
            <td style="text-align: center; vertical-align: middle;">${formatDateTime(data.returnDate)}</td>
            <td style="text-align: center; vertical-align: middle;">
                <button class="btn btn-sm btn-outline-danger" onclick="removeFromTempPreview('${data.id}')">
                    <i class="bi bi-trash"></i>
                </button>
            </td>
        `;
            tbody.appendChild(row);
        }

        // Remove from preview function (temporary storage)
        window.removeFromTempPreview = function(tempId) {
            if (!tempId) {
                console.error('No temporary ID provided for deletion');
                return;
            }

            // Show loading state
            const button = document.querySelector(`tr[data-temp-id="${tempId}"] button`);
            if (button) {
                button.disabled = true;
                button.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';
            }

            // Delete from backend temporary storage
            fetch(`<?= base_url('vtrip/deleteTempData/') ?>${tempId}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('input[name="<?= csrf_token() ?>"]').value
                    },
                    body: JSON.stringify({
                        '<?= csrf_token() ?>': document.querySelector('input[name="<?= csrf_token() ?>"]').value
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Remove row from table
                        const row = document.querySelector(`tr[data-temp-id="${tempId}"]`);
                        if (row) {
                            row.remove();
                        }

                        // Hide save button if no more data
                        const tbody = document.getElementById('dataPreviewBody');
                        if (tbody.children.length === 0) {
                            document.getElementById('saveAllContainer').style.display = 'none';
                        }

                        showFlashNotification('Item removed from list', 'success');
                    } else {
                        console.error('Failed to delete temporary data:', data.message);
                        showFlashNotification(data.message || 'Failed to remove item', 'danger');
                    }
                })
                .catch(error => {
                    console.error('Error deleting temporary data:', error);
                    showFlashNotification('Error removing item from list', 'danger');
                })
                .finally(() => {
                    // Reset button state
                    if (button) {
                        button.disabled = false;
                        button.innerHTML = '<i class="bi bi-trash"></i>';
                    }
                });
        };
    });
</script>

<?= $this->endSection() ?>