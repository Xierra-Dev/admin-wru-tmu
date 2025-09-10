<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - WRU Admin</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Bootstrap Icons CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        body {
            font-family: 'Inter', sans-serif;
            background-image: url('<?= base_url('img/gedung_dalam.jpg') ?>');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            position: relative;
        }
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 0;
        }
        .header-top {
            position: relative;
            z-index: 10;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: white;
            color: #374151;
            border-bottom-left-radius: 15px;
            border-bottom-right-radius: 15px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
        }
        .header-top .logo-section {
            display: flex;
            align-items: center;
            font-weight: bold;
        }
        .header-top .logo-section .wru {
            font-size: 1.5rem;
            margin-right: 0.5rem;
            color: #1a202c;
        }
        .header-top .logo-section .artimu-img {
            height: 25px;
            width: auto;
        }
        .login-container {
            position: relative;
            z-index: 1;
            flex-grow: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 1rem;
        }
        .login-card-wrapper {
            background: rgba(255, 255, 255, 0.7);
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
            backdrop-filter: blur(10px);
            width: 100%;
            max-width: 450px;
            padding: 2.5rem;
            position: relative;
        }
        .login-title-section {
            color: white;
            position: relative;
            z-index: 1;
            margin-right: 2rem;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }
        .login-title-section .artimu-large-img {
            height: 50px;
            width: auto;
            margin-bottom: 1rem;
        }
        .btn-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            color: white;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-gradient:hover {
            opacity: 0.9;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        .btn-red {
            background-color: #EF4444;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            color: white;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-red:hover {
            opacity: 0.9;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        .form-input-custom {
            border-radius: 0.5rem;
            padding: 0.75rem 1rem;
            border: 1px solid #d1d5db;
            background-color: white;
            color: #374151;
        }
        .form-input-custom.with-button {
            border-radius: 0 0.5rem 0.5rem 0;
        }
        .input-group-text {
            border-radius: 0.5rem 0 0 0.5rem;
            background-color: #e5e7eb;
            border: 1px solid #d1d5db;
            border-right: none;
        }
        .input-group:focus-within .form-input-custom {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.3);
        }
        .alert-custom {
            border-radius: 0.5rem;
            padding: 1rem;
            margin-bottom: 1rem;
        }
        .alert-success-custom {
            background-color: #d1fae5;
            color: #065f46;
            border: 1px solid #34d399;
        }
        .alert-danger-custom {
            background-color: #fee2e2;
            color: #991b1b;
            border: 1px solid #ef4444;
        }
        .alert-warning-custom {
            background-color: #fef3c7;
            color: #92400e;
            border: 1px solid #fcd34d;
        }
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .login-title-section {
                display: none;
            }
            .login-card-wrapper {
                padding: 1.5rem;
            }
            .header-top {
                padding: 0.75rem 1rem;
            }
            .header-top .logo-section .wru {
                font-size: 1.2rem;
            }
            .header-top .logo-section .artimu-img {
                height: 20px;
            }
            .date-section {
                font-size: 0.875rem;
            }
        }
        
        /* Gaya Pop-up */
        .modal-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 1000;
            border-radius: 20px;
        }
        .modal-card {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 20px;
            backdrop-filter: blur(10px);
            padding: 2.5rem;
            text-align: center;
            position: relative;
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
            width: 90%;
            max-width: 400px;
        }
        .modal-close {
            position: absolute;
            top: 15px;
            right: 15px;
            font-size: 1.5rem;
            color: #374151;
            cursor: pointer;
        }
        .modal-icon-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 80px;
            height: 80px;
            border-radius: 50%;
            margin: 0 auto 1.5rem;
            color: white;
        }
        .modal-icon {
            font-size: 3rem;
        }
        .modal-icon-wrapper.success {
            background-color: #10B981;
        }
        .modal-icon-wrapper.error {
            background-color: #EF4444;
        }
        .modal-icon-wrapper.warning {
            background-color: #FBBF24;
        }
        .modal-title {
            font-weight: bold;
            text-transform: uppercase;
            font-size: 1.5rem;
        }
        .modal-text-success {
            color: #10B981;
        }
        .modal-text-error {
            color: #EF4444;
        }
        
        /* Remember Me Checkbox Styling */
        .remember-checkbox {
            width: 16px;
            height: 16px;
            accent-color: #667eea;
            cursor: pointer;
        }
        
        .remember-label {
            cursor: pointer;
            user-select: none;
        }
        
        .remember-container {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <div class="header-top">
        <div class="logo-section">
            <span class="wru">WRU</span>
            <img src="<?= base_url('img/artimu.png') ?>" alt="artimu Logo" class="artimu-img">
        </div>
        <div class="date-section">
            <span id="currentDate"></span>
        </div>
    </div>
    <div class="login-container flex-grow items-center justify-center min-h-screen">
        <div class="login-title-section hidden md:flex">
            <img src="<?= base_url('img/artimu.png') ?>" alt="artimu Logo Large" class="artimu-large-img">
            <h1 class="text-4xl font-bold">Login to Admin Account</h1>
        </div>
        <div class="login-card-wrapper">
            <div class="text-center mb-6">
                <h4 class="font-bold text-gray-800 text-2xl">Login as Admin</h4>
            </div>
            
            <form id="loginForm" action="<?= base_url('auth/login') ?>" method="post">
                <?= csrf_field(); ?>
                
                <div class="mb-4">
                    <label for="employee_id" class="block text-sm font-medium text-gray-700 mb-1">Employee ID</label>
                    <div class="flex rounded-md shadow-sm">
                        <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                            <i class="bi bi-person-badge"></i>
                        </span>
                        <input type="text" name="employee_id" id="employee_id" class="form-input-custom flex-1 block w-full rounded-none rounded-r-md sm:text-sm" placeholder="ex: 1234567" required value="<?= old('employee_id'); ?>">
                    </div>
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <div class="flex rounded-md shadow-sm">
                        <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                            <i class="bi bi-envelope"></i>
                        </span>
                        <input type="email" name="email" id="email" class="form-input-custom flex-1 block w-full rounded-none rounded-r-md sm:text-sm" placeholder="ex: admin@123.com" required value="<?= old('email'); ?>">
                    </div>
                </div>
                <div class="mb-6">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <div class="flex rounded-md shadow-sm relative">
                        <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                            <i class="bi bi-lock"></i>
                        </span>
                        <input type="password" name="password" id="password" class="form-input-custom with-button flex-1 block w-full rounded-none sm:text-sm pr-10" placeholder="Enter Your Password" required>
                        <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600">
                            <i class="bi bi-eye" id="eyeIcon"></i>
                        </button>
                    </div>
                </div>
                
                <!-- Remember Me Checkbox -->
                <div class="remember-container">
                    <input type="checkbox" name="remember_me" id="remember_me" class="remember-checkbox">
                    <label for="remember_me" class="remember-label text-sm text-gray-700">
                        Remember Me
                    </label>
                </div>
                
                <button type="submit" id="loginButton" class="btn-gradient w-full py-3">
                    Login
                </button>
            </form>
            
            <div class="text-center mt-6">
                <p class="text-sm text-gray-600">Belum memiliki akun? <a href="<?= base_url('auth/register') ?>" class="font-medium text-indigo-600 hover:text-indigo-500">Register di sini</a></p>
            </div>
            
            <!-- Pop-up Status (Success, Error) -->
            <div id="statusModal" class="modal-overlay">
                <div class="modal-card">
                    <span class="modal-close" id="closeStatusModal">&times;</span>
                    <div class="modal-content">
                        <div id="modalIconWrapper" class="modal-icon-wrapper">
                            <i id="modalIcon" class="modal-icon"></i>
                        </div>
                        <h3 id="modalTitle" class="modal-title mb-2"></h3>
                        <p id="modalMessage" class="text-gray-600 mb-4"></p>
                        <div id="modalButtons" class="flex flex-col gap-2">
                            <button id="closeModalBtn" class="btn-gray w-full py-3">Back</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dateElement = document.getElementById('currentDate');
            const options = { weekday: 'short', year: 'numeric', month: 'short', day: 'numeric' };
            const today = new Date();
            dateElement.textContent = today.toLocaleDateString('en-US', options);

            // Password toggle functionality
            const togglePassword = document.getElementById('togglePassword');
            const password = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');
            
            togglePassword.addEventListener('click', function() {
                const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                password.setAttribute('type', type);
                
                if (type === 'text') {
                    eyeIcon.classList.remove('bi-eye');
                    eyeIcon.classList.add('bi-eye-slash');
                } else {
                    eyeIcon.classList.remove('bi-eye-slash');
                    eyeIcon.classList.add('bi-eye');
                }
            });

            const loginForm = document.getElementById('loginForm');
            const loginButton = document.getElementById('loginButton');
            
            // Elemen-elemen pop-up status
            const statusModal = document.getElementById('statusModal');
            const closeStatusModalBtn = document.getElementById('closeStatusModal');
            const closeModalBtn = document.getElementById('closeModalBtn');
            const modalIconWrapper = document.getElementById('modalIconWrapper');
            const modalIcon = document.getElementById('modalIcon');
            const modalTitle = document.getElementById('modalTitle');
            const modalMessage = document.getElementById('modalMessage');
            
            const successMessage = `<?= addslashes(session()->getFlashdata('success')) ?>`;
            const errorMessage = `<?= addslashes(session()->getFlashdata('error')) ?>`;
            
            // Logika untuk menampilkan pop-up status
            if (successMessage) {
                modalIconWrapper.className = 'modal-icon-wrapper success';
                modalIcon.className = 'modal-icon bi bi-check-lg';
                modalTitle.className = 'modal-title modal-text-success';
                modalTitle.textContent = 'LOGIN SUCCESSFUL';
                modalMessage.textContent = successMessage;
                closeModalBtn.textContent = 'OKAY';
                statusModal.style.display = 'flex';
            } else if (errorMessage) {
                modalIconWrapper.className = 'modal-icon-wrapper error';
                modalIcon.className = 'modal-icon bi bi-x-circle-fill';
                modalTitle.className = 'modal-title modal-text-error';
                modalTitle.textContent = 'Invalid Login';
                modalMessage.textContent = 'The credentials you provided do not match our records.';
                closeModalBtn.textContent = 'back';
                closeModalBtn.className = 'btn-black w-full py-3';
                statusModal.style.display = 'flex';
            }

            // Logika untuk menutup pop-up status
            closeStatusModalBtn.addEventListener('click', function() {
                statusModal.style.display = 'none';
            });
            
            closeModalBtn.addEventListener('click', function() {
                statusModal.style.display = 'none';
            });

            statusModal.addEventListener('click', function(e) {
                if (e.target === statusModal) {
                    statusModal.style.display = 'none';
                }
            });

            // Logika untuk tombol loading
            loginButton.addEventListener('click', function(event) {
                // Mencegah form submit default
                event.preventDefault(); 
                
                // Memeriksa validasi form sebelum melanjutkan
                if (loginForm.checkValidity()) {
                    // Mengubah tampilan tombol menjadi loading
                    loginButton.innerHTML = `Logging in...`;
                    loginButton.disabled = true;

                    // Mengirimkan form setelah jeda singkat
                    setTimeout(() => {
                        loginForm.submit();
                    }, 500); // 500ms delay untuk menunjukkan loading
                } else {
                    // Jika form tidak valid, biarkan browser menampilkan pesan error bawaan
                    // dan tidak mengubah tampilan tombol
                    loginForm.reportValidity();
                }
            });
        });
    </script>
</body>
</html>
