<x-app-layout>
    <!-- BOOTSTRAP ICONS CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        .ping-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
        }
        .ping-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            display: inline-block;
        }
        /* Status Color Variants */
        .ping-online { background-color: #dcfce7; color: #15803d; border: 1px solid #bbf7d0; }
        .ping-online .ping-dot { background-color: #22c55e; box-shadow: 0 0 8px #22c55e; }

        .ping-offline { background-color: #fee2e2; color: #b91c1c; border: 1px solid #fecaca; }
        .ping-offline .ping-dot { background-color: #ef4444; box-shadow: 0 0 8px #ef4444; }

        .ping-checking { background-color: #fef9c3; color: #a16207; border: 1px solid #fef08a; }
        .ping-checking .ping-dot { background-color: #eab308; box-shadow: 0 0 8px #eab308; }
    </style>

    <div class="container-fluid px-2 px-md-4 py-4">
        
        <!-- HEADER TITLE & DESCRIPTION -->
        <div class="card border-0 rounded-3 p-3 p-sm-4 mb-4" style="background: radial-gradient(at 0% 0%, #e0e7ff 0px, transparent 50%), radial-gradient(at 25% 100%, #f3e8ff 0px, transparent 50%), radial-gradient(at 50% 0%, #ffedd5 0px, transparent 50%), radial-gradient(at 75% 100%, #fef9c3 0px, transparent 50%), radial-gradient(at 100% 0%, #dcfce7 0px, transparent 50%), #ffffff; border: 1px solid #cbd5e1 !important;">
            <div class="d-flex flex-column justify-content-center">
                <h2 class="fw-bold m-0 text-dark" style="font-size: calc(1.2rem + 0.4vw); color: #0f172a;">System Connection & IP Configuration</h2>
                <p class="text-secondary m-0 mt-1 small" style="color: #64748b !important;">Set your host IP address or tunneling URL to enable cross-device local access and generate system share link.</p>
            </div>
        </div>

        <!-- BREADCRUMB NAVIGATION -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb bg-transparent p-0 m-0 align-items-center small">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}" class="text-decoration-none fw-semibold d-inline-flex align-items-center gap-1" style="color: #64748b;">
                        <i class="fa-solid fa-rocket" style="font-size: 13px;"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="breadcrumb-item active fw-bold d-inline-flex align-items-center gap-1" aria-current="page" style="color: #0052cc;">
                    <i class="fa-solid fa-network-wired" style="font-size: 13px;"></i>
                    <span>Configure IP</span>
                </li>
            </ol>
        </nav>

        <div class="row g-4">
            <!-- MAIN CONFIGURATION FORM -->
            <div class="col-12 col-lg-7">
                <div class="card border-0 rounded-3 p-3 p-sm-4 bg-white h-100" style="border: 1px solid #cbd5e1 !important;">
                    <div class="border-bottom pb-3 mb-4">
                        <span class="text-primary fw-bold text-uppercase d-block mb-1" style="font-size: 11px; letter-spacing: 1px;">Network Settings</span>
                        <h5 class="fw-bold text-dark m-0">Set Application Base URL</h5>
                    </div>

                    <form action="{{ route('ip-config.update') }}" method="POST">
                        @csrf

                        <!-- CONNECTION MODE SELECTION -->
                        <div class="mb-4">
                            <label class="fw-bold text-secondary text-uppercase d-block mb-2" style="font-size: 11px;">Connection Mode</label>
                            <div class="row g-2">
                                <div class="col-6">
                                    <input type="radio" class="btn-check" name="connection_type" id="mode_lan" value="lan" {{ !str_contains($currentAppUrl, 'ngrok') ? 'checked' : '' }} onchange="toggleMode('lan')">
                                    <label class="btn btn-outline-primary w-100 py-2.5 fw-semibold small d-flex flex-column align-items-center gap-1" for="mode_lan">
                                        <i class="bi bi-wifi fs-5"></i>
                                        <span>Local Network (LAN)</span>
                                    </label>
                                </div>
                                <div class="col-6">
                                    <input type="radio" class="btn-check" name="connection_type" id="mode_tunnel" value="tunnel" {{ str_contains($currentAppUrl, 'ngrok') ? 'checked' : '' }} onchange="toggleMode('tunnel')">
                                    <label class="btn btn-outline-primary w-100 py-2.5 fw-semibold small d-flex flex-column align-items-center gap-1" for="mode_tunnel">
                                        <i class="bi bi-globe fs-5"></i>
                                        <span>Public Tunnel (Ngrok)</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- LAN SECTION -->
                        <div id="section_lan" class="row g-3 {{ str_contains($currentAppUrl, 'ngrok') ? 'd-none' : '' }}">
                            <div class="col-12 col-md-8">
                                <div class="p-3 rounded-2" style="background-color: #ffffff; border: 1px solid #cbd5e1;">
                                    <label class="fw-bold text-secondary text-uppercase d-block mb-1" style="font-size: 11px;">
                                        Detected Server IP <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-transparent border-0 ps-0 text-secondary">
                                            <i class="bi bi-pc-display"></i>
                                        </span>
                                        <input type="text" name="ip_address" id="ip_input" class="form-control border-0 bg-transparent p-0 fw-bold text-dark shadow-none" value="{{ $serverIp }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="p-3 rounded-2" style="background-color: #ffffff; border: 1px solid #cbd5e1;">
                                    <label class="fw-bold text-secondary text-uppercase d-block mb-1" style="font-size: 11px;">Port</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-transparent border-0 ps-0 text-secondary">
                                            <i class="bi bi-ethernet"></i>
                                        </span>
                                        <input type="text" name="port" class="form-control border-0 bg-transparent p-0 fw-bold text-dark shadow-none" value="8000">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- TUNNEL SECTION -->
                        <div id="section_tunnel" class="mb-3 {{ !str_contains($currentAppUrl, 'ngrok') ? 'd-none' : '' }}">
                            <div class="p-3 rounded-2" style="background-color: #ffffff; border: 1px solid #cbd5e1;">
                                <label class="fw-bold text-secondary text-uppercase d-block mb-1" style="font-size: 11px;">Public Tunnel URL (Ngrok / Expose)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-transparent border-0 ps-0 text-secondary">
                                        <i class="bi bi-link-45deg"></i>
                                    </span>
                                    <input type="url" name="tunnel_url" class="form-control border-0 bg-transparent p-0 fw-bold text-dark shadow-none" value="{{ str_contains($currentAppUrl, 'ngrok') ? $currentAppUrl : '' }}" placeholder="https://xxx-xxx.ngrok-free.app">
                                </div>
                            </div>
                        </div>

                        <!-- ACTION BUTTON -->
                        <div class="mt-4 pt-3 border-top d-flex justify-content-end">
                            <button type="submit" class="btn text-white rounded-2 px-4 py-2 fw-semibold small d-inline-flex align-items-center gap-2" style="background-color: #0052cc; border: none;">
                                <i class="bi bi-save-fill"></i>
                                <span>Save & Update .env</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- SYSTEM ACCESS URL & STATUS CARD -->
            <div class="col-12 col-lg-5">
                <div class="card border-0 rounded-3 p-3 p-sm-4 bg-white h-100 d-flex flex-column justify-content-between" style="border: 1px solid #cbd5e1 !important;">
                    <div>
                        <div class="border-bottom pb-3 mb-4 d-flex justify-content-between align-items-center">
                            <div>
                                <span class="text-primary fw-bold text-uppercase d-block mb-1" style="font-size: 11px; letter-spacing: 1px;">System Access URL</span>
                                <h5 class="fw-bold text-dark m-0">Copy Access Link</h5>
                            </div>
                            
                            <!-- LAMPU INDIKATOR NETWORK STATUS -->
                            <div id="status_badge" class="ping-badge ping-checking">
                                <span class="ping-dot"></span>
                                <span id="status_text">Checking...</span>
                            </div>
                        </div>

                        <div class="p-3 rounded-3 mb-3" style="background-color: #f8fafc; border: 1px solid #e2e8f0;">
                            <label class="fw-bold text-secondary text-uppercase d-block mb-1" style="font-size: 10px;">Active System URL</label>
                            <div class="fw-bold text-dark text-break fs-6" id="active_url_text">{{ $currentAppUrl }}</div>
                        </div>

                        <p class="text-secondary small mb-4">
                            Sistem melakukan tes koneksi ke URL di atas secara otomatis. Jika lampu berwana <strong class="text-success">Hijau</strong>, artinya link sudah aktif dan bisa diakses oleh perangkat lain.
                        </p>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="button" onclick="testConnection()" class="btn btn-light border rounded-2 py-2.5 px-3 fw-semibold small d-inline-flex align-items-center justify-content-center gap-1" title="Test Ulang Koneksi">
                            <i class="bi bi-arrow-clockwise"></i>
                        </button>

                        <button onclick="copyToClipboard('{{ $currentAppUrl }}')" class="btn text-white w-100 rounded-2 py-2.5 fw-semibold small d-inline-flex align-items-center justify-content-center gap-2" style="background-color: #0052cc; border: none;">
                            <i class="bi bi-clipboard-check fs-6"></i>
                            <span>Copy System Link</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JS SCRIPTS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function toggleMode(mode) {
            if (mode === 'lan') {
                document.getElementById('section_lan').classList.remove('d-none');
                document.getElementById('section_tunnel').classList.add('d-none');
            } else {
                document.getElementById('section_lan').classList.add('d-none');
                document.getElementById('section_tunnel').classList.remove('d-none');
            }
        }

        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(() => {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: 'System link copied to clipboard!',
                    showConfirmButton: false,
                    timer: 2000
                });
            });
        }

        // FUNGSI CEK PING / STATUS KONEKSI LAMPU
        function testConnection() {
            const activeUrl = "{{ $currentAppUrl }}";
            const badge = document.getElementById('status_badge');
            const statusText = document.getElementById('status_text');

            // Set state checking
            badge.className = "ping-badge ping-checking";
            statusText.innerText = "Checking...";

            // Lakukan ping sederhana menggunakan Fetch API (no-cors agar tidak terhalang CORS local)
            fetch(activeUrl, { mode: 'no-cors', cache: 'no-cache' })
                .then(() => {
                    badge.className = "ping-badge ping-online";
                    statusText.innerText = "Online / Ready";
                })
                .catch(() => {
                    badge.className = "ping-badge ping-offline";
                    statusText.innerText = "Offline / Error";
                });
        }

        // Jalankan tes koneksi otomatis saat halaman selesai di-load
        document.addEventListener('DOMContentLoaded', function () {
            testConnection();
        });

        @if (session('status') === 'ip-updated')
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: '.env configuration updated successfully!',
                showConfirmButton: false,
                timer: 3000
            });
        @endif
    </script>
</x-app-layout>