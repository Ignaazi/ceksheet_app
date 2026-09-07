<!-- PUSTAKA EXTERNAL (Letakkan di <head> atau sebelum modal) -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<!-- html2pdf.js untuk Fitur Download PDF -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

<style>
    /* Kustomisasi Modal Supaya Ukuran Pas & Rapi */
    .modal-approval .modal-dialog {
        max-width: 900px; /* Ukuran pas untuk preview dokumen A4 */
    }

    .modal-approval .modal-body {
        background-color: #525659; /* Warna background ala PDF Viewer Chrome */
        padding: 20px;
        max-height: 80vh;
        overflow-y: auto;
    }

    /* Kertas Dokumen */
    .print-page {
        width: 100%;
        max-width: 800px;
        margin: 0 auto;
        padding: 15px;
        background: #fff;
        box-shadow: 0 4px 10px rgba(0,0,0,0.3);
    }

    .form-border {
        border: 2px solid #000;
        padding: 8px;
        position: relative;
        background: #fff;
    }

    /* Header Form */
    .header-table {
        width: 100%;
        border-bottom: 2px solid #000;
        margin-bottom: 8px;
        padding-bottom: 5px;
    }

    .header-table td { vertical-align: middle; }
    .logo-img { max-height: 38px; width: auto; }
    .form-title { font-size: 11pt; font-weight: bold; text-align: center; letter-spacing: 0.5px; }

    /* Table Rules */
    table.tbl-form {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 6px;
        table-layout: fixed;
    }

    table.tbl-form th, table.tbl-form td {
        border: 1px solid #000;
        padding: 2px 4px;
        font-size: 7.5pt;
        vertical-align: middle;
        word-wrap: break-word;
    }

    .banner-title {
        background-color: #dcdcdc !important;
        border: 1px solid #000;
        font-weight: bold;
        text-align: center;
        font-size: 8.5pt;
        padding: 3px;
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
        font-size: 6.5pt;
        white-space: nowrap;
        padding: 2px !important;
        width: 20px;
    }

    /* Layout Grid Gambar WI */
    .wi-image-grid {
        display: flex;
        gap: 10px;
        width: 100%;
        margin-top: 6px;
        margin-bottom: 6px;
    }

    .wi-image-box {
        flex: 1;
        width: 50%;
        border: 1px solid #000;
        padding: 4px;
        background-color: #fff;
        text-align: center;
    }

    .wi-image-box img {
        width: 100%;
        height: auto;
        display: block;
        object-fit: contain;
    }

    /* Footer Signatures */
    .signature-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 5px;
        table-layout: fixed;
    }

    .signature-table td, .signature-table th {
        border: 1px solid #000;
        text-align: center;
        font-size: 8pt;
    }

    .result-box {
        border: 1px solid #000;
        padding: 2px 10px;
        font-weight: bold;
        font-size: 9pt;
        display: inline-block;
        background: #fff;
    }

    .qr-code-label {
        font-size: 7.5pt;
        font-weight: normal;
        margin-top: 6px;
        text-align: left;
    }

    /* Trik Cetak Khusus Saat Tombol Print Ditekan */
    @media print {
        body * {
            visibility: hidden;
        }
        #printableArea, #printableArea * {
            visibility: visible;
        }
        #printableArea {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            padding: 0;
            margin: 0;
            box-shadow: none !normal;
        }
        @page {
            size: A4 portrait;
            margin: 0.8cm;
        }
    }
</style>

<!-- TOMBOL Pemicu Pop-up (Bisa kamu taruh di halaman utama kamu) -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#approvalModal">
    <i class="fa-solid fa-eye me-1"></i> Preview Approval Sheet
</button>

@php
    $rawAi = $sheet->ai_result ?? ($template->schema ?? []);
    $aiData = is_array($rawAi) ? $rawAi : json_decode($rawAi, true);
    $status = strtolower($sheet->status ?? 'pending');
    
    $getVal = function($key, $default = '') use ($aiData) {
        return $aiData['actual_data'][$key] ?? ($aiData[$key] ?? $default);
    };
@endphp

<!-- MODAL POPUP BOOTSTRAP -->
<div class="modal fade modal-approval" id="approvalModal" tabindex="-1" aria-labelledby="approvalModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            
            <!-- HEADER MODAL (Lengkap dengan Icon Print & Download) -->
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title fs-6 fw-bold" id="approvalModalLabel">
                    <i class="fa-solid fa-file-invoice text-warning me-2"></i> Approval Sheet Preview
                </h5>
                
                <div class="d-flex gap-2 align-items-center">
                    <!-- Tombol Print -->
                    <button type="button" onclick="window.print()" class="btn btn-success btn-sm px-3 fw-semibold">
                        <i class="fa-solid fa-print me-1"></i> Print
                    </button>
                    
                    <!-- Tombol Download PDF -->
                    <button type="button" onclick="downloadPDF()" class="btn btn-danger btn-sm px-3 fw-semibold">
                        <i class="fa-solid fa-file-pdf me-1"></i> Download PDF
                    </button>
                    
                    <!-- Tombol Close Modal -->
                    <button type="button" class="btn-close btn-close-white ms-2" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>

            <!-- BODY MODAL (Tempat Form Dokumen) -->
            <div class="modal-body">
                
                <!-- AREA DOKUMEN YANG AKAN DICETAK / DIDOWNLOAD -->
                <div class="print-page" id="printableArea">
                    <div class="form-border">

                        <!-- HEADER FORM -->
                        <table class="header-table">
                            <tr>
                                <td width="20%">
                                    <img src="{{ asset('image/logoSiix.png') }}" alt="SIIX Logo" class="logo-img" onerror="this.remove();">
                                </td>
                                <td width="80%" class="form-title">
                                    APPROVAL SHEET PROGRAM SCREEN PRINTING
                                </td>
                            </tr>
                        </table>

                        <!-- METADATA HEADER SECTION -->
                        <table class="tbl-form mb-2" style="border: none;">
                            <tr style="border: none;">
                                <td width="15%" style="border:none;"><b>CUSTOMER</b></td>
                                <td width="35%" style="border:none;">: {{ $aiData['customer'] ?? '' }}</td>
                                <td width="15%" style="border:none;"><b>DATE</b></td>
                                <td width="35%" style="border:none;">: {{ isset($sheet->created_at) ? $sheet->created_at->format('d/m/Y') : '' }}</td>
                            </tr>
                            <tr style="border: none;">
                                <td style="border:none;"><b>MODEL</b></td>
                                <td style="border:none;">: {{ $aiData['model'] ?? ($sheet->title ?? $template->name ?? '') }}</td>
                                <td style="border:none;"><b>LINE</b></td>
                                <td style="border:none;">: {{ $sheet->line_name ?? '' }}</td>
                            </tr>
                            <tr style="border: none;">
                                <td style="border:none; vertical-align: top;"><b>STATUS RUNNING</b></td>
                                <td style="border:none;">
                                    : 
                                    <span class="checkbox-box">{{ ($aiData['status_running'] ?? '') == 'PP NEW MODEL' ? '✓' : '' }}</span> PP NEW MODEL
                                    <span class="checkbox-box ms-2">{{ ($aiData['status_running'] ?? '') == 'PP NEW RANK' ? '✓' : '' }}</span> PP NEW RANK
                                    <span class="checkbox-box ms-2">{{ ($aiData['status_running'] ?? '') == 'OTHERS' ? '✓' : '' }}</span> OTHERS
                                    <br>&nbsp;&nbsp;
                                    <span class="checkbox-box">{{ ($aiData['status_running'] ?? '') == 'PP NEW LINE' ? '✓' : '' }}</span> PP NEW LINE
                                    <span class="checkbox-box ms-2">{{ ($aiData['status_running'] ?? '') == 'ECR/ ECN' ? '✓' : '' }}</span> ECR/ ECN
                                </td>
                                <td style="border:none; vertical-align: top;"><b>TYPE MACHINE</b></td>
                                <td style="border:none; vertical-align: top;">: {{ $sheet->machine_type ?? '' }}</td>
                            </tr>
                        </table>

                        <!-- SECTION A, B, C, D -->
                        <table class="tbl-form mb-2">
                            <tr>
                                <td width="50%" class="align-top">
                                    <b>A. PROGRAM NAME :</b> {{ $aiData['program_name'] ?? '' }}<br>
                                    &nbsp;&nbsp;&nbsp;&nbsp;<b>REVISION :</b> {{ $aiData['program_revision'] ?? '' }}
                                </td>
                                <td width="50%" class="align-top">
                                    <b>C. THIKNES STENCIL :</b> {{ $aiData['stencil_thickness'] ?? '' }}<br>
                                    &nbsp;&nbsp;&nbsp;&nbsp;<span class="checkbox-box"></span> STEP UP &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: ...........................................<br>
                                    &nbsp;&nbsp;&nbsp;&nbsp;<span class="checkbox-box"></span> STEP DOWN &nbsp;&nbsp;&nbsp;&nbsp;: ...........................................
                                </td>
                            </tr>
                            <tr>
                                <td class="align-top">
                                    <b>B. NO REG STENCIL :</b> {{ $aiData['stencil_no_reg'] ?? '' }}<br>
                                    &nbsp;&nbsp;&nbsp;&nbsp;<b>REVISION :</b> {{ $aiData['stencil_revision'] ?? '' }}
                                </td>
                                <td class="align-top">
                                    <b>D. SOLDER PASTE USED :</b> {{ $aiData['solder_paste_used'] ?? '' }}<br>
                                    &nbsp;&nbsp;&nbsp;&nbsp;<b>SAP CODE :</b> {{ $aiData['sap_code'] ?? '' }}<br>
                                    &nbsp;&nbsp;&nbsp;&nbsp;<b>MAKER :</b> {{ $aiData['maker'] ?? '' }}
                                </td>
                            </tr>
                        </table>

                        <!-- BANNER STANDART PARAMETER -->
                        <div class="banner-title">
                            STANDART PARAMETER MACHINE SCREEN PRINTING FROM WI (SW-ZZ-068)
                        </div>

                        <!-- CONTAINER 2 GRID GAMBAR WI TERPISAH -->
                        <div class="wi-image-grid">
                            <div class="wi-image-box">
                                <img src="{{ asset('image/wi_sp60_sp70.png') }}" alt="WI SP60 & SP70" onerror="this.onerror=null; this.src='https://via.placeholder.com/400x550?text=Gambar+WI+Kiri+(SP60/SP70)';">
                            </div>
                            <div class="wi-image-box">
                                <img src="{{ asset('image/wi_spg_spg2.png') }}" alt="WI SPG & SPG2" onerror="this.onerror=null; this.src='https://via.placeholder.com/400x550?text=Gambar+WI+Kanan+(SPG/SPG2)';">
                            </div>
                        </div>

                        <!-- BANNER CHECK RESULT ACTUAL DATA -->
                        <div class="banner-title">
                            CHECK RESULT ACTUAL DATA PRINTING MACHINE
                        </div>

                        <!-- TABEL PRINTING DATA ACTUAL -->
                        <div class="fw-bold mb-1" style="font-size: 7.5pt;">PRINTING DATA</div>
                        <table class="tbl-form m-0">
                            <thead>
                                <tr class="text-center">
                                    <th colspan="4" width="60%">Parameter</th>
                                    <th width="20%">Data</th>
                                    <th width="20%">Units</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td rowspan="14" class="text-vertical">Printing Setting</td>
                                    <td colspan="3">Print Speed(Front & Rear)</td>
                                    <td class="text-center fw-bold">{{ $getVal('print_speed', '') }}</td>
                                    <td class="text-center">mm/s</td>
                                </tr>
                                <tr>
                                    <td colspan="3">Pressure(Front & Rear)</td>
                                    <td class="text-center fw-bold">{{ $getVal('pressure', '') }}</td>
                                    <td class="text-center">10⁻² N/mm</td>
                                </tr>
                                <tr>
                                    <td colspan="3">Kind / Squeegee Type</td>
                                    <td class="text-center fw-bold">{{ $getVal('squeegee_type', '') }}</td>
                                    <td class="text-center">-</td>
                                </tr>
                                <tr>
                                    <td rowspan="4" class="text-vertical">Fill-In</td>
                                    <td rowspan="3" width="18%">Print Mode</td>
                                    <td width="24%"><small>-Chip Part, IC 0.5 above</small></td>
                                    <td class="text-center fw-bold">{{ $getVal('print_mode_chip', '') }}</td>
                                    <td class="text-center">-</td>
                                </tr>
                                <tr>
                                    <td rowspan="2"><small>-IC fine pitch 0.4 ,<br>BGA,Chip 1005</small></td>
                                    <td width="8%">Double</td>
                                    <td class="text-center fw-bold">{{ $getVal('print_mode_double', '') }}</td>
                                    <td rowspan="2" class="text-center">-</td>
                                </tr>
                                <tr>
                                    <td>Single</td>
                                    <td class="text-center fw-bold">{{ $getVal('print_mode_single', '') }}</td>
                                </tr>
                                <tr>
                                    <td colspan="2">Squeegee Lenght</td>
                                    <td class="text-center fw-bold">{{ $getVal('squeegee_length', '') }}</td>
                                    <td class="text-center">mm</td>
                                </tr>
                                <tr>
                                    <td rowspan="7" class="text-vertical">Snap-Off</td>
                                    <td colspan="2">Squeegee Angle</td>
                                    <td class="text-center fw-bold">{{ $getVal('squeegee_angle', '') }}</td>
                                    <td class="text-center">[ ° ]</td>
                                </tr>
                                <tr>
                                    <td colspan="2">Clearance Down</td>
                                    <td class="text-center fw-bold">{{ $getVal('clearance_down', '') }}</td>
                                    <td class="text-center">mm</td>
                                </tr>
                                <tr>
                                    <td colspan="2">Down Speed Change &nbsp;&nbsp;&nbsp;&nbsp;(Snap-off Mode)</td>
                                    <td class="text-center fw-bold">{{ $getVal('down_speed_change', '') }}</td>
                                    <td class="text-center">-</td>
                                </tr>
                                <tr>
                                    <td colspan="2">Down Speed &nbsp;&nbsp;&nbsp;&nbsp;(Snap-off Mode)</td>
                                    <td class="text-center fw-bold">{{ $getVal('down_speed', '') }}</td>
                                    <td class="text-center">mm/s</td>
                                </tr>
                                <tr>
                                    <td colspan="2">Down stoke(Snap-Off Stroke)</td>
                                    <td class="text-center fw-bold">{{ $getVal('down_stroke', '') }}</td>
                                    <td class="text-center">mm</td>
                                </tr>
                                <tr>
                                    <td colspan="2">Priority After Printing &nbsp;&nbsp;&nbsp;&nbsp;.</td>
                                    <td class="text-center fw-bold">{{ $getVal('priority_after_printing', '') }}</td>
                                    <td class="text-center">-</td>
                                </tr>
                            </tbody>
                        </table>

                        <!-- TABEL CLEANING DATA ACTUAL -->
                        <div class="fw-bold mb-1 mt-1" style="font-size: 7.5pt;">CLEANING DATA</div>
                        <table class="tbl-form m-0">
                            <thead>
                                <tr class="text-center">
                                    <th colspan="2" width="60%">Parameter</th>
                                    <th width="20%">Data</th>
                                    <th width="20%">Units</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td rowspan="2" class="text-vertical">Clening Cond.</td>
                                    <td>Interval of 1 round deaning</td>
                                    <td class="text-center fw-bold">{{ $getVal('cleaning_interval_1', '') }}</td>
                                    <td class="text-center">Sheet</td>
                                </tr>
                                <tr>
                                    <td>Interval of 2 round deaning</td>
                                    <td class="text-center fw-bold">{{ $getVal('cleaning_interval_2', '') }}</td>
                                    <td class="text-center">Sheet</td>
                                </tr>
                                <tr>
                                    <td rowspan="5" class="text-vertical">Others</td>
                                    <td>Process wait</td>
                                    <td class="text-center fw-bold">{{ $getVal('process_wait', '') }}</td>
                                    <td class="text-center"><small>1 round / 2 round / unuse</small></td>
                                </tr>
                                <tr>
                                    <td>Use wait process</td>
                                    <td class="text-center fw-bold">{{ $getVal('use_wait_process', '') }}</td>
                                    <td class="text-center">Min</td>
                                </tr>
                                <tr>
                                    <td>PCB Suction Mode</td>
                                    <td class="text-center fw-bold">{{ $getVal('pcb_suction_mode', '') }}</td>
                                    <td class="text-center"><small>On / Off</small></td>
                                </tr>
                                <tr>
                                    <td>PCB Holder</td>
                                    <td class="text-center fw-bold">{{ $getVal('pcb_holder', '') }}</td>
                                    <td class="text-center"><small>On / Off</small></td>
                                </tr>
                                <tr>
                                    <td>Paste Counter</td>
                                    <td class="text-center fw-bold">{{ $getVal('paste_counter', '') }}</td>
                                    <td class="text-center">Sheet</td>
                                </tr>
                            </tbody>
                        </table>

                        <!-- TABEL PCB CLAMPING PRESSURE ACTUAL -->
                        <div class="fw-bold mb-1 mt-1" style="font-size: 7.5pt;">PCB CLAMPING PRESSURE</div>
                        <table class="tbl-form mb-2 text-center">
                            <thead>
                                <tr>
                                    <th width="35%">PCB Thickness</th>
                                    <th width="35%">PCB Clamp Pressure</th>
                                    <th width="30%">Units</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="fw-bold">{{ $getVal('pcb_thickness', '') }}</td>
                                    <td class="fw-bold">{{ $getVal('pcb_clamp_pressure', '') }}</td>
                                    <td>10⁻² N/mm</td>
                                </tr>
                            </tbody>
                        </table>

                        <!-- REMARK SECTION -->
                        <table class="tbl-form mb-2">
                            <tr style="height: 38px;">
                                <td width="15%" class="align-top" style="border-right: none;"><b>REMARK :</b></td>
                                <td class="align-top" style="border-left: none;">
                                    {{ $aiData['summary_analysis'] ?? ($aiData['remark'] ?? '') }}
                                </td>
                            </tr>
                        </table>

                        <!-- FOOTER SIGNATURE & RESULT -->
                        <table class="signature-table mb-1">
                            <tr>
                                <td rowspan="2" width="45%" class="align-middle p-2 text-start">
                                    <div class="d-flex align-items-center gap-3">
                                        <b style="font-size: 8.5pt;">RESULT :</b>
                                        <div class="d-flex gap-2">
                                            <div class="result-box {{ $status === 'approved' ? 'bg-dark text-white' : '' }}">
                                                {{ $status === 'approved' ? '✓ OK' : 'OK' }}
                                            </div>
                                            <div class="result-box {{ $status === 'rejected' ? 'bg-dark text-white' : '' }}">
                                                {{ $status === 'rejected' ? '✓ NG' : 'NG' }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <th width="18%">PREPARED</th>
                                <th width="18%">CHECKED</th>
                                <th width="19%">APPROVED</th>
                            </tr>
                            <tr style="height: 55px;">
                                <td class="align-bottom pb-1">
                                    <b>PROGRAMMER</b>
                                </td>
                                <td class="align-bottom pb-1">
                                    <b>LEADER</b>
                                </td>
                                <td class="align-bottom pb-1">
                                    <b>ENG</b>
                                </td>
                            </tr>
                        </table>

                        <!-- FOOTER QR CODE DOCUMENT NUMBER -->
                        <div class="qr-code-label">
                            QR-ENG-25-K039 (Rev.00)
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- SCRIPT PENGATURAN DOWNLOAD PDF & BOOTSTRAP JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    function downloadPDF() {
        const element = document.getElementById('printableArea');
        
        // Konfigurasi Kualitas PDF
        const opt = {
            margin:       0.3,
            filename:     'Approval_Sheet_Screen_Printing.pdf',
            image:        { type: 'jpeg', quality: 0.98 },
            html2canvas:  { scale: 2, useCORS: true },
            jsPDF:        { unit: 'in', format: 'a4', orientation: 'portrait' }
        };

        // Eksekusi Download PDF
        html2pdf().set(opt).from(element).save();
    }
</script>