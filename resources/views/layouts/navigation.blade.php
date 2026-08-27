<header class="header fixed-top d-flex align-items-center justify-content-between px-3 bg-white" style="border-bottom: 1px solid #e2e8f5; height: 65px; z-index: 1030;">
    
    <!-- LEFT SIDE: TOGGLE & LOGO -->
    <div class="d-flex align-items-center gap-3">
        <!-- HAMBURGER BUTTON -->
        <button type="button" class="btn btn-hamburger p-0 d-flex align-items-center justify-content-center" id="toggle-sidebar" style="pointer-events: auto; position: relative; z-index: 1051;">
            <div class="hamburger-icon d-flex flex-column gap-1">
                <span class="line line-1"></span>
                <span class="line line-2"></span>
                <span class="line line-3"></span>
            </div>
        </button>

        <a href="{{ route('dashboard') }}" class="logo d-flex align-items-center text-decoration-none">
            <div class="d-flex align-items-center justify-content-center" style="height: 40px;">
                <img src="{{ asset('image/logoSiix.png') }}" alt="Logo" class="img-fluid" style="max-height: 100%; width: auto; object-fit: contain;">
            </div>
        </a>
    </div>

    <!-- CALL DESKTOP VIEW -->
    @include('layouts.navigation.desktop-nav')

    <!-- CALL MOBILE VIEW -->
    @include('layouts.navigation.mobile-nav')

</header>

<!-- CDN FLAG ICONS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lipis/flag-icons@7.0.0/css/flag-icons.min.css"/>

<style>
/* CUSTOM DROPDOWN BOX FIX */
.custom-dropdown-box {
    display: none;
    z-index: 1080 !important;
}

.custom-dropdown-box.active {
    display: block !important;
}

.custom-dropdown-item {
    cursor: pointer;
    transition: background-color 0.15s ease, transform 0.15s ease;
}

.custom-dropdown-item:hover {
    background-color: #f1f5f9 !important;
}

/* DEGRADASI WARNA SOFT (ICON KOTAK 3D) */
.bg-purple-3d { background: linear-gradient(135deg, #a855f7 0%, #7e22ce 100%); box-shadow: none !important; }
.bg-blue-3d   { background: linear-gradient(135deg, #60a5fa 0%, #2563eb 100%); box-shadow: none !important; }
.bg-teal-3d   { background: linear-gradient(135deg, #2dd4bf 0%, #0d9488 100%); box-shadow: none !important; }
.bg-green-3d  { background: linear-gradient(135deg, #4ade80 0%, #16a34a 100%); box-shadow: none !important; }
.bg-orange-3d { background: linear-gradient(135deg, #fb923c 0%, #ea580c 100%); box-shadow: none !important; }
.bg-red-3d    { background: linear-gradient(135deg, #f87171 0%, #dc2626 100%); box-shadow: none !important; }

/* STYLE KHUSUS TOMBOL SIGN OUT (UPDATED: MERAH SOLID DENGAN HOVER GELAP) */
.btn-signout-solid {
    background-color: #e11d48 !important;
    border: none !important;
    color: #ffffff !important;
    border-radius: 8px !important;
    transition: all 0.2s ease-in-out;
}

.btn-signout-solid:hover {
    background-color: #be123c !important;
    color: #ffffff !important;
    box-shadow: 0 4px 12px rgba(225, 29, 72, 0.25);
}

/* POPUP CONTAINER MOBILE DROPDOWN */
.custom-mobile-menu {
    display: none;
    position: fixed;
    top: 70px;
    right: 15px;
    width: 300px;
    border-radius: 8px !important;
    border: 1px solid #e2e8f5 !important;
    font-family: 'Nunito', sans-serif;
    z-index: 1090 !important;
    opacity: 0;
    transform: translateY(10px);
    transition: opacity 0.2s ease, transform 0.2s ease;
}

.custom-mobile-menu.show {
    display: block !important;
    opacity: 1 !important;
    transform: translateY(0) !important;
}

.mobile-grid-item {
    aspect-ratio: 1 / 1;
    background-color: #f8fafc;
    border-radius: 6px !important;
    padding: 10px !important;
    transition: all 0.2s ease;
}

.mobile-grid-item:hover, .mobile-grid-item:active { background-color: #f1f5f9; }
.grid-label { font-size: 11px; letter-spacing: 0.5px; }

/* KOTAK ICON INTERNAL MOBILE */
.app-icon-box {
    width: 46px; 
    height: 46px; 
    border-radius: 6px !important;
    display: flex; 
    align-items: center; 
    justify-content: center;
    font-size: 20px; 
    transition: transform 0.2s ease;
    box-shadow: none !important;
}

.mobile-grid-item:hover .app-icon-box { transform: translateY(-2px); }

.mobile-search-wrapper {
    top: 65px; z-index: 1085; display: none; opacity: 0;
    transform: translateY(-10px); transition: opacity 0.2s ease, transform 0.2s ease;
}

.mobile-search-wrapper.show { display: block !important; opacity: 1 !important; transform: translateY(0) !important; }

.flag-box {
    width: 20px !important; height: 14px !important; border-radius: 3px !important;
    object-fit: cover !important; display: inline-block !important; box-shadow: 0 1px 3px rgba(0,0,0,0.15);
}

.btn-hamburger, .btn-nav-icon, .btn-lang-dropdown {
    width: 38px; height: 38px; border-radius: 6px !important; border: 1px solid #e2e8f5 !important;
    background-color: #ffffff !important; color: #2b3a4a !important; font-size: 15px; transition: all 0.2s ease-in-out;
    box-shadow: none !important; outline: none !important;
}

.btn-lang-dropdown { width: auto !important; }
.hamburger-icon { width: 17px; }
.hamburger-icon .line { display: block; height: 2px; background-color: #2b3a4a; border-radius: 2px; transition: all 0.2s ease-in-out; }
.hamburger-icon .line-1 { width: 100%; } .hamburger-icon .line-2 { width: 80%; } .hamburger-icon .line-3 { width: 60%; }

.btn-hamburger:hover, .btn-nav-icon:hover, .btn-lang-dropdown:hover {
    background-color: #ffffff !important; border-color: #3b82f6 !important; color: #3b82f6 !important;
}

.btn-hamburger:hover .hamburger-icon .line { width: 100% !important; background-color: #3b82f6 !important; }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const langBtn = document.getElementById('btn-desktop-lang');
    const langMenu = document.getElementById('dropdown-menu-lang');
    const profileBtn = document.getElementById('btn-desktop-profile');
    const profileMenu = document.getElementById('dropdown-menu-profile');

    // TOGGLE MENU BAHASA DESKTOP
    if (langBtn && langMenu) {
        langBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            if (profileMenu) profileMenu.classList.remove('active');
            langMenu.classList.toggle('active');
        });
    }

    // TOGGLE MENU PROFILE DESKTOP
    if (profileBtn && profileMenu) {
        profileBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            if (langMenu) langMenu.classList.remove('active');
            profileMenu.classList.toggle('active');
        });
    }

    // TOGGLE & OUTSIDE CLICK MOBILE
    document.addEventListener('click', function (e) {
        const moreBtn = e.target.closest('#btn-toggle-mobile-more');
        const searchBtn = e.target.closest('#btn-toggle-mobile-search');
        const searchBar = document.getElementById('mobile-search-bar');
        const moreDropdown = document.getElementById('mobile-more-dropdown');
        const searchInput = document.getElementById('mobile-search-input');

        if (moreBtn) {
            e.preventDefault();
            e.stopPropagation();
            if (searchBar) searchBar.classList.remove('show');
            if (moreDropdown) moreDropdown.classList.toggle('show');
            return;
        }

        if (searchBtn) {
            e.preventDefault();
            e.stopPropagation();
            if (moreDropdown) moreDropdown.classList.remove('show');
            if (searchBar) {
                searchBar.classList.toggle('show');
                if (searchBar.classList.contains('show') && searchInput) searchInput.focus();
            }
            return;
        }

        // CLOSE OUTSIDE CLICK DESKTOP & MOBILE
        if (langMenu && !langMenu.contains(e.target) && !e.target.closest('#btn-desktop-lang')) {
            langMenu.classList.remove('active');
        }
        if (profileMenu && !profileMenu.contains(e.target) && !e.target.closest('#btn-desktop-profile')) {
            profileMenu.classList.remove('active');
        }
        if (moreDropdown && !moreDropdown.contains(e.target)) {
            moreDropdown.classList.remove('show');
        }
        if (searchBar && !searchBar.contains(e.target)) {
            searchBar.classList.remove('show');
        }
    });
});

// FUNGSI PILIH BAHASA
function selectLang(code, flagCode) {
    var textElem = document.getElementById('current-lang-text');
    if(textElem) textElem.innerText = code;

    var flagElem = document.getElementById('current-lang-flag');
    if(flagElem) flagElem.className = 'fi fi-' + flagCode + ' flag-box';

    var textElemMobile = document.getElementById('current-lang-text-mobile');
    if(textElemMobile) textElemMobile.innerText = code;

    var flagElemMobile = document.getElementById('current-lang-flag-mobile');
    if(flagElemMobile) flagElemMobile.className = 'fi fi-' + flagCode + ' flag-box';

    // TUTUP DROPDOWN
    var langMenu = document.getElementById('dropdown-menu-lang');
    if(langMenu) langMenu.classList.remove('active');
}

function handleMobileLangChange(selectObj) {
    var val = selectObj.value.split('|');
    selectLang(val[0], val[1]);
}
</script>