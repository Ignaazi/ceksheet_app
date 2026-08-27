<!-- RIGHT SIDE: DESKTOP VIEW (≥ 992px) -->
<div class="d-none d-lg-flex align-items-center gap-2 gap-md-3 ms-auto">
    <!-- SEARCH BAR DESKTOP -->
    <div class="search-bar" style="width: 520px;">
        <form class="search-form d-flex align-items-center rounded-2 px-3 py-2" method="POST" action="#" style="border: 1px solid #e2e8f5; background-color: #f8fafc; margin: 0;">
            @csrf
            <input type="text" name="query" placeholder="Search..." title="Enter search keyword" class="form-control bg-transparent border-0 shadow-none p-0 small text-secondary" style="font-family: 'Nunito', sans-serif; font-size: 13.5px;">
            <button type="submit" title="Search" class="btn btn-link text-secondary p-0 ms-2"><i class="fa-solid fa-magnifying-glass" style="font-size: 14px;"></i></button>
        </form>
    </div>
    
    <!-- LANGUAGE SELECTOR DROPDOWN DESKTOP -->
    <div class="position-relative" id="desktop-lang-container">
        <button type="button" class="btn btn-lang-dropdown d-flex align-items-center justify-content-center gap-1.5 px-2.5" id="btn-desktop-lang">
            <span class="fi fi-id flag-box" id="current-lang-flag"></span>
            <span class="fw-bold" id="current-lang-text" style="font-size: 12px; font-family: 'Nunito', sans-serif;">IND</span>
            <i class="fa-solid fa-chevron-down text-muted ms-0.5" style="font-size: 10px;"></i>
        </button>
        
        <div class="custom-dropdown-box shadow-lg mt-2 p-1.5 position-absolute bg-white rounded-3" id="dropdown-menu-lang" style="font-family: 'Nunito', sans-serif; font-size: 13px; border: 1px solid #e2e8f5 !important; min-width: 130px; right: 0; top: 100%;">
            <button type="button" class="custom-dropdown-item d-flex align-items-center gap-2 rounded-2 py-2 px-2.5 w-100 border-0 bg-transparent text-start text-dark fw-semibold" onclick="selectLang('IND', 'id')">
                <span class="fi fi-id flag-box pe-none"></span>
                <span class="pe-none">IND</span>
            </button>
            <button type="button" class="custom-dropdown-item d-flex align-items-center gap-2 rounded-2 py-2 px-2.5 w-100 border-0 bg-transparent text-start text-dark fw-semibold" onclick="selectLang('ENG', 'gb')">
                <span class="fi fi-gb flag-box pe-none"></span>
                <span class="pe-none">ENG</span>
            </button>
            <button type="button" class="custom-dropdown-item d-flex align-items-center gap-2 rounded-2 py-2 px-2.5 w-100 border-0 bg-transparent text-start text-dark fw-semibold" onclick="selectLang('JPG', 'jp')">
                <span class="fi fi-jp flag-box pe-none"></span>
                <span class="pe-none">JPG</span>
            </button>
        </div>
    </div>

    <!-- NOTIFICATION ICON -->
    <button type="button" class="btn btn-nav-icon p-0 d-flex align-items-center justify-content-center" title="Notifications">
        <i class="fa-regular fa-bell"></i>
    </button>

    <!-- CHAT ICON -->
    <button type="button" class="btn btn-nav-icon p-0 d-flex align-items-center justify-content-center" id="open-chat-box" title="Messages">
        <i class="fa-regular fa-comment-alt"></i>
    </button>

    <!-- DARK MODE ICON -->
    <button type="button" class="btn btn-nav-icon p-0 d-flex align-items-center justify-content-center" id="toggle-dark-mode" title="Toggle Theme">
        <i class="fa-regular fa-moon"></i>
    </button>

    <!-- USER PROFILE DROPDOWN DESKTOP -->
    <div class="position-relative" id="desktop-profile-container">
        <button type="button" class="nav-link nav-profile d-flex align-items-center gap-2 text-decoration-none border-0 bg-transparent p-0" id="btn-desktop-profile" style="cursor: pointer;">
            <div class="rounded-circle d-flex align-items-center justify-content-center text-white font-bold" style="width: 38px; height: 38px; font-size: 14px; background-color: #4154f1;">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
            <div class="text-start" style="font-family: 'Nunito', sans-serif;">
                <span class="d-block fw-bold lh-1 small" style="color: #012970;">{{ Auth::user()->name }}</span>
                <small class="text-muted" style="font-size: 10px;">{{ strtoupper(Auth::user()->role ?? 'User') }}</small>
            </div>
            <i class="fa-solid fa-chevron-down text-muted ms-1" style="font-size: 10px;"></i>
        </button>
        
        <!-- POPUP DROPDOWN BOX CLEAN -->
        <div class="custom-dropdown-box shadow-lg mt-2 position-absolute bg-white rounded-3 p-2.5" id="dropdown-menu-profile" style="font-family: 'Nunito', sans-serif; font-size: 14px; border: 1px solid #e2e8f5 !important; width: 260px; right: 0; top: 100%;">
            
            <!-- HEADER USER INFO (ABU-ABU GELAP GELAP DIKIT: #e2e8f0) -->
            <div class="d-flex align-items-center justify-content-between p-2 mb-2 rounded-2" style="background-color: #e2e8f0;">
                <div class="d-flex align-items-center gap-2.5 overflow-hidden">
                    <div class="rounded-circle d-flex align-items-center justify-content-center text-white font-bold flex-shrink-0" style="width: 36px; height: 36px; font-size: 13px; background-color: #4154f1;">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div class="overflow-hidden">
                        <h6 class="m-0 fw-bold text-truncate" style="color: #012970; font-size: 13.5px;">{{ Auth::user()->name }}</h6>
                        <small class="text-muted d-block text-truncate" style="font-size: 11px;">{{ Auth::user()->email ?? 'user@example.com' }}</small>
                    </div>
                </div>
                <!-- LOGO SIIX POJOK KANAN ATAS -->
                <img src="{{ asset('image/logoSiix.png') }}" alt="SIIX" class="flex-shrink-0 ms-2" style="height: 20px; width: auto; object-fit: contain;">
            </div>

            <!-- GARIS PEMBATAS DI ATAS ALERTS -->
            <hr class="my-2" style="border-color: #e2e8f5; opacity: 0.7;">

            <!-- 1. ALERTS ITEM -->
            <a class="custom-dropdown-item d-flex align-items-center gap-2.5 py-2 px-2.5 mb-1 rounded-2 text-decoration-none text-dark" href="#">
                <div class="app-icon-box bg-blue-3d text-white flex-shrink-0 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; font-size: 13px; border-radius: 6px;">
                    <i class="fa-solid fa-bell"></i>
                </div>
                <span class="fw-semibold" style="font-size: 13px; color: #334155;">Alerts</span>
            </a>

            <!-- 2. MESSAGES ITEM -->
            <a class="custom-dropdown-item d-flex align-items-center gap-2.5 py-2 px-2.5 mb-1 rounded-2 text-decoration-none text-dark" href="#">
                <div class="app-icon-box bg-teal-3d text-white flex-shrink-0 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; font-size: 13px; border-radius: 6px;">
                    <i class="fa-solid fa-comment-dots"></i>
                </div>
                <span class="fw-semibold" style="font-size: 13px; color: #334155;">Messages</span>
            </a>

            <!-- 3. MY PROFILE ITEM -->
            <a class="custom-dropdown-item d-flex align-items-center gap-2.5 py-2 px-2.5 mb-1 rounded-2 text-decoration-none text-dark" href="{{ route('profile.edit') }}">
                <div class="app-icon-box bg-orange-3d text-white flex-shrink-0 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; font-size: 13px; border-radius: 6px;">
                    <i class="fa-solid fa-user"></i>
                </div>
                <span class="fw-semibold" style="font-size: 13px; color: #334155;">My Profile</span>
            </a>

            <!-- GARIS PEMBATAS SEBELUM SIGN OUT -->
            <hr class="my-2" style="border-color: #e2e8f5; opacity: 0.7;">

            <!-- SIGN OUT BUTTON MERAH SOLID SAMA SEPERTI GAMBAR CONTOH -->
            <form action="{{ route('logout') }}" method="POST" class="m-0">
                @csrf
                <button type="submit" class="btn-signout-solid w-100 d-flex align-items-center justify-content-center gap-2 py-2 px-3 border-0 rounded-2 text-white fw-semibold">
                    <i class="fa-solid fa-right-from-bracket" style="font-size: 13px;"></i>
                    <span style="font-size: 13.5px;">Sign Out</span>
                </button>
            </form>
        </div>
    </div>
</div>