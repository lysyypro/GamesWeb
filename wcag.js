(function () {
  var SIZES = { small: '13px', medium: '16px', large: '20px' };

  function setSize(name) {
    document.documentElement.style.fontSize = SIZES[name] || SIZES.medium;
    localStorage.setItem('gw_size', name);
    document.querySelectorAll('.wcag-a').forEach(function(btn) {
      btn.classList.toggle('aktywny', btn.dataset.size === name);
    });
  }

  function setTheme(theme) {
    document.documentElement.setAttribute('data-theme', theme);
    localStorage.setItem('gw_theme', theme);
    document.dispatchEvent(new CustomEvent('themeChanged', { detail: { theme: theme } }));
  }

  setSize(localStorage.getItem('gw_size') || 'medium');
  setTheme(localStorage.getItem('gw_theme') || 'dark');

  document.querySelectorAll('.wcag-a').forEach(function(btn) {
    btn.addEventListener('click', function() { setSize(btn.dataset.size); });
  });

  var toggle = document.getElementById('theme-toggle');
  if (toggle) {
    toggle.addEventListener('click', function() {
      setTheme(document.documentElement.getAttribute('data-theme') === 'dark' ? 'light' : 'dark');
    });
  }
})();
