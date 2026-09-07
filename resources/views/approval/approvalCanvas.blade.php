<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'APPROVAL TEMPLATE PREVIEW')</title>
    
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
            background-color: #e9ecef; 
            font-size: 8pt; 
            margin: 0; 
            padding: 0;
        }

        .preview-container { 
            padding: 20px 0; 
        }

        /* Container simulasi Kertas A4 */
        .a4-page { 
            width: 100%; 
            max-width: 850px; 
            margin: 0 auto; 
            padding: 15px; 
            background: #ffffff; 
            box-shadow: 0 5px 15px rgba(0,0,0,0.15); 
            border-radius: 2px;
        }

        .form-border { 
            border: 2px solid #000; 
            padding: 10px; 
        }

        /* Standard Table Styling */
        .header-table { 
            width: 100%; 
            border-bottom: 2px solid #000; 
            margin-bottom: 8px; 
            padding-bottom: 4px;
        }
        
        .form-title { 
            font-size: 11pt; 
            font-weight: bold; 
            text-align: center; 
            letter-spacing: 0.5px; 
        }

        table.tbl-form { 
            width: 100%; 
            border-collapse: collapse; 
            margin-bottom: 8px; 
        }
        
        table.tbl-form th, table.tbl-form td { 
            border: 1px solid #000; 
            padding: 4px 6px; 
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
            margin: 8px 0 6px 0; 
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

        /* Table Tanda Tangan */
        .signature-table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 10px; 
        }
        
        .signature-table td, .signature-table th { 
            border: 1px solid #000; 
            text-align: center; 
            font-size: 8pt; 
        }

        .result-box { 
            border: 2px solid #000; 
            padding: 2px 8px; 
            font-weight: bold; 
            font-size: 9pt; 
            display: inline-block; 
        }

        /* Custom Style saat Cetak */
        @media print {
            .no-print { display: none !important; }
            body { background: #fff; padding: 0; }
            .preview-container { padding: 0; }
            .a4-page { max-width: 100%; padding: 0; box-shadow: none; }
            @page { size: A4 portrait; margin: 0.8cm; }
        }
    </style>
    @stack('styles')
</head>
<body>

    <!-- TOP TOOLBAR CONTROLLER -->
    <div class="no-print bg-dark text-white p-2 mb-2 sticky-top shadow-sm">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <div class="small fw-bold">
                <i class="fa-solid fa-eye me-2 text-warning"></i> Preview Base Template: <span class="text-info">@yield('template-name', 'Approval Template')</span>
            </div>
            <div class="d-flex gap-2">
                <button onclick="window.print()" class="btn btn-success btn-sm px-3 fw-bold">
                    <i class="fa-solid fa-print me-1"></i> Cetak / Print
                </button>
                <button onclick="window.close()" class="btn btn-secondary btn-sm px-3">
                    <i class="fa-solid fa-xmark me-1"></i> Tutup
                </button>
            </div>
        </div>
    </div>

    <!-- MAIN CANVAS PAPER -->
    <div class="preview-container">
        <div class="a4-page">
            <div class="form-border">
                
                <!-- HEADER FORM MASTER -->
                <table class="header-table">
                    <tr>
                        <td width="25%">
                            <img src="{{ asset('image/logoSiix.png') }}" alt="SIIX Logo" style="max-height: 40px;" onerror="this.style.display='none'">
                        </td>
                        <td width="75%" class="form-title">
                            @yield('form-title', 'APPROVAL SHEET MASTER TEMPLATE')
                        </td>
                    </tr>
                </table>

                <!-- KONTEN SPESIFIK TEMPLATE (PRINTER, SPI, ICT, DLL) -->
                @yield('content')

                <!-- FOOTER TANDA TANGAN BASE -->
                @section('signature')
                <table class="signature-table">
                    <tr>
                        <td rowspan="2" width="30%" class="align-middle p-2">
                            <div class="mb-1"><b>RESULT :</b></div>
                            <div class="d-flex justify-content-center gap-3">
                                <div class="result-box">✓ OK</div>
                                <div class="result-box">NG</div>
                            </div>
                        </td>
                        <th width="23%">PREPARED</th>
                        <th width="23%">CHECKED</th>
                        <th width="24%">APPROVED</th>
                    </tr>
                    <tr style="height: 60px;">
                        <td class="align-bottom pb-1"><b>PROGRAMMER</b></td>
                        <td class="align-bottom pb-1"><b>LEADER</b></td>
                        <td class="align-bottom pb-1"><b>HOD ENG 1</b></td>
                    </tr>
                </table>
                @show

            </div>
        </div>
    </div>

    @stack('scripts')
</body>
</html>