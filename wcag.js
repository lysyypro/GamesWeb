
(function () {
  'use strict';

  const STORAGE_SIZE  = 'gw_font_size';
  const STORAGE_THEME = 'gw_theme';
  const SIZES = { small: '13px', medium: '16px', large: '20px' };

  function setSize(name) {
    document.documentElement.style.fontSize = SIZES[name] || SIZES.medium;
    localStorage.setItem(STORAGE_SIZE, name);
    document.querySelectorAll('.wcag-a').forEach(btn => {
      btn.classList.toggle('aktywny', btn.dataset.size === name);
    });
  }

  function setTheme(theme) {
    document.documentElement.setAttribute('data-theme', theme);
    localStorage.setItem(STORAGE_THEME, theme);
    document.dispatchEvent(new CustomEvent('themeChanged', { detail: { theme } }));
  }
  (function restore() {
    const savedSize  = localStorage.getItem(STORAGE_SIZE)  || 'medium';
    const savedTheme = localStorage.getItem(STORAGE_THEME) || 'dark';
    setSize(savedSize);
    setTheme(savedTheme);
  })();

  document.querySelectorAll('.wcag-a').forEach(btn => {
    btn.addEventListener('click', () => setSize(btn.dataset.size));
  });

  const themeBtn = document.getElementById('theme-toggle');
  if (themeBtn) {
    themeBtn.addEventListener('click', toggleTheme);
  }

})();
