<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts & CSS CDN -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lipis/flag-icons@7.0.0/css/flag-icons.min.css"/>

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            html, body {
                overflow-x: hidden;
            }

            .sidebar, #main-content {
                transition: all 0.3s ease-in-out !important;
            }

            body.toggle-sidebar .sidebar {
                left: -260px !important;
            }

            body.toggle-sidebar #main-content {
                margin-left: 0 !important;
            }

            /* Responsive CSS Adjustment */
            @media (max-width: 991.98px) {
                #main-content {
                    margin-left: 0 !important;
                }
            }
        </style>
    </head>
    <body class="font-sans antialiased bg-light">
        
        <!-- Top Navigation Bar (Memanggil layouts/navigation.blade.php) -->
        @include('layouts.navigation')

        <!-- Container Layout -->
        <div class="d-flex" style="padding-top: 65px;">
            <!-- Sidebar Kiri -->
            @include('layouts.sidebar')

            <!-- Main Content Area -->
            <div id="main-content" class="flex-grow-1 min-vh-100" style="margin-left: 260px;">
                @isset($header)
                    <header class="bg-white shadow-sm py-3 px-4">
                        {{ $header }}
                    </header>
                @endisset

                <main class="p-4">
                    {{ $slot }}
                </main>
            </div>
        </div>

        <!-- Bootstrap JS Bundle -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

        <!-- Navigation & Layout Scripts -->
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // 1. Toggle Sidebar Script
                localStorage.removeItem('sidebar-collapsed');
                const toggleBtn = document.getElementById('toggle-sidebar');
                if (toggleBtn) {
                    toggleBtn.addEventListener('click', function (e) {
                        e.preventDefault();
                        document.body.classList.toggle('toggle-sidebar');
                    });
                }

                // 2. Mobile Menu & Search Bar Toggle Script
                const searchBtn = document.getElementById('btn-toggle-mobile-search');
                const searchBar = document.getElementById('mobile-search-bar');
                const searchInput = document.getElementById('mobile-search-input');
                const moreBtn = document.getElementById('btn-toggle-mobile-more');
                const moreDropdown = document.getElementById('mobile-more-dropdown');

                if (searchBtn && searchBar) {
                    searchBtn.addEventListener('click', function (e) {
                        e.preventDefault(); 
                        e.stopPropagation();
                        if (moreDropdown) moreDropdown.classList.remove('show');
                        searchBar.classList.toggle('show');
                        if (searchBar.classList.contains('show') && searchInput) searchInput.focus();
                    });
                }

                if (moreBtn && moreDropdown) {
                    moreBtn.addEventListener('click', function (e) {
                        e.preventDefault(); 
                        e.stopPropagation();
                        if (searchBar) searchBar.classList.remove('show');
                        moreDropdown.classList.toggle('show');
                    });
                }

                // Close popup when clicking outside
                document.addEventListener('click', function (e) {
                    if (searchBar && !searchBar.contains(e.target) && !searchBtn.contains(e.target)) {
                        searchBar.classList.remove('show');
                    }
                    if (moreDropdown && !moreDropdown.contains(e.target) && !moreBtn.contains(e.target)) {
                        moreDropdown.classList.remove('show');
                    }
                });
            });

            // 3. Language Changer Helper (Sync PC & Mobile)
            function changeLanguage(code, flagCode) {
                var textDesktop = document.getElementById('current-lang-text-desktop');
                if (textDesktop) textDesktop.innerText = code;
                
                var flagDesktop = document.getElementById('current-lang-flag-desktop');
                if (flagDesktop) flagDesktop.className = 'fi fi-' + flagCode + ' flag-box';

                var textMobile = document.getElementById('current-lang-text-mobile');
                if (textMobile) textMobile.innerText = code;

                var flagMobile = document.getElementById('current-lang-flag-mobile');
                if (flagMobile) flagMobile.className = 'fi fi-' + flagCode + ' flag-box';
            }

            function handleMobileLangChange(selectObj) {
                var val = selectObj.value.split('|');
                changeLanguage(val[0], val[1]);
            }
        </script>
    </body>
</html>