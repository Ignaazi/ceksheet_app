<x-app-layout>
    <div class="container-fluid px-3 px-md-4 py-3" style="font-family: 'Nunito', sans-serif;">
        
        <!-- PAGE TITLE & DESCRIPTION -->
        <div class="mb-3">
            <h1 class="fw-extrabold text-dark m-0" style="font-size: 1.6rem; font-weight: 800; color: #0f172a; letter-spacing: -0.025em;">
                <i class="fa-solid fa-robot text-primary me-2"></i>Approval Sheets AI
            </h1>
            <p class="text-muted m-0 mt-1" style="font-size: 13px; font-weight: 400; color: #64748b;">
                Upload file sensor CSV (seperti parameter mesin/speed/clearance) untuk menghasilkan analisis otomatis dan membuat form approval sheet via AI.
            </p>
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
                    <i class="fa-solid fa-microchip" style="font-size: 12px;"></i>
                    <span>Approval Sheets AI</span>
                </li>
            </ol>
        </nav>

        <div class="row g-3">
            <!-- PANEL KIRI: IMPORT CSV FORM -->
            <div class="col-lg-4">
                <div class="card border-0 rounded-2 shadow-sm p-3" style="background-color: #ffffff; border: 1px solid #cbd5e1 !important;">
                    <div class="d-flex align-items-center gap-2 mb-3 pb-2 border-bottom">
                        <i class="fa-solid fa-file-csv text-success" style="font-size: 18px;"></i>
                        <h6 class="fw-bold text-dark m-0" style="font-size: 14px;">Import Sensor Log (.CSV)</h6>
                    </div>

                    <form action="{{ route('approval.store') }}" method="POST" enctype="multipart/form-data" id="form-import-csv">
                        @csrf
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold text-dark mb-1" style="font-size: 12.5px;">Judul Laporan Sheet</label>
                            <input type="text" name="title" value="{{ old('title') }}" class="form-control form-control-sm" placeholder="Contoh: Audit Machine SPG2" style="font-size: 13px;" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold text-dark mb-1" style="font-size: 12.5px;">Target Line Produksi</label>
                            <select name="line_name" class="form-select form-select-sm" style="font-size: 13px;" required>
                                <option value="" selected disabled>-- Pilih Line --</option>
                                <option value="Line A - SMT" {{ old('line_name') == 'Line A - SMT' ? 'selected' : '' }}>Line A - SMT</option>
                                <option value="Line B - DIP" {{ old('line_name') == 'Line B - DIP' ? 'selected' : '' }}>Line B - DIP</option>
                                <option value="Line C - Assembly" {{ old('line_name') == 'Line C - Assembly' ? 'selected' : '' }}>Line C - Assembly</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold text-dark mb-1" style="font-size: 12.5px;">Mesin / Peralatan</label>
                            <select name="machine_type" class="form-select form-select-sm" style="font-size: 13px;" required>
                                <option value="" selected disabled>-- Pilih Jenis Mesin --</option>
                                <option value="Printer Screen Printing" {{ old('machine_type') == 'Printer Screen Printing' ? 'selected' : '' }}>Printer Screen Printing</option>
                                <option value="NPM-WX High Speed" {{ old('machine_type') == 'NPM-WX High Speed' ? 'selected' : '' }}>NPM-WX High Speed</option>
                                <option value="Reflow Oven 10-Zone" {{ old('machine_type') == 'Reflow Oven 10-Zone' ? 'selected' : '' }}>Reflow Oven 10-Zone</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold text-dark mb-1" style="font-size: 12.5px;">File Data Sensor (.CSV)</label>
                            <input type="file" name="csv_file" class="form-control form-control-sm" accept=".csv,.txt" style="font-size: 13px;" required>
                            <div class="form-text mt-1 text-muted" style="font-size: 11px;">
                                <i class="fa-solid fa-circle-info me-1"></i>Format CSV mencakup nama parameter dan nilai (cth: speed, clearance).
                            </div>
                        </div>

                        <button type="submit" id="btn-submit-csv" class="btn btn-primary rounded-2 w-100 py-2 fw-bold d-inline-flex align-items-center justify-content-center gap-2" style="font-size: 13px; background-color: #2563eb; border: none;">
                            <i class="fa-solid fa-wand-magic-sparkles" id="btn-icon"></i>
                            <span id="btn-text">Generate Form via AI</span>
                        </button>
                    </form>
                </div>
            </div>

            <!-- PANEL KANAN: HISTORY / DAFTAR APPROVAL -->
            <div class="col-lg-8">
                <div class="card border-0 rounded-2 shadow-sm p-0 overflow-hidden" style="background-color: #ffffff; border: 1px solid #cbd5e1 !important;">
                    <div class="p-3 border-bottom d-flex align-items-center justify-content-between" style="background-color: #f8fafc; border-bottom: 1px solid #e2e8f0 !important;">
                        <span class="fw-bold text-dark" style="font-size: 13.5px;">
                            <i class="fa-solid fa-list-check text-primary me-1"></i> Generated Approval Sheets
                        </span>
                        <span class="badge bg-primary px-2 py-1" style="font-size: 11px;">Total: {{ count($sheets ?? []) }}</span>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle m-0" style="font-size: 13.5px;">
                            <thead style="background-color: #f8fafc; border-bottom: 2px solid #e2e8f0;">
                                <tr>
                                    <th class="py-3 px-3 text-uppercase fw-bold text-muted" style="font-size: 11px; letter-spacing: 0.5px;">Sheet Title</th>
                                    <th class="py-3 px-3 text-uppercase fw-bold text-muted" style="font-size: 11px; letter-spacing: 0.5px;">Line & Machine</th>
                                    <th class="py-3 px-3 text-uppercase fw-bold text-muted text-center" style="font-size: 11px; letter-spacing: 0.5px;">AI Score</th>
                                    <th class="py-3 px-3 text-uppercase fw-bold text-muted text-center" style="font-size: 11px; letter-spacing: 0.5px;">Status</th>
                                    <th class="py-3 px-3 text-uppercase fw-bold text-muted text-center" style="font-size: 11px; letter-spacing: 0.5px; width: 180px;">Action</th>
                                </tr>
                            </thead>
                            <tbody class="border-0">
                                @forelse($sheets ?? [] as $sheet)
                                    <tr style="border-bottom: 1px solid #f1f5f9;">
                                        <td class="py-3 px-3">
                                            <div class="fw-bold text-dark" style="font-size: 13.5px;">{{ $sheet->title }}</div>
                                            <span class="text-muted" style="font-size: 11px;">REF-{{ $sheet->id }}</span>
                                        </td>
                                        <td class="py-3 px-3">
                                            <div class="fw-semibold text-dark" style="font-size: 12.5px;">{{ $sheet->line_name }}</div>
                                            <span class="text-muted" style="font-size: 11px;">{{ $sheet->machine_type }}</span>
                                        </td>
                                        <td class="py-3 px-3 text-center">
                                            @php 
                                                $aiData = is_array($sheet->ai_result) ? $sheet->ai_result : json_decode($sheet->ai_result, true);
                                                $score = $aiData['score_kelayakan'] ?? 85; 
                                            @endphp
                                            <span class="badge {{ $score >= 80 ? 'bg-success bg-opacity-10 text-success border-success' : 'bg-warning bg-opacity-10 text-warning border-warning' }} fw-bold border border-opacity-25 px-2 py-1" style="font-size: 11px;">
                                                {{ $score }}/100
                                            </span>
                                        </td>
                                        <td class="py-3 px-3 text-center">
                                            @php $status = strtolower($sheet->status ?? 'pending'); @endphp
                                            @if($status === 'approved')
                                                <span class="badge bg-success bg-opacity-10 text-success fw-bold px-2 py-1" style="font-size: 11px;">Approved</span>
                                            @elseif($status === 'rejected')
                                                <span class="badge bg-danger bg-opacity-10 text-danger fw-bold px-2 py-1" style="font-size: 11px;">Rejected</span>
                                            @else
                                                <span class="badge bg-warning bg-opacity-10 text-warning fw-bold px-2 py-1" style="font-size: 11px;">Pending</span>
                                            @endif
                                        </td>
                                        <td class="py-3 px-3 text-center">
                                            <div class="d-inline-flex align-items-center gap-1">
                                                <!-- TOMBOL CETAK PRINT FORM (OPEN NEW TAB) -->
                                                <a href="{{ route('approval.print', $sheet->id) }}" target="_blank" class="btn btn-sm btn-dark border py-1 px-2 fw-semibold d-inline-flex align-items-center gap-1" style="font-size: 11px;" title="Cetak / Print Form">
                                                    <i class="fa-solid fa-print"></i> Print
                                                </a>

                                                <!-- TOMBOL VIEW DETAIL -->
                                                <a href="{{ route('approval.show', $sheet->id) }}" class="btn btn-sm btn-light border py-1 px-2 fw-semibold text-primary d-inline-flex align-items-center gap-1" style="font-size: 11px;" title="Lihat Detail">
                                                    <i class="fa-solid fa-eye"></i> View
                                                </a>

                                                <!-- DROPDOWN AKSI APPROVAL -->
                                                @if($status === 'pending')
                                                    <div class="dropdown">
                                                        <button class="btn btn-sm btn-outline-secondary py-1 px-1" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="font-size: 11px;">
                                                            <i class="fa-solid fa-ellipsis-vertical"></i>
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0" style="font-size: 12px;">
                                                            <li>
                                                                <form action="{{ route('approval.approve', $sheet->id) }}" method="POST">
                                                                    @csrf
                                                                    @method('PATCH')
                                                                    <button type="submit" class="dropdown-item text-success fw-bold d-flex align-items-center gap-2">
                                                                        <i class="fa-solid fa-circle-check"></i> Approve
                                                                    </button>
                                                                </form>
                                                            </li>
                                                            <li>
                                                                <form action="{{ route('approval.reject', $sheet->id) }}" method="POST">
                                                                    @csrf
                                                                    @method('PATCH')
                                                                    <button type="submit" class="dropdown-item text-danger fw-bold d-flex align-items-center gap-2">
                                                                        <i class="fa-solid fa-circle-xmark"></i> Reject
                                                                    </button>
                                                                </form>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5 text-muted">
                                            <i class="fa-solid fa-robot fs-2 d-block mb-2 opacity-25"></i>
                                            <span style="font-size: 13px;">Belum ada data sheet. Silakan upload CSV di panel sebelah kiri untuk memproses form pertama!</span>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- SWEETALERT2 & FORM SPINNER JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // SweetAlert Notifications
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                timer: 2500,
                showConfirmButton: false
            });
        @endif

        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: "{{ session('error') }}"
            });
        @endif

        // Auto Loading State saat Form Di-submit
        document.getElementById('form-import-csv').addEventListener('submit', function() {
            const btn = document.getElementById('btn-submit-csv');
            const icon = document.getElementById('btn-icon');
            const text = document.getElementById('btn-text');

            btn.disabled = true;
            icon.className = 'fa-solid fa-circle-notch fa-spin';
            text.innerText = 'Menganalisis via Gemini AI...';
        });
    </script>
</x-app-layout>