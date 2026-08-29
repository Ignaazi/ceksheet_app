document.addEventListener('DOMContentLoaded', function () {
    // Event Delegation untuk otomatis menangani SEMUA tombol dropdown ber-class .sidebar-dropdown-toggle
    document.addEventListener('click', function (e) {
      const btn = e.target.closest('.sidebar-dropdown-toggle');
      if (!btn) return;
  
      const dropdownId = btn.getAttribute('data-target');
      const dropdown = document.getElementById(dropdownId);
      const chevron = btn.querySelector('.dropdown-chevron');
  
      if (!dropdown) return;
  
      const isHidden = dropdown.style.display === 'none' || getComputedStyle(dropdown).display === 'none';
  
      if (isHidden) {
        // 1. Matikan class 'active' dari SEMUA menu utama lain
        document.querySelectorAll('.sidebar-nav .nav-link').forEach(link => {
          link.classList.remove('active');
        });
  
        // 2. Tampilkan dropdown & aktifkan tombol Settings
        dropdown.style.display = 'block';
        btn.classList.add('active');
        if (chevron) chevron.classList.add('open');
      } else {
        // 3. Sembunyikan dropdown & nonaktifkan animasi chevron
        dropdown.style.display = 'none';
        if (chevron) chevron.classList.remove('open');
  
        // 4. Periksa apakah halaman aktif berada di salah satu sub-item dropdown ini
        const hasActiveChild = dropdown.querySelector('.sub-nav-link.active') !== null;
  
        if (!hasActiveChild) {
          btn.classList.remove('active');
  
          // Restore status active ke menu single utama yang sedang dibuka
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
    });
  });