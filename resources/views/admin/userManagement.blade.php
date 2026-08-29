<x-app-layout>
    <!-- BOOTSTRAP ICONS CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- CUSTOM CSS ASSETS -->
    <link rel="stylesheet" href="{{ asset('css/admin/userManagement.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/AddUser.css') }}">

    <style>
        /* Custom Bordered Table Style */
        .table-bordered-custom th,
        .table-bordered-custom td {
            border: 1px solid #cbd5e1 !important;
            text-align: center !important;
            vertical-align: middle !important;
        }

        /* Header Blue Style with Vertical Borders */
        .table-blue-header th {
            background-color: #0052cc !important;
            color: #ffffff !important;
            border-color: #003d99 !important;
            font-weight: 600;
        }

        /* Responsive Scroll Container */
        .table-scroll-container {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .table-scroll-container table {
            min-width: 850px;
        }

        /* Subtle 3D Card Style for Directory Snapshots */
        .stat-card-3d {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        
        .stat-card-3d:hover {
            transform: translateY(-2px);
        }

        .stat-card-blue {
            background-color: #ffffff;
            border: 1px solid #bfdbfe !important;
            box-shadow: 0 4px 0 0 #3b82f6;
        }

        .stat-card-indigo {
            background-color: #ffffff;
            border: 1px solid #c7d2fe !important;
            box-shadow: 0 4px 0 0 #6366f1;
        }

        .stat-card-amber {
            background-color: #ffffff;
            border: 1px solid #fde68a !important;
            box-shadow: 0 4px 0 0 #f59e0b;
        }

        .stat-card-sky {
            background-color: #ffffff;
            border: 1px solid #bae6fd !important;
            box-shadow: 0 4px 0 0 #0ea5e9;
        }
    </style>

    <div class="container-fluid px-2 px-md-4 py-4">
        
        <!-- HEADER TITLE & DESCRIPTION -->
        <div class="card border-0 rounded-3 p-3 p-sm-4 mb-4" style="background: radial-gradient(at 0% 0%, #e0e7ff 0px, transparent 50%), radial-gradient(at 25% 100%, #f3e8ff 0px, transparent 50%), radial-gradient(at 50% 0%, #ffedd5 0px, transparent 50%), radial-gradient(at 75% 100%, #fef9c3 0px, transparent 50%), radial-gradient(at 100% 0%, #dcfce7 0px, transparent 50%), #ffffff; border: 1px solid #cbd5e1 !important;">
            <div class="d-flex flex-column justify-content-center">
                <h2 class="fw-bold m-0 text-dark" style="font-size: calc(1.2rem + 0.4vw); color: #0f172a;">User Accounts</h2>
                <p class="text-secondary m-0 mt-1 small" style="color: #64748b !important;">Manage system users, roles, NIK, and access security settings from a centralized panel.</p>
            </div>
        </div>

        <!-- BREADCRUMB NAVIGATION -->
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb bg-transparent p-0 m-0 align-items-center small">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}" class="text-decoration-none fw-semibold d-inline-flex align-items-center gap-1" style="color: #64748b;">
                        <i class="fa-solid fa-rocket" style="font-size: 13px;"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="breadcrumb-item active fw-bold d-inline-flex align-items-center gap-1" aria-current="page" style="color: #0052cc;">
                    <i class="fa-solid fa-users" style="font-size: 13px;"></i>
                    <span>User Accounts</span>
                </li>
            </ol>
        </nav>

        <!-- DIRECTORY SNAPSHOT STATS (4 SUBTLE 3D CARDS WITHOUT CONTAINER) -->
        <div class="row g-3 mb-4">
            <!-- TOTAL ACCOUNT -->
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="p-3 rounded-3 stat-card-3d stat-card-blue d-flex align-items-center justify-content-between h-100">
                    <div>
                        <div class="text-uppercase fw-bold mb-1" style="font-size: 10px; letter-spacing: 0.5px; color: #1e40af;">Total Account</div>
                        <div class="fw-bold fs-3 leading-none text-dark">{{ $users->total() }}</div>
                        <div class="mt-1 small" style="font-size: 11px; color: #2563eb;">All Accounts</div>
                    </div>
                    <div class="rounded-circle p-2.5 bg-primary bg-opacity-10 text-primary">
                        <i class="bi bi-people-fill fs-4"></i>
                    </div>
                </div>
            </div>

            <!-- TOTAL ADMIN -->
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="p-3 rounded-3 stat-card-3d stat-card-indigo d-flex align-items-center justify-content-between h-100">
                    <div>
                        <div class="text-uppercase fw-bold mb-1" style="font-size: 10px; letter-spacing: 0.5px; color: #3730a3;">Total Admin</div>
                        <div class="fw-bold fs-3 leading-none text-dark">
                            {{ $adminCount ?? $users->filter(fn($u) => in_array(strtolower($u->role), ['admin', 'administrator']))->count() }}
                        </div>
                        <div class="mt-1 small" style="font-size: 11px; color: #4338ca;">Full Privileges</div>
                    </div>
                    <div class="rounded-circle p-2.5" style="background-color: #e0e7ff; color: #3730a3;">
                        <i class="bi bi-shield-lock-fill fs-4"></i>
                    </div>
                </div>
            </div>

            <!-- TOTAL LEADER -->
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="p-3 rounded-3 stat-card-3d stat-card-amber d-flex align-items-center justify-content-between h-100">
                    <div>
                        <div class="text-uppercase fw-bold mb-1" style="font-size: 10px; letter-spacing: 0.5px; color: #92400e;">Total Leader</div>
                        <div class="fw-bold fs-3 leading-none text-dark">
                            {{ $leaderCount ?? $users->filter(fn($u) => strtolower($u->role) === 'leader')->count() }}
                        </div>
                        <div class="mt-1 small" style="font-size: 11px; color: #b45309;">Team Supervisor</div>
                    </div>
                    <div class="rounded-circle p-2.5" style="background-color: #fef3c7; color: #92400e;">
                        <i class="bi bi-person-badge-fill fs-4"></i>
                    </div>
                </div>
            </div>

            <!-- TOTAL STAFF -->
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="p-3 rounded-3 stat-card-3d stat-card-sky d-flex align-items-center justify-content-between h-100">
                    <div>
                        <div class="text-uppercase fw-bold mb-1" style="font-size: 10px; letter-spacing: 0.5px; color: #075985;">Total Staff</div>
                        <div class="fw-bold fs-3 leading-none text-dark">
                            {{ $staffCount ?? $users->filter(fn($u) => strtolower($u->role) === 'staff')->count() }}
                        </div>
                        <div class="mt-1 small" style="font-size: 11px; color: #0284c7;">Operational Access</div>
                    </div>
                    <div class="rounded-circle p-2.5" style="background-color: #e0f2fe; color: #075985;">
                        <i class="bi bi-person-workspace fs-4"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- MAIN TABLE CARD & TOOLBAR -->
        <div class="card border-0 rounded-3 p-3 p-sm-4 bg-white" style="border: 1px solid #cbd5e1 !important;">
            
            <!-- TOOLBAR: SEARCH, FILTER DROPDOWN, AND ADD USER LINK -->
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
                
                <!-- SEARCH & FILTER FORM -->
                <form method="GET" action="{{ route('users.index') }}" class="d-flex flex-wrap align-items-center gap-2 m-0 flex-grow-1" id="filterForm">
                    <input type="hidden" name="role" id="selectedRoleInput" value="{{ request('role') }}">

                    <!-- FILTER DROPDOWN -->
                    <div class="dropdown">
                        <button class="btn btn-gradient-blue rounded-3 px-3 py-2 fw-semibold small d-inline-flex align-items-center gap-2 dropdown-toggle" 
                                type="button" 
                                id="roleDropdownMenu" 
                                data-bs-toggle="dropdown" 
                                aria-expanded="false">
                            <i class="bi bi-funnel-fill"></i>
                            <span>
                                @if(request('role') == 'admin')
                                    Administrator
                                @elseif(request('role') == 'leader')
                                    Leader
                                @elseif(request('role') == 'staff')
                                    Staff
                                @else
                                    All Roles
                                @endif
                            </span>
                        </button>
                        <ul class="dropdown-menu border-0 rounded-3 mt-1" aria-labelledby="roleDropdownMenu" style="border: 1px solid #cbd5e1 !important;">
                            <li>
                                <a class="dropdown-item small fw-semibold text-secondary d-flex align-items-center gap-2" href="#" onclick="selectRoleFilter('')">
                                    <i class="bi bi-people-fill text-primary"></i> All Roles
                                </a>
                            </li>
                            <li><hr class="dropdown-divider my-1"></li>
                            <li>
                                <a class="dropdown-item small fw-semibold text-secondary d-flex align-items-center gap-2" href="#" onclick="selectRoleFilter('admin')">
                                    <i class="bi bi-shield-lock-fill text-primary"></i> Administrator
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item small fw-semibold text-secondary d-flex align-items-center gap-2" href="#" onclick="selectRoleFilter('leader')">
                                    <i class="bi bi-person-badge-fill text-warning"></i> Leader
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item small fw-semibold text-secondary d-flex align-items-center gap-2" href="#" onclick="selectRoleFilter('staff')">
                                    <i class="bi bi-person-workspace text-info"></i> Staff
                                </a>
                            </li>
                        </ul>
                    </div>

                    <!-- SEARCH INPUT -->
                    <div class="position-relative flex-grow-1" style="max-width: 300px;">
                        <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-secondary" style="font-size: 13px;"></i>
                        <input type="text" name="search" id="userSearchInput" class="form-control rounded-3 ps-5 pe-3 py-2 fw-semibold small" placeholder="Search users, NIK..." value="{{ request('search') }}" style="border-color: #cbd5e1;">
                    </div>

                    @if(request('search') || request('role'))
                        <a href="{{ route('users.index') }}" class="btn btn-light rounded-3 px-3 py-2 fw-semibold border small text-secondary d-inline-flex align-items-center justify-content-center" style="background-color: #ffffff; border-color: #cbd5e1 !important;">
                            <i class="bi bi-arrow-counterclockwise me-1"></i> Reset
                        </a>
                    @endif
                </form>

                <!-- ADD USER NAVIGATION LINK (FULL PAGE) -->
                <div>
                    <a href="{{ route('users.create') }}" 
                       class="btn btn-gradient-blue rounded-3 px-3 py-2 fw-semibold small d-inline-flex align-items-center gap-2 text-nowrap justify-content-center text-decoration-none">
                        <i class="bi bi-person-plus-fill"></i>
                        <span>Add User</span>
                    </a>
                </div>
            </div>

            <!-- USERS TABLE CONTAINER -->
            <div class="table-scroll-container rounded-2">
                <table class="table table-hover align-middle m-0 text-nowrap table-bordered-custom table-blue-header" id="userDirectoryTable" style="font-size: 13.5px;">
                    <thead>
                        <tr>
                            <th style="width: 60px;">NO</th>
                            <th style="width: 80px;">PROFILE</th>
                            <th>NAME</th>
                            <th>EMAIL ADDRESS</th>
                            <th>NIK</th>
                            <th>ROLE</th>
                            <th style="width: 120px;">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $index => $u)
                            @php
                                $rawRole = strtolower($u->role ?? 'staff');
                            @endphp
                            <tr>
                                <td class="fw-bold text-dark">
                                    {{ sprintf('%02d', $users->firstItem() + $index) }}
                                </td>
                                <td>
                                    <div class="d-flex align-items-center justify-content-center">
                                        <img src="{{ asset('image/defaultProfile.png') }}" 
                                             alt="Profile" 
                                             class="rounded-circle border border-primary-subtle object-fit-cover" 
                                             style="width: 35px; height: 35px; flex-shrink: 0;">
                                    </div>
                                </td>
                                <td class="fw-bold text-dark">{{ $u->name }}</td>
                                <td class="fw-semibold text-secondary">{{ $u->email ?? '-' }}</td>
                                <td class="fw-bold text-dark">{{ $u->nik }}</td>
                                <td>
                                    @if($rawRole === 'admin' || $rawRole === 'administrator')
                                        <span class="badge rounded-pill px-2.5 py-1.5 fw-semibold d-inline-flex align-items-center gap-1" style="background-color: #e0e7ff; color: #3730a3; font-size: 11px;">
                                            <i class="bi bi-shield-lock-fill"></i> Administrator
                                        </span>
                                    @elseif($rawRole === 'leader')
                                        <span class="badge rounded-pill px-2.5 py-1.5 fw-semibold d-inline-flex align-items-center gap-1" style="background-color: #fef3c7; color: #92400e; font-size: 11px;">
                                            <i class="bi bi-person-badge-fill"></i> Leader
                                        </span>
                                    @else
                                        <span class="badge rounded-pill px-2.5 py-1.5 fw-semibold d-inline-flex align-items-center gap-1" style="background-color: #e0f2fe; color: #075985; font-size: 11px;">
                                            <i class="bi bi-person-workspace"></i> Staff
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex align-items-center justify-content-center gap-1">
                                        <!-- PREVIEW BUTTON -->
                                        <a href="{{ route('profile.edit', ['id' => $u->id]) }}" 
                                           class="btn btn-sm btn-gradient-blue rounded-2 px-2 py-1" 
                                           title="Preview Profile">
                                            <i class="bi bi-eye-fill"></i>
                                        </a>

                                        <!-- EDIT BUTTON -->
                                        <a href="{{ route('profile.edit', ['id' => $u->id]) }}" 
                                           class="btn btn-sm btn-gradient-yellow rounded-2 px-2 py-1" 
                                           title="Edit Profile">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                        <!-- DELETE BUTTON -->
                                        @if(Auth::id() !== $u->id)
                                            <form action="{{ route('users.destroy', $u->id) }}" method="POST" id="delete-user-form-{{ $u->id }}" class="m-0">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" 
                                                        class="btn btn-sm btn-gradient-red rounded-2 px-2 py-1" 
                                                        onclick="confirmDeleteUser({{ $u->id }}, '{{ $u->name }}')" 
                                                        title="Delete">
                                                    <i class="bi bi-trash-fill"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-4 text-secondary small">
                                    <i class="bi bi-person-x fs-3 d-block mb-2"></i>
                                    No user accounts found matching your query.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- FOOTER INFO & PAGINATION -->
            <div class="mt-3 d-flex flex-column flex-sm-row justify-content-between align-items-center gap-2">
                <span class="text-secondary small fw-medium text-center text-sm-start">
                    Showing {{ $users->firstItem() ?? 0 }}-{{ $users->lastItem() ?? 0 }} of {{ $users->total() }} users
                </span>
                <div>
                    {{ $users->links() }}
                </div>
            </div>

        </div>
    </div>

    <!-- SWEETALERT2 & JS ASSETS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/admin/userManagement.js') }}"></script>
    <script>
        @if (session('status') === 'user-created' || session('success') === 'user-created')
            Toast.fire({ icon: 'success', title: 'User account created successfully!' });
        @elseif (session('status') === 'user-updated' || session('success') === 'user-updated')
            Toast.fire({ icon: 'success', title: 'User details updated successfully!' });
        @elseif (session('status') === 'user-deleted' || session('success') === 'user-deleted')
            Toast.fire({ icon: 'success', title: 'User account removed successfully!' });
        @endif
    </script>
</x-app-layout>