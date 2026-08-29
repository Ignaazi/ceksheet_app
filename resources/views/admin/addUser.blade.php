<x-app-layout>
    <!-- BOOTSTRAP ICONS CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- CUSTOM CSS ASSETS -->
    <link rel="stylesheet" href="{{ asset('css/admin/AddUser.css') }}">

    <div class="container-fluid px-2 px-md-4 py-4">
        
        <!-- HEADER TITLE & DESCRIPTION -->
        <div class="card border-0 rounded-3 p-3 p-sm-4 mb-4" style="background: radial-gradient(at 0% 0%, #e0e7ff 0px, transparent 50%), radial-gradient(at 25% 100%, #f3e8ff 0px, transparent 50%), radial-gradient(at 50% 0%, #ffedd5 0px, transparent 50%), radial-gradient(at 75% 100%, #fef9c3 0px, transparent 50%), radial-gradient(at 100% 0%, #dcfce7 0px, transparent 50%), #ffffff; border: 1px solid #cbd5e1 !important;">
            <div class="d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-3">
                <div>
                    <h2 class="fw-bold m-0 text-dark" style="font-size: calc(1.2rem + 0.4vw); color: #0f172a;">Create User Account</h2>
                    <p class="text-secondary m-0 mt-1 small" style="color: #64748b !important;">Add a new employee user to the system directory and configure their access permissions.</p>
                </div>
                <div>
                    <a href="{{ route('users.index') }}" class="btn btn-light rounded-3 px-3 py-2 fw-semibold border small text-secondary d-inline-flex align-items-center gap-2" style="background-color: #ffffff; border-color: #cbd5e1 !important;">
                        <i class="bi bi-arrow-left"></i>
                        <span>Back to Directory</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- BREADCRUMB NAVIGATION -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb bg-transparent p-0 m-0 align-items-center small">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}" class="text-decoration-none fw-semibold d-inline-flex align-items-center gap-1" style="color: #64748b;">
                        <i class="fa-solid fa-rocket" style="font-size: 13px;"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('users.index') }}" class="text-decoration-none fw-semibold d-inline-flex align-items-center gap-1" style="color: #64748b;">
                        <i class="fa-solid fa-users" style="font-size: 13px;"></i>
                        <span>User Accounts</span>
                    </a>
                </li>
                <li class="breadcrumb-item active fw-bold d-inline-flex align-items-center gap-1" aria-current="page" style="color: #0052cc;">
                    <i class="bi bi-person-plus-fill" style="font-size: 13px;"></i>
                    <span>Add User</span>
                </li>
            </ol>
        </nav>

        <!-- MAIN FORM CONTAINER CARD -->
        <div class="card border-0 rounded-3 p-3 p-sm-4 bg-white" style="border: 1px solid #cbd5e1 !important;">
            <div class="border-bottom pb-3 mb-4">
                <span class="text-primary fw-bold text-uppercase d-block mb-1" style="font-size: 11px; letter-spacing: 1px;">New Account Registration</span>
                <h5 class="fw-bold text-dark m-0">Employee Account Details</h5>
            </div>

            <form method="POST" action="{{ route('users.store') }}" id="create-user-form" onsubmit="confirmUserCreate(event);">
                @csrf
                
                <div class="row g-3">
                    <!-- NIK (NOMOR INDUK KARYAWAN) -->
                    <div class="col-12 col-md-6">
                        <div class="p-3 rounded-2 h-100" style="background-color: #ffffff; border: 1px solid #cbd5e1;">
                            <label class="fw-bold text-secondary text-uppercase d-block mb-1" style="font-size: 11px;">
                                NIK (Nomor Induk Karyawan) <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-transparent border-0 ps-0 text-secondary">
                                    <i class="bi bi-card-heading"></i>
                                </span>
                                <input type="text" name="nik" class="form-control border-0 bg-transparent p-0 fw-bold text-dark shadow-none" placeholder="e.g. 24096068" value="{{ old('nik') }}" required>
                            </div>
                        </div>
                    </div>

                    <!-- FULL NAME -->
                    <div class="col-12 col-md-6">
                        <div class="p-3 rounded-2 h-100" style="background-color: #ffffff; border: 1px solid #cbd5e1;">
                            <label class="fw-bold text-secondary text-uppercase d-block mb-1" style="font-size: 11px;">
                                Full Name <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-transparent border-0 ps-0 text-secondary">
                                    <i class="bi bi-person"></i>
                                </span>
                                <input type="text" name="name" class="form-control border-0 bg-transparent p-0 fw-bold text-dark shadow-none" placeholder="Enter employee full name" value="{{ old('name') }}" required>
                            </div>
                        </div>
                    </div>

                    <!-- EMAIL ADDRESS -->
                    <div class="col-12 col-md-6">
                        <div class="p-3 rounded-2 h-100" style="background-color: #ffffff; border: 1px solid #cbd5e1;">
                            <label class="fw-bold text-secondary text-uppercase d-block mb-1" style="font-size: 11px;">Email Address</label>
                            <div class="input-group">
                                <span class="input-group-text bg-transparent border-0 ps-0 text-secondary">
                                    <i class="bi bi-envelope"></i>
                                </span>
                                <input type="email" name="email" class="form-control border-0 bg-transparent p-0 fw-bold text-dark shadow-none" placeholder="name@example.com" value="{{ old('email') }}">
                            </div>
                        </div>
                    </div>

                    <!-- ROLE / ACCESS LEVEL -->
                    <div class="col-12 col-md-6">
                        <div class="p-3 rounded-2 h-100" style="background-color: #ffffff; border: 1px solid #cbd5e1;">
                            <label class="fw-bold text-secondary text-uppercase d-block mb-1" style="font-size: 11px;">
                                Role / Access Level <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-transparent border-0 ps-0 text-secondary">
                                    <i class="bi bi-shield-check"></i>
                                </span>
                                <select name="role" class="form-select border-0 bg-transparent p-0 fw-bold text-dark shadow-none" required>
                                    <option value="staff" {{ old('role') == 'staff' ? 'selected' : '' }}>Staff</option>
                                    <option value="leader" {{ old('role') == 'leader' ? 'selected' : '' }}>Leader</option>
                                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrator</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- PASSWORD -->
                    <div class="col-12">
                        <div class="p-3 rounded-2" style="background-color: #ffffff; border: 1px solid #cbd5e1;">
                            <label class="fw-bold text-secondary text-uppercase d-block mb-1" style="font-size: 11px;">
                                Password <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-transparent border-0 ps-0 text-secondary">
                                    <i class="bi bi-lock"></i>
                                </span>
                                <input type="password" name="password" class="form-control border-0 bg-transparent p-0 fw-bold text-dark shadow-none" placeholder="Minimum 8 characters" required>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ACTION BUTTONS -->
                <div class="d-flex align-items-center justify-content-end gap-2 mt-4 pt-3 border-top">
                    <a href="{{ route('users.index') }}" class="btn btn-light rounded-2 px-4 py-2 fw-semibold border small">Cancel</a>
                    <button type="submit" class="btn text-white rounded-2 px-4 py-2 fw-semibold small d-inline-flex align-items-center gap-2" style="background-color: #0052cc; border: none;">
                        <i class="bi bi-person-plus-fill"></i>
                        <span>Create Account</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- SWEETALERT2 & JS ASSETS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/admin/userManagement.js') }}"></script>
</x-app-layout>