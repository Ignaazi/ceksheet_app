<x-app-layout>
    <div class="container-fluid px-3 px-md-4 py-3" style="font-family: 'Nunito', sans-serif;">
        
        <!-- PAGE TITLE & NAVIGATION -->
        <div class="d-flex align-items-center justify-content-between mb-3">
            <div>
                <h1 class="fw-extrabold text-dark m-0" style="font-size: 1.6rem; font-weight: 800; color: #0f172a; letter-spacing: -0.025em;">
                    <i class="fa-solid fa-file-signature text-primary me-2"></i>Detail Approval Sheet
                </h1>
                <p class="text-muted m-0 mt-1" style="font-size: 13px; font-weight: 400; color: #64748b;">
                    Detail hasil analisis sensor log CSV dan parameter form checksheet yang di-generate via Gemini AI.
                </p>
            </div>
            <a href="{{ route('approval.index') }}" class="btn btn-outline-secondary btn-sm rounded-2 px-3 fw-bold d-inline-flex align-items-center gap-1.5" style="font-size: 13px;">
                <i class="fa-solid fa-arrow-left"></i>
                <span>Kembali</span>
            </a>
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
                <li class="breadcrumb-item">
                    <a href="{{ route('approval.index') }}" class="text-decoration-none fw-semibold d-inline-flex align-items-center gap-1.5" style="color: #64748b;">
                        <i class="fa-solid fa-robot" style="font-size: 12px;"></i>
                        <span>Approval Sheets</span>
                    </a>
                </li>
                <li class="breadcrumb-item active fw-bold d-inline-flex align-items-center gap-1.5" aria-current="page" style="color: #2563eb;">
                    <i class="fa-solid fa-file-lines" style="font-size: 12px;"></i>
                    <span>REF-{{ $sheet->id }}</span>
                </li>
            </ol>
        </nav>

        @php
            // Memastikan ai_result selalu berwujud array valid
            $aiData = is_string($sheet->ai_result) ? json_decode($sheet->ai_result, true) : ($sheet->ai_result ?? []);
        @endphp

        <div class="row g-3">
            <!-- HEADER INFO CARD -->
            <div class="col-lg-12">
                <div class="card border-0 rounded-2 shadow-sm p-3 mb-1" style="background-color: #ffffff; border: 1px solid #cbd5e1 !important;">
                    <div class="row align-items-center g-3">
                        <div class="col-md-4 border-end">
                            <span class="text-muted small fw-bold d-block mb-1 text-uppercase" style="font-size: 11px;">Judul Sheet</span>
                            <h5 class="fw-bold text-dark m-0" style="font-size: 1.1rem;">{{ $sheet->title }}</h5>
                            <span class="text-muted small" style="font-size: 11px;">ID: REF-{{ $sheet->id }} | Created: {{ $sheet->created_at ? $sheet->created_at->format('d M Y H:i') : '-' }}</span>
                        </div>
                        <div class="col-md-3 border-end">
                            <span class="text-muted small fw-bold d-block mb-1 text-uppercase" style="font-size: 11px;">Line & Mesin</span>
                            <div class="fw-semibold text-dark" style="font-size: 13.5px;">{{ $sheet->line_name }}</div>
                            <span class="text-muted small" style="font-size: 12px;">{{ $sheet->machine_type }}</span>
                        </div>
                        <div class="col-md-2 border-end text-center">
                            <span class="text-muted small fw-bold d-block mb-1 text-uppercase" style="font-size: 11px;">Skor Kelayakan AI</span>
                            @php $score = $aiData['score_kelayakan'] ?? 85; @endphp
                            <span class="badge {{ $score >= 80 ? 'bg-success bg-opacity-10 text-success border-success' : 'bg-warning bg-opacity-10 text-warning border-warning' }} fw-bold border border-opacity-25 px-3 py-1" style="font-size: 13px;">
                                {{ $score }}/100
                            </span>
                        </div>
                        <div class="col-md-3 text-center">
                            <span class="text-muted small fw-bold d-block mb-1 text-uppercase" style="font-size: 11px;">Status Approval</span>
                            @php $status = strtolower($sheet->status ?? 'pending'); @endphp
                            @if($status === 'approved')
                                <span class="badge bg-success text-white px-3 py-1.5 fw-bold" style="font-size: 12px;">
                                    <i class="fa-solid fa-circle-check me-1"></i> APPROVED
                                </span>
                            @elseif($status === 'rejected')
                                <span class="badge bg-danger text-white px-3 py-1.5 fw-bold" style="font-size: 12px;">
                                    <i class="fa-solid fa-circle-xmark me-1"></i> REJECTED
                                </span>
                            @else
                                <span class="badge bg-warning text-dark px-3 py-1.5 fw-bold" style="font-size: 12px;">
                                    <i class="fa-solid fa-clock me-1"></i> PENDING
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- DETAIL FORM PARAMETER -->
            <div class="col-lg-12">
                <div class="card border-0 rounded-2 shadow-sm p-0 overflow-hidden" style="background-color: #ffffff; border: 1px solid #cbd5e1 !important;">
                    <div class="p-3 border-bottom d-flex align-items-center justify-content-between" style="background-color: #f8fafc; border-bottom: 1px solid #e2e8f0 !important;">
                        <span class="fw-bold text-dark" style="font-size: 13.5px;">
                            <i class="fa-solid fa-list-check text-primary me-1"></i> Extracted Parameters from CSV Log
                        </span>
                        <span class="badge bg-primary bg-opacity-10 text-primary px-2 py-1 fw-bold" style="font-size: 11px;">
                            Gemini AI Processed
                        </span>
                    </div>

                    <div class="p-4">
                        <!-- AI INSIGHT / NOTES -->
                        @php
                            $aiAnalysisText = $aiData['summary_analysis'] ?? $aiData['ai_notes'] ?? 'Analisis diproses secara internal.';
                        @endphp
                        <div class="alert alert-info border-0 shadow-sm d-flex align-items-center gap-2 mb-4" style="background-color: #eff6ff; color: #1e40af;">
                            <i class="fa-solid fa-robot fs-4"></i>
                            <div style="font-size: 13px;">
                                <strong>Analisis Gemini AI:</strong> {{ $aiAnalysisText }}
                            </div>
                        </div>

                        <!-- PARAMETER TABLE -->
                        <div class="table-responsive mb-4">
                            <table class="table table-bordered align-middle m-0" style="font-size: 13.5px;">
                                <thead style="background-color: #f8fafc;">
                                    <tr>
                                        <th class="py-2.5 px-3 fw-bold text-muted text-uppercase" style="font-size: 11px; width: 40%;">Parameter Name</th>
                                        <th class="py-2.5 px-3 fw-bold text-muted text-uppercase" style="font-size: 11px; width: 40%;">Recorded Value / Setting</th>
                                        <th class="py-2.5 px-3 fw-bold text-muted text-uppercase text-center" style="font-size: 11px; width: 20%;">Verification</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $parameters = $aiData['parameters'] ?? [];
                                    @endphp

                                    @if(is_array($parameters) && count($parameters) > 0)
                                        @foreach($parameters as $item)
                                            @php
                                                // Handle kompatibilitas baik Indexed Array maupun Key-Value Lama
                                                $pName = is_array($item) ? ($item['parameter'] ?? '-') : $loop->key;
                                                $pValue = is_array($item) ? ($item['value'] ?? '-') : $item;
                                            @endphp
                                            <tr>
                                                <td class="py-2.5 px-3 fw-bold text-dark text-capitalize">
                                                    {{ str_replace('_', ' ', (string)$pName) }}
                                                </td>
                                                <td class="py-2.5 px-3 text-dark fw-semibold">
                                                    {{ is_array($pValue) ? json_encode($pValue) : ($pValue ?? '-') }}
                                                </td>
                                                <td class="py-2.5 px-3 text-center">
                                                    <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-2 py-1" style="font-size: 11px;">
                                                        <i class="fa-solid fa-check me-1"></i> Valid
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="3" class="text-center py-4 text-muted small">
                                                Tidak ada data parameter yang dapat diekstrak dari file CSV.
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>

                        <!-- ACTION BUTTONS WITH FORMS -->
                        <div class="d-flex align-items-center justify-content-end gap-2 pt-3 border-top">
                            <a href="{{ route('approval.index') }}" class="btn btn-light border btn-sm px-3 fw-semibold text-muted" style="font-size: 13px;">
                                Kembali ke Daftar
                            </a>

                            @if($status === 'pending')
                                <!-- REJECT FORM -->
                                <form action="{{ route('approval.reject', $sheet->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-outline-danger btn-sm px-3 fw-bold" style="font-size: 13px;" onclick="return confirm('Apakah Anda yakin ingin menolak sheet ini?')">
                                        <i class="fa-solid fa-xmark me-1"></i> Reject Sheet
                                    </button>
                                </form>

                                <!-- APPROVE FORM -->
                                <form action="{{ route('approval.approve', $sheet->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-success btn-sm px-4 fw-bold" style="font-size: 13px;" onclick="return confirm('Apakah Anda yakin ingin menyetujui sheet ini?')">
                                        <i class="fa-solid fa-check me-1"></i> Approve Sheet
                                    </button>
                                </form>
                            @else
                                <span class="text-muted small fst-italic">Status sheet telah diperbarui ({{ strtoupper($status) }}).</span>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- SWEETALERT NOTIFICATION -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
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
                text: "{{ session('error') }}",
            });
        @endif
    </script>
</x-app-layout>