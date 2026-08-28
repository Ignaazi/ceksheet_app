<aside class="sidebar flex-shrink-0" style="font-family: 'Nunito', sans-serif; background-color: #ffffff; border-right: 1px solid #e2e8f5; height: calc(100vh - 65px); width: 260px; transition: all 0.3s ease; display: flex; flex-direction: column; justify-content: space-between; padding-top: 15px; position: fixed; top: 65px; left: 0; z-index: 996;">
    <ul class="sidebar-nav d-flex flex-column gap-1 list-unstyled px-2" style="margin: 0; padding-left: 8px; padding-right: 8px;">

      <!-- SECTION: MAIN MENU -->
      <li class="nav-item">
        <a class="nav-link rounded-3 d-flex align-items-center {{ request()->routeIs('dashboard') ? 'active' : 'collapsed' }}"
           href="{{ route('dashboard') }}"
           style="padding: 6px 12px; height: 35px; font-size: 13.5px; font-weight: 600;">
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
           href="{{ route('users.index') }}"
           style="padding: 6px 12px; height: 35px; font-size: 13.5px; font-weight: 600;">
          <i class="fa-solid fa-users me-2" style="font-size: 15px;"></i>
          <span>User Accounts</span>
        </a>
      </li>

      <!-- MY PROFILE MENU -->
      <li class="nav-item">
        <a class="nav-link rounded-3 d-flex align-items-center {{ request()->routeIs('profile.edit') ? 'active' : 'collapsed' }}"
           href="{{ route('profile.edit') }}"
           style="padding: 6px 12px; height: 35px; font-size: 13.5px; font-weight: 600;">
          <i class="fa-solid fa-user-gear me-2" style="font-size: 15px;"></i>
          <span>My Profile</span>
        </a>
      </li>

      <!-- DROPDOWN SYSTEM SETTINGS -->
      <li class="nav-item">
        <button type="button" 
                id="btn-settings-toggle"
                class="nav-link rounded-3 d-flex align-items-center w-100 border-0 bg-transparent text-start {{ request()->routeIs('settings.*') ? 'active' : '' }}"
                onclick="toggleSettingsMenu(this)"
                style="padding: 6px 12px; height: 35px; font-size: 13.5px; font-weight: 600;">
          <i class="fa-solid fa-sliders me-2" style="font-size: 15px;"></i>
          <span>System Settings</span>
          <i class="fa-solid fa-chevron-down ms-auto dropdown-chevron" id="settings-chevron" style="font-size: 10px; transition: transform 0.2s ease; transform: {{ request()->routeIs('settings.*') ? 'rotate(180deg)' : 'rotate(0deg)' }};"></i>
        </button>

        <!-- SUB-MENU DROPDOWN WITH TREE LINE & ICONS -->
        <div id="settings-dropdown" class="sidebar-tree-wrapper" style="display: {{ request()->routeIs('settings.*') ? 'block' : 'none' }};">
          <ul class="nav flex-column list-unstyled sidebar-tree-list">
            <li>
              <a class="sub-nav-link d-flex align-items-center {{ request()->routeIs('settings.roles*') ? 'active' : '' }}" 
                 href="#">
                <span class="tree-bullet"></span>
                <i class="fa-solid fa-shield-halved me-2" style="font-size: 12px;"></i>
                <span>Role & Permissions</span>
              </a>
            </li>
            <li>
              <a class="sub-nav-link d-flex align-items-center {{ request()->routeIs('settings.ip*') ? 'active' : '' }}" 
                 href="#">
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

<script>
  function toggleSettingsMenu(btn) {
    const dropdown = document.getElementById('settings-dropdown');
    const chevron = document.getElementById('settings-chevron');
    
    if (dropdown.style.display === 'none' || dropdown.style.display === '') {
      // 1. Matikan class 'active' dari SEMUA menu utama lain
      document.querySelectorAll('.sidebar-nav .nav-link').forEach(link => {
        link.classList.remove('active');
      });

      // 2. Tampilkan dropdown & aktifkan tombol Settings
      dropdown.style.display = 'block';
      btn.classList.add('active');
      chevron.style.transform = 'rotate(180deg)';
    } else {
      // 3. Sembunyikan dropdown & nonaktifkan tombol Settings
      dropdown.style.display = 'none';
      btn.classList.remove('active');
      chevron.style.transform = 'rotate(0deg)';

      // 4. Kembalikan status active ke halaman asal
      const currentPath = window.location.pathname;
      if (currentPath.includes('dashboard')) {
        document.querySelector('a[href*="dashboard"]')?.classList.add('active');
      } else if (currentPath.includes('users')) {
        document.querySelector('a[href*="users"]')?.classList.add('active');
      } else if (currentPath.includes('profile')) {
        document.querySelector('a[href*="profile"]')?.classList.add('active');
      }
    }
  }
</script>

<style>
/* Base Style Main Nav Link */
.sidebar-nav .nav-link {
  color: #4b5563;
  transition: all 0.15s ease-in-out;
  border-radius: 6px !important; 
  text-decoration: none;
  border-left: 4px solid transparent;
}

/* Hover Main Item */
.sidebar-nav .nav-link:hover {
  background-color: #f1f5f9 !important;
  color: #1e293b !important;
}

/* Active Main Item */
.sidebar-nav .nav-link.active {
  background-color: #eff6ff !important;
  color: #2563eb !important;
  border-left: 4px solid #3b82f6 !important;
}

/* --- TREE STYLE SUB MENU (GARIS & BULETAN) --- */
.sidebar-tree-wrapper {
  padding-left: 20px;
  position: relative;
  margin-top: 4px;
  margin-bottom: 6px;
}

.sidebar-tree-list {
  position: relative;
  padding-left: 12px;
  border-left: 2px solid #cbd5e1;
}

.sub-nav-link {
  padding: 6px 10px;
  font-size: 13px;
  font-weight: 500;
  color: #64748b;
  text-decoration: none;
  border-radius: 6px;
  transition: all 0.15s ease;
  position: relative;
}

/* Bulatan (Bullet Point Circle) */
.sub-nav-link .tree-bullet {
  width: 7px;
  height: 7px;
  border: 2px solid #94a3b8;
  border-radius: 50%;
  background-color: #ffffff;
  display: inline-block;
  margin-right: 8px;
  flex-shrink: 0;
  transition: all 0.15s ease;
}

/* Hover Sub-item */
.sub-nav-link:hover {
  color: #1e293b;
  background-color: #f8fafc;
}

.sub-nav-link:hover .tree-bullet {
  border-color: #3b82f6;
  background-color: #3b82f6;
}

/* Active Sub-item */
.sub-nav-link.active {
  color: #2563eb;
  font-weight: 700;
  background-color: #eff6ff;
}

.sub-nav-link.active .tree-bullet {
  border-color: #2563eb;
  background-color: #2563eb;
  box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.2);
}
</style>