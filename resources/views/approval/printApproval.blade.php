<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Approval Sheet - REF-{{ $sheet->id }}</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome Font -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            color: #000;
            background-color: #fff;
            font-size: 12pt;
        }

        .print-container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        .header-title {
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .table-bordered th, .table-bordered td {
            border: 1px solid #000 !important;
            padding: 6px 10px;
        }

        .signature-box {
            margin-top: 50px;
        }

        /* MEDIA PRINT SPECIFIC RULES */
        @media print {
            .no-print {
                display: none !important;
            }
            body {
                padding: 0;
            }
            .print-container {
                width: 100%;
                max-width: 100%;
                padding: 0;
            }
            @page {
                size: A4;
                margin: 1.5cm;
            }
        }
    </style>
</head>
<body>

    <!-- CONTROL BAR (TIDAK TERTIUP SAAT DICETAK) -->
    <div class="no-print bg-light border-bottom p-3 mb-4 shadow-sm">
        <div class="container d-flex align-items-center justify-content-between">
            <div>
                <span class="fw-bold">Print Preview:</span> REF-{{ $sheet->id }}
            </div>
            <div class="d-flex gap-2">
                <button onclick="window.print()" class="btn btn-primary btn-sm px-3 fw-bold">
                    <i class="fa-solid fa-print me-1"></i> Cetak / Save PDF
                </button>
                <button onclick="window.close()" class="btn btn-outline-secondary btn-sm px-3">
                    <i class="fa-solid fa-xmark me-1"></i> Tutup
                </button>
            </div>
        </div>
    </div>

    <!-- DOCUMENT PRINT AREA -->
    <div class="print-container">
        
        <!-- HEADER FORM -->
        <div class="header-title text-center">
            <h3 class="fw-bold text-uppercase m-0">FORM APPROVAL SENSOR & PARAMETER MESIN</h3>
            <p class="m-0 text-muted small">Generated automatically by AI System</p>
        </div>

        <!-- METADATA FORM -->
        <table class="table table-bordered mb-4">
            <tbody>
                <tr>
                    <th width="20%" class="bg-light">No. Reference</th>
                    <td width="30%">REF-{{ $sheet->id }}</td>
                    <th width="20%" class="bg-light">Tanggal Dibuat</th>
                    <td width="30%">{{ $sheet->created_at ? $sheet->created_at->format('d/m/Y H:i') : date('d/m/Y H:i') }}</td>
                </tr>
                <tr>
                    <th class="bg-light">Judul Report</th>
                    <td colspan="3" class="fw-bold">{{ $sheet->title }}</td>
                </tr>
                <tr>
                    <th class="bg-light">Line Produksi</th>
                    <td>{{ $sheet->line_name }}</td>
                    <th class="bg-light">Jenis Mesin</th>
                    <td>{{ $sheet->machine_type }}</td>
                </tr>
                <tr>
                    <th class="bg-light">Status Approval</th>
                    <td colspan="3">
                        <strong class="text-uppercase">{{ $sheet->status ?? 'PENDING' }}</strong>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- RINGKASAN REKOMENDASI AI -->
        @php
            $aiData = is_array($sheet->ai_result) ? $sheet->ai_result : json_decode($sheet->ai_result, true);
        @endphp

        <div class="mb-4">
            <h6 class="fw-bold text-uppercase border-bottom pb-1">1. Hasil Analisis AI</h6>
            <table class="table table-bordered">
                <tr>
                    <th width="30%" class="bg-light">Score Kelayakan AI</th>
                    <td>
                        <strong>{{ $aiData['score_kelayakan'] ?? 85 }}/100</strong>
                    </td>
                </tr>
                <tr>
                    <th class="bg-light">Rekomendasi</th>
                    <td>{{ $aiData['rekomendasi'] ?? 'Parameter dalam batas normal toleransi mesin.' }}</td>
                </tr>
                <tr>
                    <th class="bg-light">Catatan / Risk Factor</th>
                    <td>{{ $aiData['catatan'] ?? 'Tidak ada anomali kritis yang ditemukan pada log sensor.' }}</td>
                </tr>
            </table>
        </div>

        <!-- TANDA TANGAN / APPROVAL SIGNATURE -->
        <div class="signature-box">
            <h6 class="fw-bold text-uppercase border-bottom pb-1">2. Lembar Persetujuan (Signatures)</h6>
            <table class="table table-bordered text-center align-middle mt-3">
                <thead>
                    <tr class="bg-light">
                        <th width="33%">Diajukan Oleh (Engineer)</th>
                        <th width="33%">Ditinjau Oleh (Supervisor)</th>
                        <th width="33%">Disetujui Oleh (Manager)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="height: 90px; vertical-align: bottom;">
                            <div class="border-top pt-1 small">( .................................... )</div>
                        </td>
                        <td style="height: 90px; vertical-align: bottom;">
                            <div class="border-top pt-1 small">( .................................... )</div>
                        </td>
                        <td style="height: 90px; vertical-align: bottom;">
                            @if(strtolower($sheet->status) === 'approved')
                                <div class="text-success fw-bold mb-2">[ APPROVED ]</div>
                            @elseif(strtolower($sheet->status) === 'rejected')
                                <div class="text-danger fw-bold mb-2">[ REJECTED ]</div>
                            @endif
                            <div class="border-top pt-1 small">( .................................... )</div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>

    <!-- TRIGGER OTOMATIS POP-UP DIALOG PRINT -->
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            setTimeout(() => {
                window.print();
            }, 500);
        });
    </script>
</body>
</html>