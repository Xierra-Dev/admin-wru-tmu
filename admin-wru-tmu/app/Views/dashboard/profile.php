<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<style>
    /* Inter Font from Google Fonts */
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

    body {
        font-family: 'Inter', sans-serif;
    }

    /* Main Container & Background */
    .profile-container {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: calc(100vh - 60px);
        padding: 2rem 1rem;
        position: relative;
        z-index: 1;
        opacity: 80%;
    }
    
    /* Profile Panel - FIXED BLUR ISSUE */
    .profile-panel {
        background-color: #ffffff;
        border-radius: 1rem;
        padding: 2rem;
        width: 100%;
        max-width: 1000px;
        min-height: 400px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        position: relative;
        z-index: 2;
    }

    .profile-panel h2 {
        font-size: 2rem;
        font-weight: 600;
        color: #030000ff;
        margin-bottom: 2rem;
        text-align: center;
    }

    /* Form Group & Input Fields - Updated untuk konsistensi */
    .form-group {
        display: flex;
        align-items: center;
        margin-bottom: 1.5rem;
    }

    .form-group label {
        flex: 0 0 150px;
        font-size: 1rem;
        font-weight: bold;
        color: #030000ff;
        margin-right: 1.5rem;
    }

    .input-wrapper {
        flex-grow: 1;
        position: relative;
        margin-right: 50px; /* Tambah margin kanan untuk konsistensi dengan password form */
    }

    .form-group input {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 2px solid #ddd;
        border-radius: 0.5rem;
        font-size: 1rem;
        color: #030000ff;
        background-color: white;
        transition: border-color 0.3s ease;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .form-group input:focus {
        outline: none;
        border-color: #007bff;
        box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.25);
    }

    /* Styling untuk input yang disabled/readonly */
    .form-group input:disabled,
    .form-group input[readonly] {
        background-color: #f8f9fa;
        color: #6c757d;
        border-color: #e9ecef;
        cursor: not-allowed;
    }

    /* State aktif ketika password edit mode - form menyala */
    .password-edit-active .password-form-group {
        background-color: rgba(0, 123, 255, 0.05);
        border-radius: 0.75rem;
        padding: 0.5rem;
        margin: -0.5rem;
        transition: all 0.3s ease;
    }

    .password-edit-active .password-form-group input {
        background-color: white !important;
        border-color: #007bff !important;
        box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.15);
        opacity: 1 !important;
    }

    /* Ikon Edit di sebelah kanan input password */
    .edit-icon {
        margin-left: 15px;
        font-size: 1.25rem;
        color: #999;
        cursor: pointer;
        transition: opacity 0.3s ease, color 0.3s ease;
        opacity: 0;
        pointer-events: none;
        z-index: 10;
        flex-shrink: 0;
    }

    .edit-icon.visible {
        opacity: 1;
        pointer-events: auto;
    }

    .edit-icon:hover {
        color: #007bff;
    }

    /* Password form group dengan layout khusus */
    .password-form-group {
        display: flex;
        align-items: center;
        margin-bottom: 1.5rem;
    }

    .password-form-group label {
        flex: 0 0 150px;
        font-size: 1rem;
        font-weight: bold;
        color: #030000ff;
        margin-right: 1.5rem;
    }

    .password-form-group .input-wrapper {
        flex-grow: 1;
        position: relative;
        margin-right: 15px; /* Samakan dengan form lainnya */
    }

    /* Pastikan input password memiliki styling yang sama dengan input lainnya */
    .password-form-group input {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 2px solid #ddd;
        border-radius: 0.5rem;
        font-size: 1rem;
        color: #030000ff;
        background-color: white;
        transition: border-color 0.3s ease;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .password-form-group input:focus {
        outline: none;
        border-color: #007bff;
        box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.25);
    }

    /* Styling untuk input yang disabled/readonly di password form */
    .password-form-group input:disabled,
    .password-form-group input[readonly] {
        background-color: #f8f9fa;
        color: #6c757d;
        border-color: #e9ecef;
        cursor: not-allowed;
    }

    /* Ikon Trigger di kanan bawah panel */
    .trigger-icon {
        position: absolute;
        bottom: 1.5rem;
        right: 1.5rem;
        width: 30px;
        height: auto;
        cursor: pointer;
        transition: transform 0.2s ease, opacity 0.3s ease;
        z-index: 10;
        opacity: 1;
    }

    .trigger-icon:hover {
        transform: scale(1.1);
    }

    .trigger-icon.hidden {
        opacity: 0;
        pointer-events: none;
    }

    /* FIXED Modal Styles - TANPA BACKDROP */
    .modal {
        z-index: 99999 !important;
        pointer-events: auto !important;
    }
    
    /* HAPUS BACKDROP STYLING KARENA KITA MATIKAN */
    
    .modal-dialog {
        z-index: 99999 !important;
        position: relative;
        pointer-events: auto !important;
    }
    
    .modal-content {
        border-radius: 1rem;
        padding: 1rem;
        border: none;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
        z-index: 100000 !important;
        position: relative;
        pointer-events: auto !important;
        background: white !important;
    }
    
    /* CRITICAL: Force semua elemen di dalam modal bisa diinteraksi */
    .modal *,
    .modal input,
    .modal button {
        pointer-events: auto !important;
        z-index: inherit !important;
    }

    .modal-header {
        border-bottom: none;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        padding-bottom: 0.5rem;
    }
    
    .modal-title {
        font-weight: 700;
        color: #030000ff;
        margin-top: 0.5rem;
    }

    .modal-body {
        text-align: center;
        padding: 1.5rem 2rem;
    }

    .modal-body p {
        color: #555;
        margin-bottom: 1.5rem;
    }
    
    .modal-key-icon {
        font-size: 3rem;
        color: #ffa500;
        margin-bottom: 0;
    }

    .modal-footer {
        border-top: none;
        justify-content: center;
        gap: 1rem;
        padding-top: 1rem;
    }

    .modal-footer .btn {
        width: 150px;
        padding: 0.75rem;
        border-radius: 0.75rem;
        font-weight: 600;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        z-index: 100001 !important;
        position: relative;
    }

    .btn-secondary {
        background-color: #6c757d;
        color: white;
    }

    .btn-secondary:hover {
        background-color: #5a6268;
    }

    .btn-warning {
        background-color: #ffa500;
        color: white;
    }

    .btn-warning:hover {
        background-color: #e8940f;
    }

    /* Form control dalam modal - INI YANG PENTING */
    .modal .form-control {
        padding: 0.75rem 1rem;
        border: 1px solid #ddd;
        border-radius: 0.5rem;
        font-size: 1rem;
        transition: border-color 0.3s ease;
        z-index: 100001 !important;
        position: relative;
        pointer-events: auto !important;
    }

    .modal .form-control:focus {
        outline: none;
        border-color: #ffa500;
        box-shadow: 0 0 0 3px rgba(255, 165, 0, 0.25);
    }

    /* Styles untuk Modal Konfirmasi */
    .confirmation-icon-red {
        width: 80px;
        height: 80px;
        background: #dc3545;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
        position: relative;
    }

    .confirmation-icon-red i {
        font-size: 2rem;
        color: white;
    }

    .warning-triangle {
        position: absolute;
        bottom: -5px;
        right: -5px;
        width: 30px;
        height: 30px;
        background: #ffa500;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .warning-triangle i {
        font-size: 1rem;
        color: white;
    }

    /* Styles untuk Modal Success */
    .success-icon-green {
        width: 80px;
        height: 80px;
        background: #28a745;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
    }

    .success-icon-green i {
        font-size: 2rem;
        color: white;
    }

    .btn-danger {
        background-color: #dc3545;
        color: white;
        border: none;
    }

    .btn-danger:hover {
        background-color: #c82333;
    }

    .btn-success {
        background-color: #28a745;
        color: white;
        border: none;
    }

    .btn-success:hover {
        background-color: #218838;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .form-group {
            flex-direction: column;
            align-items: flex-start;
        }

        .form-group label {
            flex: none;
            margin-bottom: 0.5rem;
            margin-right: 0;
        }

        .profile-panel {
            padding: 1.5rem;
        }
    }
</style>

<div class="profile-container">
    <div class="profile-panel">
        <h2>Profiles</h2>
        <form>
            <div class="form-group">
                <label for="employee_id">Employee ID</label>
                <div class="input-wrapper">
                    <input type="text" id="employee_id" name="employee_id" value="<?= session()->get('admin_employee_id') ?? '' ?>" readonly disabled>
                </div>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <div class="input-wrapper">
                    <input type="email" id="email" name="email" value="<?= session()->get('admin_email') ?? '' ?>" readonly disabled>
                </div>
            </div>
            <div class="password-form-group">
                <label for="password">Password</label>
                <div class="input-wrapper">
                    <input type="password" id="password" value="********" readonly>
                </div>
                <i class="bi bi-pencil-square edit-icon" id="passwordEditIcon"></i>
            </div>
        </form>

        <!-- Ikon Trigger di kanan bawah panel -->
        <img src="<?= base_url('img/Group.png') ?>" alt="Edit Trigger" class="trigger-icon" id="editTrigger">
    </div>
</div>

<!-- HAPUS MODAL DUPLIKAT - GUNAKAN HANYA SATU INI -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <i class="bi bi-key modal-key-icon"></i>
                <h5 class="modal-title" id="changePasswordModalLabel">Change Password</h5>
            </div>
            <div class="modal-body">
                <p>Please enter your current password and new password</p>
                <form id="changePasswordForm">
                    <div class="mb-3">
                        <input type="password" class="form-control" id="currentPassword" placeholder="Enter your current password" required>
                    </div>
                    <div class="mb-3">
                        <input type="password" class="form-control" id="newPassword" placeholder="Enter your new password" required>
                    </div>
                    <div class="mb-3">
                        <input type="password" class="form-control" id="confirmPassword" placeholder="Confirm your new password" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-warning" id="changePasswordBtn">Change</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM loaded, initializing profile page...');
        
        if (typeof bootstrap === 'undefined') {
            console.error('Bootstrap not loaded!');
            return;
        }

        const editTrigger = document.getElementById('editTrigger');
        const passwordEditIcon = document.getElementById('passwordEditIcon');
        const changePasswordModal = document.getElementById('changePasswordModal');
        const profileContainer = document.querySelector('.profile-container');

        // Event listener untuk trigger edit - hanya untuk menampilkan/menyembunyikan ikon edit password
        if (editTrigger && passwordEditIcon) {
            editTrigger.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                console.log('Edit trigger clicked');
                
                // Toggle visibility ikon edit password
                passwordEditIcon.classList.toggle('visible');
                
                // Toggle state aktif untuk efek menyala
                if (passwordEditIcon.classList.contains('visible')) {
                    profileContainer.classList.add('password-edit-active');
                    // Hide the trigger icon after activation
                    editTrigger.classList.add('hidden');
                    console.log('Password edit mode activated - form highlighted, trigger hidden');
                } else {
                    profileContainer.classList.remove('password-edit-active');
                    // Show the trigger icon when deactivated
                    editTrigger.classList.remove('hidden');
                    console.log('Password edit mode deactivated, trigger visible');
                }
            });
        }

        // CRITICAL FIX: Event listener untuk ikon edit password
        if (passwordEditIcon && changePasswordModal) {
            passwordEditIcon.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                console.log('Password edit icon clicked');
                
                // HAPUS SEMUA BACKDROP DAN MODAL STATE
                document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
                document.body.classList.remove('modal-open');
                document.body.style.overflow = '';
                document.body.style.paddingRight = '';
                
                // Reset modal
                changePasswordModal.classList.remove('show', 'fade');
                changePasswordModal.style.display = 'none';
                changePasswordModal.removeAttribute('aria-modal');
                changePasswordModal.removeAttribute('role');
                
                // Tunggu cleanup selesai
                setTimeout(() => {
                    // Tambahkan kelas fade kembali
                    changePasswordModal.classList.add('fade');
                    
                    // Buat modal instance baru
                    const modalInstance = new bootstrap.Modal(changePasswordModal, {
                        backdrop: false, // MATIKAN BACKDROP
                        keyboard: true,
                        focus: true
                    });

                    modalInstance.show();
                    console.log('Modal shown without backdrop');
                }, 50);
            });
        }

        // Event listener untuk modal events
        if (changePasswordModal) {
            changePasswordModal.addEventListener('shown.bs.modal', function() {
                console.log('Modal fully shown');
                
                // FORCE SEMUA ELEMEN MODAL JADI INTERAKTIF
                const modalElements = changePasswordModal.querySelectorAll('input, button, .form-control');
                modalElements.forEach(element => {
                    element.style.pointerEvents = 'auto';
                    element.style.position = 'relative';
                    element.style.zIndex = '100001';
                });

                // Focus pada input pertama
                const firstInput = document.getElementById('currentPassword');
                if (firstInput) {
                    setTimeout(() => {
                        firstInput.focus();
                    }, 150);
                }
            });

            changePasswordModal.addEventListener('hidden.bs.modal', function() {
                console.log('Modal hidden');
                document.getElementById('changePasswordForm').reset();
            });
        }

        // Event listener untuk tombol change password (Modal 1 -> Modal 2)
        const changePasswordBtn = document.getElementById('changePasswordBtn');
        if (changePasswordBtn) {
            changePasswordBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                console.log('Change password button clicked');
                
                const currentPassword = document.getElementById('currentPassword').value;
                const newPassword = document.getElementById('newPassword').value;
                const confirmPassword = document.getElementById('confirmPassword').value;

                if (!currentPassword || !newPassword || !confirmPassword) {
                    alert('Please fill in all fields');
                    return;
                }

                if (newPassword !== confirmPassword) {
                    alert('New password and confirmation do not match');
                    return;
                }

                if (newPassword.length < 6) {
                    alert('New password must be at least 6 characters');
                    return;
                }

                // Tutup modal input password
                const inputModal = bootstrap.Modal.getInstance(changePasswordModal);
                if (inputModal) {
                    inputModal.show();
                }

                // Tampilkan modal konfirmasi merah
                setTimeout(() => {
                    const confirmModal = new bootstrap.Modal(document.getElementById('confirmPasswordModal'), {
                        backdrop: false,
                        keyboard: true
                    });
                    confirmModal.show();
                }, 300);
            });
        }

        // Event listener untuk tombol konfirmasi (Modal 2 -> Modal 3)
        const confirmChangeBtn = document.getElementById('confirmChangeBtn');
    if (confirmChangeBtn) {
        confirmChangeBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            console.log('Confirm change button clicked');

            // Close the confirmation moda
            const confirmModal = bootstrap.Modal.getInstance(document.getElementById('confirmPasswordModal'));
            const inputModal = bootstrap.Modal.getInstance(changePasswordModal);
            if (confirmModal && inputModal) {
                confirmModal.hide();
                inputModal.hide();
            }

            // Get all necessary data
            const employeeId = document.getElementById('employee_id').value;
            const email = document.getElementById('email').value;
            const currentPassword = document.getElementById('currentPassword').value;
            const newPassword = document.getElementById('newPassword').value;
            const confirmPassword = document.getElementById('confirmPassword').value;

            // Show loading state
            confirmChangeBtn.disabled = true;
            confirmChangeBtn.textContent = 'Changing...';

            // --- First, handle the password change request ---
            fetch('<?= base_url('profile/changePassword') ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: new URLSearchParams({
                    'current_password': currentPassword,
                    'new_password': newPassword,
                    'confirm_password': confirmPassword
                })
            })
            .then(response => response.json())
            .then(data => {
                // Reset button state
                confirmChangeBtn.disabled = false;
                confirmChangeBtn.textContent = 'Change';

                if (data.success) {
                    // If password change is successful, then proceed with profile update
                    console.log('Password changed successfully. Now updating profile data...');

                    // --- Second, handle the profile update request ---
                    return fetch('<?= base_url('profile/update') ?>', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: new URLSearchParams({
                            'employee_id': employeeId,
                            'email': email
                        })
                    });
                } else {
                    // Show password change error
                    alert('Error changing password: ' + data.message);
                    // Reopen the main password change modal
                    setTimeout(() => {
                        const changeModal = new bootstrap.Modal(changePasswordModal, {
                            backdrop: false,
                            keyboard: true,
                            focus: true
                        });
                        changeModal.show();
                    }, 300);
                    return Promise.reject('Password change failed'); // Stop the chain
                }
            })
            .then(response => response.json())
            .then(data => {
                // Handle profile update response
                if (data.success) {
                    // Show final success modal
                    setTimeout(() => {
                        const successModal = new bootstrap.Modal(document.getElementById('successPasswordModal'), {
                            backdrop: false,
                            keyboard: true
                        });
                        successModal.show();
                    }, 300);
                } else {
                    // Show profile update error
                    alert('Error updating profile: ' + data.message);
                    // Reopen the main password change modal
                    setTimeout(() => {
                        const changeModal = new bootstrap.Modal(changePasswordModal, {
                            backdrop: false,
                            keyboard: true,
                            focus: true
                        });
                        changeModal.show();
                    }, 300);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                confirmChangeBtn.disabled = false;
                confirmChangeBtn.textContent = 'Change';
                alert('Network error. Please try again.');
                
                // Reopen the main password change modal
                setTimeout(() => {
                    const changeModal = new bootstrap.Modal(changePasswordModal, {
                        backdrop: false,
                        keyboard: true,
                        focus: true
                    });
                    changeModal.show();
                }, 300);
            });
        });
    }

        // Event listener untuk tombol cancel konfirmasi (kembali ke Modal 1)
        const cancelConfirmBtn = document.getElementById('cancelConfirmBtn');
        if (cancelConfirmBtn) {
            cancelConfirmBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();

                // Tutup modal konfirmasi
                const confirmModal = bootstrap.Modal.getInstance(document.getElementById('confirmPasswordModal'));
                if (confirmModal) {
                    confirmModal.hide();
                }

                // Kembali ke modal input password
                setTimeout(() => {
                    const inputModal = new bootstrap.Modal(changePasswordModal, {
                        backdrop: false,
                        keyboard: true
                    });
                    inputModal.show();
                }, 300);
            });
        }

        // Event listener untuk tombol Done (tutup semua)
        const doneBtn = document.getElementById('doneBtn');
        if (doneBtn) {
            doneBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();

                const successModal = bootstrap.Modal.getInstance(document.getElementById('successPasswordModal'));
                if (successModal) {
                    successModal.hide();
                }

                // Reset form
                document.getElementById('changePasswordForm').reset();
            });
        }
    });
</script>

<!-- Modal 1: Input Password -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <i class="bi bi-key modal-key-icon"></i>
                <h5 class="modal-title" id="changePasswordModalLabel">Change Password</h5>
            </div>
            <div class="modal-body">
                <p>Please enter your current password and new password</p>
                <form id="changePasswordForm">
                    <div class="mb-3">
                        <input type="password" class="form-control" id="currentPassword" placeholder="Enter your current password" required>
                    </div>
                    <div class="mb-3">
                        <input type="password" class="form-control" id="newPassword" placeholder="Enter your new password" required>
                    </div>
                    <div class="mb-3">
                        <input type="password" class="form-control" id="confirmPassword" placeholder="Confirm your new password" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-warning" id="changePasswordBtn">Change</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal 2: Confirmation (Red) -->
<div class="modal fade" id="confirmPasswordModal" tabindex="-1" aria-labelledby="confirmPasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <div class="confirmation-icon-red">
                    <i class="bi bi-key-fill"></i>
                    <div class="warning-triangle">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                    </div>
                </div>
            </div>
            <div class="modal-body text-center">
                <h6 class="fw-bold mb-3">Are you sure you want change your password?</h6>
                <p class="text-muted small mb-0">This action can't be undone</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="cancelConfirmBtn">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmChangeBtn">Change</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal 3: Success (Green) -->
<div class="modal fade" id="successPasswordModal" tabindex="-1" aria-labelledby="successPasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <div class="success-icon-green">
                    <i class="bi bi-key-fill"></i>
                </div>
            </div>
            <div class="modal-body text-center">
                <h6 class="fw-bold mb-3 text-success">YOUR PASSWORD SUCCESSFULLY CHANGED</h6>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-success" id="doneBtn">Done</button>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>