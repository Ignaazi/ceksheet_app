<aside class="sidebar flex-shrink-0" style="font-family: 'Nunito', sans-serif; background-color: #ffffff; border-right: 1px solid #e2e8f5; height: calc(100vh - 65px); width: 260px; transition: all 0.3s ease; display: flex; flex-direction: column; justify-content: space-between; padding-top: 15px; position: fixed; top: 65px; left: 0; z-index: 996;">
    <ul class="sidebar-nav d-flex flex-column gap-1 list-unstyled px-2" style="margin: 0; padding-left: 8px; padding-right: 8px;">

      <!-- SECTION: MAIN MENU (LANGSUNG DASHBOARD PALING ATAS) -->
      <li class="nav-item">
        <a class="nav-link rounded-3 d-flex align-items-center {{ request()->routeIs('dashboard') ? 'active' : 'collapsed' }}"
           href="{{ route('dashboard') }}"
           style="padding: 6px 12px; height: 35px; font-size: 13.5px; font-weight: 600;">
          <i class="fa-solid fa-chart-pie me-2" style="font-size: 15px;"></i>
          <span>Dashboard</span>
          <span class="ms-auto fw-bold text-uppercase opacity-50" style="font-size: 10px; letter-spacing: 0.5px;">Home</span>
        </a>
      </li>
  
      <!-- SECTION: MANAGEMENT -->
      <li class="nav-heading mt-3 mb-2 px-2 d-flex align-items-center position-relative" style="height: 20px;">
        <span class="bg-white pe-2 text-muted fw-bold position-relative" style="font-size: 10.5px; text-transform: uppercase; letter-spacing: 0.8px; z-index: 2; color: #747d8c !important;">
          System Management
        </span>
        <div class="position-absolute start-0 end-0 top-50 translate-y-50" style="border-bottom: 1px solid #e2e8f5; z-index: 1; margin-left: 8px; margin-right: 8px;"></div>
      </li>
  
      <li class="nav-item">
        <a class="nav-link rounded-3 d-flex align-items-center {{ request()->routeIs('users.*') ? 'active' : 'collapsed' }}"
           href="#"
           style="padding: 6px 12px; height: 35px; font-size: 13.5px; font-weight: 600;">
          <i class="fa-solid fa-users me-2" style="font-size: 15px;"></i>
          <span>User Accounts</span>
        </a>
      </li>
  
      <!-- SECTION: USER SETTINGS -->
      <li class="nav-heading mt-3 mb-2 px-2 d-flex align-items-center position-relative" style="height: 20px;">
        <span class="bg-white pe-2 text-muted fw-bold position-relative" style="font-size: 10.5px; text-transform: uppercase; letter-spacing: 0.8px; z-index: 2; color: #747d8c !important;">
          Settings
        </span>
        <div class="position-absolute start-0 end-0 top-50 translate-y-50" style="border-bottom: 1px solid #e2e8f5; z-index: 1; margin-left: 8px; margin-right: 8px;"></div>
      </li>
  
      <li class="nav-item">
        <a class="nav-link rounded-3 d-flex align-items-center {{ request()->routeIs('profile.edit') ? 'active' : 'collapsed' }}"
           href="{{ route('profile.edit') }}"
           style="padding: 6px 12px; height: 35px; font-size: 13.5px; font-weight: 600;">
          <i class="fa-solid fa-user-gear me-2" style="font-size: 15px;"></i>
          <span>My Profile</span>
        </a>
      </li>
  
    </ul>
  
    <!-- BOTTOM SIDEBAR: LOGOUT BUTTON -->
    <div class="p-2 border-top" style="border-color: #e2e8f5 !important;">
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="nav-link rounded-3 d-flex align-items-center w-100 text-start border-0 bg-transparent text-danger"
                style="padding: 6px 12px; height: 35px; font-size: 13.5px; font-weight: 600;">
          <i class="fa-solid fa-right-from-bracket me-2" style="font-size: 15px;"></i>
          <span>Logout</span>
        </button>
      </form>
    </div>
</aside>

<style>
/* Reset & Base style link navigasi sidebar */
.sidebar-nav .nav-link {
  color: #4b5563;
  transition: all 0.15s ease-in-out;
  border-radius: 6px !important; 
  text-decoration: none;
  border-left: 4px solid transparent;
}

/* KONDISI HOVER */
.sidebar-nav .nav-link:hover,
.sidebar-nav .nav-link.active:hover {
  background-color: #f1f5f9 !important;
  color: #1e293b !important;
  border-left: 4px solid #94a3b8 !important;
}

/* KONDISI AKTIF/DIKLIK */
.sidebar-nav .nav-link.active {
  background-color: #eff6ff !important;
  color: #2563eb !important;
  border-left: 4px solid #3b82f6 !important;
}
</style>