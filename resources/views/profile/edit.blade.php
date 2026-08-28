<x-app-layout>
    <div class="container-fluid px-3 px-md-4 py-3" style="font-family: 'Nunito', sans-serif;">
        
        <div class="mb-3">
            <h1 class="fw-extrabold text-dark m-0" style="font-size: 1.6rem; font-weight: 800; color: #0f172a; tracking-tight: -0.025em;">Profile Management</h1>
            <p class="text-muted m-0 mt-1" style="font-size: 13px; font-weight: 400; color: #64748b;">Manage your account details, profile picture, and security settings.</p>
        </div>

        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb bg-transparent p-0 m-0 align-items-center" style="font-size: 13.5px;">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}" class="text-decoration-none fw-semibold d-inline-flex align-items-center gap-1.5" style="color: #64748b; transition: color 0.2s;">
                        <i class="fa-solid fa-rocket" style="font-size: 12px;"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="breadcrumb-item active fw-bold d-inline-flex align-items-center gap-1.5" aria-current="page" style="color: #2563eb;">
                    <i class="fa-solid fa-user-gear" style="font-size: 12px;"></i>
                    <span>My Profile</span>
                </li>
            </ol>
        </nav>

        <div class="card border-0 rounded-2 shadow-sm p-3 p-sm-4 mb-4" style="background: radial-gradient(at 0% 0%, #e0e7ff 0px, transparent 50%), radial-gradient(at 25% 100%, #f3e8ff 0px, transparent 50%), radial-gradient(at 50% 0%, #ffedd5 0px, transparent 50%), radial-gradient(at 75% 100%, #fef9c3 0px, transparent 50%), radial-gradient(at 100% 0%, #dcfce7 0px, transparent 50%), #ffffff; border: 1px solid #cbd5e1 !important;">
            <div class="d-flex flex-column flex-md-row align-items-center justify-content-between gap-3">
                
                <div class="d-flex flex-column flex-sm-row align-items-center gap-3 text-center text-sm-start">
                    <div class="position-relative flex-shrink-0">
                        <img src="{{ auth()->user()->avatar_url }}" alt="{{ Auth::user()->name }}" class="rounded-2 shadow-sm" style="width: 90px; height: 90px; object-fit: cover; border: 3px solid #ffffff;">
                    </div>

                    <div class="d-flex flex-column justify-content-center">
                        <span class="text-uppercase mb-1" style="font-size: 14px; font-weight: 800; letter-spacing: 1.5px; color: #2563eb;">My Profile</span>
                        <h2 class="fw-extrabold m-0 text-dark" style="font-size: calc(1.2rem + 0.4vw); font-weight: 800; color: #0f172a; line-height: 1.2;">{{ Auth::user()->name }}</h2>
                        
                        <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-sm-start gap-1.5 mt-2" style="font-size: 13px; color: #475569;">
                            <span class="badge rounded-1 px-2.5 py-1 fw-bold shadow-sm" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: #ffffff; font-size: 11px; letter-spacing: 0.5px; border: 1px solid #b45309;">
                                {{ strtoupper(Auth::user()->role ?? 'User') }}
                            </span>
                            <span class="fw-semibold">at Engineering 1 portal</span>
                        </div>
                    </div>
                </div>

                <div class="d-flex align-items-center justify-content-center gap-2 align-self-center mt-2 mt-md-0">
                    <form action="#" method="POST" enctype="multipart/form-data" id="avatar-form" class="m-0">
                        @csrf
                        <input type="file" name="avatar" id="avatar-input" class="d-none" onchange="confirmAvatarUpload();">
                        <button type="button" class="btn btn-light rounded-2 px-3 py-2 fw-semibold d-inline-flex align-items-center gap-2 border" onclick="document.getElementById('avatar-input').click();" style="font-size: 13px; background-color: #ffffff; color: #475569; border-color: #cbd5e1 !important;">
                            <i class="fa-solid fa-upload" style="font-size: 12px;"></i>
                            <span>Upload Avatar</span>
                        </button>
                    </form>
                </div>

            </div>
        </div>

        <div class="card border-0 rounded-2 shadow-sm p-3 p-sm-4" style="background-color: #ffffff; border: 1px solid #edf2f7 !important;">
            
            <div class="overflow-auto mb-4 pb-1">
                <ul class="nav nav-tabs border-bottom-0 gap-2 flex-nowrap" id="profileTab" role="tablist" style="min-width: max-content;">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active rounded-2 px-3 px-sm-4 py-2 fw-bold" id="overview-tab" data-bs-toggle="tab" data-bs-target="#overview" type="button" role="tab" style="font-size: 13px;">
                            <i class="fa-solid fa-user me-1.5"></i> Overview
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link rounded-2 px-3 px-sm-4 py-2 fw-bold" id="edit-tab" data-bs-toggle="tab" data-bs-target="#edit" type="button" role="tab" style="font-size: 13px;">
                            <i class="fa-solid fa-pen-to-square me-1.5"></i> Edit Profile
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link rounded-2 px-3 px-sm-4 py-2 fw-bold" id="security-tab" data-bs-toggle="tab" data-bs-target="#security" type="button" role="tab" style="font-size: 13px;">
                            <i class="fa-solid fa-lock me-1.5"></i> Security
                        </button>
                    </li>
                </ul>
            </div>

            <div class="tab-content" id="profileTabContent">
                
                <div class="tab-pane fade show active" id="overview" role="tabpanel">
                    <div class="mb-3 mb-sm-4">
                        <span class="text-primary fw-bold text-uppercase d-block mb-1" style="font-size: 11px; letter-spacing: 1px;">Overview</span>
                        <h4 class="fw-bold m-0 text-dark" style="font-size: 17px;">Profile Details</h4>
                    </div>

                    <div class="row g-2.5 g-sm-3">
                        <div class="col-12 col-md-6">
                            <div class="p-3 rounded-2" style="background-color: #f8fafc; border: 1px solid #e2e8f0;">
                                <span class="fw-bold text-muted text-uppercase d-block mb-1" style="font-size: 10.5px; letter-spacing: 0.5px;">Full Name</span>
                                <span class="fw-bold text-dark d-block text-break" style="font-size: 14px;">{{ $user->name }}</span>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="p-3 rounded-2" style="background-color: #f8fafc; border: 1px solid #e2e8f0;">
                                <span class="fw-bold text-muted text-uppercase d-block mb-1" style="font-size: 10.5px; letter-spacing: 0.5px;">NIK (Nomor Induk Karyawan)</span>
                                <span class="fw-bold text-dark d-block text-break" style="font-size: 14px;">{{ $user->nik ?? '-' }}</span>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="p-3 rounded-2" style="background-color: #f8fafc; border: 1px solid #e2e8f0;">
                                <span class="fw-bold text-muted text-uppercase d-block mb-1" style="font-size: 10.5px; letter-spacing: 0.5px;">Email Address</span>
                                <span class="fw-bold text-dark d-block text-break" style="font-size: 14px;">{{ $user->email }}</span>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="p-3 rounded-2" style="background-color: #f8fafc; border: 1px solid #e2e8f0;">
                                <span class="fw-bold text-muted text-uppercase d-block mb-1" style="font-size: 10.5px; letter-spacing: 0.5px;">Role / Position</span>
                                <span class="fw-bold text-dark d-block text-break" style="font-size: 14px;">{{ strtoupper($user->role ?? 'User') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="edit" role="tabpanel">
                    <div class="mb-3 mb-sm-4">
                        <span class="text-primary fw-bold text-uppercase d-block mb-1" style="font-size: 11px; letter-spacing: 1px;">Update Info</span>
                        <h4 class="fw-bold m-0 text-dark" style="font-size: 17px;">Edit Profile Information</h4>
                    </div>

                    <form method="post" action="{{ route('profile.update') }}" id="edit-profile-form" onsubmit="confirmProfileUpdate(event);">
                        @csrf
                        @method('patch')

                        <div class="row g-2.5 g-sm-3">
                            <div class="col-12 col-md-6">
                                <div class="p-3 rounded-2" style="background-color: #ffffff; border: 1px solid #cbd5e1;">
                                    <label for="name" class="fw-bold text-muted text-uppercase d-block mb-1" style="font-size: 10.5px; letter-spacing: 0.5px;">Full Name</label>
                                    <input type="text" id="name" name="name" class="form-control border-0 bg-transparent p-0 fw-bold text-dark shadow-none" value="{{ old('name', $user->name) }}" required style="font-size: 14px;">
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="p-3 rounded-2" style="background-color: #ffffff; border: 1px solid #cbd5e1;">
                                    <label for="email" class="fw-bold text-muted text-uppercase d-block mb-1" style="font-size: 10.5px; letter-spacing: 0.5px;">Email Address</label>
                                    <input type="email" id="email" name="email" class="form-control border-0 bg-transparent p-0 fw-bold text-dark shadow-none" value="{{ old('email', $user->email) }}" required style="font-size: 14px;">
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 text-end">
                            <button type="submit" class="btn btn-primary rounded-2 px-4 py-2 fw-semibold" style="font-size: 13px; background-color: #2563eb; border: none;">
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>

                <div class="tab-pane fade" id="security" role="tabpanel">
                    <div class="mb-3 mb-sm-4">
                        <span class="text-primary fw-bold text-uppercase d-block mb-1" style="font-size: 11px; letter-spacing: 1px;">Security</span>
                        <h4 class="fw-bold m-0 text-dark" style="font-size: 17px;">Change Password</h4>
                    </div>

                    <form method="post" action="{{ route('password.update') }}" id="security-password-form" onsubmit="confirmPasswordUpdate(event);">
                        @csrf
                        @method('put')

                        <div class="row g-2.5 g-sm-3">
                            <div class="col-12 col-md-4">
                                <div class="p-3 rounded-2" style="background-color: #ffffff; border: 1px solid #cbd5e1;">
                                    <label for="current_password" class="fw-bold text-muted text-uppercase d-block mb-1" style="font-size: 10.5px; letter-spacing: 0.5px;">Current Password</label>
                                    <input type="password" id="current_password" name="current_password" class="form-control border-0 bg-transparent p-0 fw-bold text-dark shadow-none" style="font-size: 14px;">
                                </div>
                            </div>

                            <div class="col-12 col-md-4">
                                <div class="p-3 rounded-2" style="background-color: #ffffff; border: 1px solid #cbd5e1;">
                                    <label for="update_password_password" class="fw-bold text-muted text-uppercase d-block mb-1" style="font-size: 10.5px; letter-spacing: 0.5px;">New Password</label>
                                    <input type="password" id="update_password_password" name="password" class="form-control border-0 bg-transparent p-0 fw-bold text-dark shadow-none" style="font-size: 14px;">
                                </div>
                            </div>

                            <div class="col-12 col-md-4">
                                <div class="p-3 rounded-2" style="background-color: #ffffff; border: 1px solid #cbd5e1;">
                                    <label for="update_password_password_confirmation" class="fw-bold text-muted text-uppercase d-block mb-1" style="font-size: 10.5px; letter-spacing: 0.5px;">Confirm Password</label>
                                    <input type="password" id="update_password_password_confirmation" name="password_confirmation" class="form-control border-0 bg-transparent p-0 fw-bold text-dark shadow-none" style="font-size: 14px;">
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 text-end">
                            <button type="submit" class="btn btn-primary rounded-2 px-4 py-2 fw-semibold" style="font-size: 13px; background-color: #2563eb; border: none;">
                                Update Password
                            </button>
                        </div>
                    </form>
                </div>

            </div>

        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // 1. Confirm Avatar Upload (English)
        function confirmAvatarUpload() {
            const input = document.getElementById('avatar-input');
            if (input.files && input.files[0]) {
                Swal.fire({
                    title: 'Upload Avatar?',
                    text: 'Are you sure you want to update your profile picture?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#2563eb',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: 'Yes, upload it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('avatar-form').submit();
                    } else {
                        input.value = '';
                    }
                });
            }
        }

        // 2. Confirm Profile Information Update (English)
        function confirmProfileUpdate(event) {
            event.preventDefault();
            Swal.fire({
                title: 'Save Changes?',
                text: 'Are you sure you want to save the changes to your profile?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#2563eb',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Yes, save changes!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('edit-profile-form').submit();
                }
            });
        }

        // 3. Confirm Password Update (English)
        function confirmPasswordUpdate(event) {
            event.preventDefault();
            Swal.fire({
                title: 'Update Password?',
                text: 'Are you sure you want to change your password?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#2563eb',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Yes, update password!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('security-password-form').submit();
                }
            });
        }

        // 4. Alert Success Status (1.5 DETIK / 1500ms)
        @if (session('status') === 'profile-updated')
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: 'Your profile details have been updated.',
                timer: 1500,
                showConfirmButton: false
            });
        @elseif (session('status') === 'password-updated')
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: 'Your password has been updated.',
                timer: 1500,
                showConfirmButton: false
            });
        @elseif (session('status') === 'avatar-updated')
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: 'Your avatar picture has been uploaded.',
                timer: 1500,
                showConfirmButton: false
            });
        @endif

        // 5. Alert Error / Validation Failed (1.8 DETIK / 1800ms)
        @if ($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Failed!',
                text: '{{ $errors->first() }}',
                timer: 1800,
                showConfirmButton: false
            });
        @endif
    </script>

    <style>
        .breadcrumb-item a:hover {
            color: #2563eb !important;
        }
        .nav-tabs .nav-link {
            color: #64748b;
            background-color: #f8fafc;
            border: 1px solid #e2e8f0 !important;
            transition: all 0.2s ease;
            white-space: nowrap;
        }
        .nav-tabs .nav-link:hover {
            color: #1e293b;
            background-color: #f1f5f9;
        }
        .nav-tabs .nav-link.active {
            color: #2563eb !important;
            background-color: #eff6ff !important;
            border-color: #bfdbfe !important;
        }
    </style>
</x-app-layout>