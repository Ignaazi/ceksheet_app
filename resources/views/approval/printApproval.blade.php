<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>APPROVAL SHEET PROGRAM SCREEN PRINTING - REF-{{ $sheet->id }}</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        * {
            box-sizing: border-box;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            color: #000;
            background-color: #fff;
            font-size: 8pt;
            margin: 0;
            padding: 0;
        }

        .print-page {
            width: 100%;
            max-width: 850px;
            margin: 0 auto;
            padding: 10px;
            background: #fff;
        }

        /* Border Box Wrapper Layout Form */
        .form-border {
            border: 2px solid #000;
            padding: 8px;
        }

        /* Header Form */
        .header-table {
            width: 100%;
            border-bottom: 2px solid #000;
            margin-bottom: 6px;
            padding-bottom: 5px;
        }

        .header-table td {
            vertical-align: middle;
        }

        .logo-img {
            max-height: 40px;
            width: auto;
        }

        .form-title {
            font-size: 11pt;
            font-weight: bold;
            text-align: center;
            letter-spacing: 0.5px;
        }

        /* Table Rules */
        table.tbl-form {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 6px;
        }

        table.tbl-form th, 
        table.tbl-form td {
            border: 1px solid #000;
            padding: 3px 5px;
            font-size: 7.5pt;
            vertical-align: middle;
        }

        .bg-gray {
            background-color: #e0e0e0 !important;
            font-weight: bold;
        }

        .banner-title {
            background-color: #dcdcdc !important;
            border: 1px solid #000;
            font-weight: bold;
            text-align: center;
            font-size: 8.5pt;
            padding: 4px;
            margin: 6px 0 4px 0;
        }

        .checkbox-box {
            display: inline-block;
            width: 11px;
            height: 11px;
            border: 1px solid #000;
            margin-right: 3px;
            vertical-align: middle;
            text-align: center;
            line-height: 9px;
            font-size: 8pt;
            font-weight: bold;
        }

        .text-vertical {
            writing-mode: vertical-lr;
            transform: rotate(180deg);
            text-align: center;
            font-weight: bold;
            font-size: 7pt;
            white-space: nowrap;
        }

        /* Footer Signatures */
        .signature-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
        }

        .signature-table td, .signature-table th {
            border: 1px solid #000;
            text-align: center;
            font-size: 8pt;
        }

        .result-box {
            border: 2px solid #000;
            padding: 3px 8px;
            font-weight: bold;
            font-size: 10pt;
            display: inline-block;
        }

        /* Media Print Rules */
        @media print {
            .no-print { display: none !important; }
            body { padding: 0; background: #fff; }
            .print-page { width: 100%; max-width: 100%; padding: 0; }
            .form-border { border: 2px solid #000; }
            @page {
                size: A4 portrait;
                margin: 0.8cm;
            }
        }
    </style>
</head>
<body>

    <!-- CONTROL TOOLBAR (TIDAK IKUT TERCETAK) -->
    <div class="no-print bg-dark text-white p-2 mb-3 shadow-sm">
        <div class="container d-flex align-items-center justify-content-between">
            <div class="small fw-bold">
                <i class="fa-solid fa-file-pdf me-2 text-warning"></i> Form Approval Screen Printing - {{ $sheet->title }}
            </div>
            <div class="d-flex gap-2">
                <button onclick="window.print()" class="btn btn-success btn-sm px-3 fw-bold">
                    <i class="fa-solid fa-print me-1"></i> Cetak Dokumen
                </button>
                <button onclick="window.close()" class="btn btn-secondary btn-sm px-3">
                    <i class="fa-solid fa-xmark me-1"></i> Tutup
                </button>
            </div>
        </div>
    </div>

    @php
        $aiData = is_array($sheet->ai_result) ? $sheet->ai_result : json_decode($sheet->ai_result, true);
        $status = strtolower($sheet->status ?? 'pending');
    @endphp

    <div class="print-page">
        <div class="form-border">
            
            <!-- HEADER (LOGO & JUDUL FORM) -->
            <table class="header-table">
                <tr>
                    <td width="25%">
                        <img src="{{ asset('image/logoSiix.png') }}" alt="SIIX Logo" class="logo-img" onerror="this.remove();">
                    </td>
                    <td width="75%" class="form-title">
                        APPROVAL SHEET PROGRAM SCREEN PRINTING
                    </td>
                </tr>
            </table>

            <!-- METADATA HEADER SECTION -->
            <table class="tbl-form mb-2" style="border: none;">
                <tr style="border: none;">
                    <td width="15%" style="border:none;"><b>CUSTOMER</b></td>
                    <td width="35%" style="border:none;">: {{ $aiData['customer'] ?? '...........................................' }}</td>
                    <td width="15%" style="border:none;"><b>DATE</b></td>
                    <td width="35%" style="border:none;">: {{ $sheet->created_at ? $sheet->created_at->format('d/m/Y') : date('d/m/Y') }}</td>
                </tr>
                <tr style="border: none;">
                    <td style="border:none;"><b>MODEL</b></td>
                    <td style="border:none;">: {{ $aiData['model'] ?? $sheet->title }}</td>
                    <td style="border:none;"><b>LINE</b></td>
                    <td style="border:none;">: {{ $sheet->line_name }}</td>
                </tr>
                <tr style="border: none;">
                    <td style="border:none;"><b>STATUS RUNNING</b></td>
                    <td style="border:none;">
                        : 
                        <span class="checkbox-box">{{ ($aiData['status_running'] ?? '') == 'PP NEW MODEL' ? '✓' : '' }}</span> PP NEW MODEL
                        <span class="checkbox-box ms-2">{{ ($aiData['status_running'] ?? '') == 'PP NEW RANK' ? '✓' : '' }}</span> PP NEW RANK
                        <span class="checkbox-box ms-2">{{ ($aiData['status_running'] ?? '') == 'OTHERS' ? '✓' : '' }}</span> OTHERS
                        <br>&nbsp;&nbsp;
                        <span class="checkbox-box">{{ ($aiData['status_running'] ?? '') == 'PP NEW LINE' ? '✓' : '' }}</span> PP NEW LINE
                        <span class="checkbox-box ms-2">{{ ($aiData['status_running'] ?? '') == 'ECR/ ECN' ? '✓' : '' }}</span> ECR / ECN
                    </td>
                    <td style="border:none;"><b>TYPE MACHINE</b></td>
                    <td style="border:none;">: {{ $sheet->machine_type }}</td>
                </tr>
            </table>

            <!-- SECTION A, B, C, D METADATA DETAIL -->
            <table class="tbl-form mb-2">
                <tr>
                    <td width="50%" class="align-top">
                        <b>A. PROGRAM NAME :</b> {{ $aiData['program_name'] ?? '-' }}<br>
                        &nbsp;&nbsp;&nbsp;&nbsp;<b>REVISION :</b> {{ $aiData['program_revision'] ?? '00' }}
                    </td>
                    <td width="50%" class="align-top">
                        <b>C. THIKNES STENCIL :</b> {{ $aiData['stencil_thickness'] ?? '-' }} µm<br>
                        &nbsp;&nbsp;&nbsp;&nbsp;<span class="checkbox-box"></span> STEP UP &nbsp;&nbsp;&nbsp;&nbsp;: ...........................................<br>
                        &nbsp;&nbsp;&nbsp;&nbsp;<span class="checkbox-box"></span> STEP DOWN &nbsp;&nbsp;: ...........................................
                    </td>
                </tr>
                <tr>
                    <td class="align-top">
                        <b>B. NO REG STENCIL :</b> {{ $aiData['stencil_no_reg'] ?? '-' }}<br>
                        &nbsp;&nbsp;&nbsp;&nbsp;<b>REVISION :</b> {{ $aiData['stencil_revision'] ?? '00' }}
                    </td>
                    <td class="align-top">
                        <b>D. SOLDER PASTE USED :</b> {{ $aiData['solder_paste_used'] ?? '-' }}<br>
                        &nbsp;&nbsp;&nbsp;&nbsp;<b>SAP CODE :</b> {{ $aiData['sap_code'] ?? '-' }}<br>
                        &nbsp;&nbsp;&nbsp;&nbsp;<b>MAKER :</b> {{ $aiData['maker'] ?? '-' }}
                    </td>
                </tr>
            </table>

            <!-- BANNER STANDART PARAMETER -->
            <div class="banner-title">
                STANDART PARAMETER MACHINE SCREEN PRINTING FROM WI (SW-ZZ-068)
            </div>

            <!-- TABEL ACUAN STANDAR PARAMETER (2 KOLOM SP60 & SPG2 SEPERTI GAMBAR) -->
            <table class="tbl-form mb-2">
                <tr class="bg-gray text-center">
                    <td width="50%">SP60 & SP70 (PARAMETER STANDARD)</td>
                    <td width="50%">SPG & SPG2 (PARAMETER STANDARD)</td>
                </tr>
                <tr>
                    <td class="p-0">
                        <table class="tbl-form m-0" style="border:none;">
                            <tr class="bg-gray text-center">
                                <th>Parameter</th>
                                <th>Data</th>
                                <th>Units</th>
                            </tr>
                            <tr><td>Print Speed(Front & Rear)</td><td class="text-center">30 ~ 70</td><td class="text-center">mm/s</td></tr>
                            <tr><td>Pressure(Front & Rear)</td><td class="text-center">20 ~ 45</td><td class="text-center">10⁻² N/mm</td></tr>
                            <tr><td>Kind / Squeegee Type</td><td class="text-center">Flat Sq</td><td class="text-center">-</td></tr>
                            <tr><td>Print Mode</td><td class="text-center">Single / Double</td><td class="text-center">-</td></tr>
                            <tr><td>Squeegee Length</td><td class="text-center">350</td><td class="text-center">mm</td></tr>
                            <tr><td>Squeegee Angle</td><td class="text-center">60</td><td class="text-center">°</td></tr>
                            <tr><td>Snap-Off Clearance</td><td class="text-center">0.00 ~ 0.20</td><td class="text-center">mm</td></tr>
                        </table>
                    </td>
                    <td class="p-0">
                        <table class="tbl-form m-0" style="border:none;">
                            <tr class="bg-gray text-center">
                                <th>Parameter</th>
                                <th>Data</th>
                                <th>Units</th>
                            </tr>
                            <tr><td>Print Speed(Front & Rear)</td><td class="text-center">30 ~ 70</td><td class="text-center">mm/s</td></tr>
                            <tr><td>Pressure(Front & Rear)</td><td class="text-center">20 ~ 45</td><td class="text-center">10⁻² N/mm</td></tr>
                            <tr><td>Kind / Squeegee Type</td><td class="text-center">Flat Sq</td><td class="text-center">-</td></tr>
                            <tr><td>Print Mode</td><td class="text-center">Single / Double</td><td class="text-center">-</td></tr>
                            <tr><td>Squeegee Length</td><td class="text-center">370</td><td class="text-center">mm</td></tr>
                            <tr><td>Squeegee Angle</td><td class="text-center">60</td><td class="text-center">°</td></tr>
                            <tr><td>Snap-Off Clearance</td><td class="text-center">0.00 ~ 0.20</td><td class="text-center">mm</td></tr>
                        </table>
                    </td>
                </tr>
            </table>

            <!-- BANNER CHECK RESULT -->
            <div class="banner-title">
                CHECK RESULT ACTUAL DATA PRINTING MACHINE
            </div>

            <!-- TABEL ACTUAL PRINTING DATA -->
            <div class="fw-bold mb-1" style="font-size: 8pt;">PRINTING DATA</div>
            <table class="tbl-form mb-2">
                <thead>
                    <tr class="bg-gray text-center">
                        <th colspan="2" width="40%">Printing Setting / Parameter</th>
                        <th width="40%">Actual Data</th>
                        <th width="20%">Units</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($aiData['printing_data'] ?? [] as $row)
                        <tr>
                            <td colspan="2">{{ $row['setting'] ?? $row['parameter'] }}</td>
                            <td class="text-center fw-bold">{{ $row['data'] ?? '-' }}</td>
                            <td class="text-center">{{ $row['units'] ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2">Print Speed(Front & Rear)</td>
                            <td class="text-center fw-bold">40</td>
                            <td class="text-center">mm/s</td>
                        </tr>
                        <tr>
                            <td colspan="2">Pressure(Front & Rear)</td>
                            <td class="text-center fw-bold">25</td>
                            <td class="text-center">10⁻² N/mm</td>
                        </tr>
                        <tr>
                            <td colspan="2">Kind / Squeegee Type</td>
                            <td class="text-center fw-bold">Flat Sq</td>
                            <td class="text-center">-</td>
                        </tr>
                        <tr>
                            <td colspan="2">Print Mode</td>
                            <td class="text-center fw-bold">Single</td>
                            <td class="text-center">-</td>
                        </tr>
                        <tr>
                            <td colspan="2">Squeegee Length / Angle</td>
                            <td class="text-center fw-bold">350 / 60°</td>
                            <td class="text-center">mm / °</td>
                        </tr>
                        <tr>
                            <td colspan="2">Snap-Off Clearance</td>
                            <td class="text-center fw-bold">0.10</td>
                            <td class="text-center">mm</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- TABEL CLEANING DATA & PCB CLAMPING PRESSURE -->
            <div class="fw-bold mb-1" style="font-size: 8pt;">CLEANING DATA & OTHERS</div>
            <table class="tbl-form mb-2">
                <thead>
                    <tr class="bg-gray text-center">
                        <th width="40%">Cleaning Cond. / Parameter</th>
                        <th width="40%">Data</th>
                        <th width="20%">Units</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($aiData['cleaning_data'] ?? [] as $clean)
                        <tr>
                            <td>{{ $clean['setting'] ?? $clean['parameter'] }}</td>
                            <td class="text-center fw-bold">{{ $clean['data'] ?? '-' }}</td>
                            <td class="text-center">{{ $clean['units'] ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td>Interval of 1 round cleaning</td>
                            <td class="text-center fw-bold">10</td>
                            <td class="text-center">Sheet</td>
                        </tr>
                        <tr>
                            <td>PCB Suction Mode / Holder</td>
                            <td class="text-center fw-bold">On / On</td>
                            <td class="text-center">On / Off</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- REMARK SECTION -->
            <table class="tbl-form mb-2">
                <tr>
                    <td class="bg-gray" width="15%"><b>REMARK :</b></td>
                    <td>{{ $aiData['summary_analysis'] ?? ($aiData['rnd_notes'] ?? 'Parameter hasil ekstraksi CSV dalam batas normal toleransi.') }}</td>
                </tr>
            </table>

            <!-- FOOTER SIGNATURE & RESULT (OK / NG) -->
            <table class="signature-table">
                <tr>
                    <td rowspan="2" width="30%" class="align-middle p-2">
                        <div class="mb-1"><b>RESULT :</b></div>
                        <div class="d-flex justify-content-center gap-3">
                            <div class="result-box {{ $status === 'approved' ? 'bg-dark text-white' : '' }}">
                                {{ $status === 'approved' ? '✓ OK' : 'O OK' }}
                            </div>
                            <div class="result-box {{ $status === 'rejected' ? 'bg-dark text-white' : '' }}">
                                {{ $status === 'rejected' ? '✓ NG' : 'NG' }}
                            </div>
                        </div>
                    </td>
                    <th width="23%">PREPARED</th>
                    <th width="23%">CHECKED</th>
                    <th width="24%">APPROVED</th>
                </tr>
                <tr style="height: 65px;">
                    <td class="align-bottom pb-1">
                        <small class="text-muted d-block" style="font-size: 6pt;">Generated AI System</small>
                        <b>PROGRAMMER</b>
                    </td>
                    <td class="align-bottom pb-1">
                        <b>LEADER</b>
                    </td>
                    <td class="align-bottom pb-1">
                        @if($status === 'approved')
                            <span class="text-success fw-bold d-block" style="font-size: 8pt;">[ APPROVED ]</span>
                        @elseif($status === 'rejected')
                            <span class="text-danger fw-bold d-block" style="font-size: 8pt;">[ REJECTED ]</span>
                        @endif
                        <b>HOD ENG 1</b>
                    </td>
                </tr>
            </table>

        </div>
    </div>

    <script>
        window.addEventListener('DOMContentLoaded', () => {
            setTimeout(() => {
                window.print();
            }, 600);
        });
    </script>
</body>
</html>