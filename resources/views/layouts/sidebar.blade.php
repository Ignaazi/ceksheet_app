<aside class="sidebar flex-shrink-0">
  <ul class="sidebar-nav d-flex flex-column gap-1 list-unstyled px-2">

    <!-- SECTION: MAIN MENU -->
    <li class="nav-item">
      <a class="nav-link rounded-3 d-flex align-items-center {{ request()->routeIs('dashboard') ? 'active' : 'collapsed' }}"
         href="{{ route('dashboard') }}">
        <i class="fa-solid fa-rocket me-2" style="font-size: 15px;"></i>
        <span>Dashboard</span>
        <span class="ms-auto fw-bold text-uppercase opacity-50" style="font-size: 10px; letter-spacing: 0.5px;">Home</span>
      </a>
    </li>

    <!-- SECTION: SYSTEM MANAGEMENT -->
    <li class="nav-heading mt-3 mb-2 px-2 d-flex align-items-center position-relative" style="height: 20px;">
      <span class="bg-white pe-2 text-muted fw-bold position-relative" style="font-size: 10.5px; text-transform: uppercase; letter-spacing: 0.8px; z-index: 2; color: #747d8c !important;">
        System Management
      </span>
      <div class="position-absolute start-0 end-0 top-50 translate-y-50" style="border-bottom: 1px solid #e2e8f5; z-index: 1; margin-left: 8px; margin-right: 8px;"></div>
    </li>

    <!-- USER ACCOUNTS MENU -->
    <li class="nav-item">
      <a class="nav-link rounded-3 d-flex align-items-center {{ request()->routeIs('users.*') ? 'active' : 'collapsed' }}"
         href="{{ route('users.index') }}">
        <i class="fa-solid fa-users me-2" style="font-size: 15px;"></i>
        <span>User Accounts</span>
      </a>
    </li>

    <!-- MY PROFILE MENU -->
    <li class="nav-item">
      <a class="nav-link rounded-3 d-flex align-items-center {{ request()->routeIs('profile.edit') ? 'active' : 'collapsed' }}"
         href="{{ route('profile.edit') }}">
        <i class="fa-solid fa-user-gear me-2" style="font-size: 15px;"></i>
        <span>My Profile</span>
      </a>
    </li>

    <!-- DROPDOWN SYSTEM SETTINGS -->
    @php
      // DITAMBAHKAN: request()->routeIs('ip-config.*') agar dropdown tetap terbuka
      $isSettingsActive = request()->routeIs('settings.*') || request()->routeIs('permissions.*') || request()->routeIs('ip-config.*');
    @endphp
    <li class="nav-item">
      <button type="button" 
              class="nav-link rounded-3 d-flex align-items-center w-100 border-0 bg-transparent text-start sidebar-dropdown-toggle {{ $isSettingsActive ? 'active' : '' }}"
              data-target="settings-dropdown">
        <i class="fa-solid fa-sliders me-2" style="font-size: 15px;"></i>
        <span>System Settings</span>
        <i class="fa-solid fa-chevron-down ms-auto dropdown-chevron {{ $isSettingsActive ? 'open' : '' }}"></i>
      </button>

      <!-- SUB-MENU DROPDOWN -->
      <div id="settings-dropdown" class="sidebar-tree-wrapper" style="display: {{ $isSettingsActive ? 'block' : 'none' }};">
        <ul class="nav flex-column list-unstyled sidebar-tree-list">
          <li>
            <a class="sub-nav-link d-flex align-items-center {{ request()->routeIs('permissions.*') ? 'active' : '' }}" 
               href="{{ route('permissions.index') }}">
              <span class="tree-bullet"></span>
              <i class="fa-solid fa-shield-halved me-2" style="font-size: 12px;"></i>
              <span>Role & Permissions</span>
            </a>
          </li>
          <li>
            <a class="sub-nav-link d-flex align-items-center {{ request()->routeIs('ip-config.*') ? 'active' : '' }}" 
               href="{{ route('ip-config.index') }}">
              <span class="tree-bullet"></span>
              <i class="fa-solid fa-network-wired me-2" style="font-size: 12px;"></i>
              <span>Configure IP</span>
            </a>
          </li>
        </ul>
      </div>
    </li>

  </ul>
</aside>