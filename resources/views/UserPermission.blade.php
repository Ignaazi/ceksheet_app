<x-app-layout>
    <div class="container-fluid px-3 px-md-4 py-3" style="font-family: 'Nunito', sans-serif;">
        
        <!-- PAGE TITLE & DESCRIPTION -->
        <div class="mb-3">
            <h1 class="fw-extrabold text-dark m-0" style="font-size: 1.6rem; font-weight: 800; color: #0f172a; letter-spacing: -0.025em;">Role & Access Matrix</h1>
            <p class="text-muted m-0 mt-1" style="font-size: 13px; font-weight: 400; color: #64748b;">Configure permission checkboxes for action buttons (View, Create, Edit, Delete) across system roles.</p>
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
                    <i class="fa-solid fa-shield-halved" style="font-size: 12px;"></i>
                    <span>Role & Permissions</span>
                </li>
            </ol>
        </nav>

        <form method="POST" action="{{ route('permissions.update') }}" id="matrix-permission-form" onsubmit="confirmMatrixSave(event);">
            @csrf
            @method('PUT')

            <!-- ROLE SELECTOR & ACTION TOOLBAR -->
            <div class="card border-0 rounded-2 shadow-sm p-3 mb-3" style="background-color: #ffffff; border: 1px solid #cbd5e1 !important;">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                    <div class="d-flex align-items-center gap-2">
                        <span class="fw-bold text-dark" style="font-size: 13.5px;"><i class="fa-solid fa-user-shield text-primary me-1"></i> Target Role:</span>
                        <div class="btn-group" role="group" aria-label="Role Switcher">
                            <input type="radio" class="btn-check" name="selected_role" id="role_admin" value="admin" checked autocomplete="off" onchange="switchRoleTab('admin')">
                            <label class="btn btn-outline-primary btn-sm fw-bold px-3" for="role_admin">Admin</label>

                            <input type="radio" class="btn-check" name="selected_role" id="role_leader" value="leader" autocomplete="off" onchange="switchRoleTab('leader')">
                            <label class="btn btn-outline-primary btn-sm fw-bold px-3" for="role_leader">Leader</label>

                            <input type="radio" class="btn-check" name="selected_role" id="role_staff" value="staff" autocomplete="off" onchange="switchRoleTab('staff')">
                            <label class="btn btn-outline-primary btn-sm fw-bold px-3" for="role_staff">Staff</label>
                        </div>
                    </div>

                    @if(Auth::user()->role === 'admin')
                    <div class="d-flex align-items-center gap-2">
                        <button type="button" class="btn btn-light border rounded-2 px-3 py-1.5 fw-semibold text-muted" onclick="toggleSelectAllCurrentRole()" style="font-size: 13px; background-color: #ffffff; border-color: #cbd5e1 !important;">
                            <i class="fa-solid fa-check-double me-1"></i> Toggle All
                        </button>
                        <button type="submit" class="btn btn-primary rounded-2 px-3.5 py-1.5 fw-bold d-inline-flex align-items-center gap-2" style="font-size: 13px; background-color: #2563eb; border: none;">
                            <i class="fa-solid fa-floppy-disk"></i>
                            <span>Save Permissions Matrix</span>
                        </button>
                    </div>
                    @endif
                </div>
            </div>

            <!-- PERMISSION MATRIX TABLE -->
            <div class="card border-0 rounded-2 shadow-sm p-0 overflow-hidden" style="background-color: #ffffff; border: 1px solid #cbd5e1 !important;">
                <div class="table-responsive">
                    <table class="table table-hover align-middle m-0" style="font-size: 13.5px;">
                        <thead style="background-color: #f8fafc; border-bottom: 2px solid #e2e8f0;">
                            <tr>
                                <th class="py-3 px-3 text-uppercase fw-bold text-muted" style="font-size: 11px; letter-spacing: 0.5px;">System Module / Feature</th>
                                <th class="py-3 px-3 text-uppercase fw-bold text-muted text-center" style="font-size: 11px; letter-spacing: 0.5px; width: 110px;">
                                    <i class="fa-solid fa-eye me-1"></i> View
                                </th>
                                <th class="py-3 px-3 text-uppercase fw-bold text-muted text-center" style="font-size: 11px; letter-spacing: 0.5px; width: 110px;">
                                    <i class="fa-solid fa-plus me-1"></i> Create
                                </th>
                                <th class="py-3 px-3 text-uppercase fw-bold text-muted text-center" style="font-size: 11px; letter-spacing: 0.5px; width: 110px;">
                                    <i class="fa-solid fa-pen-to-square me-1"></i> Edit
                                </th>
                                <th class="py-3 px-3 text-uppercase fw-bold text-muted text-center" style="font-size: 11px; letter-spacing: 0.5px; width: 110px;">
                                    <i class="fa-solid fa-trash-can me-1"></i> Delete
                                </th>
                                <th class="py-3 px-3 text-uppercase fw-bold text-muted text-center" style="font-size: 11px; letter-spacing: 0.5px; width: 100px;">Row Action</th>
                            </tr>
                        </thead>
                        <tbody class="border-0">

                            @php
                                $modules = [
                                    'dashboard' => ['label' => 'Dashboard Overview', 'icon' => 'fa-rocket', 'actions' => ['view']],
                                    'users' => ['label' => 'User Accounts Management', 'icon' => 'fa-users', 'actions' => ['view', 'create', 'edit', 'delete']],
                                    'ip_config' => ['label' => 'Configure IP / LAN Settings', 'icon' => 'fa-network-wired', 'actions' => ['view', 'edit']],
                                    'permissions' => ['label' => 'Role & Permissions Access', 'icon' => 'fa-shield-halved', 'actions' => ['view', 'edit']],
                                ];

                                // Dummy Matrix Default Akses
                                $roles = ['admin', 'leader', 'staff'];
                            @endphp

                            @foreach ($modules as $modKey => $mod)
                                <tr style="border-bottom: 1px solid #f1f5f9;">
                                    <td class="py-3 px-3">
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="fa-solid {{ $mod['icon'] }} text-primary" style="font-size: 14px; width: 18px;"></i>
                                            <span class="fw-bold text-dark">{{ $mod['label'] }}</span>
                                        </div>
                                    </td>

                                    <!-- VIEW PERMISSION -->
                                    <td class="py-3 px-3 text-center">
                                        @if(in_array('view', $mod['actions']))
                                            @foreach($roles as $r)
                                                <div class="form-check d-inline-block role-check-group role-group-{{ $r }} {{ $r !== 'admin' ? 'd-none' : '' }}">
                                                    <input class="form-check-input check-{{ $r }} row-check-{{ $modKey }}" type="checkbox" 
                                                           name="permissions[{{ $r }}][{{ $modKey }}][view]" value="1" 
                                                           {{ ($r === 'admin' || $r === 'leader' || ($r === 'staff' && $modKey === 'dashboard')) ? 'checked' : '' }}
                                                           {{ Auth::user()->role !== 'admin' ? 'disabled' : '' }}>
                                                </div>
                                            @endforeach
                                        @else
                                            <span class="text-muted">&mdash;</span>
                                        @endif
                                    </td>

                                    <!-- CREATE PERMISSION -->
                                    <td class="py-3 px-3 text-center">
                                        @if(in_array('create', $mod['actions']))
                                            @foreach($roles as $r)
                                                <div class="form-check d-inline-block role-check-group role-group-{{ $r }} {{ $r !== 'admin' ? 'd-none' : '' }}">
                                                    <input class="form-check-input check-{{ $r }} row-check-{{ $modKey }}" type="checkbox" 
                                                           name="permissions[{{ $r }}][{{ $modKey }}][create]" value="1" 
                                                           {{ ($r === 'admin' || ($r === 'leader' && $modKey === 'users')) ? 'checked' : '' }}
                                                           {{ Auth::user()->role !== 'admin' ? 'disabled' : '' }}>
                                                </div>
                                            @endforeach
                                        @else
                                            <span class="text-muted">&mdash;</span>
                                        @endif
                                    </td>

                                    <!-- EDIT PERMISSION -->
                                    <td class="py-3 px-3 text-center">
                                        @if(in_array('edit', $mod['actions']))
                                            @foreach($roles as $r)
                                                <div class="form-check d-inline-block role-check-group role-group-{{ $r }} {{ $r !== 'admin' ? 'd-none' : '' }}">
                                                    <input class="form-check-input check-{{ $r }} row-check-{{ $modKey }}" type="checkbox" 
                                                           name="permissions[{{ $r }}][{{ $modKey }}][edit]" value="1" 
                                                           {{ ($r === 'admin' || ($r === 'leader' && $modKey === 'users')) ? 'checked' : '' }}
                                                           {{ Auth::user()->role !== 'admin' ? 'disabled' : '' }}>
                                                </div>
                                            @endforeach
                                        @else
                                            <span class="text-muted">&mdash;</span>
                                        @endif
                                    </td>

                                    <!-- DELETE PERMISSION -->
                                    <td class="py-3 px-3 text-center">
                                        @if(in_array('delete', $mod['actions']))
                                            @foreach($roles as $r)
                                                <div class="form-check d-inline-block role-check-group role-group-{{ $r }} {{ $r !== 'admin' ? 'd-none' : '' }}">
                                                    <input class="form-check-input check-{{ $r }} row-check-{{ $modKey }}" type="checkbox" 
                                                           name="permissions[{{ $r }}][{{ $modKey }}][delete]" value="1" 
                                                           {{ ($r === 'admin') ? 'checked' : '' }}
                                                           {{ Auth::user()->role !== 'admin' ? 'disabled' : '' }}>
                                                </div>
                                            @endforeach
                                        @else
                                            <span class="text-muted">&mdash;</span>
                                        @endif
                                    </td>

                                    <!-- ROW TOGGLE ALL -->
                                    <td class="py-3 px-3 text-center">
                                        @if(Auth::user()->role === 'admin')
                                            <button type="button" class="btn btn-sm btn-light border py-1 px-2 text-muted fw-semibold" onclick="toggleRowCheck('{{ $modKey }}')" style="font-size: 11px;">
                                                Select Row
                                            </button>
                                        @else
                                            <span class="badge bg-light text-muted border px-2 py-1" style="font-size: 10px;">Read Only</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </form>

    </div>

    <!-- SWEETALERT2 & SCRIPT -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        let currentActiveRole = 'admin';

        function switchRoleTab(role) {
            currentActiveRole = role;
            
            // Sembunyikan semua checkbox group role
            document.querySelectorAll('.role-check-group').forEach(el => el.classList.add('d-none'));
            
            // Tampilkan checkbox milik role yang dipilih
            document.querySelectorAll(`.role-group-${role}`).forEach(el => el.classList.remove('d-none'));
        }

        function toggleSelectAllCurrentRole() {
            const checkboxes = document.querySelectorAll(`.check-${currentActiveRole}`);
            const allChecked = Array.from(checkboxes).every(cb => cb.checked);
            
            checkboxes.forEach(cb => {
                if (!cb.disabled) cb.checked = !allChecked;
            });
        }

        function toggleRowCheck(modKey) {
            const rowCheckboxes = document.querySelectorAll(`.row-check-${modKey}.check-${currentActiveRole}`);
            const allChecked = Array.from(rowCheckboxes).every(cb => cb.checked);
            
            rowCheckboxes.forEach(cb => {
                if (!cb.disabled) cb.checked = !allChecked;
            });
        }

        function confirmMatrixSave(event) {
            event.preventDefault();
            Swal.fire({
                title: 'Save Access Rules?',
                text: `Update permission settings for target systems?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#2563eb',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Yes, Save Matrix!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('matrix-permission-form').submit();
                }
            });
        }

        @if (session('status') === 'permissions-updated')
            Swal.fire({ icon: 'success', title: 'Updated!', text: 'Permissions matrix saved successfully.', timer: 1500, showConfirmButton: false });
        @endif
    </script>
</x-app-layout>