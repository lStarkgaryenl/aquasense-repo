// ─── Navbar colapsable compartido ───
(function() {
  const STORAGE_KEY = 'aq_nav_collapsed';

  function isCollapsed() {
    return localStorage.getItem(STORAGE_KEY) === '1';
  }

  function applyState(collapsed) {
    const aside   = document.getElementById('sidebar');
    const main    = document.getElementById('main-content');
    const header  = document.getElementById('main-header');
    const labels  = document.querySelectorAll('.nav-label');
    const logo    = document.getElementById('nav-logo-full');
    const logoMin = document.getElementById('nav-logo-mini');
    const btn     = document.getElementById('nav-toggle');

    if (collapsed) {
      aside.style.width  = '64px';
      aside.style.overflow = 'hidden';
      main.style.marginLeft  = '64px';
      header.style.marginLeft = '64px';
      header.style.maxWidth   = 'calc(100% - 64px)';
      labels.forEach(l => l.style.display = 'none');
      if (logo)    logo.style.display = 'none';
      if (logoMin) logoMin.style.display = 'flex';
      if (btn) btn.querySelector('span').textContent = 'chevron_right';
    } else {
      aside.style.width  = '256px';
      aside.style.overflow = 'visible';
      main.style.marginLeft  = '256px';
      header.style.marginLeft = '256px';
      header.style.maxWidth   = 'calc(100% - 256px)';
      labels.forEach(l => l.style.display = '');
      if (logo)    logo.style.display = '';
      if (logoMin) logoMin.style.display = 'none';
      if (btn) btn.querySelector('span').textContent = 'chevron_left';
    }
  }

  function toggle() {
    const next = !isCollapsed();
    localStorage.setItem(STORAGE_KEY, next ? '1' : '0');
    applyState(next);
  }

  document.addEventListener('DOMContentLoaded', () => {
    applyState(isCollapsed());
    const btn = document.getElementById('nav-toggle');
    if (btn) btn.addEventListener('click', toggle);
  });
})();
