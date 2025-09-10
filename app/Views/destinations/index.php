<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<style>
    /* Custom CSS for Destination Page */
    .destinations-page-container {
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
        color: #ffffff;
        padding: 8px 25px; /* Increased padding for longer button */
        border-radius: 8px 50px 50px 8px;
        text-decoration: none;
        font-weight: 500;
        transition: background-color 0.3s;
        position: absolute;
        left: 0;
    }

    .search-section {
        position: relative;
        flex-grow: 1;
        display: flex;
        margin: 0 20px;
        max-width: 600px;
    }
    
    .search-input {
        width: 100%;
        padding: 12px 40px 12px 20px;
        border-radius: 25px;
        border: 1px solid #d1d5db;
        outline: none;
        font-size: 14px;
        transition: border-color 0.3s ease;
    }

    .search-input:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.1);
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
        padding: 10px 30px; /* Increased padding for longer button */
        border-radius: 50px 8px 8px 50px;
        text-decoration: none;
        font-weight: 600;
        transition: background-color 0.3s;
        position: absolute;
        right: 0;
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
        color: #333;
    }

    .destination-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .destination-item {
        display: flex;
        align-items: stretch;
        background-color: white;
        border-radius: 10px;
        margin-bottom: 10px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        overflow: hidden;
    }

    .destination-left-section {
        width: 2%;
        background-color: #007bff;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 15px 10px;
    }

    .destination-right-section {
        width: 98%;
        background-color: white;
        display: flex;
        align-items: center;
        padding: 15px 20px;
    }

    .destination-number {
        font-size: 1.1rem;
        font-weight: 600;
        color: white;
        text-align: center;
    }

    .destination-name {
        flex-grow: 1;
        font-size: 1.1rem;
        color: #333;
        font-weight: 500;
    }

    .destination-actions {
        display: flex;
        gap: 10px;
    }

    .action-btn {
        width: 40px;
        height: 40px;
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 8px; /* Changed to rounded square */
        text-decoration: none;
        font-size: 1.1rem;
        border: 2px solid; /* Added border */
        transition: all 0.3s ease;
    }

    .edit-btn {
        background-color: transparent; /* Changed to transparent */
        border-color: #007bff;
        color: #007bff; /* Text/icon color changed to blue */
    }

    .delete-btn {
        background-color: transparent; /* Changed to transparent */
        border-color: #dc3545;
        color: #dc3545; /* Text/icon color changed to red */
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
    #added-destinations {
        margin-top: 10px;
        border: 1px solid #e5e7eb;
        border-radius: 16px;
        background: #ffffff;
        padding: 12px;
        box-shadow: inset 0 1px 0 rgba(0,0,0,0.02);
    }

    #added-destinations > label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #111827;
    }

    #added-destinations-list {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        min-height: 30px;
    }

    #added-destinations-list .chip {
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

    #added-destinations-list .chip .chip-remove {
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

    .floating-trigger-icon {
        width: 30px;
        height: auto;
        cursor: pointer;
        transition: transform 0.2s ease;
    }

    .hidden {
        display: none !important;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.3s ease;
    }

    .visible {
        display: flex !important;
        opacity: 1;
        pointer-events: auto;
    }

    .add-button.visible {
        display: block !important;
    }

    .destination-actions.visible {
        display: flex !important;
    }

    .empty-state {
        text-align: center;
        padding: 40px 20px;
        color: #6c757d;
    }

    .empty-state i {
        font-size: 3rem;
        margin-bottom: 15px;
    }

    .empty-state h5 {
        margin-bottom: 10px;
        color: #6c757d;
    }

    .empty-state p {
        margin: 0;
        font-size: 14px;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .destinations-page-container {
            padding: 15px;
        }
        
        .header-section {
            flex-direction: column;
            gap: 10px;
        }
        
        .back-button, .add-button {
            position: static;
            margin: 5px 0;
        }
        
        .search-section {
            margin: 0;
            max-width: 100%;
        }
        
        .modal-content {
            margin: 2% auto;
            width: 95%;
        }
        
        .destination-item {
            padding: 12px 15px;
        }
        
        .destination-number {
            width: 35px;
            height: 25px;
            font-size: 1rem;
        }
        
        .destination-name {
            font-size: 1rem;
        }
        
        .action-btn {
            width: 35px;
            height: 35px;
            font-size: 1rem;
        }
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

    /* Special styling for Edit Destination Modal */
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
        margin-bottom: 0;
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

    /* Special styling for Add Destination Modal */
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

    /* Destination data to be added section */
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

<div class="destinations-page-container">
    <div class="header-section">
        <a href="#" class="back-button hidden" id="back-button">
            <i class="bi bi-chevron-left me-2"></i>Kembali
        </a>
        <div class="search-section">
            <input type="text" class="search-input" placeholder="Cari destinasi..." id="search-input">
            <i class="bi bi-search search-icon"></i>
        </div>
        <a href="#" class="add-button hidden" id="add-destination-btn">
            <i class="bi bi-plus-lg"></i> Tambah
        </a>
    </div>

    <div class="main-card">
        <h3 class="card-title" id="page-title">Destinasi</h3>
        <div class="card-body">
            <?php if (empty($destinations)): ?>
                <div class="empty-state">
                    <i class="bi bi-geo-alt-fill"></i>
                    <h5>Belum ada data destinasi</h5>
                    <p>Klik tombol "Tambah" untuk menambahkan data baru.</p>
                </div>
            <?php else: ?>
                <ul class="destination-list" id="destination-list">
                    <?php
                    $currentPage = $pager->getCurrentPage();
                    $perPage = $pager->getPerPage();
                    $startNumber = ($currentPage - 1) * $perPage;
                    ?>
                    <?php foreach ($destinations as $index => $destination): ?>
                        <li class="destination-item" data-name="<?= strtolower(esc($destination['destination_name'])) ?>">
                            <div class="destination-left-section">
                                <span class="destination-number"><?= $startNumber + $index + 1 ?></span>
                            </div>
                            <div class="destination-right-section">
                                <span class="destination-name"><?= esc($destination['destination_name']) ?></span>
                                <div class="destination-actions hidden">
                                    <a href="#" class="action-btn edit-btn" data-id="<?= $destination['id'] ?>" data-name="<?= esc($destination['destination_name']) ?>">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="#" class="action-btn delete-btn" data-id="<?= $destination['id'] ?>">
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

<!-- Modal Add/Edit Destination -->
<div id="destination-modal" class="modal">
    <div class="modal-content add-modal-content">
        <div class="modal-header add-modal-header">
            <h4 id="modal-title">Add Destination</h4>
            <span class="close-btn add-close-btn" onclick="closeModal()">&times;</span>
        </div>
        <form id="destination-form" method="post" action="#" onsubmit="return false;">
            <?= csrf_field() ?>
            <input type="hidden" name="id" id="destination-id">
            <input type="hidden" id="addConfigMode" name="config_mode" value="0">
            <div class="modal-body add-modal-body">
                <div class="form-group add-form-group">
                    <label for="destination-name" class="add-label">Destinasi</label>
                    <input type="text" name="destination_name" id="destination-name" class="add-input" placeholder="Add destination name" required>
                    <button type="button" class="btn add-btn" id="modal-add-btn">Add</button>
                </div>
                
                <!-- Panel untuk data sementara -->
                <div id="added-destinations" class="add-people-section" style="display: none;">
                    <label class="add-people-label">Destination data to be added</label>
                    <div id="added-destinations-list" class="add-people-list">
                        <?php if (!empty($tmp_destinations)): ?>
                            <?php foreach ($tmp_destinations as $tmp): ?>
                                <div class="add-chip" data-tmp-id="<?= $tmp['id'] ?>">
                                    <?= esc($tmp['destination_name']) ?>
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

<!-- Modal Edit Single Destination -->
<div id="edit-modal" class="modal">
    <div class="modal-content edit-modal-content">
        <div class="modal-header edit-modal-header">
            <h4>Edit Destination</h4>
            <span class="close-btn edit-close-btn" onclick="closeEditModal()">&times;</span>
        </div>
        <form id="edit-form" method="post" action="<?= base_url('destinations/update') ?>">
            <?= csrf_field() ?>
            <input type="hidden" name="id" id="edit-destination-id">
            <input type="hidden" id="editConfigMode" name="config_mode" value="0">
            <div class="modal-body edit-modal-body">
                <div class="form-group edit-form-group">
                    <label for="edit-destination-name" class="edit-label">Destinasi</label>
                    <input type="text" name="destination_name" id="edit-destination-name" class="edit-input" placeholder="Enter new destination name" required>
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
            <h4>PERINGATAN!</h4>
            <span class="close-btn" onclick="closeDeleteModal()">&times;</span>
        </div>
        <div class="modal-body">
            <i class="bi bi-trash-fill text-danger" style="font-size: 3rem;"></i>
            <p class="mt-3">Aksi ini akan mengakibatkan penghapusan permanen data yang dipilih. Setelah dihapus, data tidak dapat dikembalikan.</p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" onclick="closeDeleteModal()">Batal</button>
            <a href="#" class="btn btn-danger" id="confirm-delete-btn">Hapus</a>
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
        
        // Initialize tmp destinations panel visibility
        updateTmpDestinationsPanel();
    }

    // Helper function to enter configuration mode
    function enterConfigurationMode() {
        const addButton = document.getElementById('add-destination-btn');
        const backButton = document.getElementById('back-button');
        const destinationActions = document.querySelectorAll('.destination-actions');
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
        destinationActions.forEach(actions => {
            actions.classList.remove('hidden');
            actions.classList.add('visible');
        });
        
        // Change title to configuration mode
        if (pageTitle) {
            pageTitle.textContent = 'Konfigurasi Destinasi';
        }
        
        // Hide trigger button
        if (floatingTriggerContainer) {
            floatingTriggerContainer.classList.add('hidden');
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
        const destinationItems = document.querySelectorAll('.destination-item');
        
        destinationItems.forEach(item => {
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
        const modal = document.getElementById('destination-modal');
        const addBtn = document.getElementById('modal-add-btn');
        const saveBtn = document.getElementById('modal-save-btn');
        const destinationNameInput = document.getElementById('destination-name');
        
        // Reset form
        destinationNameInput.value = '';
        document.getElementById('destination-id').value = '';
        
        // Show both buttons for add mode
        addBtn.style.display = 'block';
        saveBtn.style.display = 'block';
        
        // Show tmp_destinations panel if there's data
        updateTmpDestinationsPanel();
        
        modal.style.display = 'block';
        destinationNameInput.focus();
    }

    function openEditModal(id, name) {
        const modal = document.getElementById('edit-modal');
        document.getElementById('edit-destination-id').value = id;
        document.getElementById('edit-destination-name').value = name;
        modal.style.display = 'block';
        document.getElementById('edit-destination-name').focus();
    }

    function closeModal() {
        const modal = document.getElementById('destination-modal');
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
        confirmBtn.href = `<?= base_url('destinations/delete/') ?>/${id}${currentConfigMode ? '?config_mode=1' : ''}`;
        modal.style.display = 'block';
    }

    function closeDeleteModal() {
        const modal = document.getElementById('delete-modal');
        modal.style.display = 'none';
    }

    // Update tmp_destinations panel visibility
    function updateTmpDestinationsPanel() {
        const panel = document.getElementById('added-destinations');
        const list = document.getElementById('added-destinations-list');
        
        if (list.children.length > 0) {
            panel.style.display = 'block';
        } else {
            panel.style.display = 'none';
        }
    }

    // Add to tmp_destinations
    document.getElementById('modal-add-btn').addEventListener('click', function(e) {
        e.preventDefault();
        const form = document.getElementById('destination-form');
        const nameInput = document.getElementById('destination-name');
        const name = nameInput.value.trim();
        
        if (!name) {
            alert('Nama destinasi tidak boleh kosong');
            nameInput.focus();
            return;
        }

        const formData = new FormData(form);
        formData.set('destination_name', name);
        
        // Add CSRF token
        const csrfToken = '<?= csrf_token() ?>';
        const csrfHash = '<?= csrf_hash() ?>';
        formData.set(csrfToken, csrfHash);
        
        console.log('Sending data:', {
            destination_name: name,
            csrf_token: csrfToken,
            csrf_hash: csrfHash
        });

        fetch('<?= base_url('destinations/addTmp') ?>', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': '<?= csrf_hash() ?>'
            }
        })
        .then(response => {
            console.log('Response status:', response.status);
            return response.json();
        })
        .then(data => {
            console.log('Response data:', data);
            if (data.status === 'success') {
                const tmp = data.data;
                const list = document.getElementById('added-destinations-list');
                
                // Create chip element with new classes
                const chip = document.createElement('div');
                chip.className = 'add-chip';
                chip.setAttribute('data-tmp-id', tmp.id);
                chip.innerHTML = escapeHtml(tmp.destination_name) + ' <span class="add-chip-remove" onclick="removeTmp(' + tmp.id + ')">&times;</span>';
                list.appendChild(chip);

                // Clear input and update panel visibility
                nameInput.value = '';
                updateTmpDestinationsPanel();
                nameInput.focus();
                
                console.log('Successfully added destination to temporary list');
            } else {
                console.error('Error response:', data);
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

    // Save all data (from tmp_destinations + current input)
    document.getElementById('modal-save-btn').addEventListener('click', function() {
        const nameInput = document.getElementById('destination-name');
        const currentName = nameInput.value.trim();
        
        // Create form to submit to saveDestinations endpoint
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '<?= base_url('destinations/saveDestinations') ?>';

        // Add CSRF token
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '<?= csrf_token() ?>';
        csrfInput.value = '<?= csrf_hash() ?>';
        form.appendChild(csrfInput);

        // Add current input if not empty
        if (currentName) {
            const nameInput = document.createElement('input');
            nameInput.type = 'hidden';
            nameInput.name = 'current_name';
            nameInput.value = currentName;
            form.appendChild(nameInput);
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

    // Remove from tmp_destinations
    function removeTmp(id) {
        if (!confirm('Hapus destinasi dari daftar sementara?')) return;

        fetch('<?= base_url('destinations/removeTmp') ?>/' + id, {
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
                updateTmpDestinationsPanel();
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
    document.getElementById('add-destination-btn').addEventListener('click', function(e) {
        e.preventDefault();
        openModal();
    });

    document.querySelectorAll('.edit-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const id = this.getAttribute('data-id');
            const name = this.getAttribute('data-name');
            openEditModal(id, name);
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
    const addButton = document.getElementById('add-destination-btn');
    const destinationActions = document.querySelectorAll('.destination-actions');
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

    function returnToInitialState() {
        // Change title back
        if (pageTitle) {
            pageTitle.textContent = 'Destinasi';
        }
        
        // Hide action buttons
        addButton.classList.remove('visible');
        addButton.classList.add('hidden');
        backButton.classList.remove('visible');
        backButton.classList.add('hidden');
        destinationActions.forEach(actions => {
            actions.classList.remove('visible');
            actions.classList.add('hidden');
        });
        
        // Show trigger
        if (floatingTriggerContainer) {
            floatingTriggerContainer.classList.remove('hidden');
        }
    }

    // Close modals when clicking outside
    window.onclick = function(event) {
        const modal = document.getElementById('destination-modal');
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

    // Initialize tmp_destinations panel on page load
    document.addEventListener('DOMContentLoaded', function() {
        // Debug: Log tmp destinations data
        const tmpDestinations = <?= json_encode($tmp_destinations ?? []) ?>;
        console.log('Tmp destinations data:', tmpDestinations);
        
        updateTmpDestinationsPanel();
        
        // Initialize configuration mode based on URL parameter
        initializeConfigMode();
    });

    // Add destination on Enter key
    document.getElementById('destination-name').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            document.getElementById('modal-add-btn').click();
        }
    });
</script>

<?= $this->endSection() ?>