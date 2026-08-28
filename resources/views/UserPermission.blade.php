<x-app-layout>
    <div class="container-fluid px-3 px-md-4 py-3" style="font-family: 'Nunito', sans-serif;">
        
        <!-- PAGE TITLE & DESCRIPTION -->
        <div class="mb-3">
            <h1 class="fw-extrabold text-dark m-0" style="font-size: 1.6rem; font-weight: 800; color: #0f172a; letter-spacing: -0.025em;">Role & Permissions</h1>
            <p class="text-muted m-0 mt-1" style="font-size: 13px; font-weight: 400; color: #64748b;">Manage system access rights and permission rules for all users.</p>
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

        <!-- MAIN CONTAINER CARD -->
        <div class="card border-0 rounded-2 shadow-sm p-3 p-sm-4" style="background-color: #ffffff; border: 1px solid #cbd5e1 !important;">
            
            <!-- TOOLBAR: SEARCH AND ADD BUTTON -->
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
                
                <form method="GET" action="{{ route('permissions.index') }}" class="d-flex flex-wrap align-items-center gap-2 m-0 flex-grow-1">
                    <div class="position-relative flex-grow-1" style="max-width: 320px;">
                        <i class="fa-solid fa-magnifying-glass position-absolute top-50 start-0 translate-middle-y ms-3 text-muted" style="font-size: 13px;"></i>
                        <input type="text" name="search" class="form-control rounded-2 ps-5 pe-3 py-2 fw-semibold" placeholder="Search permission name..." value="{{ request('search') }}" style="font-size: 13px; border-color: #cbd5e1;">
                    </div>

                    @if(request('search'))
                        <a href="{{ route('permissions.index') }}" class="btn btn-light rounded-2 px-3 py-2 fw-semibold border text-muted" style="font-size: 13px; background-color: #ffffff; border-color: #cbd5e1 !important;">
                            <i class="fa-solid fa-rotate-left me-1"></i> Reset
                        </a>
                    @endif
                </form>

                <!-- ADD PERMISSION BUTTON (ADMIN ONLY) -->
                @if(Auth::user()->role === 'admin')
                <div>
                    <button type="button" class="btn btn-primary rounded-2 px-3.5 py-2 fw-bold d-inline-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#createPermissionModal" style="font-size: 13px; background-color: #2563eb; border: none;">
                        <i class="fa-solid fa-plus" style="font-size: 13px;"></i>
                        <span>Add New Permission</span>
                    </button>
                </div>
                @endif
            </div>

            <!-- TABLE -->
            <div class="table-responsive rounded-2" style="border: 1px solid #e2e8f0;">
                <table class="table table-hover align-middle m-0" style="font-size: 13.5px;">
                    <thead style="background-color: #f8fafc; border-bottom: 2px solid #e2e8f0;">
                        <tr>
                            <th class="py-3 px-3 text-uppercase fw-bold text-muted" style="font-size: 11px; letter-spacing: 0.5px;">Permission Name</th>
                            <th class="py-3 px-3 text-uppercase fw-bold text-muted" style="font-size: 11px; letter-spacing: 0.5px;">Guard Name</th>
                            <th class="py-3 px-3 text-uppercase fw-bold text-muted" style="font-size: 11px; letter-spacing: 0.5px;">Created At</th>
                            <th class="py-3 px-3 text-uppercase fw-bold text-muted text-center" style="font-size: 11px; letter-spacing: 0.5px; width: 120px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="border-0">
                        @forelse ($permissions as $p)
                            <tr style="border-bottom: 1px solid #f1f5f9;">
                                <td class="py-3 px-3">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="fa-solid fa-key text-primary" style="font-size: 13px;"></i>
                                        <span class="fw-bold text-dark">{{ $p->name }}</span>
                                    </div>
                                </td>
                                <td class="py-3 px-3 font-monospace text-muted">{{ $p->guard_name ?? 'web' }}</td>
                                <td class="py-3 px-3 text-dark fw-medium">{{ $p->created_at ? $p->created_at->format('d M Y, H:i') : '-' }}</td>
                                <td class="py-3 px-3 text-center">
                                    <div class="d-flex align-items-center justify-content-center gap-1.5">
                                        
                                        <!-- EDIT (ADMIN & LEADER) -->
                                        @if(in_array(Auth::user()->role, ['admin', 'leader']))
                                            <button type="button" class="btn btn-sm btn-light border rounded-2 p-1.5 text-primary" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#editPermissionModal{{ $p->id }}" 
                                                    title="Edit Permission"
                                                    style="width: 32px; height: 32px; background-color: #ffffff; border-color: #cbd5e1 !important;">
                                                <i class="fa-solid fa-pen-to-square" style="font-size: 12px;"></i>
                                            </button>
                                        @endif

                                        <!-- DELETE (ADMIN ONLY) -->
                                        @if(Auth::user()->role === 'admin')
                                            <form action="{{ route('permissions.destroy', $p->id) }}" method="POST" id="delete-permission-form-{{ $p->id }}" class="m-0">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-sm btn-light border rounded-2 p-1.5 text-danger" 
                                                        onclick="confirmDeletePermission({{ $p->id }}, '{{ $p->name }}')" 
                                                        title="Delete Permission"
                                                        style="width: 32px; height: 32px; background-color: #ffffff; border-color: #cbd5e1 !important;">
                                                    <i class="fa-solid fa-trash-can" style="font-size: 12px;"></i>
                                                </button>
                                            </form>
                                        @endif

                                        <!-- READ ONLY READOUT FOR STAFF -->
                                        @if(Auth::user()->role === 'staff')
                                            <span class="badge bg-light text-muted border px-2 py-1" style="font-size: 11px;">View Only</span>
                                        @endif

                                    </div>
                                </td>
                            </tr>

                            <!-- MODAL EDIT PERMISSION -->
                            @if(in_array(Auth::user()->role, ['admin', 'leader']))
                            <div class="modal fade" id="editPermissionModal{{ $p->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content border-0 rounded-2 shadow" style="border: 1px solid #cbd5e1 !important;">
                                        <div class="modal-header border-bottom-0 pb-0">
                                            <div>
                                                <span class="text-primary fw-bold text-uppercase d-block mb-1" style="font-size: 11px; letter-spacing: 1px;">Update Rule</span>
                                                <h5 class="modal-title fw-bold text-dark" style="font-size: 16px;">Edit Permission</h5>
                                            </div>
                                            <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form method="POST" action="{{ route('permissions.update', $p->id) }}" id="edit-permission-form-{{ $p->id }}" onsubmit="confirmPermissionUpdate(event, {{ $p->id }});">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body py-3">
                                                <div class="row g-2.5">
                                                    <div class="col-12">
                                                        <div class="p-2.5 rounded-2" style="background-color: #ffffff; border: 1px solid #cbd5e1;">
                                                            <label class="fw-bold text-muted text-uppercase d-block mb-1" style="font-size: 10.5px; letter-spacing: 0.5px;">Permission Name</label>
                                                            <input type="text" name="name" class="form-control border-0 bg-transparent p-0 fw-bold text-dark shadow-none" value="{{ old('name', $p->name) }}" required style="font-size: 13.5px;">
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="p-2.5 rounded-2" style="background-color: #ffffff; border: 1px solid #cbd5e1;">
                                                            <label class="fw-bold text-muted text-uppercase d-block mb-1" style="font-size: 10.5px; letter-spacing: 0.5px;">Guard Name</label>
                                                            <input type="text" name="guard_name" class="form-control border-0 bg-transparent p-0 fw-bold text-dark shadow-none" value="{{ old('guard_name', $p->guard_name ?? 'web') }}" required style="font-size: 13.5px;">
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
                            @endif
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-4 text-muted" style="font-size: 13.5px;">
                                    <i class="fa-solid fa-shield-slash d-block mb-2" style="font-size: 24px;"></i>
                                    No permissions found matching your query.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- PAGINATION -->
            <div class="mt-3 d-flex justify-content-end">
                {{ $permissions->links() }}
            </div>

        </div>
    </div>

    <!-- MODAL CREATE PERMISSION (ADMIN ONLY) -->
    @if(Auth::user()->role === 'admin')
    <div class="modal fade" id="createPermissionModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 rounded-2 shadow" style="border: 1px solid #cbd5e1 !important;">
                <div class="modal-header border-bottom-0 pb-0">
                    <div>
                        <span class="text-primary fw-bold text-uppercase d-block mb-1" style="font-size: 11px; letter-spacing: 1px;">New Rule</span>
                        <h5 class="modal-title fw-bold text-dark" style="font-size: 16px;">Create New Permission</h5>
                    </div>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('permissions.store') }}" id="create-permission-form" onsubmit="confirmPermissionCreate(event);">
                    @csrf
                    <div class="modal-body py-3">
                        <div class="row g-2.5">
                            <div class="col-12">
                                <div class="p-2.5 rounded-2" style="background-color: #ffffff; border: 1px solid #cbd5e1;">
                                    <label class="fw-bold text-muted text-uppercase d-block mb-1" style="font-size: 10.5px; letter-spacing: 0.5px;">Permission Name</label>
                                    <input type="text" name="name" class="form-control border-0 bg-transparent p-0 fw-bold text-dark shadow-none" placeholder="e.g. edit-users, delete-posts" required style="font-size: 13.5px;">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="p-2.5 rounded-2" style="background-color: #ffffff; border: 1px solid #cbd5e1;">
                                    <label class="fw-bold text-muted text-uppercase d-block mb-1" style="font-size: 10.5px; letter-spacing: 0.5px;">Guard Name</label>
                                    <input type="text" name="guard_name" class="form-control border-0 bg-transparent p-0 fw-bold text-dark shadow-none" value="web" required style="font-size: 13.5px;">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-top-0 pt-0">
                        <button type="button" class="btn btn-light rounded-2 px-3 py-1.5 fw-semibold border" data-bs-dismiss="modal" style="font-size: 13px;">Cancel</button>
                        <button type="submit" class="btn btn-primary rounded-2 px-3 py-1.5 fw-semibold" style="font-size: 13px; background-color: #2563eb; border: none;">Create Permission</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif

    <!-- SWEETALERT2 SCRIPT -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmPermissionCreate(event) {
            event.preventDefault();
            Swal.fire({
                title: 'Create Permission?',
                text: 'Are you sure you want to add this permission?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#2563eb',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Yes, create!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('create-permission-form').submit();
                }
            });
        }

        function confirmPermissionUpdate(event, id) {
            event.preventDefault();
            Swal.fire({
                title: 'Save Changes?',
                text: 'Are you sure you want to update this permission?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#2563eb',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Yes, save!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(`edit-permission-form-${id}`).submit();
                }
            });
        }

        function confirmDeletePermission(id, name) {
            Swal.fire({
                title: 'Delete Permission?',
                text: `Are you sure you want to delete ${name}?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Yes, delete!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(`delete-permission-form-${id}`).submit();
                }
            });
        }

        @if (session('status') === 'permission-created')
            Swal.fire({ icon: 'success', title: 'Success!', text: 'Permission has been created.', timer: 1500, showConfirmButton: false });
        @elseif (session('status') === 'permission-updated')
            Swal.fire({ icon: 'success', title: 'Success!', text: 'Permission has been updated.', timer: 1500, showConfirmButton: false });
        @elseif (session('status') === 'permission-deleted')
            Swal.fire({ icon: 'success', title: 'Deleted!', text: 'Permission has been deleted.', timer: 1500, showConfirmButton: false });
        @endif
    </script>
</x-app-layout>