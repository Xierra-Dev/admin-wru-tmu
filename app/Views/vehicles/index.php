<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<style>
    /* Custom CSS for Vehicle Page */
    .vehicles-page-container {
        padding: 20px;
        width: 100%;
    }

    .header-section {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-bottom: 20px;
        position: relative;
    }
    
    .back-button {
        background-color: rgba(92, 92, 92, 1);
        color: #ffffffff;
        padding: 8px 25px;
        border-radius: 8px 50px 50px 8px;
        text-decoration: none;
        font-weight: 500;
        transition: background-color 0.3s;
        position: absolute;
        left: 0;
    }

    .back-button:hover {
        background-color: rgba(92, 92, 92, 1);
    }

    .search-section {
        position: relative;
        flex-grow: 1;
        display: flex;
        margin: 0 20px;
        max-width: 600px;
    }
    
    .search-input {
        width: 150%;
        padding: 10px 40px 10px 20px;
        border-radius: 20px;
        border: 1px solid #d1d5db;
        outline: none;
    }

    .search-icon {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #9ca3af;
    }

    .add-button {
        background-color: rgba(0, 157, 255, 1);
        color: white;
        padding: 10px 30px;
        border-radius: 50px 8px 8px 50px;
        text-decoration: none;
        font-weight: 600;
        transition: background-color 0.3s;
        position: absolute;
        right: 0;
    }

    .add-button:hover {
        background-color: rgba(0, 157, 255, 1);
    }

    .main-card {
        background-color: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(5px);
        border-radius: 15px;
        padding: 20px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    .card-title {
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 20px;
        text-align: center;
    }

    .vehicle-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .vehicle-item {
        display: flex;
        align-items: stretch;
        background-color: white;
        border-radius: 10px;
        margin-bottom: 10px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        overflow: hidden;
    }

    .vehicle-left-section {
        width: 2%;
        background-color: #007bff;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 15px 10px;
    }

    .vehicle-right-section {
        width: 98%;
        background-color: white;
        display: flex;
        align-items: center;
        padding: 15px 20px;
    }

    .vehicle-number {
        font-size: 1.1rem;
        font-weight: 600;
        color: white;
        text-align: center;
    }

    .vehicle-name {
        flex-grow: 1;
        font-size: 1.1rem;
        color: #333;
        font-weight: 500;
    }

    .vehicle-actions {
        display: flex;
        gap: 10px;
    }

    .action-btn {
        width: 40px;
        height: 40px;
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 8px;
        text-decoration: none;
        font-size: 1.1rem;
        border: 2px solid;
        background: transparent;
        transition: all 0.3s ease;
    }

    .edit-btn {
        border-color: #007bff;
        color: #007bff;
    }

    .delete-btn {
        border-color: #dc3545;
        color: #dc3545;
    }

    /* Modal styles */
    .modal {
        display: none;
        position: fixed;
        z-index: 1050; /* Standard modal z-index */
        inset: 0;
        overflow: auto;
        background: rgba(0,0,0,0.35);
        padding: calc(var(--global-navbar-height) + 50px) 16px 42px 16px; /* Added top padding to push modal below navbar */
    }
    
    .modal-content {
        border-radius: 1rem;
        background: #fff;
        margin: 0 auto;
        padding: 1rem;
        width: 92%;
        max-width: 520px;
        border: 1px solid #e5e7eb;
        box-shadow: 0 16px 48px rgba(0,0,0,0.18);
        position: relative;
        z-index: 1051; /* Standard modal content z-index */
        margin-top: 0; /* Remove any additional top margin since we added padding to modal */
    }

    .modal-header {
        border-bottom: none;
        padding: 6px 6px 2px;
        display: flex;
        justify-content: center;
        align-items: center;
        position: relative;
    }

    .modal-header h4 {
        margin: 0;
        font-weight: 700;
        font-size: 18px;
        color: #111827;
    }

    .close-btn {
        position: absolute;
        right: 8px;
        top: 8px;
        width: 32px;
        height: 32px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: #f3f4f6;
        color: #111827;
        border: 1px solid #e5e7eb;
        font-size: 18px;
        cursor: pointer;
        line-height: 1;
    }

    .close-btn:hover { 
        background: #e5e7eb; 
    }

    .modal-body {
        padding: 8px 2px 6px;
    }

    .modal-body .form-group {
        margin-bottom: 12px;
    }

    .modal-body .form-group label {
        margin-bottom: 6px;
        font-weight: 600;
        color: #111827;
        display: flex;
        justify-content: center;
        align-items: center;
        position: relative;
    }

    .modal-body .form-group input {
        width: 100%;
        height: 44px;
        padding: 10px 12px;
        border: 1.5px solid #e5e7eb;
        border-radius: 12px;
        outline: none;
        font-size: 14px;
        box-sizing: border-box;
    }

    .modal-body .form-group input::placeholder {
        color: #9ca3af;
    }

    /* Panel daftar yang akan ditambahkan */
    #added-vehicles {
        margin-top: 10px;
        border: 1px solid #e5e7eb;
        border-radius: 16px;
        background: #ffffff;
        padding: 12px;
        box-shadow: inset 0 1px 0 rgba(0,0,0,0.02);
    }

    #added-vehicles > label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #111827;
    }

    #added-vehicles-list {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        min-height: 30px;
    }

    #added-vehicles-list .chip {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 6px 10px;
        border-radius: 9999px;
        background: #f3f4f6;
        border: 1px solid #e5e7eb;
        font-size: 13px;
        color: #111827;
        font-weight: 500;
    }

    #added-vehicles-list .chip .chip-remove {
        width: 18px;
        height: 18px;
        border-radius: 50%;
        background: #e5e7eb;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 12px;
        line-height: 1;
    }

    .modal-footer {
        border-top: none;
        padding-top: 8px;
        display: flex;
        gap: 10px;
        justify-content: center;
    }

    .modal-footer .btn {
        flex: 1;
        height: 46px;
        border: none;
        border-radius: 12px;
        font-weight: 700;
        color: #fff;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-primary {
        background: linear-gradient(180deg, #1f38ff 0%, #00a9ff 100%);
        box-shadow: 0 8px 16px rgba(0, 169, 255, 0.35);
    }

    .btn-success {
        background: linear-gradient(180deg, #28a745 0%, #20c997 100%);
        box-shadow: 0 8px 16px rgba(40, 167, 69, 0.35);
    }

    .btn-secondary {
        background: linear-gradient(180deg, #6c757d 0%, #5a6268 100%);
        box-shadow: 0 8px 16px rgba(108, 117, 125, 0.35);
    }

    .btn-danger {
        background: linear-gradient(180deg, #dc3545 0%, #c82333 100%);
        box-shadow: 0 8px 16px rgba(220, 53, 69, 0.35);
    }

    .btn:active {
        transform: translateY(1px);
    }

    /* Styling untuk trigger melayang */
    .floating-trigger-container {
        position: fixed;
        bottom: 2rem;
        right: 2rem;
        z-index: 10001 !important;
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

    /* Kelas untuk menampilkan elemen dengan animasi */
    .visible {
        display: flex !important;
        opacity: 1;
        pointer-events: auto;
    }

    .add-button.visible {
        display: block !important;
    }

    .vehicle-actions.visible {
        display: flex !important;
    }

    /* Empty state styling */
    .empty-state {
        text-align: center;
        padding: 40px 20px;
    }

    .empty-state i {
        font-size: 3rem;
        color: #9ca3af;
    }

    .empty-state h5 {
        color: #6b7280;
        margin-top: 1rem;
    }

    .empty-state p {
        color: #9ca3af;
    }

    @media (max-width: 420px) {
        .modal-content { 
            border-radius: 20px; 
            padding: 16px; 
        }
        .modal-body .form-group input { 
            height: 42px; 
        }
        .modal {
            padding: 100px 8px 20px 8px; /* Adjust padding for mobile */
        }
    }

    /* Special styling for Edit Vehicle Modal */
    .edit-modal-content {
        background: #ffffff;
        border-radius: 24px;
        padding: 32px;
        width: 90%;
        max-width: 480px;
        border: none;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
        position: relative;
        margin: 0 auto;
        margin-top: 0;
    }

    .edit-modal-header {
        border-bottom: none;
        padding: 0 0 24px 0;
        display: flex;
        justify-content: center;
        align-items: center;
        position: relative;
    }

    .edit-modal-header h4 {
        margin: 0;
        font-weight: 700;
        font-size: 24px;
        color: #000000;
        text-align: center;
    }

    .edit-close-btn {
        position: absolute;
        right: 0;
        top: 0;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: #f0f0f0;
        color: #666666;
        border: none;
        font-size: 24px;
        cursor: pointer;
        line-height: 1;
        font-weight: normal;
    }

    .edit-modal-body {
        padding: 0 0 32px 0;
    }

    .edit-form-group {
        margin-bottom: 24px;
    }

    .edit-label {
        display: block;
        margin-bottom: 16px;
        font-weight: 500;
        color: #000000;
        font-size: 16px;
        text-align: center;
    }

    .edit-input {
        width: 100%;
        height: 56px;
        padding: 16px 20px;
        border: 2px solid #e0e0e0;
        border-radius: 28px;
        outline: none;
        font-size: 16px;
        box-sizing: border-box;
        background: #ffffff;
        transition: border-color 0.3s ease;
    }

    .edit-input:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.1);
    }

    .edit-input::placeholder {
        color: #cccccc;
        font-size: 16px;
    }

    .edit-modal-footer {
        border-top: none;
        padding: 0;
        display: flex;
        justify-content: center;
    }

    .edit-save-btn {
        width: 100%;
        height: 56px;
        border: none;
        border-radius: 28px;
        font-weight: 700;
        font-size: 18px;
        color: #ffffff;
        background: linear-gradient(135deg, #00a9ff 0%, #0080ff 100%);
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 8px 20px rgba(0, 169, 255, 0.3);
    }

    .edit-save-btn:active {
        transform: translateY(0);
    }

    /* Special styling for Add Vehicle Modal */
    .add-modal-content {
        background: #ffffff;
        border-radius: 24px;
        padding: 32px;
        width: 90%;
        max-width: 520px;
        border: none;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
        position: relative;
        margin: 0 auto;
        margin-top: 0;
    }

    .add-modal-header {
        border-bottom: none;
        padding: 0 0 24px 0;
        display: flex;
        justify-content: center;
        align-items: center;
        position: relative;
    }

    .add-modal-header h4 {
        margin: 0;
        font-weight: 700;
        font-size: 24px;
        color: #000000;
        text-align: center;
    }

    .add-close-btn {
        position: absolute;
        right: 0;
        top: 0;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: #f0f0f0;
        color: #666666;
        border: none;
        font-size: 24px;
        cursor: pointer;
        line-height: 1;
        font-weight: normal;
    }

    .add-modal-body {
        padding: 0 0 32px 0;
    }

    .add-form-group {
        margin-bottom: 24px;
        position: relative;
    }

    .add-label {
        display: block;
        margin-bottom: 16px;
        font-weight: 500;
        color: #000000;
        font-size: 16px;
        text-align: center;
    }

    .add-input {
        width: 100%;
        height: 56px;
        padding: 16px 20px;
        border: 2px solid #e0e0e0;
        border-radius: 28px;
        outline: none;
        font-size: 16px;
        box-sizing: border-box;
        background: #ffffff;
        transition: border-color 0.3s ease;
        margin-bottom: 16px;
    }

    .add-input:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.1);
    }

    .add-input::placeholder {
        color: #cccccc;
        font-size: 16px;
    }

    .add-btn {
        width: 100%;
        height: 56px;
        border: none;
        border-radius: 28px;
        font-weight: 700;
        font-size: 18px;
        color: #ffffff;
        background: linear-gradient(135deg, #1f38ff 0%, #0028d4 100%);
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 8px 20px rgba(31, 56, 255, 0.3);
    }

    .add-btn:active {
        transform: translateY(0);
    }

    /* Vehicle data to be added section */
    .add-people-section {
        margin-bottom: 24px;
        padding: 20px;
        border: 2px solid #e0e0e0;
        border-radius: 16px;
        background: #fafafa;
    }

    .add-people-label {
        display: block;
        margin-bottom: 16px;
        font-weight: 500;
        color: #000000;
        font-size: 16px;
        text-align: center;
    }

    .add-people-list {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        min-height: 40px;
        justify-content: flex-start;
        align-items: flex-start;
    }

    .add-chip {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 16px;
        border-radius: 24px;
        background: #d0d0d0;
        border: 1px solid #c0c0c0;
        font-size: 14px;
        color: #333333;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .add-chip-remove {
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background: #999999;
        color: #ffffff;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 14px;
        line-height: 1;
        font-weight: bold;
        transition: background-color 0.3s ease;
    }

    .add-modal-footer {
        border-top: none;
        padding: 0;
        display: flex;
        justify-content: center;
    }

    .add-save-btn {
        width: 100%;
        height: 56px;
        border: none;
        border-radius: 28px;
        font-weight: 700;
        font-size: 18px;
        color: #ffffff;
        background: linear-gradient(135deg, #00bcd4 0%, #00a9c0 100%);
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 8px 20px rgba(0, 188, 212, 0.3);
    }

    .add-save-btn:active {
        transform: translateY(0);
    }
</style>

<div class="vehicles-page-container">
    <div class="header-section">
        <a href="<?= base_url('dashboard') ?>" class="back-button hidden" id="back-button">
            <i class="bi bi-chevron-left me-2"></i> Kembali
        </a>
        <div class="search-section">
            <input type="text" class="search-input" placeholder="Search..." id="search-input">
            <i class="bi bi-search search-icon"></i>
        </div>
        <a href="#" class="add-button hidden" id="add-vehicle-btn">
            <i class="bi bi-plus-lg"></i> Tambah
        </a>
    </div>

    <div class="main-card">
        <h3 class="card-title" id="page-title">Kendaraan</h3>
        <div class="card-body">
            <?php if (empty($vehicles)): ?>
                <div class="empty-state">
                    <i class="bi bi-truck text-muted"></i>
                    <h5 class="text-muted mt-3">Belum ada data kendaraan</h5>
                    <p class="text-muted">Klik tombol "Tambah" untuk menambahkan data baru.</p>
                </div>
            <?php else: ?>
                <ul class="vehicle-list" id="vehicle-list">
                    <?php
                    $currentPage = $pager->getCurrentPage();
                    $perPage = $pager->getPerPage();
                    $startNumber = ($currentPage - 1) * $perPage;
                    ?>
                    <?php foreach ($vehicles as $index => $vehicle): ?>
                        <li class="vehicle-item" data-name="<?= strtolower(esc($vehicle['vehicle_name'] . ' ' . $vehicle['number_plate'])) ?>">
                            <div class="vehicle-left-section">
                                <span class="vehicle-number"><?= $startNumber + $index + 1 ?></span>
                            </div>
                            <div class="vehicle-right-section">
                                <span class="vehicle-name"><?= esc($vehicle['vehicle_name']) ?> - <?= esc($vehicle['number_plate']) ?></span>
                                <div class="vehicle-actions hidden">
                                    <a href="#" class="action-btn edit-btn" data-id="<?= $vehicle['id'] ?>" data-name="<?= esc($vehicle['vehicle_name']) ?>" data-plate="<?= esc($vehicle['number_plate']) ?>">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="#" class="action-btn delete-btn" data-id="<?= $vehicle['id'] ?>">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </div>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <div class="mt-4 d-flex justify-content-center">
                    <?= $pager->links('default', 'bootstrap_pager') ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <div class="floating-trigger-container">
        <img src="<?= base_url('img/Group.png') ?>" alt="Action Trigger" class="floating-trigger-icon" id="actionTrigger">
    </div>
</div>

<!-- Modal Add/Edit Vehicle -->
<div id="vehicle-modal" class="modal">
    <div class="modal-content add-modal-content">
        <div class="modal-header add-modal-header">
            <h4 id="modal-title">Add Vehicle</h4>
            <span class="close-btn add-close-btn" onclick="closeModal()">&times;</span>
        </div>
        <form id="vehicle-form" method="post" action="#" onsubmit="return false;">
            <?= csrf_field() ?>
            <input type="hidden" name="id" id="vehicle-id">
            <input type="hidden" id="addConfigMode" name="config_mode" value="0">
            <div class="modal-body add-modal-body">
                <div class="form-group add-form-group">
                    <label for="vehicle-name" class="add-label">Vehicle Name</label>
                    <input type="text" name="vehicle_name" id="vehicle-name" class="add-input" placeholder="Enter vehicle name" required>
                </div>
                <div class="form-group add-form-group">
                    <label for="vehicle-plate" class="add-label">Number Plate</label>
                    <input type="text" name="number_plate" id="vehicle-plate" class="add-input" placeholder="Enter number plate (e.g., D 1299 SAX)" required>
                    <button type="button" class="btn add-btn" id="modal-add-btn">Add</button>
                </div>
                
                <!-- Panel untuk data sementara -->
                <div id="added-vehicles" class="add-people-section" style="display: none;">
                    <label class="add-people-label">Vehicle data to be added</label>
                    <div id="added-vehicles-list" class="add-people-list">
                        <?php if (!empty($tmp_vehicles)): ?>
                            <?php foreach ($tmp_vehicles as $tmp): ?>
                                <div class="add-chip" data-tmp-id="<?= $tmp['id'] ?>">
                                    <?= esc($tmp['vehicle_name']) ?> - <?= esc($tmp['number_plate']) ?>
                                    <span class="add-chip-remove" onclick="removeTmp(<?= $tmp['id'] ?>)">&times;</span>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer add-modal-footer">
                <button type="button" class="btn add-save-btn" id="modal-save-btn">Save</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Single Vehicle -->
<div id="edit-modal" class="modal">
    <div class="modal-content edit-modal-content">
        <div class="modal-header edit-modal-header">
            <h4>Edit Vehicle</h4>
            <span class="close-btn edit-close-btn" onclick="closeEditModal()">&times;</span>
        </div>
        <form id="edit-form" method="post" action="<?= base_url('vehicles/update') ?>">
            <?= csrf_field() ?>
            <input type="hidden" name="id" id="edit-vehicle-id">
            <input type="hidden" id="editConfigMode" name="config_mode" value="0">
            <div class="modal-body edit-modal-body">
                <div class="form-group edit-form-group">
                    <label for="edit-vehicle-name" class="edit-label">Vehicle Name</label>
                    <input type="text" name="vehicle_name" id="edit-vehicle-name" class="edit-input" placeholder="Enter vehicle name" required>
                </div>
                <div class="form-group edit-form-group">
                    <label for="edit-vehicle-plate" class="edit-label">Number Plate</label>
                    <input type="text" name="number_plate" id="edit-vehicle-plate" class="edit-input" placeholder="Enter number plate" required>
                </div>
            </div>
            <div class="modal-footer edit-modal-footer">
                <button type="submit" class="btn edit-save-btn">Save</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Delete Confirmation -->
<div id="delete-modal" class="modal">
    <div class="modal-content text-center">
        <div class="modal-header">
            <h4>WARNING!</h4>
            <span class="close-btn" onclick="closeDeleteModal()">&times;</span>
        </div>
        <div class="modal-body">
            <i class="bi bi-trash-fill text-danger" style="font-size: 3rem;"></i>
            <p class="mt-3">This action will result in the permanent deletion of the selected data. Once deleted, the data cannot be recovered.</p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" onclick="closeDeleteModal()">Cancel</button>
            <a href="#" class="btn btn-danger" id="confirm-delete-btn">Delete</a>
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

    // Initialize configuration mode on page load
    function initializeConfigMode() {
        updateFormConfigMode(isConfigMode);
        
        if (isConfigMode) {
            enterConfigurationMode();
        } else {
            returnToInitialState();
        }
    }

    // Helper function to enter configuration mode
    function enterConfigurationMode() {
        const addButton = document.getElementById('add-vehicle-btn');
        const backButton = document.getElementById('back-button');
        const vehicleActions = document.querySelectorAll('.vehicle-actions');
        const pageTitle = document.getElementById('page-title');
        const floatingTriggerContainer = document.querySelector('.floating-trigger-container');
        
        // Show all action buttons
        if (addButton) {
            addButton.classList.remove('hidden');
            addButton.classList.add('visible');
        }
        if (backButton) {
            backButton.classList.remove('hidden');
            backButton.classList.add('visible');
        }
        vehicleActions.forEach(actions => {
            actions.classList.remove('hidden');
            actions.classList.add('visible');
        });
        
        // Change title to configuration mode
        if (pageTitle) {
            pageTitle.textContent = 'Konfigurasi Kendaraan';
        }
        
        // Hide trigger button
        if (floatingTriggerContainer) {
            floatingTriggerContainer.classList.add('hidden');
        }
    }

    // Helper function to return to initial state
    function returnToInitialState() {
        const addButton = document.getElementById('add-vehicle-btn');
        const backButton = document.getElementById('back-button');
        const vehicleActions = document.querySelectorAll('.vehicle-actions');
        const pageTitle = document.getElementById('page-title');
        const floatingTriggerContainer = document.querySelector('.floating-trigger-container');
        
        // Hide all action buttons
        if (addButton) {
            addButton.classList.remove('visible');
            addButton.classList.add('hidden');
        }
        if (backButton) {
            backButton.classList.remove('visible');
            backButton.classList.add('hidden');
        }
        vehicleActions.forEach(actions => {
            actions.classList.remove('visible');
            actions.classList.add('hidden');
        });
        
        // Change title back to normal
        if (pageTitle) {
            pageTitle.textContent = 'Kendaraan';
        }
        
        // Show trigger button
        if (floatingTriggerContainer) {
            floatingTriggerContainer.classList.remove('hidden');
        }
    }

    // Utility function to escape HTML
    function escapeHtml(text) {
        const map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        };
        return text.replace(/[&<>"']/g, function(m) { return map[m]; });
    }

    // Search functionality
    document.getElementById('search-input').addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        const vehicleItems = document.querySelectorAll('.vehicle-item');
        
        vehicleItems.forEach(item => {
            const name = item.getAttribute('data-name');
            if (name.includes(searchTerm)) {
                item.style.display = 'flex';
            } else {
                item.style.display = 'none';
            }
        });
    });

    // Modal functions
    function openModal() {
        const modal = document.getElementById('vehicle-modal');
        const addBtn = document.getElementById('modal-add-btn');
        const saveBtn = document.getElementById('modal-save-btn');
        const vehicleNameInput = document.getElementById('vehicle-name');
        const vehiclePlateInput = document.getElementById('vehicle-plate');
        
        // Reset form
        vehicleNameInput.value = '';
        vehiclePlateInput.value = '';
        document.getElementById('vehicle-id').value = '';
        
        // Show both buttons for add mode
        addBtn.style.display = 'block';
        saveBtn.style.display = 'block';
        
        // Show tmp_vehicles panel if there's data
        updateTmpVehiclesPanel();
        
        modal.style.display = 'block';
        vehicleNameInput.focus();
    }

    function openEditModal(id, name, plate) {
        const modal = document.getElementById('edit-modal');
        document.getElementById('edit-vehicle-id').value = id;
        document.getElementById('edit-vehicle-name').value = name;
        document.getElementById('edit-vehicle-plate').value = plate;
        modal.style.display = 'block';
        document.getElementById('edit-vehicle-name').focus();
    }

    function closeModal() {
        const modal = document.getElementById('vehicle-modal');
        modal.style.display = 'none';
    }

    function closeEditModal() {
        const modal = document.getElementById('edit-modal');
        modal.style.display = 'none';
    }

    function openDeleteModal(id) {
        const modal = document.getElementById('delete-modal');
        const confirmBtn = document.getElementById('confirm-delete-btn');
        
        // Add config_mode parameter to delete URL
        const currentConfigMode = isConfigMode || addButton.classList.contains('visible');
        confirmBtn.href = `<?= base_url('vehicles/delete/') ?>/${id}${currentConfigMode ? '?config_mode=1' : ''}`;
        modal.style.display = 'block';
    }

    function closeDeleteModal() {
        const modal = document.getElementById('delete-modal');
        modal.style.display = 'none';
    }

    // Update tmp_vehicles panel visibility
    function updateTmpVehiclesPanel() {
        const panel = document.getElementById('added-vehicles');
        const list = document.getElementById('added-vehicles-list');
        
        if (list.children.length > 0) {
            panel.style.display = 'block';
        } else {
            panel.style.display = 'none';
        }
    }

    // Add to tmp_vehicles
    document.getElementById('modal-add-btn').addEventListener('click', function(e) {
        e.preventDefault();
        const form = document.getElementById('vehicle-form');
        const nameInput = document.getElementById('vehicle-name');
        const plateInput = document.getElementById('vehicle-plate');
        const name = nameInput.value.trim();
        const plate = plateInput.value.trim();
        
        if (!name) {
            alert('Nama kendaraan tidak boleh kosong');
            nameInput.focus();
            return;
        }
        
        if (!plate) {
            alert('Nomor plat tidak boleh kosong');
            plateInput.focus();
            return;
        }

        const formData = new FormData(form);
        formData.set('vehicle_name', name);
        formData.set('number_plate', plate);

        fetch('<?= base_url('vehicles/addTmp') ?>', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                const tmp = data.data;
                const list = document.getElementById('added-vehicles-list');
                
                // Create chip element
                const chip = document.createElement('div');
                chip.className = 'add-chip';
                chip.setAttribute('data-tmp-id', tmp.id);
                chip.innerHTML = escapeHtml(tmp.vehicle_name) + ' - ' + escapeHtml(tmp.number_plate) + ' <span class="add-chip-remove" onclick="removeTmp(' + tmp.id + ')">&times;</span>';
                list.appendChild(chip);

                // Clear inputs and update panel visibility
                nameInput.value = '';
                plateInput.value = '';
                updateTmpVehiclesPanel();
                nameInput.focus();
            } else {
                if (data.errors) {
                    const errorMessages = Object.values(data.errors).join('\n');
                    alert(errorMessages);
                } else {
                    alert(data.message || 'Gagal menambahkan data sementara');
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat menambahkan data');
        });
    });

    // Save all data (from tmp_vehicles + current input)
    document.getElementById('modal-save-btn').addEventListener('click', function() {
        const nameInput = document.getElementById('vehicle-name');
        const plateInput = document.getElementById('vehicle-plate');
        const currentName = nameInput.value.trim();
        const currentPlate = plateInput.value.trim();
        
        // Create form to submit to saveVehicles endpoint
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '<?= base_url('vehicles/saveVehicles') ?>';

        // Add CSRF token
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '<?= csrf_token() ?>';
        csrfInput.value = '<?= csrf_hash() ?>';
        form.appendChild(csrfInput);

        // Add current inputs if not empty
        if (currentName && currentPlate) {
            const nameInput = document.createElement('input');
            nameInput.type = 'hidden';
            nameInput.name = 'current_name';
            nameInput.value = currentName;
            form.appendChild(nameInput);

            const plateInput = document.createElement('input');
            plateInput.type = 'hidden';
            plateInput.name = 'current_plate';
            plateInput.value = currentPlate;
            form.appendChild(plateInput);
        }

        // Add config_mode parameter
        const currentConfigMode = isConfigMode || addButton.classList.contains('visible');
        const configInput = document.createElement('input');
        configInput.type = 'hidden';
        configInput.name = 'config_mode';
        configInput.value = currentConfigMode ? '1' : '0';
        form.appendChild(configInput);

        document.body.appendChild(form);
        form.submit();
    });

    // Remove from tmp_vehicles
    function removeTmp(id) {
        if (!confirm('Hapus kendaraan dari daftar sementara?')) return;

        fetch('<?= base_url('vehicles/removeTmp') ?>/' + id, {
            method: 'DELETE',
            headers: { 
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': '<?= csrf_hash() ?>'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                // Remove chip from DOM
                const chip = document.querySelector('[data-tmp-id="' + id + '"]');
                if (chip) {
                    chip.remove();
                }
                updateTmpVehiclesPanel();
            } else {
                alert(data.message || 'Gagal menghapus item');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat menghapus item');
        });
    }

    // Event listeners
    document.getElementById('add-vehicle-btn').addEventListener('click', function(e) {
        e.preventDefault();
        openModal();
    });

    document.querySelectorAll('.edit-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const id = this.getAttribute('data-id');
            const name = this.getAttribute('data-name');
            const plate = this.getAttribute('data-plate');
            openEditModal(id, name, plate);
        });
    });

    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const id = this.getAttribute('data-id');
            openDeleteModal(id);
        });
    });

    // Floating trigger functionality
    const floatingTriggerContainer = document.querySelector('.floating-trigger-container');
    const addButton = document.getElementById('add-vehicle-btn');
    const vehicleActions = document.querySelectorAll('.vehicle-actions');
    const backButton = document.getElementById('back-button');
    const pageTitle = document.getElementById('page-title');

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
                // Enter configuration mode and update URL
                enterConfigurationMode();
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

    // Close modals when clicking outside
    window.onclick = function(event) {
        const modal = document.getElementById('vehicle-modal');
        const editModal = document.getElementById('edit-modal');
        const deleteModal = document.getElementById('delete-modal');
        
        if (event.target === modal) {
            closeModal();
        }
        if (event.target === editModal) {
            closeEditModal();
        }
        if (event.target === deleteModal) {
            closeDeleteModal();
        }
    }

    // Initialize tmp_vehicles panel on page load
    document.addEventListener('DOMContentLoaded', function() {
        updateTmpVehiclesPanel();
        
        // Initialize configuration mode based on URL parameter
        initializeConfigMode();
    });
</script>

<?= $this->endSection() ?>