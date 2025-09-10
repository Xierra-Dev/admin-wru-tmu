<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<style>
/* ===========================
   CSS Kustom untuk Halaman M-Loc - New Design
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
}

.filter-btn:hover {
    background: #FF8C00;
    color: white;
}

.filter-btn.active {
    border-color: #FF6600;
    box-shadow: 0 0 0 1px #FF6600;
}

/* White background container starting from M-Loc title */
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
    padding: 25px 20px;
    position: sticky;
    top: 0;
    z-index: 10000;
    background: transparent;
    border-radius: 10px;
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
    max-width: 400px;
    margin: 0 20px;
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
.mloc-main-container {
    background: white;
    border-radius: 15px;
    padding: 0;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    width: 100%;
    max-width: none;
    border: 3px solid #007bff; /* Blue border around container */
}

.today-header {
    background: #007bff;
    color: white;
    padding: 15px 20px;
    font-size: 1.2rem;
    font-weight: 600;
    margin: 0;
    border-top-left-radius: 12px; /* Match the container border radius minus border width */
    border-top-right-radius: 12px;
}

.mloc-content {
    padding: 20px;
    width: 100%;
    box-sizing: border-box;
    background: white;
    border-bottom-left-radius: 12px; /* Match the container border radius minus border width */
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
    color: #000; /* Black color for person name */
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
    grid-template-columns: 1fr 1fr; /* 2 columns layout */
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
    padding: 0; /* Remove padding to allow full-width sections */
    flex: 1;
    min-width: 280px;
    display: flex;
    align-items: stretch; /* Make sections same height */
    gap: 0; /* Remove gap between sections */
    position: relative;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    box-sizing: border-box;
    height: 80px; /* Fixed height for consistency */
    overflow: hidden; /* Ensure clean borders */
}

@media (max-width: 1200px) {
    .schedules-container {
        grid-template-columns: 1fr; /* Single column on smaller screens */
    }
    
    .schedule-card {
        min-width: 250px;
    }
}

@media (min-width: 769px) and (max-width: 1024px) {
    .schedules-container {
        grid-template-columns: 1fr 1fr; /* 2 columns on medium screens */
        gap: 12px;
    }
}

.schedule-number {
    background: #007bff;
    color: white;
    width: 5%; /* 5% left section */
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 1.2rem;
    flex-shrink: 0;
}

.schedule-content {
    width: 90%; /* 90% center section when icon present */
    padding: 15px;
    display: flex;
    align-items: center;
    gap: 15px;
    background: white;
    flex: 1;
}

/* When no letter icon is present, expand content area */
.schedule-card-no-icon .schedule-content {
    width: 95%; /* 95% when no red section */
}

.schedule-info {
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.schedule-dates {
    text-align: right;
    font-size: 0.8rem;
    color: #000; /* Black text for better visibility */
    min-width: 120px;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.schedule-task-icon {
    background: #FE0000;
    color: white;
    width: 5%; /* 5% right section */
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    flex-shrink: 0;
}

.destination-name {
    font-weight: 600;
    color: #000; /* Black text for better visibility */
    margin-bottom: 5px;
    font-size: 1rem;
}

.request-info {
    color: #000; /* Black text for better visibility */
    font-size: 0.85rem;
}

.schedule-dates-info {
    margin-top: 5px;
    color: #000; /* Black text for better visibility */
    font-size: 0.75rem;
}

.date-info {
    margin-bottom: 3px;
}

.date-info small {
    color: #000; /* Black text for better visibility */
}

/* Action Buttons */
.schedule-actions {
    display: flex;
    flex-direction: column;
    gap: 6px;
    margin-left: 15px;
    z-index: 5;
}

.action-btn {
    background: transparent;
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
    }
    
    .filter-btn {
        min-width: 70px;
        padding: 8px 16px;
    }
    
    .schedules-container {
        grid-template-columns: 1fr; /* Single column on mobile */
    }
    
    .schedule-card {
        min-width: 250px;
        height: 90px; /* Slightly taller on mobile */
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
        font-size: 1rem; /* Smaller font on mobile */
    }
    
    .schedule-task-icon {
        font-size: 1rem; /* Smaller icon on mobile */
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
    }
    
    /* Mobile modal adjustments */
    .modal.show {
        padding-top: calc(var(--global-navbar-height) - 10px) !important; /* Reduced padding for mobile */
    }
    
    .modal-dialog {
        margin: 1rem; /* Smaller margin on mobile */
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
}

/* Configuration mode adjustments */
.page-container.config-mode {
    padding-top: 0;
}

.page-container.config-mode .main-search-container {
    display: none;
}

@media (max-width: 768px) {
    .page-container.config-mode {
        padding-top: 0;
    }
    
    .config-header {
        position: sticky;
        top: 0;
        left: auto;
        right: auto;
        padding: 20px;
        flex-direction: column;
        gap: 12px;
        z-index: 10000;
        background: transparent;
    }
    
    .search-container {
        margin: 0;
        max-width: 100%;
    }
}

/* ===========================
   PERBAIKAN Z-INDEX (Modal di atas elemen lainnya)
   =========================== */
/* Pastikan backdrop dan modal lebih tinggi dari alert / fab / dropdown */
.modal-backdrop {
    z-index: 99998 !important;
}
.modal, .modal.show {
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
.modal .btn {
    pointer-events: auto !important;
    z-index: inherit !important;
}

/* Turunkan notifikasi / elemen lain agar tidak menutupi modal */
.alert-notification {
    position: fixed;
    top: calc(70px + 20px); /* Navbar height + 20px margin */
    left: 50%;
    transform: translateX(-50%);
    z-index: 1800; /* < modal z-index */
    min-width: 300px;
    border-radius: 10px;
}

/* Search suggestions dan FAB agar tetap di bawah modal */
.search-suggestions {
    z-index: 1700; /* < modal z-index */
}
.fab {
    z-index: 1600; /* < modal z-index */
}

/* Jika elemen mloc-card tidak perlu berada di atas, beri z-index rendah */
.mloc-card {
    z-index: 1;
    position: relative; /* tetap relative untuk layout, tapi z-index kecil */
}

/* ===========================
   Modal Styles
   =========================== */
/* Custom modal overlay that doesn't block interactions */
.modal.show {
    background: rgba(0, 0, 0, 0.4) !important;
    padding-top: 80px !important; /* Add top padding to avoid navbar overlap */
}

.modal-dialog {
    margin-top: 2rem; /* Additional margin to ensure clearance from navbar */
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

/* Form floating tweaks */
.form-floating > .form-control {
    height: 3.5rem;
    padding: 1rem 0.75rem;
}

.form-floating > label {
    padding: 1rem 0.75rem;
}

.modal-form-row {
    display: flex;
    gap: 15px;
    margin-bottom: 1rem;
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
    color: white;
    transition: all 0.3s ease;
}

.btn-primary-custom:hover {
    background: #0056b3 !important;
    border-color: #0056b3 !important;
    color: white !important;
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0, 123, 255, 0.3);
}

.btn-warning-custom {
    background: #ffc107;
    border: #ffc107;
    color: #000;
    border-radius: 25px;
    padding: 10px 30px;
    transition: all 0.3s ease;
}

.btn-warning-custom:hover {
    background: #e0a800 !important;
    border-color: #e0a800 !important;
    color: #000 !important;
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(255, 193, 7, 0.4);
}

/* Multiple data mode buttons */
.btn-add-multiple {
    background: #20B2AA; /* Dark Turquoise/Tosca */
    border: 2px solid #20B2AA;
    color: white;
    border-radius: 25px;
    padding: 12px 40px;
    font-weight: 500;
    transition: all 0.3s ease;
    width: 100%; /* Full width */
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
#addMlocModal .save-all-container {
    position: absolute;
    bottom: 20px;
    right: 20px;
    z-index: 100001;
}

/* Ensure positioning context */
#addMlocModal .modal-dialog {
    position: relative;
}

#addMlocModal .modal-content {
    position: relative;
}

.btn-save-all {
    background: #28a745;
    border: 2px solid #28a745;
    color: white;
    border-radius: 50%; /* Circular button */
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
    padding-bottom: 80px; /* Add padding to prevent overlap with save button */
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
    
    #addMlocModal .save-all-container {
        position: absolute;
        bottom: 15px;
        right: 15px;
        z-index: 100001;
    }
    
    .btn-add-multiple {
        padding: 10px 30px;
        font-size: 14px;
        width: 100%; /* Maintain full width on mobile */
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
        padding-bottom: 70px; /* Add padding to prevent overlap with save button */
    }
}

/* Warning Modal Styles */
.warning-modal .modal-content {
    border-radius: 15px;
    border: none;
    text-align: center;
    max-width: 500px;
    margin: 0 auto;
    width: 90%;
}

.warning-modal .modal-dialog {
    max-width: 500px;
    width: 90%;
    margin: 1.75rem auto;
}

.warning-modal .modal-body {
    padding: 2rem;
}

.schedule-conflict-icon {
    width: 80px;
    height: 80px;
    background: #FFA500;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem auto;
    position: relative;
}

.schedule-conflict-icon i {
    font-size: 2.5rem;
    color: white;
}

.schedule-conflict-icon::after {
    content: '!';
    position: absolute;
    bottom: -5px;
    right: 10px;
    background: #FFD700;
    color: #000;
    width: 25px;
    height: 25px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 1rem;
    border: 2px solid white;
}

.conflict-warning-title {
    font-size: 1.5rem;
    font-weight: bold;
    color: #333;
    margin-bottom: 1rem;
}

.conflict-message {
    color: #666;
    margin-bottom: 1rem;
    line-height: 1.5;
}

.conflict-question {
    color: #333;
    font-weight: 500;
    margin-bottom: 2rem;
}

.conflict-buttons {
    display: flex;
    gap: 1rem;
    justify-content: center;
}

.btn-secondary-modal {
    background: #6c757d;
    border: none;
    color: white;
    border-radius: 25px;
    padding: 10px 30px;
    font-weight: 500;
    transition: all 0.3s ease;
    min-width: 100px;
}

.btn-secondary-modal:hover {
    background: #5a6268;
    color: white;
    transform: translateY(-1px);
}

.btn-primary-modal {
    background: #007bff;
    border: none;
    color: white;
    border-radius: 25px;
    padding: 10px 30px;
    font-weight: 500;
    transition: all 0.3s ease;
    min-width: 100px;
}

.btn-primary-modal:hover {
    background: #0056b3;
    color: white;
    transform: translateY(-1px);
}

/* Responsive design for warning modal */
@media (max-width: 768px) {
    .warning-modal .modal-content {
        margin: 1rem;
        max-width: none;
    }
    
    .warning-modal .modal-body {
        padding: 1.5rem;
    }
    
    .schedule-conflict-icon {
        width: 60px;
        height: 60px;
    }
    
    .schedule-conflict-icon i {
        font-size: 2rem;
    }
    
    .conflict-warning-title {
        font-size: 1.25rem;
    }
    
    .conflict-buttons {
        flex-direction: column;
    }
    
    .btn-secondary-modal,
    .btn-primary-modal {
        width: 100%;
    }
}

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

/* ===========================
   M-Loc Card / Items
   =========================== */
.mloc-card {
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    margin-bottom: 20px;
    padding: 20px;
    /* z-index: 1; defined earlier in "PERBAIKAN" */
}

.mloc-header {
    background: #007bff;
    color: #fff;
    border-radius: 8px 8px 0 0;
    padding: 15px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin: -20px -20px 20px -20px;
}

.mloc-header h5 {
    font-weight: bold;
    margin-bottom: 0;
}

.mloc-item-container {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
}

.mloc-item {
    background: #ffc107;
    border-radius: 8px;
    padding: 15px;
    flex: 1 1 calc(50% - 15px);
    max-width: calc(50% - 15px);
    position: relative;
    z-index: 1; /* pastikan item tidak naik di atas modal */
}

.mloc-item .mloc-details {
    display: flex;
    align-items: center;
    gap: 15px;
    color: #000;
}

.mloc-item .number-circle {
    background: #fff;
    border-radius: 50%;
    width: 30px;
    height: 30px;
    display: flex;
    justify-content: center;
    align-items: center;
    font-weight: bold;
    color: #000;
    flex-shrink: 0;
}

.mloc-item .mloc-info {
    flex-grow: 1;
}

.mloc-item .mloc-actions {
    position: absolute;
    top: 10px;
    right: 10px;
    z-index: 2; /* icon action tetap di atas card, namun tetap di bawah modal */
}

.mloc-item .action-btn {
    background: #fff;
    border: none;
    border-radius: 50%;
    width: 30px;
    height: 30px;
    display: inline-flex;
    justify-content: center;
    align-items: center;
    color: #000;
    margin-left: 5px;
    cursor: pointer;
    text-decoration: none;
}

.mloc-item .action-btn.edit-btn {
    color: #28a745;
}

.mloc-item .action-btn.delete-btn {
    color: #dc3545;
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
    width: 15%; /* Name column */
}

.data-preview-table table th:nth-child(2),
.data-preview-table table td:nth-child(2) {
    width: 15%; /* Leaving column */
}

.data-preview-table table th:nth-child(3),
.data-preview-table table td:nth-child(3) {
    width: 15%; /* Return column */
}

.data-preview-table table th:nth-child(4),
.data-preview-table table td:nth-child(4) {
    width: 20%; /* Destination column */
}

.data-preview-table table th:nth-child(5),
.data-preview-table table td:nth-child(5) {
    width: 15%; /* Request column */
}

.data-preview-table table th:nth-child(6),
.data-preview-table table td:nth-child(6) {
    width: 10%; /* Letter column */
}

.data-preview-table table th:nth-child(7),
.data-preview-table table td:nth-child(7) {
    width: 10%; /* Action column */
}

/* Dropdown improvements */
.dropdown-menu {
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
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

/* Field label styling */
.field-label {
    font-weight: 500;
    color: #333;
    margin-bottom: 0.5rem;
    display: block;
    font-size: 0.95rem;
}

/* Letter label styling */
.letter-label {
    margin-bottom: 0.25rem;
}

/* ===========================
   Searchable Dropdown Styles (Enhanced Structure)
   =========================== */

/* Searchable dropdown container */
.searchable-dropdown {
    position: relative;
    width: 100%;
    z-index: 2147483640; /* Very high z-index */
}

/* Display input (readonly, shows selected value) */
.searchable-dropdown-display {
    position: relative;
    width: 100%;
}

.searchable-dropdown-display-input {
    width: 100%;
    padding: 0.75rem 2.25rem 0.75rem 0.75rem;
    border: 1px solid #ced4da;
    border-radius: 0.375rem;
    font-size: 1rem;
    line-height: 1.5;
    color: #212529;
    background-color: #f8f9fa; /* Light background for readonly */
    background-clip: padding-box;
    cursor: pointer;
    transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    position: relative;
    z-index: 2147483641 !important;
}

.searchable-dropdown-display-input:focus {
    color: #212529;
    background-color: #f8f9fa;
    border-color: #86b7fe;
    outline: 0;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
}

.searchable-dropdown-display-input::placeholder {
    color: #6c757d;
    opacity: 1;
}

/* Arrow indicator */
.searchable-dropdown-arrow {
    position: absolute;
    right: 0.75rem;
    top: 50%;
    transform: translateY(-50%);
    pointer-events: none;
    color: #6c757d;
    transition: transform 0.15s ease-in-out;
    z-index: 2147483642 !important;
}

.searchable-dropdown.open .searchable-dropdown-arrow {
    transform: translateY(-50%) rotate(180deg);
}

/* Search input container (appears below display when clicked) */
.searchable-dropdown-search-container {
    width: 100%;
    margin-top: 0.25rem;
    margin-bottom: 0.5rem;
}

.searchable-dropdown-search-input {
    width: 100%;
    padding: 0.5rem 0.75rem;
    border: 1px solid #007bff;
    border-radius: 0.375rem;
    font-size: 0.9rem;
    line-height: 1.5;
    color: #212529;
    background-color: #fff;
    background-clip: padding-box;
    transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    z-index: 2147483641 !important;
}

.searchable-dropdown-search-input:focus {
    color: #212529;
    background-color: #fff;
    border-color: #0056b3;
    outline: 0;
    box-shadow: 0 0 0 0.25rem rgba(0, 123, 255, 0.25);
}

.searchable-dropdown-search-input::placeholder {
    color: #6c757d;
    opacity: 1;
}

/* Dropdown menu */
.searchable-dropdown-menu {
    position: absolute;
    background: white;
    border: 1px solid #ced4da;
    border-radius: 0.375rem;
    max-height: 250px;
    overflow-y: auto;
    z-index: 2147483647 !important; /* Maximum z-index */
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.25);
    pointer-events: auto !important;
    min-width: 200px;
    width: 100%;
    margin-top: 0.75rem;
}

.searchable-dropdown-menu.show {
    display: block !important;
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
    pointer-events: auto !important;
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
    color: #6c757d;
    font-style: italic;
    text-align: center;
    cursor: default;
    padding: 1rem 0.75rem;
}

.searchable-dropdown-item.no-results:hover {
    background-color: transparent;
}

/* Add new item styling */
.searchable-dropdown-item.add-new-item {
    background-color: #f8f9fa !important;
    border-top: 1px solid #dee2e6 !important;
    color: #007bff !important;
    font-weight: 500 !important;
    cursor: pointer !important;
}

.searchable-dropdown-item.add-new-item:hover {
    background-color: #e9ecef !important;
    color: #0056b3 !important;
}

/* Ensure dropdown menus attached to body are properly styled */
body > .searchable-dropdown-menu {
    z-index: 2147483647 !important;
    position: fixed !important;
    background: white;
    border: 1px solid #ced4da;
    border-radius: 0.375rem;
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.25);
    max-height: 250px;
    overflow-y: auto;
}

body > .searchable-dropdown-menu .searchable-dropdown-item {
    padding: 0.5rem 0.75rem;
    cursor: pointer;
    border-bottom: 1px solid #f8f9fa;
    font-size: 0.95rem;
    color: #212529;
    background-color: transparent;
    transition: background-color 0.15s ease-in-out;
    pointer-events: auto !important;
}

body > .searchable-dropdown-menu .searchable-dropdown-item:hover {
    background-color: #e9ecef;
}

body > .searchable-dropdown-menu .searchable-dropdown-item:last-child {
    border-bottom: none;
}

body > .searchable-dropdown-menu .searchable-dropdown-item.selected {
    background-color: #0d6efd;
    color: white;
}

body > .searchable-dropdown-menu .searchable-dropdown-item.add-new-item {
    background-color: #f8f9fa !important;
    border-top: 1px solid #dee2e6 !important;
    color: #007bff !important;
    font-weight: 500 !important;
}

body > .searchable-dropdown-menu .searchable-dropdown-item.add-new-item:hover {
    background-color: #e9ecef !important;
    color: #0056b3 !important;
}

/* Modal z-index management */
.modal .searchable-dropdown {
    z-index: 2147483640 !important;
    position: relative;
}

.modal .searchable-dropdown-menu {
    z-index: 2147483647 !important;
    pointer-events: auto !important;
    position: absolute !important;
}

.modal .searchable-dropdown-display-input,
.modal .searchable-dropdown-search-input {
    z-index: 2147483641 !important;
    position: relative;
}

.modal .searchable-dropdown-arrow {
    z-index: 2147483642 !important;
    position: absolute;
}

/* Letter checkbox specific styling */
.modal-form-col .form-check {
    min-height: 3.5rem;
    padding-left: 1.5rem !important; /* Add more spacing from left edge */
    display: flex;
    align-items: center;
    justify-content: flex-start;
}

.modal-form-col .form-check .form-check-input {
    margin-top: 0;
    margin-right: 0.5rem;
}

.modal-form-col .form-check .form-check-label {
    margin-bottom: 0;
    line-height: 1.2;
}

.modal-form-col .form-check-input {
    margin-right: 0.5rem;
}

.modal-form-col .form-check-label {
    font-size: 0.95rem;
    color: #212529;
}

/* Modal form adjustments */
.modal-form-col {
    flex: 1;
    margin-bottom: 1rem;
}

.modal-form-col .form-control {
    padding: 0.75rem;
    border: 1px solid #ced4da;
    border-radius: 0.375rem;
}

.modal-notification .alert {
    margin-bottom: 0;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    border-radius: 8px;
}

/* Mobile responsive adjustments for searchable dropdowns */
@media (max-width: 768px) {
    .searchable-dropdown-menu,
    body > .searchable-dropdown-menu {
        max-height: 200px;
        font-size: 0.9rem;
        z-index: 999999 !important; /* Extremely high on mobile */
        position: fixed !important;
    }
    
    .searchable-dropdown {
        z-index: 999998 !important;
    }
    
    .searchable-dropdown-input {
        font-size: 16px; /* Prevent zoom on iOS */
        z-index: 999998 !important;
    }
    
    .searchable-dropdown-item,
    body > .searchable-dropdown-menu .searchable-dropdown-item {
        padding: 0.75rem;
    }
    
    .field-label {
        font-size: 0.9rem;
        margin-bottom: 0.4rem;
    }
    
    .modal-form-col {
        margin-bottom: 1.5rem;
    }
    
    /* Ensure buttons stay below dropdowns on mobile */
    .btn-add-multiple,
    .btn-save-all,
    .modal-buttons-container .btn {
        z-index: 100115 !important;
    }
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
    /* z-index adjusted earlier */
}

.fab:hover {
    transform: scale(1.1);
    box-shadow: 0 6px 16px rgba(0, 123, 255, 0.4);
}

/* Floating trigger for configuration */
.floating-trigger-container {
    position: fixed;
    bottom: 2rem;
    right: 2rem;
    z-index: 2147483648 !important; /* One higher than dropdown menus */
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
    transition: all 0.3s ease;
    pointer-events: auto !important;
}

.floating-trigger-container:hover {
    transform: scale(1.1);
    box-shadow: 0 6px 16px rgba(0, 123, 255, 0.4);
    background-color: #0056b3;
}

.floating-trigger-icon {
    width: 30px;
    height: auto;
    transition: transform 0.2s ease;
    margin-left: 4px;
    pointer-events: none;
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

.mloc-actions.visible {
    display: block !important;
}
</style>

<!-- Alert Notifications -->
<div id="alertContainer"></div>

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
    <a href="#" class="btn-add hidden" id="add-mloc-btn" data-bs-toggle="modal" data-bs-target="#addMlocModal">
        <i class="bi bi-plus me-2"></i>Tambah
    </a>
</div>

<div class="page-container">
    <!-- Main search bar (always visible) -->
    <div class="main-search-container">
        <input type="text" class="main-search-input" id="mainSearchInput" placeholder="Search..." autocomplete="off">
        <i class="bi bi-search main-search-icon"></i>
    </div>
    
    <!-- Content wrapper with white background -->
    <div class="content-wrapper">
        <!-- Page title (centered) -->
        <h1 class="page-title" id="page-title">M-Loc</h1>
        
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

        <?php if (empty($groupedMlocs)): ?>
            <div class="empty-state">
                <i class="bi bi-calendar-x text-muted" style="font-size: 3rem;"></i>
                <h5 class="text-muted mt-3">Belum ada data M-Loc</h5>
                <p class="text-muted">Klik tombol "Tambah" untuk menambahkan data baru.</p>
            </div>
        <?php else: ?>
            <?php 
            // Group data by leaving date
            $dateGroups = [];
            $today = date('Y-m-d');
            
            foreach ($groupedMlocs as $peopleName => $mlocs) {
                foreach ($mlocs as $mloc) {
                    $leaveDate = date('Y-m-d', strtotime($mloc['leave_date']));
                    $dateKey = ($leaveDate === $today) ? 'today' : $leaveDate;
                    
                    if (!isset($dateGroups[$dateKey])) {
                        $dateGroups[$dateKey] = [];
                    }
                    if (!isset($dateGroups[$dateKey][$peopleName])) {
                        $dateGroups[$dateKey][$peopleName] = [];
                    }
                    $dateGroups[$dateKey][$peopleName][] = $mloc;
                }
            }
            
            // Sort date groups: today first, then by date
            uksort($dateGroups, function($a, $b) {
                if ($a === 'today') return -1;
                if ($b === 'today') return 1;
                return strcmp($a, $b);
            });
            
            // Remove any duplicate today entries (e.g., if today's date appears as both 'today' and actual date)
            $todayDateKey = $today;
            if (isset($dateGroups['today']) && isset($dateGroups[$todayDateKey])) {
                // Merge today's date entries into the 'today' section
                foreach ($dateGroups[$todayDateKey] as $peopleName => $mlocs) {
                    if (!isset($dateGroups['today'][$peopleName])) {
                        $dateGroups['today'][$peopleName] = [];
                    }
                    $dateGroups['today'][$peopleName] = array_merge($dateGroups['today'][$peopleName], $mlocs);
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
                <div class="mloc-main-container" style="margin-bottom: 20px;">
                    <div class="today-header">
                        <?php if ($dateKey === 'today'): ?>
                            Today
                        <?php else: ?>
                            <?= date('d M Y', strtotime($dateKey)) ?>
                        <?php endif; ?>
                    </div>
                    <div class="mloc-content" id="mlocContainer">
                        <?php if ($dateKey === 'today' && empty($dateGroupData)): ?>
                            <!-- Empty state for Today -->
                            <div class="empty-today-state" style="padding: 40px 20px; text-align: center; background: white;">
                                <i class="bi bi-calendar-check text-muted" style="font-size: 3rem;"></i>
                                <h5 class="text-muted mt-3">No schedules for today</h5>
                                <p class="text-muted">There are no M-Loc schedules planned for today.</p>
                            </div>
                        <?php else: ?>
                            <?php foreach ($dateGroupData as $peopleName => $mlocs): ?>
                            <div class="person-card" data-person="<?= esc($peopleName) ?>">
                                <div class="person-header">
                                    <span class="person-name"><?= esc($peopleName) ?></span>
                                    <div class="header-right">
                                        <span class="schedule-count">(<?= count($mlocs) ?> Schedule)s</span>
                                        <div class="person-actions hidden">
                                            <a href="#" class="delete-person-btn" title="Delete All Schedules">
                                                <i class="bi bi-trash-fill"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="schedules-container">
                                    <?php foreach ($mlocs as $index => $mloc): ?>
                                        <div class="schedule-card-wrapper" style="position: relative; display: flex; align-items: center; margin-bottom: 15px;">
                                            <div class="schedule-card <?= (!isset($mloc['letter']) || $mloc['letter'] != 1) ? 'schedule-card-no-icon' : '' ?>" data-id="<?= isset($mloc['original_id']) ? $mloc['original_id'] : $mloc['id'] ?>" data-date="<?= $mloc['leave_date'] ?>">
                                                <div class="schedule-number"><?= $index + 1 ?></div>
                                                <div class="schedule-content">
                                                    <div class="schedule-info">
                                                        <div class="destination-name"><?= esc($mloc['destination_name']) ?></div>
                                                        <div class="request-info">Request by: <?= esc($mloc['request_by'] ?? '-') ?></div>
                                                    </div>
                                                    <div class="schedule-dates">
                                                        <div class="date-info">
                                                            <small>Leaving: <?= date('d-M-Y', strtotime($mloc['leave_date'])) ?></small>
                                                        </div>
                                                        <div class="date-info">
                                                            <small>Return: <?= date('d-M-Y', strtotime($mloc['return_date'])) ?></small>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php if (isset($mloc['letter']) && $mloc['letter'] == 1): ?>
                                                <div class="schedule-task-icon">
                                                    <i class="bi bi-file-earmark"></i>
                                                </div>
                                                <?php endif; ?>
                                            </div>
                                            <div class="schedule-actions hidden">
                                                <a href="#" class="action-btn edit-btn" data-bs-toggle="modal" data-bs-target="#editMlocModal" 
                                                   data-id="<?= isset($mloc['original_id']) ? $mloc['original_id'] : $mloc['id'] ?>" 
                                                   data-person="<?= esc($mloc['people_name']) ?>"
                                                   data-destination="<?= esc($mloc['destination_name']) ?>"
                                                   data-request="<?= esc($mloc['request_by'] ?? '') ?>"
                                                   data-leave="<?= $mloc['leave_date'] ?>"
                                                   data-return="<?= $mloc['return_date'] ?>"
                                                   data-letter="<?= isset($mloc['letter']) ? $mloc['letter'] : '0' ?>">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <a href="#" class="action-btn delete-btn" data-bs-toggle="modal" data-bs-target="#deleteMlocModal" 
                                                   data-id="<?= isset($mloc['original_id']) ? $mloc['original_id'] : $mloc['id'] ?>"
                                                   data-person="<?= esc($mloc['people_name']) ?>"
                                                   data-destination="<?= esc($mloc['destination_name']) ?>">
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

<!-- Add M-LOC Modal -->
<div class="modal fade" id="addMlocModal" tabindex="-1" aria-labelledby="addMlocModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title w-100 text-center" id="addMlocModalLabel">Add M-LOC</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addMlocForm" action="<?= base_url('mloc/storeWithFlash') ?>" method="post">
                    <?= csrf_field() ?>
                    <input type="hidden" id="addConfigMode" name="config_mode" value="0">
                    <div class="modal-form-row">
                        <div class="modal-form-col">
                            <label class="field-label">Personil Name</label>
                            <div class="searchable-dropdown" id="people-dropdown">
                                <!-- Display field that shows selected value -->
                                <div class="searchable-dropdown-display" id="people-display">
                                    <input type="text" class="searchable-dropdown-display-input" 
                                           id="people-display-input" 
                                           placeholder="Click to select personnel" 
                                           readonly
                                           data-target="people_id">
                                    <div class="searchable-dropdown-arrow">
                                        <i class="bi bi-chevron-down"></i>
                                    </div>
                                </div>
                                <!-- Search field that appears below when clicked -->
                                <div class="searchable-dropdown-search-container" id="people-search-container" style="display: none;">
                                    <input type="text" class="searchable-dropdown-search-input" 
                                           id="people-search" 
                                           placeholder="Search personnel..." 
                                           autocomplete="off">
                                </div>
                                <!-- Options list -->
                                <div class="searchable-dropdown-menu" id="people-menu" style="display: none;">
                                    <?php if (!empty($people)): foreach($people as $p): ?>
                                    <div class="searchable-dropdown-item" data-value="<?= esc($p['id']) ?>" data-text="<?= esc($p['name']) ?>"><?= esc($p['name']) ?></div>
                                    <?php endforeach; endif; ?>
                                </div>
                            </div>
                            <input type="hidden" id="people_id" name="people_id" required>
                        </div>
                        <div class="modal-form-col">
                            <label class="field-label">Leaving Date</label>
                            <input type="date" class="form-control" id="leavingDate" name="leaving_date" required>
                        </div>
                        <div class="modal-form-col">
                            <label class="field-label">Return Date</label>
                            <input type="date" class="form-control" id="returnDate" name="return_date" required>
                        </div>
                    </div>
                    
                    <div class="modal-form-row">
                        <div class="modal-form-col">
                            <label class="field-label">Request</label>
                            <input type="text" class="form-control" id="requestBy" name="request_by" placeholder="Request">
                        </div>
                        <div class="modal-form-col">
                            <label class="field-label">Destination</label>
                            <div class="searchable-dropdown" id="destination-dropdown">
                                <!-- Display field that shows selected value -->
                                <div class="searchable-dropdown-display" id="destination-display">
                                    <input type="text" class="searchable-dropdown-display-input" 
                                           id="destination-display-input" 
                                           placeholder="Click to select destination" 
                                           readonly
                                           data-target="destination_id">
                                    <div class="searchable-dropdown-arrow">
                                        <i class="bi bi-chevron-down"></i>
                                    </div>
                                </div>
                                <!-- Search field that appears below when clicked -->
                                <div class="searchable-dropdown-search-container" id="destination-search-container" style="display: none;">
                                    <input type="text" class="searchable-dropdown-search-input" 
                                           id="destination-search" 
                                           placeholder="Search destinations..." 
                                           autocomplete="off">
                                </div>
                                <!-- Options list -->
                                <div class="searchable-dropdown-menu" id="destination-menu" style="display: none;">
                                    <?php if (!empty($destinations)): foreach($destinations as $d): ?>
                                    <div class="searchable-dropdown-item" data-value="<?= esc($d['id']) ?>" data-text="<?= esc($d['destination_name']) ?>"><?= esc($d['destination_name']) ?></div>
                                    <?php endforeach; endif; ?>
                                </div>
                            </div>
                            <input type="hidden" id="destination_id" name="destination_id" required>
                        </div>
                        <div class="modal-form-col d-flex flex-column">
                            <label class="field-label letter-label">Letter</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="letterCheckbox" name="letter" value="1">
                                <label class="form-check-label" for="letterCheckbox">
                                    Letter
                                </label>
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
                        <h6 class="w-100 text-center">M-Loc data to be added</h6>
                        <table class="table table-sm table-bordered text-center">
                            <thead>
                                <tr>
                                    <th style="text-align: center; vertical-align: middle;">Name</th>
                                    <th style="text-align: center; vertical-align: middle;">Leaving</th>
                                    <th style="text-align: center; vertical-align: middle;">Return</th>
                                    <th style="text-align: center; vertical-align: middle;">Destination</th>
                                    <th style="text-align: center; vertical-align: middle;">Request</th>
                                    <th style="text-align: center; vertical-align: middle;">Letter</th>
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

<!-- Edit M-LOC Modal -->
<div class="modal fade" id="editMlocModal" tabindex="-1" aria-labelledby="editMlocModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title w-100 text-center" id="editMlocModalLabel">Edit M-LOC</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editMlocForm" action="<?= base_url('mloc/updateWithFlash') ?>" method="post">
                    <?= csrf_field() ?>
                    <input type="hidden" id="editMlocId" name="mloc_id">
                    <input type="hidden" id="editConfigMode" name="config_mode" value="0">
                    
                    <div class="modal-form-row">
                        <div class="modal-form-col">
                            <label class="field-label">Personil Name</label>
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
                                    <?php if (!empty($people)): foreach($people as $p): ?>
                                    <div class="searchable-dropdown-item" data-value="<?= esc($p['id']) ?>" data-text="<?= esc($p['name']) ?>"><?= esc($p['name']) ?></div>
                                    <?php endforeach; endif; ?>
                                </div>
                            </div>
                            <input type="hidden" id="editPeopleId" name="people_id" required>
                        </div>
                        <div class="modal-form-col">
                            <label class="field-label">Leaving Date</label>
                            <input type="date" class="form-control" id="editLeavingDate" name="leaving_date" required>
                        </div>
                        <div class="modal-form-col">
                            <label class="field-label">Return Date</label>
                            <input type="date" class="form-control" id="editReturnDate" name="return_date" required>
                        </div>
                    </div>
                    
                    <div class="modal-form-row">
                        <div class="modal-form-col">
                            <label class="field-label">Request</label>
                            <input type="text" class="form-control" id="editRequestBy" name="request_by" placeholder="Request">
                        </div>
                        <div class="modal-form-col">
                            <label class="field-label">Destination</label>
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
                                    <?php if (!empty($destinations)): foreach($destinations as $d): ?>
                                    <div class="searchable-dropdown-item" data-value="<?= esc($d['id']) ?>" data-text="<?= esc($d['destination_name']) ?>"><?= esc($d['destination_name']) ?></div>
                                    <?php endforeach; endif; ?>
                                </div>
                            </div>
                            <input type="hidden" id="editDestinationId" name="destination_id" required>
                        </div>
                        <div class="modal-form-col d-flex flex-column">
                            <label class="field-label letter-label">Letter</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="editLetterCheckbox" name="letter" value="1">
                                <label class="form-check-label" for="editLetterCheckbox">
                                    Letter
                                </label>
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
<div class="modal fade warning-modal" id="deleteMlocModal" tabindex="-1" aria-labelledby="deleteMlocModalLabel" aria-hidden="true">
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

<!-- Schedule Conflict Warning Modal -->
<div class="modal fade warning-modal" id="scheduleWarningModal" tabindex="-1" aria-labelledby="scheduleWarningModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="schedule-conflict-icon">
                    <i class="bi bi-calendar-event"></i>
                </div>
                <h5 class="conflict-warning-title">WARNING!</h5>
                <p id="conflictPersonnelMessage" class="conflict-message"></p>
                <p class="conflict-question">Are you sure you want to add this schedule?</p>
                
                <div class="conflict-buttons">
                    <button type="button" class="btn btn-secondary-modal" data-bs-dismiss="modal">No</button>
                    <button type="button" class="btn btn-primary-modal" id="confirmAddBtn">Yes</button>
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

<!-- Delete All Schedules Confirmation Modal -->
<div class="modal fade warning-modal" id="deleteAllSchedulesModal" tabindex="-1" aria-labelledby="deleteAllSchedulesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="delete-icon">
                    <i class="bi bi-trash"></i>
                </div>
                <h5 class="warning-text">WARNING!</h5>
                <p class="warning-subtext" id="deleteAllMessage">This action will result in the permanent deletion of all schedules for this person. Once deleted, the data cannot be recovered.</p>
                
                <div class="d-flex gap-3 justify-content-center">
                    <button type="button" class="btn btn-secondary-custom" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger-custom" id="confirmDeleteAllBtn">Delete All</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function(){
    // Move modals to body to prevent z-index issues
    ['addMlocModal','editMlocModal','deleteMlocModal','deleteAllSchedulesModal','scheduleWarningModal','scheduleErrorModal']
        .forEach(id => {
            const el = document.getElementById(id);
            if (el && el.parentElement !== document.body) {
                document.body.appendChild(el);
            }
        });
});

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
    
    // Initialize configuration mode on page load
    function initializeConfigMode() {
        updateFormConfigMode(isConfigMode);
        
        if (isConfigMode) {
            showConfigurationMode();
        } else {
            returnToInitialState();
        }
    }
    let multipleDataMode = false;
    let pendingData = [];
    let currentDeleteId = null;
    let currentDeleteAllData = null;
    
    // Get people and destinations data from PHP for JavaScript use
    const peopleData = <?= json_encode($people ?? []) ?>;
    const destinationsData = <?= json_encode($destinations ?? []) ?>;

    // Handle delete all schedules button
    document.addEventListener('click', function(e) {
        if (e.target.closest('.delete-person-btn')) {
            e.preventDefault();
            const btn = e.target.closest('.delete-person-btn');
            const personCard = btn.closest('.person-card');
            const peopleName = personCard.dataset.person;
            
            // Store data for deletion
            currentDeleteAllData = {
                people_name: peopleName
            };
            
            // Update modal message
            document.getElementById('deleteAllMessage').textContent = 
                `This action will result in the permanent deletion of all schedules for ${peopleName}. Once deleted, the data cannot be recovered.`;
            
            // Show modal
            const modal = new bootstrap.Modal(document.getElementById('deleteAllSchedulesModal'));
            modal.show();
        }
    });
    
    // Confirm delete all button
    document.getElementById('confirmDeleteAllBtn').addEventListener('click', function() {
        if (currentDeleteAllData) {
            // Close modal first
            const modal = bootstrap.Modal.getInstance(document.getElementById('deleteAllSchedulesModal'));
            if (modal) {
                modal.hide();
            }
            
            // Create form and submit to flash message endpoint
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '<?= base_url('mloc/deleteAllByPersonWithFlash') ?>';
            
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '<?= csrf_token() ?>';
            csrfInput.value = '<?= csrf_hash() ?>';
            form.appendChild(csrfInput);
            
            const peopleNameInput = document.createElement('input');
            peopleNameInput.type = 'hidden';
            peopleNameInput.name = 'people_name';
            peopleNameInput.value = currentDeleteAllData.people_name;
            form.appendChild(peopleNameInput);
            
            // Add config_mode parameter
            const currentConfigMode = isConfigMode || (document.querySelector('.config-header') && document.querySelector('.config-header').classList.contains('visible'));
            const configInput = document.createElement('input');
            configInput.type = 'hidden';
            configInput.name = 'config_mode';
            configInput.value = currentConfigMode ? '1' : '0';
            form.appendChild(configInput);
            
            document.body.appendChild(form);
            form.submit();
        } else {
            showAlert('No data selected for deletion', 'warning');
        }
    });
    function showAlert(message, type = 'success') {
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type} alert-notification alert-dismissible fade show`;
        alertDiv.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        
        document.getElementById('alertContainer').appendChild(alertDiv);
        
        // Auto dismiss after 5 seconds
        setTimeout(() => {
            if (alertDiv.parentNode) {
                alertDiv.remove();
            }
        }, 5000);
    }

    // Search functionality (for both search inputs)
    const searchInput = document.getElementById('searchInput');
    const mainSearchInput = document.getElementById('mainSearchInput');
    const searchSuggestions = document.getElementById('searchSuggestions');
    
    function performSearch(query) {
        const dateContainers = document.querySelectorAll('.mloc-main-container');
        
        dateContainers.forEach(container => {
            const personCards = container.querySelectorAll('.person-card');
            let hasVisibleInContainer = false;
            
            personCards.forEach(card => {
                const personName = card.dataset.person.toLowerCase();
                const scheduleCards = card.querySelectorAll('.schedule-card');
                let hasMatch = false;
                
                scheduleCards.forEach(schedule => {
                    const destination = schedule.querySelector('.destination-name').textContent.toLowerCase();
                    const request = schedule.querySelector('.request-info').textContent.toLowerCase();
                    
                    if (personName.includes(query) || destination.includes(query) || request.includes(query)) {
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
            const container = document.getElementById('mlocContainer');
            const cards = Array.from(container.querySelectorAll('.person-card'));
            
            cards.sort((a, b) => {
                const nameA = a.dataset.person.toLowerCase();
                const nameB = b.dataset.person.toLowerCase();
                return sortType === 'asc' ? nameA.localeCompare(nameB) : nameB.localeCompare(nameA);
            });
            
            cards.forEach(card => container.appendChild(card));
            
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

    // Filter functionality
    document.querySelectorAll('[data-filter]').forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            const filterType = this.dataset.filter;
            const today = new Date();
            
            // Get all date group containers
            const dateContainers = document.querySelectorAll('.mloc-main-container');
            
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
                        
                        switch(filterType) {
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
    
    // Function to load existing temporary data into preview table
    function loadTempDataToPreview() {
        fetch('<?= base_url('mloc/getTempData') ?>', {
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
                        people_id: item.people_id,
                        people_name: item.people_name,
                        leaving_date: item.leave_date,
                        return_date: item.return_date,
                        destination_id: item.destination_id,
                        destination_name: item.destination_name,
                        request_by: item.request_by,
                        letter: item.letter
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
        
        // Get people name for display
        const selectedPerson = peopleData.find(p => p.id == formData.people_id);
        const personName = selectedPerson ? selectedPerson.name : 'Unknown';
        
        console.log('Checking conflicts for person:', personName);
        
        // Check for existing conflicts via AJAX
        fetch('<?= base_url('mloc/checkConflict') ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('input[name="<?= csrf_token() ?>"]').value
            },
            body: JSON.stringify({
                people_id: formData.people_id,
                leaving_date: formData.leaving_date,
                return_date: formData.return_date,
                destination_id: formData.destination_id,
                <?= csrf_token() ?>: document.querySelector('input[name="<?= csrf_token() ?>"]').value
            })
        })
        .then(response => {
            console.log('Multiple data conflict check response status:', response.status);
            return response.json();
        })
        .then(data => {
            console.log('Multiple data conflict check response data:', data);
            if (data.hasConflict) {
                console.log('Conflict detected in multiple mode, showing warning modal');
                // Get destination name for display
                const selectedDestination = destinationsData.find(d => d.id == formData.destination_id);
                const destinationName = selectedDestination ? selectedDestination.destination_name : 'Unknown';
                
                // Show conflict warning modal
                const conflictDate = new Date(formData.leaving_date).toLocaleDateString('en-GB', {
                    day: '2-digit',
                    month: 'long',
                    year: 'numeric'
                });
                
                document.getElementById('conflictPersonnelMessage').textContent = 
                    `Personnel "${personName}" is already scheduled to "${destinationName}" on ${conflictDate}.`;
                
                // Store form data for later addition
                window.pendingMultipleData = formData;
                
                // Show warning modal
                const modal = new bootstrap.Modal(document.getElementById('scheduleWarningModal'));
                modal.show();
            } else {
                console.log('No conflict detected in multiple mode, adding to list directly');
                // No conflict, add to list directly
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
        fetch('<?= base_url('mloc/addToTempData') ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('input[name="<?= csrf_token() ?>"]').value
            },
            body: new URLSearchParams({
                people_id: formData.people_id,
                destination_id: formData.destination_id,
                leaving_date: formData.leaving_date,
                return_date: formData.return_date,
                request_by: formData.request_by,
                letter: formData.letter,
                <?= csrf_token() ?>: document.querySelector('input[name="<?= csrf_token() ?>"]').value
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                console.log('Data successfully added to temporary storage:', data.data);
                
                // Format data for preview table
                const formattedData = {
                    id: data.data.id,
                    people_id: data.data.people_id,
                    people_name: data.data.people_name,
                    leaving_date: data.data.leave_date,
                    return_date: data.data.return_date,
                    destination_id: data.data.destination_id,
                    destination_name: data.data.destination_name,
                    request_by: data.data.request_by,
                    letter: data.data.letter,
                    _forceAdded: forceAdd
                };
                
                // Add to preview table
                const currentIndex = document.getElementById('dataPreviewBody').children.length;
                addToPreviewTableFromTemp(formattedData, currentIndex);
                
                // Reset form
                document.getElementById('addMlocForm').reset();
                
                // Reset searchable dropdowns
                if (searchableDropdowns['people-dropdown']) {
                    searchableDropdowns['people-dropdown'].reset();
                }
                if (searchableDropdowns['destination-dropdown']) {
                    searchableDropdowns['destination-dropdown'].reset();
                }
                
                // Show save button
                const saveContainer = document.getElementById('saveAllContainer');
                saveContainer.style.display = 'block';
                
                // Set default dates to today
                const today = new Date().toISOString().split('T')[0];
                document.getElementById('leavingDate').value = today;
                document.getElementById('returnDate').value = today;
                
                // Show success message
                showAlert('Data successfully added to list', 'success');
            } else {
                console.error('Failed to add data to temporary storage:', data.message);
                showAlert(data.message || 'Failed to add data to list', 'danger');
            }
        })
        .catch(error => {
            console.error('Error adding data to temporary storage:', error);
            showAlert('An error occurred while adding data', 'danger');
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
        const leavingDate = document.getElementById('leavingDate').value;
        const returnDate = document.getElementById('returnDate').value;
        const destinationId = document.getElementById('destination_id').value;
        
        // Get display text from searchable dropdowns
        const peopleText = searchableDropdowns['people-dropdown'] ? 
            searchableDropdowns['people-dropdown'].displayInput.value : '';
        const destinationText = searchableDropdowns['destination-dropdown'] ? 
            searchableDropdowns['destination-dropdown'].displayInput.value : '';
        
        return {
            people_id: peopleId,
            people_name: peopleText,
            leaving_date: leavingDate,
            return_date: returnDate,
            destination_id: destinationId,
            destination_name: destinationText,
            request_by: document.getElementById('requestBy').value || '-',
            letter: document.getElementById('letterCheckbox').checked ? '1' : '0'
        };
    }

    // Validate form data
    function validateFormData(data) {
        if (!data.people_id || !data.leaving_date || !data.return_date || !data.destination_id) {
            showAlert('Please fill in all required fields', 'warning');
            return false;
        }
        
        if (new Date(data.leaving_date) > new Date(data.return_date)) {
            showAlert('Return date must be on or after leaving date', 'warning');
            return false;
        }
        
        return true;
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
        fetch('<?= base_url('mloc/saveAllTempData') ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('input[name="<?= csrf_token() ?>"]').value
            },
            body: JSON.stringify({
                <?= csrf_token() ?>: document.querySelector('input[name="<?= csrf_token() ?>"]').value
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Show success notification
                showFlashNotification(data.message || 'All data successfully saved!', 'success');
                
                // Reset form and mode
                resetMultipleDataMode(true); // Clear temp data after successful save
                document.getElementById('addMlocForm').reset();
                
                // Close modal
                const modal = bootstrap.Modal.getInstance(document.getElementById('addMlocModal'));
                if (modal) {
                    modal.hide();
                }
                
                // Refresh page after a short delay to show notification
                setTimeout(() => {
                    location.reload();
                }, 2000);
            } else {
                // Show error notification
                showFlashNotification(data.message || 'Failed to save data', 'danger');
                // Re-enable button
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalContent;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showFlashNotification('An error occurred while saving data', 'danger');
            // Re-enable button
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalContent;
        });
    });

    // Edit M-LOC Form submission
    document.getElementById('editMlocForm').addEventListener('submit', function(e) {
        // For edit, allow normal form submission (no preventDefault)
        // This will use the updateWithFlash endpoint and refresh the page with flash notification
        console.log('Submitting edit form normally to:', this.action);
    });

    // Single form submission
    document.getElementById('addMlocForm').addEventListener('submit', function(e) {
        console.log('Form submission triggered, multipleDataMode:', multipleDataMode);
        
        // In multiple mode, prevent normal form submission since we have separate buttons
        if (multipleDataMode) {
            console.log('Preventing form submission due to multiple data mode');
            e.preventDefault();
            return;
        }
        
        console.log('Single form submission - preventing default and checking conflicts');
        // Prevent default submission to check for conflicts first
        e.preventDefault();
        
        // Check for schedule conflicts before submitting
        checkScheduleConflict(this);
    });
    
    // Function to check for schedule conflicts
    function checkScheduleConflict(form) {
        const formData = new FormData(form);
        
        console.log('Starting conflict check for single form submission');
        console.log('Form data:', {
            people_id: formData.get('people_id'),
            leaving_date: formData.get('leaving_date'),
            return_date: formData.get('return_date'),
            destination_id: formData.get('destination_id')
        });
        
        // Check if required fields are filled
        if (!formData.get('people_id') || !formData.get('leaving_date') || !formData.get('return_date') || !formData.get('destination_id')) {
            console.log('Required fields missing, submitting with alert');
            showAlert('Please fill in all required fields', 'warning');
            return;
        }
        
        // Check if return date is after leaving date (allow same day)
        const leavingDate = new Date(formData.get('leaving_date'));
        const returnDate = new Date(formData.get('return_date'));
        
        if (leavingDate > returnDate) {
            console.log('Date validation failed, leaving date is after return date');
            showAlert('Return date must be on or after leaving date', 'warning');
            return;
        }
        
        // Get people name for display
        const peopleId = formData.get('people_id');
        const selectedPerson = peopleData.find(p => p.id == peopleId);
        const personName = selectedPerson ? selectedPerson.name : 'Unknown';
        
        console.log('All validations passed, checking for conflicts via AJAX');
        
        // Check for existing conflicts via AJAX
        fetch('<?= base_url('mloc/checkConflict') ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('input[name="<?= csrf_token() ?>"]').value
            },
            body: JSON.stringify({
                people_id: formData.get('people_id'),
                leaving_date: formData.get('leaving_date'),
                return_date: formData.get('return_date'),
                destination_id: formData.get('destination_id'),
                <?= csrf_token() ?>: document.querySelector('input[name="<?= csrf_token() ?>"]').value
            })
        })
        .then(response => {
            console.log('Conflict check response status:', response.status);
            return response.json();
        })
        .then(data => {
            console.log('Conflict check response data:', data);
            if (data.hasConflict) {
                console.log('Conflict detected, showing warning modal');
                // Get destination name for display
                const selectedDestination = destinationsData.find(d => d.id == formData.get('destination_id'));
                const destinationName = selectedDestination ? selectedDestination.destination_name : 'Unknown';
                
                // Show conflict warning modal
                const conflictDate = new Date(formData.get('leaving_date')).toLocaleDateString('en-GB', {
                    day: '2-digit',
                    month: 'long',
                    year: 'numeric'
                });
                
                document.getElementById('conflictPersonnelMessage').textContent = 
                    `Personnel "${personName}" is already scheduled to "${destinationName}" on ${conflictDate}.`;
                
                // Store form for later submission
                window.pendingForm = form;
                
                // Show warning modal
                const modal = new bootstrap.Modal(document.getElementById('scheduleWarningModal'));
                modal.show();
            } else {
                console.log('No conflict detected, submitting form directly');
                // No conflict, submit form normally
                submitFormDirectly(form);
            }
        })
        .catch(error => {
            console.error('Error checking conflict:', error);
            // If error checking, allow submission anyway
            submitFormDirectly(form);
        });
    }
    
    // Function to check for schedule conflicts in edit mode
    function checkEditScheduleConflict(form) {
        const formData = new FormData(form);
        
        console.log('Starting conflict check for edit form submission');
        console.log('Edit form data:', {
            mloc_id: formData.get('mloc_id'),
            people_id: formData.get('people_id'),
            leaving_date: formData.get('leaving_date'),
            return_date: formData.get('return_date'),
            destination_id: formData.get('destination_id')
        });
        
        // Check if required fields are filled
        if (!formData.get('people_id') || !formData.get('leaving_date') || !formData.get('return_date') || !formData.get('destination_id')) {
            console.log('Required fields missing, submitting with alert');
            showAlert('Please fill in all required fields', 'warning');
            return;
        }
        
        // Check if return date is after leaving date (allow same day)
        const leavingDate = new Date(formData.get('leaving_date'));
        const returnDate = new Date(formData.get('return_date'));
        
        if (leavingDate > returnDate) {
            console.log('Date validation failed, leaving date is after return date');
            showAlert('Return date must be on or after leaving date', 'warning');
            return;
        }
        
        // Get people name for display
        const peopleId = formData.get('people_id');
        const selectedPerson = peopleData.find(p => p.id == peopleId);
        const personName = selectedPerson ? selectedPerson.name : 'Unknown';
        
        console.log('All validations passed, checking for conflicts via AJAX');
        
        // Check for existing conflicts via AJAX (excluding current record)
        fetch('<?= base_url('mloc/checkConflict') ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('input[name="<?= csrf_token() ?>"]').value
            },
            body: JSON.stringify({
                people_id: formData.get('people_id'),
                leaving_date: formData.get('leaving_date'),
                return_date: formData.get('return_date'),
                destination_id: formData.get('destination_id'),
                exclude_id: formData.get('mloc_id'), // Exclude current record from conflict check
                <?= csrf_token() ?>: document.querySelector('input[name="<?= csrf_token() ?>"]').value
            })
        })
        .then(response => {
            console.log('Edit conflict check response status:', response.status);
            return response.json();
        })
        .then(data => {
            console.log('Edit conflict check response data:', data);
            if (data.hasConflict) {
                console.log('Edit conflict detected, showing warning modal');
                // Get destination name for display
                const selectedDestination = destinationsData.find(d => d.id == formData.get('destination_id'));
                const destinationName = selectedDestination ? selectedDestination.destination_name : 'Unknown';
                
                // Show conflict warning modal
                const conflictDate = new Date(formData.get('leaving_date')).toLocaleDateString('en-GB', {
                    day: '2-digit',
                    month: 'long',
                    year: 'numeric'
                });
                
                document.getElementById('conflictPersonnelMessage').textContent = 
                    `Personnel "${personName}" is already scheduled to "${destinationName}" on ${conflictDate}.`;
                
                // Store form for later submission
                window.pendingForm = form;
                
                // Show warning modal
                const modal = new bootstrap.Modal(document.getElementById('scheduleWarningModal'));
                modal.show();
            } else {
                console.log('No edit conflict detected, submitting form directly');
                // No conflict, submit form normally
                submitFormDirectly(form);
            }
        })
        .catch(error => {
            console.error('Error checking edit conflict:', error);
            // If error checking, allow submission anyway
            submitFormDirectly(form);
        });
    }
    
    // Function to submit form directly
    function submitFormDirectly(form) {
        console.log('Submitting single form normally to:', form.action);
        form.submit();
    }
    
    // Handle confirm button in warning modal
    document.getElementById('confirmAddBtn').addEventListener('click', function() {
        console.log('Confirm button clicked');
        console.log('pendingForm:', window.pendingForm);
        console.log('pendingMultipleData:', window.pendingMultipleData);
        
        // Close modal
        const modal = bootstrap.Modal.getInstance(document.getElementById('scheduleWarningModal'));
        if (modal) {
            modal.hide();
        }
        
        // Check if this is for single form submission or multiple data addition
        if (window.pendingForm) {
            console.log('Processing single form submission with force save');
            // Submit form with force_save flag
            const forceSaveInput = document.createElement('input');
            forceSaveInput.type = 'hidden';
            forceSaveInput.name = 'force_save';
            forceSaveInput.value = '1';
            window.pendingForm.appendChild(forceSaveInput);
            
            submitFormDirectly(window.pendingForm);
            window.pendingForm = null;
        } else if (window.pendingMultipleData) {
            console.log('Processing multiple data addition despite conflict');
            // Add to list despite conflict
            addToListDirectly(window.pendingMultipleData, true); // Pass true to indicate force add
            window.pendingMultipleData = null;
        } else {
            console.log('No pending data found!');
        }
    });

    // Submit multiple data function
    function submitMultipleData() {
        const submitBtn = document.getElementById('submitMultipleBtn');
        const originalText = submitBtn.innerHTML;
        
        // Show loading state
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Saving All...';
        
        // Send multiple data via fetch
        fetch('<?= base_url('mloc/storeMultiple') ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('input[name="<?= csrf_token() ?>"]').value
            },
            body: JSON.stringify({
                data: pendingData,
                <?= csrf_token() ?>: document.querySelector('input[name="<?= csrf_token() ?>"]').value
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showFlashNotification(data.message || `${pendingData.length} M-Loc data successfully saved!`, 'success');
                bootstrap.Modal.getInstance(document.getElementById('addMlocModal')).hide();
                resetMultipleDataMode(true); // Clear temp data after successful save
                // Refresh page after a short delay to show notification
                setTimeout(() => {
                    window.location.reload();
                }, 2000);
            } else {
                showFlashNotification(data.message || 'Failed to save multiple data', 'danger');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showFlashNotification('An error occurred while saving multiple data', 'danger');
        })
        .finally(() => {
            // Reset button state
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
        });
    }

    // Edit M-LOC Form submission
    document.getElementById('editMlocForm').addEventListener('submit', function(e) {
        console.log('Edit form submission triggered');
        // Prevent default submission to check for conflicts first
        e.preventDefault();
        
        // Check for schedule conflicts before submitting
        checkEditScheduleConflict(this);
    });

    // Edit button click handler
    document.addEventListener('click', function(e) {
        if (e.target.closest('.edit-btn')) {
            const btn = e.target.closest('.edit-btn');
            document.getElementById('editMlocId').value = btn.dataset.id;
            
            // Set people dropdown value
            const personName = btn.dataset.person;
            const personData = peopleData.find(p => p.name === personName);
            if (personData && searchableDropdowns['edit-people-dropdown']) {
                searchableDropdowns['edit-people-dropdown'].setValue(personData.id, personData.name);
            }
            
            // Format database datetime values to date format for form inputs
            const leavingDateTime = btn.dataset.leave;
            if (leavingDateTime) {
                const leavingDate = new Date(leavingDateTime);
                // Use local date formatting to avoid timezone conversion issues
                const year = leavingDate.getFullYear();
                const month = String(leavingDate.getMonth() + 1).padStart(2, '0');
                const day = String(leavingDate.getDate()).padStart(2, '0');
                document.getElementById('editLeavingDate').value = `${year}-${month}-${day}`;
            }
            
            const returnDateTime = btn.dataset.return;
            if (returnDateTime) {
                const returnDate = new Date(returnDateTime);
                // Use local date formatting to avoid timezone conversion issues
                const year = returnDate.getFullYear();
                const month = String(returnDate.getMonth() + 1).padStart(2, '0');
                const day = String(returnDate.getDate()).padStart(2, '0');
                document.getElementById('editReturnDate').value = `${year}-${month}-${day}`;
            }
            
            document.getElementById('editRequestBy').value = btn.dataset.request;
            
            // Set destination dropdown value
            const destinationName = btn.dataset.destination;
            const destinationData = destinationsData.find(d => d.destination_name === destinationName);
            if (destinationData && searchableDropdowns['edit-destination-dropdown']) {
                searchableDropdowns['edit-destination-dropdown'].setValue(destinationData.id, destinationData.destination_name);
            }
            
            document.getElementById('editLetterCheckbox').checked = btn.dataset.letter === '1';
        }
    });

    // Delete button click handler
    document.addEventListener('click', function(e) {
        if (e.target.closest('.delete-btn')) {
            const btn = e.target.closest('.delete-btn');
            currentDeleteId = btn.dataset.id;
        }
    });

    // Confirm delete button
    document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
        if (currentDeleteId) {
            // Add config_mode parameter to delete URL
            const currentConfigMode = isConfigMode || (document.querySelector('.config-header') && document.querySelector('.config-header').classList.contains('visible'));
            const deleteUrl = '<?= base_url('mloc/deleteWithFlash/') ?>' + currentDeleteId + (currentConfigMode ? '?config_mode=1' : '');
            window.location.href = deleteUrl;
        } else {
            console.log('No currentDeleteId set');
            showAlert('No item selected for deletion', 'warning');
        }
    });

    // Add to preview table function (from temporary storage)
    function addToPreviewTableFromTemp(data, index) {
        const tbody = document.getElementById('dataPreviewBody');
        const row = document.createElement('tr');
        row.style.textAlign = 'center';
        row.style.verticalAlign = 'middle';
        row.dataset.tempId = data.id; // Store temporary ID for deletion
        
        // Add visual indicator if this item was force added
        const forceAddedIndicator = data._forceAdded ? 
            '<span class="badge bg-warning text-dark ms-1" title="Added despite schedule conflict">⚠️</span>' : '';
        
        row.innerHTML = `
            <td style="text-align: center; vertical-align: middle;">${data.people_name}${forceAddedIndicator}</td>
            <td style="text-align: center; vertical-align: middle;">${formatDate(data.leaving_date)}</td>
            <td style="text-align: center; vertical-align: middle;">${formatDate(data.return_date)}</td>
            <td style="text-align: center; vertical-align: middle;">${data.destination_name}</td>
            <td style="text-align: center; vertical-align: middle;">${data.request_by}</td>
            <td style="text-align: center; vertical-align: middle;">${data.letter === '1' || data.letter === 1 ? '✓' : '✗'}</td>
            <td style="text-align: center; vertical-align: middle;">
                <button class="btn btn-sm btn-outline-danger" onclick="removeFromTempPreview('${data.id}')">
                    <i class="bi bi-trash"></i>
                </button>
            </td>
        `;
        tbody.appendChild(row);
    }

    // Format date function
    function formatDate(dateString) {
        const date = new Date(dateString);
        return date.toLocaleDateString('id-ID', {
            day: '2-digit',
            month: 'short',
            year: 'numeric'
        });
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
        fetch(`<?= base_url('mloc/deleteTempData/') ?>${tempId}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('input[name="<?= csrf_token() ?>"]').value
            },
            body: JSON.stringify({
                <?= csrf_token() ?>: document.querySelector('input[name="<?= csrf_token() ?>"]').value
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
                
                // Hide save button if no data left
                const tbody = document.getElementById('dataPreviewBody');
                if (tbody.children.length === 0) {
                    document.getElementById('saveAllContainer').style.display = 'none';
                }
                
                showAlert('Item successfully removed from list', 'success');
            } else {
                console.error('Failed to delete temporary data:', data.message);
                showAlert(data.message || 'Failed to remove item', 'danger');
                
                // Reset button if failed
                if (button) {
                    button.disabled = false;
                    button.innerHTML = '<i class="bi bi-trash"></i>';
                }
            }
        })
        .catch(error => {
            console.error('Error deleting temporary data:', error);
            showAlert('An error occurred while removing item', 'danger');
            
            // Reset button if error
            if (button) {
                button.disabled = false;
                button.innerHTML = '<i class="bi bi-trash"></i>';
            }
        });
    };

    // Legacy remove function for compatibility
    window.removeFromPreview = function(index) {
        console.log('Legacy removeFromPreview called, redirecting to removeFromTempPreview');
        // This function is kept for compatibility but shouldn't be used in new implementation
        const rows = document.querySelectorAll('#dataPreviewBody tr');
        if (rows[index] && rows[index].dataset.tempId) {
            removeFromTempPreview(rows[index].dataset.tempId);
        }
    };

    // Reset multiple data mode
    function resetMultipleDataMode(clearTempData = false) {
        console.log('Resetting multiple data mode, clearTempData:', clearTempData);
        
        document.getElementById('dataPreviewTable').style.display = 'none';
        multipleDataMode = false;
        pendingData = []; // Keep for legacy compatibility
        
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
            fetch('<?= base_url('mloc/clearAllTempData') ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('input[name="<?= csrf_token() ?>"]').value
                },
                body: JSON.stringify({
                    <?= csrf_token() ?>: document.querySelector('input[name="<?= csrf_token() ?>"]').value
                })
            })
            .catch(error => {
                console.error('Error clearing temporary data:', error);
            });
        }
        
        // Reset searchable dropdowns
        if (searchableDropdowns['people-dropdown']) {
            searchableDropdowns['people-dropdown'].reset();
        }
        if (searchableDropdowns['destination-dropdown']) {
            searchableDropdowns['destination-dropdown'].reset();
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
    document.getElementById('addMlocModal').addEventListener('hidden.bs.modal', function() {
        document.getElementById('addMlocForm').reset();
        
        // Reset searchable dropdowns
        if (searchableDropdowns['people-dropdown']) {
            searchableDropdowns['people-dropdown'].reset();
        }
        if (searchableDropdowns['destination-dropdown']) {
            searchableDropdowns['destination-dropdown'].reset();
        }
        
        // Clean up any dropdown menus attached to body
        document.querySelectorAll('body > .searchable-dropdown-menu').forEach(menu => {
            menu.remove();
        });
        
        resetMultipleDataMode(false); // Don't clear temp data when modal closes
    });
    
    // Load temporary data when modal is shown (for persistence after refresh)
    document.getElementById('addMlocModal').addEventListener('shown.bs.modal', function() {
        // If there's existing temporary data, load it
        if (!multipleDataMode) {
            // Check if there's any temporary data that should be loaded
            fetch('<?= base_url('mloc/getTempData') ?>', {
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
    
    // Also clean up when edit modal is closed
    document.getElementById('editMlocModal').addEventListener('hidden.bs.modal', function() {
        // Clean up any dropdown menus attached to body
        document.querySelectorAll('body > .searchable-dropdown-menu').forEach(menu => {
            menu.remove();
        });
    });

    // Set default dates to today
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('leavingDate').value = today;
    document.getElementById('returnDate').value = today;

    // Floating trigger functionality for configuration mode
    const addButton = document.getElementById('add-mloc-btn');
    const scheduleActions = document.querySelectorAll('.schedule-actions');
    const personActions = document.querySelectorAll('.person-actions');
    const backButton = document.getElementById('back-button');
    const pageTitle = document.getElementById('page-title');
    const floatingTriggerContainer = document.querySelector('.floating-trigger-container');
    const configHeader = document.getElementById('config-header');

    if (floatingTriggerContainer) {
        floatingTriggerContainer.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const isVisible = addButton.classList.contains('visible');

            if (isVisible) {
                // Return to initial state and update URL
                returnToInitialState();
                window.history.pushState({}, '', window.location.pathname);
                updateFormConfigMode(false);
            } else {
                // Show configuration mode and update URL
                showConfigurationMode();
                window.history.pushState({}, '', window.location.pathname + '?config=1');
                updateFormConfigMode(true);
            }
        });
    }

    // Back button functionality
    if (backButton) {
        backButton.addEventListener('click', function(e) {
            e.preventDefault();
            returnToInitialState();
            window.history.pushState({}, '', window.location.pathname);
            updateFormConfigMode(false);
        });
    }

    function showConfigurationMode() {
        // Change title
        if (pageTitle) {
            pageTitle.textContent = 'Konfigurasi M-Loc';
        }
        
        // Add configuration mode class to page container
        const pageContainer = document.querySelector('.page-container');
        if (pageContainer) {
            pageContainer.classList.add('config-mode');
        }
        
        // Show configuration header
        if (configHeader) {
            configHeader.classList.add('visible');
        }
        
        // Show action buttons
        addButton.classList.remove('hidden');
        addButton.classList.add('visible');
        backButton.classList.remove('hidden');
        backButton.classList.add('visible');
        
        // Show all edit/delete actions
        scheduleActions.forEach(actions => {
            actions.classList.remove('hidden');
            actions.classList.add('visible');
        });
        
        // Show person delete actions
        personActions.forEach(actions => {
            actions.classList.remove('hidden');
            actions.classList.add('visible');
        });
        
        // Hide trigger
        if (floatingTriggerContainer) {
            floatingTriggerContainer.classList.add('hidden');
        }
    }

    function returnToInitialState() {
        // Change title back
        if (pageTitle) {
            pageTitle.textContent = 'M-Loc';
        }
        
        // Remove configuration mode class from page container
        const pageContainer = document.querySelector('.page-container');
        if (pageContainer) {
            pageContainer.classList.remove('config-mode');
        }
        
        // Hide configuration header
        if (configHeader) {
            configHeader.classList.remove('visible');
        }
        
        // Hide action buttons
        addButton.classList.remove('visible');
        addButton.classList.add('hidden');
        backButton.classList.remove('visible');
        backButton.classList.add('hidden');
        
        // Hide all edit/delete actions
        scheduleActions.forEach(actions => {
            actions.classList.remove('visible');
            actions.classList.add('hidden');
        });
        
        // Hide person delete actions
        personActions.forEach(actions => {
            actions.classList.remove('visible');
            actions.classList.add('hidden');
        });
        
        // Show trigger
        if (floatingTriggerContainer) {
            floatingTriggerContainer.classList.remove('hidden');
        }
    }

    // Date validation
    document.getElementById('leavingDate').addEventListener('change', function() {
        const returnDateInput = document.getElementById('returnDate');
        if (this.value && returnDateInput.value && new Date(this.value) > new Date(returnDateInput.value)) {
            returnDateInput.value = this.value;
        }
    });

    document.getElementById('returnDate').addEventListener('change', function() {
        const leavingDateInput = document.getElementById('leavingDate');
        if (this.value && leavingDateInput.value && new Date(this.value) < new Date(leavingDateInput.value)) {
            showAlert('Return date cannot be earlier than leaving date', 'warning');
            this.value = leavingDateInput.value;
        }
    });

    // Edit form date validation
    document.getElementById('editLeavingDate').addEventListener('change', function() {
        const returnDateInput = document.getElementById('editReturnDate');
        if (this.value && returnDateInput.value && new Date(this.value) > new Date(returnDateInput.value)) {
            returnDateInput.value = this.value;
        }
    });

    document.getElementById('editReturnDate').addEventListener('change', function() {
        const leavingDateInput = document.getElementById('editLeavingDate');
        if (this.value && leavingDateInput.value && new Date(this.value) < new Date(leavingDateInput.value)) {
            showAlert('Return date cannot be earlier than leaving date', 'warning');
            this.value = leavingDateInput.value;
        }
    });

    // Force modal elements to be clickable when modals are shown
    const modals = ['addMlocModal', 'editMlocModal', 'deleteMlocModal', 'scheduleWarningModal', 'scheduleErrorModal'];
    
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
    
    // Searchable Dropdown Class (Enhanced Structure)
    class SearchableDropdown {
        constructor(element) {
            this.element = element;
            this.display = element.querySelector('.searchable-dropdown-display');
            this.displayInput = element.querySelector('.searchable-dropdown-display-input');
            this.searchContainer = element.querySelector('.searchable-dropdown-search-container');
            this.searchInput = element.querySelector('.searchable-dropdown-search-input');
            this.menu = element.querySelector('.searchable-dropdown-menu');
            this.hiddenInput = document.getElementById(this.displayInput.dataset.target);
            this.items = Array.from(element.querySelectorAll('.searchable-dropdown-item'));
            this.selectedIndex = -1;
            this.isOpen = false;
            this.toggleTimeout = null;
            
            this.init();
        }
        
        init() {
            // Display input events (readonly, only for toggling)
            this.displayInput.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
                this.toggle();
            });
            
            // Search input events (for actual searching)
            this.searchInput.addEventListener('input', (e) => this.handleSearch(e));
            this.searchInput.addEventListener('keydown', (e) => this.handleKeydown(e));
            
            // Menu item events
            this.items.forEach((item) => {
                item.addEventListener('click', (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    this.selectItemByElement(item);
                });
            });
            
            // Close on outside click
            document.addEventListener('click', (e) => {
                const isDropdownClick = this.element.contains(e.target);
                const isFloatingTrigger = e.target.closest('.floating-trigger-container');
                const isBodyDropdownMenu = e.target.closest('body > .searchable-dropdown-menu');
                
                if (!isDropdownClick && !isFloatingTrigger && !isBodyDropdownMenu) {
                    this.close();
                }
            }, true);
            
            // Update position on scroll and resize
            window.addEventListener('scroll', () => {
                if (this.isOpen) {
                    this.updatePosition();
                }
            });
            
            window.addEventListener('resize', () => {
                if (this.isOpen) {
                    this.updatePosition();
                }
            });
        }
        
        toggle() {
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
            this.isOpen = true;
            this.element.classList.add('open');
            
            // Show search container
            this.searchContainer.style.display = 'block';
            
            // Position and show menu
            setTimeout(() => {
                const displayRect = this.displayInput.getBoundingClientRect();
                
                // Attach to body for proper stacking
                if (this.menu.parentElement !== document.body) {
                    document.body.appendChild(this.menu);
                }
                
                this.menu.style.position = 'fixed';
                this.menu.style.top = (displayRect.bottom + 35) + 'px'; // Account for search input
                this.menu.style.left = displayRect.left + 'px';
                this.menu.style.width = displayRect.width + 'px';
                this.menu.style.zIndex = '2147483647';
                
                this.menu.classList.add('show');
                
                // Focus search input
                setTimeout(() => {
                    this.searchInput.focus();
                }, 50);
                
                this.filterItems('', '');
                this.selectedIndex = -1;
            }, 10);
        }
        
        close() {
            this.isOpen = false;
            this.element.classList.remove('open');
            
            // Hide search container
            this.searchContainer.style.display = 'none';
            
            // Hide menu
            this.menu.classList.remove('show');
            
            // Reset positioning and move back to original parent
            this.menu.style.position = '';
            this.menu.style.top = '';
            this.menu.style.left = '';
            this.menu.style.width = '';
            this.menu.style.zIndex = '';
            
            if (this.menu.parentElement === document.body) {
                this.element.appendChild(this.menu);
            }
            
            // Reset search
            this.searchInput.value = '';
            this.filterItems('', '');
            this.selectedIndex = -1;
            this.clearHighlight();
        }
        
        updatePosition() {
            if (this.isOpen && this.menu.parentElement === document.body) {
                const displayRect = this.displayInput.getBoundingClientRect();
                
                this.menu.style.top = (displayRect.bottom + 35) + 'px';
                this.menu.style.left = displayRect.left + 'px';
                this.menu.style.width = displayRect.width + 'px';
            }
        }
        
        handleSearch(e) {
            const originalQuery = e.target.value;
            const query = originalQuery.toLowerCase();
            this.filterItems(query, originalQuery);
            this.selectedIndex = -1;
        }
        
        handleKeydown(e) {
            const visibleItems = this.items.filter(item => item.style.display !== 'none');
            
            switch(e.key) {
                case 'ArrowDown':
                    e.preventDefault();
                    this.selectedIndex = Math.min(this.selectedIndex + 1, visibleItems.length - 1);
                    this.highlightItem();
                    break;
                    
                case 'ArrowUp':
                    e.preventDefault();
                    this.selectedIndex = Math.max(this.selectedIndex - 1, 0);
                    this.highlightItem();
                    break;
                    
                case 'Enter':
                    e.preventDefault();
                    if (this.selectedIndex >= 0 && this.selectedIndex < visibleItems.length) {
                        const selectedItem = visibleItems[this.selectedIndex];
                        this.selectItemByElement(selectedItem);
                    }
                    break;
                    
                case 'Escape':
                    e.preventDefault();
                    this.close();
                    break;
            }
        }
        
        filterItems(query, originalQuery) {
            let hasResults = false;
            
            this.items.forEach(item => {
                if (item.classList.contains('add-new-item') || item.classList.contains('no-results')) {
                    return;
                }
                
                const text = item.dataset.text.toLowerCase();
                const matches = text.includes(query);
                
                item.style.display = matches ? 'block' : 'none';
                if (matches) hasResults = true;
            });
            
            // Remove existing add-new/no-results items
            const existingAddNew = this.menu.querySelector('.add-new-item');
            const existingNoResults = this.menu.querySelector('.no-results');
            if (existingAddNew) existingAddNew.remove();
            if (existingNoResults) existingNoResults.remove();
            
            // Show add-new option if no results and query is not empty
            if (!hasResults && query.trim() !== '') {
                const dropdownId = this.element.id;
                
                if (dropdownId.includes('people')) {
                    this.showAddNewPerson(originalQuery || query);
                } else if (dropdownId.includes('destination')) {
                    this.showAddNewDestination(originalQuery || query);
                } else {
                    this.showNoResults();
                }
            }
        }
        
        showAddNewPerson(query) {
            const addNewItem = document.createElement('div');
            addNewItem.className = 'searchable-dropdown-item add-new-item';
            addNewItem.innerHTML = `<i class="bi bi-person-plus me-2"></i>Add new person: "${query}"`;
            
            addNewItem.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
                this.addNewPerson(query);
            });
            
            this.menu.appendChild(addNewItem);
        }
        
        showAddNewDestination(query) {
            const addNewItem = document.createElement('div');
            addNewItem.className = 'searchable-dropdown-item add-new-item';
            addNewItem.innerHTML = `<i class="bi bi-plus-circle me-2"></i>Add new destination: "${query}"`;
            
            addNewItem.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
                this.addNewDestination(query);
            });
            
            this.menu.appendChild(addNewItem);
        }
        
        showNoResults() {
            const noResultsItem = document.createElement('div');
            noResultsItem.className = 'searchable-dropdown-item no-results';
            noResultsItem.textContent = 'Tidak ada hasil ditemukan';
            this.menu.appendChild(noResultsItem);
        }
        
        highlightItem() {
            this.clearHighlight();
            const visibleItems = this.items.filter(item => item.style.display !== 'none');
            
            if (this.selectedIndex >= 0 && this.selectedIndex < visibleItems.length) {
                visibleItems[this.selectedIndex].classList.add('selected');
                visibleItems[this.selectedIndex].scrollIntoView({
                    block: 'nearest',
                    behavior: 'smooth'
                });
            }
        }
        
        clearHighlight() {
            this.items.forEach(item => item.classList.remove('selected'));
        }
        
        selectItemByElement(item) {
            const value = item.dataset.value;
            const text = item.dataset.text;
            
            this.displayInput.value = text;
            this.hiddenInput.value = value;
            
            this.close();
            
            // Trigger change event
            const changeEvent = new Event('change', { bubbles: true });
            this.hiddenInput.dispatchEvent(changeEvent);
        }
        
        setValue(value, text) {
            this.displayInput.value = text || '';
            this.hiddenInput.value = value || '';
        }
        
        reset() {
            this.setValue('', '');
        }
        
        reloadDropdownData(type) {
            return new Promise((resolve, reject) => {
                // Fetch fresh data from server
                const endpoint = type === 'people' ? '<?= base_url('people/getAll') ?>' : '<?= base_url('destinations/getAll') ?>';
                
                fetch(endpoint, {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Clear existing menu items (except search container)
                        this.menu.innerHTML = '';
                        
                        // Rebuild menu with fresh data
                        data.data.forEach(item => {
                            const menuItem = document.createElement('div');
                            menuItem.className = 'searchable-dropdown-item';
                            if (type === 'people') {
                                menuItem.dataset.value = item.id;
                                menuItem.dataset.text = item.name;
                                menuItem.textContent = item.name;
                            } else {
                                menuItem.dataset.value = item.id;
                                menuItem.dataset.text = item.destination_name;
                                menuItem.textContent = item.destination_name;
                            }
                            
                            menuItem.addEventListener('click', (e) => {
                                e.preventDefault();
                                e.stopPropagation();
                                this.selectItemByElement(menuItem);
                            });
                            
                            this.menu.appendChild(menuItem);
                        });
                        
                        // Update items array
                        this.items = Array.from(this.element.querySelectorAll('.searchable-dropdown-item:not(.add-new-item):not(.no-results)'));
                        
                        resolve();
                    } else {
                        reject(new Error(data.message || 'Failed to load data'));
                    }
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                    reject(error);
                });
            });
        }
        
        addNewPerson(personName) {
            const addNewItem = this.menu.querySelector('.add-new-item');
            if (addNewItem) {
                addNewItem.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Adding person...';
                addNewItem.style.pointerEvents = 'none';
            }
            
            const csrfToken = document.querySelector('input[name="<?= csrf_token() ?>"]')?.value;
            
            fetch('<?= base_url('people/addQuick') ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    name: personName.trim(),
                    <?= csrf_token() ?>: csrfToken
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Reload the entire dropdown menu with fresh data
                    this.reloadDropdownData('people').then(() => {
                        // Set the newly added person as selected
                        this.setValue(data.person.id, data.person.name);
                        this.close();
                        
                        this.showModalNotification(`Person "${data.person.name}" successfully added!`, 'success');
                    }).catch(error => {
                        console.error('Error reloading dropdown data:', error);
                        // Fallback to the old method if reload fails
                        const newItem = document.createElement('div');
                        newItem.className = 'searchable-dropdown-item';
                        newItem.dataset.value = data.person.id;
                        newItem.dataset.text = data.person.name;
                        newItem.textContent = data.person.name;
                        
                        newItem.addEventListener('click', (e) => {
                            e.preventDefault();
                            e.stopPropagation();
                            this.selectItemByElement(newItem);
                        });
                        
                        this.menu.insertBefore(newItem, addNewItem);
                        this.items = Array.from(this.element.querySelectorAll('.searchable-dropdown-item:not(.add-new-item):not(.no-results)'));
                        
                        this.setValue(data.person.id, data.person.name);
                        this.close();
                        
                        this.showModalNotification(`Person "${data.person.name}" successfully added!`, 'success');
                    });
                } else {
                    this.showModalNotification(data.message || 'Failed to add new person', 'danger');
                    if (addNewItem) {
                        addNewItem.innerHTML = `<i class="bi bi-person-plus me-2"></i>Add new person: "${personName}"`;
                        addNewItem.style.pointerEvents = 'auto';
                    }
                }
            })
            .catch(error => {
                console.error('Error adding person:', error);
                this.showModalNotification('An error occurred while adding the person', 'danger');
                if (addNewItem) {
                    addNewItem.innerHTML = `<i class="bi bi-person-plus me-2"></i>Add new person: "${personName}"`;
                    addNewItem.style.pointerEvents = 'auto';
                }
            });
        }
        
        addNewDestination(destinationName) {
            const addNewItem = this.menu.querySelector('.add-new-item');
            if (addNewItem) {
                addNewItem.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Adding destination...';
                addNewItem.style.pointerEvents = 'none';
            }
            
            const csrfToken = document.querySelector('input[name="<?= csrf_token() ?>"]')?.value;
            
            fetch('<?= base_url('destinations/addQuick') ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    destination_name: destinationName.trim(),
                    <?= csrf_token() ?>: csrfToken
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Reload the entire dropdown menu with fresh data
                    this.reloadDropdownData('destinations').then(() => {
                        // Set the newly added destination as selected
                        this.setValue(data.destination.id, data.destination.destination_name);
                        this.close();
                        
                        this.showModalNotification(`Destination "${data.destination.destination_name}" successfully added!`, 'success');
                    }).catch(error => {
                        console.error('Error reloading dropdown data:', error);
                        // Fallback to the old method if reload fails
                        const newItem = document.createElement('div');
                        newItem.className = 'searchable-dropdown-item';
                        newItem.dataset.value = data.destination.id;
                        newItem.dataset.text = data.destination.destination_name;
                        newItem.textContent = data.destination.destination_name;
                        
                        newItem.addEventListener('click', (e) => {
                            e.preventDefault();
                            e.stopPropagation();
                            this.selectItemByElement(newItem);
                        });
                        
                        this.menu.insertBefore(newItem, addNewItem);
                        this.items = Array.from(this.element.querySelectorAll('.searchable-dropdown-item:not(.add-new-item):not(.no-results)'));
                        
                        this.setValue(data.destination.id, data.destination.destination_name);
                        this.close();
                        
                        this.showModalNotification(`Destination "${data.destination.destination_name}" successfully added!`, 'success');
                    });
                } else {
                    this.showModalNotification(data.message || 'Failed to add new destination', 'danger');
                    if (addNewItem) {
                        addNewItem.innerHTML = `<i class="bi bi-plus-circle me-2"></i>Add new destination: "${destinationName}"`;
                        addNewItem.style.pointerEvents = 'auto';
                    }
                }
            })
            .catch(error => {
                console.error('Error adding destination:', error);
                this.showModalNotification('An error occurred while adding the destination', 'danger');
                if (addNewItem) {
                    addNewItem.innerHTML = `<i class="bi bi-plus-circle me-2"></i>Add new destination: "${destinationName}"`;
                    addNewItem.style.pointerEvents = 'auto';
                }
            });
        }
        
        showModalNotification(message, type) {
            const notification = document.createElement('div');
            notification.className = 'modal-notification';
            notification.style.position = 'fixed';
            notification.style.top = 'calc(70px + 20px)'; // Navbar height + 20px margin
            notification.style.left = '50%';
            notification.style.transform = 'translateX(-50%)';
            notification.style.zIndex = '999999999';
            notification.style.minWidth = '300px';
            notification.innerHTML = `
                <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            `;
            
            document.body.appendChild(notification);
            
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
    }
    
    // Initialize searchable dropdowns
    const searchableDropdowns = {};
    
    document.querySelectorAll('.searchable-dropdown').forEach(element => {
        const dropdown = new SearchableDropdown(element);
        searchableDropdowns[element.id] = dropdown;
    });

    // Initialize configuration mode on page load
    initializeConfigMode();
});
</script>

<?= $this->endSection() ?>