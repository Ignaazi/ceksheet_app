<x-app-layout>
    <div class="container-fluid px-3 px-md-4 py-3" style="font-family: 'Nunito', sans-serif;">
        
        <!-- PAGE TITLE & DESCRIPTION -->
        <div class="mb-3">
            <h1 class="fw-extrabold text-dark m-0" style="font-size: 1.6rem; font-weight: 800; color: #0f172a; letter-spacing: -0.025em;">User Accounts Management</h1>
            <p class="text-muted m-0 mt-1" style="font-size: 13px; font-weight: 400; color: #64748b;">Manage system users, roles, NIK, and access security settings.</p>
        </div>

        <!-- BREADCRUMB NAVIGATION -->
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb bg-transparent p-0 m-0 align-items-center" style="font-size: 13.5px;">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}" class="text-decoration-none fw-semibold d-inline-flex align-items-center gap-1.5" style="color: #64748b;">
                        <i class="fa-solid fa-rocket" style="font-size: 12px;"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="breadcrumb-item active fw-bold d-inline-flex align-items-center gap-1.5" aria-current="page" style="color: #2563eb;">
                    <i class="fa-solid fa-users" style="font-size: 12px;"></i>
                    <span>User Accounts</span>
                </li>
            </ol>
        </nav>

        <!-- MAIN CONTAINER CARD -->
        <div class="card border-0 rounded-2 shadow-sm p-3 p-sm-4" style="background-color: #ffffff; border: 1px solid #cbd5e1 !important;">
            
            <!-- TOOLBAR: SEARCH, FILTER, AND ADD USER BUTTON -->
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
                
                <!-- SEARCH & FILTER FORM -->
                <form method="GET" action="{{ route('users.index') }}" class="d-flex flex-wrap align-items-center gap-2 m-0 flex-grow-1">
                    <div class="position-relative flex-grow-1" style="max-width: 320px;">
                        <i class="fa-solid fa-magnifying-glass position-absolute top-50 start-0 translate-middle-y ms-3 text-muted" style="font-size: 13px;"></i>
                        <input type="text" name="search" class="form-control rounded-2 ps-5 pe-3 py-2 fw-semibold" placeholder="Search NIK, Name, Email..." value="{{ request('search') }}" style="font-size: 13px; border-color: #cbd5e1;">
                    </div>

                    <div style="min-width: 140px;">
                        <select name="role" class="form-select rounded-2 py-2 fw-semibold" onchange="this.form.submit()" style="font-size: 13px; border-color: #cbd5e1; color: #475569;">
                            <option value="">All Roles</option>
                            <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="leader" {{ request('role') == 'leader' ? 'selected' : '' }}>Leader</option>
                            <option value="staff" {{ request('role') == 'staff' ? 'selected' : '' }}>Staff</option>
                        </select>
                    </div>

                    @if(request('search') || request('role'))
                        <a href="{{ route('users.index') }}" class="btn btn-light rounded-2 px-3 py-2 fw-semibold border text-muted" style="font-size: 13px; background-color: #ffffff; border-color: #cbd5e1 !important;">
                            <i class="fa-solid fa-rotate-left me-1"></i> Reset
                        </a>
                    @endif
                </form>

                <!-- ADD USER BUTTON -->
                <div>
                    <button type="button" class="btn btn-primary rounded-2 px-3.5 py-2 fw-bold d-inline-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#createUserModal" style="font-size: 13px; background-color: #2563eb; border: none;">
                        <i class="fa-solid fa-user-plus" style="font-size: 13px;"></i>
                        <span>Add New User</span>
                    </button>
                </div>
            </div>

            <!-- USERS TABLE -->
            <div class="table-responsive rounded-2" style="border: 1px solid #e2e8f0;">
                <table class="table table-hover align-middle m-0" style="font-size: 13.5px;">
                    <thead style="background-color: #f8fafc; border-bottom: 2px solid #e2e8f0;">
                        <tr>
                            <th class="py-3 px-3 text-uppercase fw-bold text-muted" style="font-size: 11px; letter-spacing: 0.5px;">User Info</th>
                            <th class="py-3 px-3 text-uppercase fw-bold text-muted" style="font-size: 11px; letter-spacing: 0.5px;">NIK</th>
                            <th class="py-3 px-3 text-uppercase fw-bold text-muted" style="font-size: 11px; letter-spacing: 0.5px;">Email</th>
                            <th class="py-3 px-3 text-uppercase fw-bold text-muted" style="font-size: 11px; letter-spacing: 0.5px;">Role</th>
                            <th class="py-3 px-3 text-uppercase fw-bold text-muted text-center" style="font-size: 11px; letter-spacing: 0.5px; width: 120px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="border-0">
                        @forelse ($users as $u)
                            <tr style="border-bottom: 1px solid #f1f5f9;">
                                <td class="py-3 px-3">
                                    <div class="d-flex align-items-center gap-2.5">
                                        <!-- DEFAULT PROFILE IMAGE -->
                                        <img src="{{ asset('image/defaultProfile.png') }}" 
                                             alt="{{ $u->name }}" 
                                             class="rounded-circle border shadow-sm flex-shrink-0" 
                                             style="width: 36px; height: 36px; object-fit: cover; border-color: #cbd5e1 !important;">
                                        <div class="d-flex flex-column">
                                            <span class="fw-bold text-dark">{{ $u->name }}</span>
                                            <span class="text-muted" style="font-size: 11.5px;">ID: #{{ $u->id }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3 px-3 font-monospace fw-semibold text-dark">{{ $u->nik }}</td>
                                <td class="py-3 px-3 text-dark fw-medium">{{ $u->email ?? '-' }}</td>
                                <td class="py-3 px-3">
                                    @if($u->role === 'admin')
                                        <span class="badge rounded-1 px-2.5 py-1 fw-bold" style="background-color: #fef3c7; color: #b45309; border: 1px solid #fde68a; font-size: 11px;">ADMIN</span>
                                    @elseif($u->role === 'leader')
                                        <span class="badge rounded-1 px-2.5 py-1 fw-bold" style="background-color: #e0e7ff; color: #3730a3; border: 1px solid #c7d2fe; font-size: 11px;">LEADER</span>
                                    @else
                                        <span class="badge rounded-1 px-2.5 py-1 fw-bold" style="background-color: #f1f5f9; color: #475569; border: 1px solid #e2e8f0; font-size: 11px;">STAFF</span>
                                    @endif
                                </td>
                                <td class="py-3 px-3 text-center">
                                    <div class="d-flex align-items-center justify-content-center gap-1.5">
                                        <!-- BUTTON EDIT -->
                                        <button type="button" class="btn btn-sm btn-light border rounded-2 p-1.5 text-primary" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#editUserModal{{ $u->id }}" 
                                                title="Edit User"
                                                style="width: 32px; height: 32px; background-color: #ffffff; border-color: #cbd5e1 !important;">
                                            <i class="fa-solid fa-pen-to-square" style="font-size: 12px;"></i>
                                        </button>

                                        <!-- BUTTON DELETE -->
                                        @if(Auth::id() !== $u->id)
                                            <form action="{{ route('users.destroy', $u->id) }}" method="POST" id="delete-user-form-{{ $u->id }}" class="m-0">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-sm btn-light border rounded-2 p-1.5 text-danger" 
                                                        onclick="confirmDeleteUser({{ $u->id }}, '{{ $u->name }}')" 
                                                        title="Delete User"
                                                        style="width: 32px; height: 32px; background-color: #ffffff; border-color: #cbd5e1 !important;">
                                                    <i class="fa-solid fa-trash-can" style="font-size: 12px;"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>

                            <!-- MODAL EDIT USER -->
                            <div class="modal fade" id="editUserModal{{ $u->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content border-0 rounded-2 shadow" style="border: 1px solid #cbd5e1 !important;">
                                        <div class="modal-header border-bottom-0 pb-0">
                                            <div>
                                                <span class="text-primary fw-bold text-uppercase d-block mb-1" style="font-size: 11px; letter-spacing: 1px;">Update Account</span>
                                                <h5 class="modal-title fw-bold text-dark" style="font-size: 16px;">Edit User Details</h5>
                                            </div>
                                            <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form method="POST" action="{{ route('users.update', $u->id) }}" id="edit-user-form-{{ $u->id }}" onsubmit="confirmUserUpdate(event, {{ $u->id }});">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body py-3">
                                                <div class="row g-2.5">
                                                    <div class="col-12">
                                                        <div class="p-2.5 rounded-2" style="background-color: #ffffff; border: 1px solid #cbd5e1;">
                                                            <label class="fw-bold text-muted text-uppercase d-block mb-1" style="font-size: 10.5px; letter-spacing: 0.5px;">NIK (Nomor Induk Karyawan)</label>
                                                            <input type="text" name="nik" class="form-control border-0 bg-transparent p-0 fw-bold text-dark shadow-none" value="{{ old('nik', $u->nik) }}" required style="font-size: 13.5px;">
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="p-2.5 rounded-2" style="background-color: #ffffff; border: 1px solid #cbd5e1;">
                                                            <label class="fw-bold text-muted text-uppercase d-block mb-1" style="font-size: 10.5px; letter-spacing: 0.5px;">Full Name</label>
                                                            <input type="text" name="name" class="form-control border-0 bg-transparent p-0 fw-bold text-dark shadow-none" value="{{ old('name', $u->name) }}" required style="font-size: 13.5px;">
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="p-2.5 rounded-2" style="background-color: #ffffff; border: 1px solid #cbd5e1;">
                                                            <label class="fw-bold text-muted text-uppercase d-block mb-1" style="font-size: 10.5px; letter-spacing: 0.5px;">Email Address</label>
                                                            <input type="email" name="email" class="form-control border-0 bg-transparent p-0 fw-bold text-dark shadow-none" value="{{ old('email', $u->email) }}" style="font-size: 13.5px;">
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="p-2.5 rounded-2" style="background-color: #ffffff; border: 1px solid #cbd5e1;">
                                                            <label class="fw-bold text-muted text-uppercase d-block mb-1" style="font-size: 10.5px; letter-spacing: 0.5px;">Role / Access Level</label>
                                                            <select name="role" class="form-select border-0 bg-transparent p-0 fw-bold text-dark shadow-none" style="font-size: 13.5px;" required>
                                                                <option value="admin" {{ $u->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                                                <option value="leader" {{ $u->role === 'leader' ? 'selected' : '' }}>Leader</option>
                                                                <option value="staff" {{ $u->role === 'staff' ? 'selected' : '' }}>Staff</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="p-2.5 rounded-2" style="background-color: #ffffff; border: 1px solid #cbd5e1;">
                                                            <label class="fw-bold text-muted text-uppercase d-block mb-1" style="font-size: 10.5px; letter-spacing: 0.5px;">New Password (Optional)</label>
                                                            <input type="password" name="password" class="form-control border-0 bg-transparent p-0 fw-bold text-dark shadow-none" placeholder="Leave blank to keep unchanged" style="font-size: 13.5px;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer border-top-0 pt-0">
                                                <button type="button" class="btn btn-light rounded-2 px-3 py-1.5 fw-semibold border" data-bs-dismiss="modal" style="font-size: 13px;">Cancel</button>
                                                <button type="submit" class="btn btn-primary rounded-2 px-3 py-1.5 fw-semibold" style="font-size: 13px; background-color: #2563eb; border: none;">Save Changes</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted" style="font-size: 13.5px;">
                                    <i class="fa-solid fa-user-slash d-block mb-2" style="font-size: 24px;"></i>
                                    No user accounts found matching your query.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- PAGINATION -->
            <div class="mt-3 d-flex justify-content-end">
                {{ $users->links() }}
            </div>

        </div>
    </div>

    <!-- MODAL CREATE USER -->
    <div class="modal fade" id="createUserModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 rounded-2 shadow" style="border: 1px solid #cbd5e1 !important;">
                <div class="modal-header border-bottom-0 pb-0">
                    <div>
                        <span class="text-primary fw-bold text-uppercase d-block mb-1" style="font-size: 11px; letter-spacing: 1px;">New Account</span>
                        <h5 class="modal-title fw-bold text-dark" style="font-size: 16px;">Create User Account</h5>
                    </div>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('users.store') }}" id="create-user-form" onsubmit="confirmUserCreate(event);">
                    @csrf
                    <div class="modal-body py-3">
                        <div class="row g-2.5">
                            <div class="col-12">
                                <div class="p-2.5 rounded-2" style="background-color: #ffffff; border: 1px solid #cbd5e1;">
                                    <label class="fw-bold text-muted text-uppercase d-block mb-1" style="font-size: 10.5px; letter-spacing: 0.5px;">NIK (Nomor Induk Karyawan)</label>
                                    <input type="text" name="nik" class="form-control border-0 bg-transparent p-0 fw-bold text-dark shadow-none" placeholder="e.g. 24096068" required style="font-size: 13.5px;">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="p-2.5 rounded-2" style="background-color: #ffffff; border: 1px solid #cbd5e1;">
                                    <label class="fw-bold text-muted text-uppercase d-block mb-1" style="font-size: 10.5px; letter-spacing: 0.5px;">Full Name</label>
                                    <input type="text" name="name" class="form-control border-0 bg-transparent p-0 fw-bold text-dark shadow-none" placeholder="Enter employee full name" required style="font-size: 13.5px;">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="p-2.5 rounded-2" style="background-color: #ffffff; border: 1px solid #cbd5e1;">
                                    <label class="fw-bold text-muted text-uppercase d-block mb-1" style="font-size: 10.5px; letter-spacing: 0.5px;">Email Address</label>
                                    <input type="email" name="email" class="form-control border-0 bg-transparent p-0 fw-bold text-dark shadow-none" placeholder="name@example.com" style="font-size: 13.5px;">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="p-2.5 rounded-2" style="background-color: #ffffff; border: 1px solid #cbd5e1;">
                                    <label class="fw-bold text-muted text-uppercase d-block mb-1" style="font-size: 10.5px; letter-spacing: 0.5px;">Role / Access Level</label>
                                    <select name="role" class="form-select border-0 bg-transparent p-0 fw-bold text-dark shadow-none" style="font-size: 13.5px;" required>
                                        <option value="staff" selected>Staff</option>
                                        <option value="leader">Leader</option>
                                        <option value="admin">Admin</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="p-2.5 rounded-2" style="background-color: #ffffff; border: 1px solid #cbd5e1;">
                                    <label class="fw-bold text-muted text-uppercase d-block mb-1" style="font-size: 10.5px; letter-spacing: 0.5px;">Password</label>
                                    <input type="password" name="password" class="form-control border-0 bg-transparent p-0 fw-bold text-dark shadow-none" placeholder="Minimum 8 characters" required style="font-size: 13.5px;">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-top-0 pt-0">
                        <button type="button" class="btn btn-light rounded-2 px-3 py-1.5 fw-semibold border" data-bs-dismiss="modal" style="font-size: 13px;">Cancel</button>
                        <button type="submit" class="btn btn-primary rounded-2 px-3 py-1.5 fw-semibold" style="font-size: 13px; background-color: #2563eb; border: none;">Create Account</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- SWEETALERT2 SCRIPT FOR CONFIRMATION AND NOTIFICATIONS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // 1. Confirm Create User
        function confirmUserCreate(event) {
            event.preventDefault();
            Swal.fire({
                title: 'Create User?',
                text: 'Are you sure you want to add this user account?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#2563eb',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Yes, create it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('create-user-form').submit();
                }
            });
        }

        // 2. Confirm Update User
        function confirmUserUpdate(event, userId) {
            event.preventDefault();
            Swal.fire({
                title: 'Save Changes?',
                text: 'Are you sure you want to update this user details?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#2563eb',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Yes, save changes!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(`edit-user-form-${userId}`).submit();
                }
            });
        }

        // 3. Confirm Delete User
        function confirmDeleteUser(userId, userName) {
            Swal.fire({
                title: 'Delete Account?',
                text: `Are you sure you want to delete ${userName}? This action cannot be undone!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Yes, delete!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(`delete-user-form-${userId}`).submit();
                }
            });
        }

        // 4. Success Notifications (Timer: 1500ms)
        @if (session('status') === 'user-created')
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: 'New user account has been created.',
                timer: 1500,
                showConfirmButton: false
            });
        @elseif (session('status') === 'user-updated')
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: 'User details have been updated.',
                timer: 1500,
                showConfirmButton: false
            });
        @elseif (session('status') === 'user-deleted')
            Swal.fire({
                icon: 'success',
                title: 'Deleted!',
                text: 'User account has been removed.',
                timer: 1500,
                showConfirmButton: false
            });
        @endif

        // 5. Validation Error Notification (Timer: 1800ms)
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
</x-app-layout>