<!-- RIGHT SIDE: MOBILE VIEW (< 992px) -->
<div class="d-flex d-lg-none align-items-center gap-2 ms-auto position-relative" style="z-index: 1050;">
    <!-- SEARCH BUTTON MOBILE -->
    <button type="button" class="btn btn-nav-icon p-0 d-flex align-items-center justify-content-center" id="btn-toggle-mobile-search" title="Search" style="pointer-events: auto; position: relative; z-index: 1051;">
        <i class="fa-solid fa-magnifying-glass"></i>
    </button>

    <!-- WRAPPER UNTUK DROPDOWN TITIK 3 -->
    <div class="position-static">
        <!-- TITIK 3 BUTTON MOBILE -->
        <button type="button" class="btn btn-nav-icon p-0 d-flex align-items-center justify-content-center" id="btn-toggle-mobile-more" title="More Options" style="pointer-events: auto; position: relative; z-index: 1051;">
            <i class="fa-solid fa-ellipsis"></i>
        </button>
        
        <div class="custom-mobile-menu shadow-lg border-0 p-3 bg-white" id="mobile-more-dropdown">
            <div class="row g-2 text-center">
                <!-- THEME (Solid Moon/Sun) -->
                <div class="col-6">
                    <button type="button" class="btn mobile-grid-item w-100 d-flex flex-column align-items-center justify-content-center gap-2 border-0" id="toggle-dark-mode-mobile">
                        <div class="app-icon-box bg-purple-3d text-white"><i class="fa-solid fa-moon"></i></div>
                        <span class="fw-bold text-dark grid-label">THEME</span>
                    </button>
                </div>

                <!-- ALERTS (Solid Bell) -->
                <div class="col-6">
                    <button type="button" class="btn mobile-grid-item w-100 d-flex flex-column align-items-center justify-content-center gap-2 border-0">
                        <div class="app-icon-box bg-blue-3d text-white"><i class="fa-solid fa-bell"></i></div>
                        <span class="fw-bold text-dark grid-label">ALERTS</span>
                    </button>
                </div>

                <!-- MESSAGES (Solid Comment/Chat) -->
                <div class="col-6">
                    <button type="button" class="btn mobile-grid-item w-100 d-flex flex-column align-items-center justify-content-center gap-2 border-0">
                        <div class="app-icon-box bg-teal-3d text-white"><i class="fa-solid fa-comment-dots"></i></div>
                        <span class="fw-bold text-dark grid-label">MESSAGES</span>
                    </button>
                </div>

                <!-- LANGUAGE (Native Select Overlay) -->
                <div class="col-6">
                    <div class="mobile-grid-item w-100 d-flex flex-column align-items-center justify-content-center gap-2 position-relative">
                        <div class="app-icon-box bg-green-3d text-white"><span class="fi fi-id flag-box" id="current-lang-flag-mobile"></span></div>
                        <span class="fw-bold text-dark grid-label" id="current-lang-text-mobile">IND</span>
                        <select class="position-absolute top-0 start-0 w-100 h-100 opacity-0" style="cursor: pointer; z-index: 10;" onchange="handleMobileLangChange(this)">
                            <option value="IND|id" selected>IND</option>
                            <option value="ENG|gb">ENG</option>
                            <option value="JPG|jp">JPG</option>
                        </select>
                    </div>
                </div>

                <!-- PROFILE (Solid User/Person) -->
                <div class="col-6">
                    <a href="{{ route('profile.edit') }}" class="btn mobile-grid-item w-100 d-flex flex-column align-items-center justify-content-center gap-2 border-0 text-decoration-none">
                        <div class="app-icon-box bg-orange-3d text-white"><i class="fa-solid fa-user"></i></div>
                        <span class="fw-bold text-dark grid-label">PROFILE</span>
                    </a>
                </div>

                <!-- SIGN OUT (Solid Logout) -->
                <div class="col-6">
                    <form action="{{ route('logout') }}" method="POST" class="m-0 h-100">
                        @csrf
                        <button type="submit" class="btn mobile-grid-item w-100 d-flex flex-column align-items-center justify-content-center gap-2 border-0">
                            <div class="app-icon-box bg-red-3d text-white"><i class="fa-solid fa-right-from-bracket"></i></div>
                            <span class="fw-bold text-danger grid-label">SIGN OUT</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- EXPANDABLE MOBILE SEARCH BAR -->
<div class="mobile-search-wrapper fixed-top bg-white px-3 py-2 border-bottom shadow-sm d-lg-none" id="mobile-search-bar">
    <form class="d-flex align-items-center rounded-2 px-3 py-2" method="POST" action="#" style="border: 1px solid #e2e8f5; background-color: #f8fafc; margin: 0;">
        @csrf
        <input type="text" name="query" id="mobile-search-input" placeholder="Search..." class="form-control bg-transparent border-0 shadow-none p-0 small text-secondary" style="font-family: 'Nunito', sans-serif; font-size: 13.5px;">
        <button type="submit" class="btn btn-link text-secondary p-0 ms-2"><i class="fa-solid fa-magnifying-glass" style="font-size: 14px;"></i></button>
    </form>
</div>