/*
  main.js
  -------
  Handles: detecting whether Firebase is configured, the login form,
  auth-state changes (showing the dashboard vs. the login screen),
  logging out, and sidebar navigation between pages. Page-specific data
  logic lives in dashboard.js / categories.js / products.js / banners.js /
  settings.js / quotes.js, all of which wait for the 'excoso:authed' event
  fired below before loading anything from Firestore.
*/
(function () {
  var loginScreen = document.getElementById('loginScreen');
  var appShell = document.getElementById('appShell');
  var notConfiguredNotice = document.getElementById('notConfiguredNotice');
  var loginForm = document.getElementById('loginForm');
  var loginError = document.getElementById('loginError');
  var loginBtn = document.getElementById('loginBtn');
  var userEmailEl = document.getElementById('userEmail');
  var logoutBtn = document.getElementById('logoutBtn');

  function showError(msg) {
    loginError.textContent = msg;
    loginError.classList.add('is-visible');
  }
  function clearError() {
    loginError.textContent = '';
    loginError.classList.remove('is-visible');
  }

  if (typeof firebaseReady === 'undefined' || !firebaseReady || !auth) {
    notConfiguredNotice.style.display = 'block';
    loginBtn.disabled = true;
    return; // Nothing else in this file can safely run without Firebase.
  }

  loginForm.addEventListener('submit', function (ev) {
    ev.preventDefault();
    clearError();
    loginBtn.disabled = true;
    loginBtn.textContent = 'Signing in\u2026';
    var email = document.getElementById('loginEmail').value.trim();
    var password = document.getElementById('loginPassword').value;
    auth.signInWithEmailAndPassword(email, password)
      .catch(function (err) {
        showError(friendlyAuthError(err));
      })
      .finally(function () {
        loginBtn.disabled = false;
        loginBtn.textContent = 'Sign In';
      });
  });

  function friendlyAuthError(err) {
    var code = err && err.code;
    if (code === 'auth/invalid-email') return 'That email address doesn\u2019t look right.';
    if (code === 'auth/user-not-found' || code === 'auth/wrong-password' || code === 'auth/invalid-credential') {
      return 'Incorrect email or password.';
    }
    if (code === 'auth/too-many-requests') return 'Too many attempts \u2014 please wait a bit and try again.';
    return 'Could not sign in: ' + (err && err.message ? err.message : 'unknown error.');
  }

  logoutBtn.addEventListener('click', function () {
    auth.signOut();
  });

  auth.onAuthStateChanged(function (user) {
    if (user) {
      loginScreen.style.display = 'none';
      appShell.style.display = 'flex';
      userEmailEl.textContent = user.email || '';
      document.dispatchEvent(new CustomEvent('excoso:authed', { detail: { user: user } }));
    } else {
      appShell.style.display = 'none';
      loginScreen.style.display = 'flex';
    }
  });

  // ---------- sidebar navigation ----------
  var navButtons = document.querySelectorAll('.a-nav__link[data-page]');
  var pages = {
    dashboard: document.getElementById('pageDashboard'),
    products: document.getElementById('pageProducts'),
    categories: document.getElementById('pageCategories'),
    banners: document.getElementById('pageBanners'),
    quotes: document.getElementById('pageQuotes'),
    settings: document.getElementById('pageSettings')
  };
  var pageTitles = {
    dashboard: 'Dashboard', products: 'Products', categories: 'Categories',
    banners: 'Banners', quotes: 'Quotes', settings: 'Settings'
  };
  var titleEl = document.getElementById('pageTitle');
  var sidebar = document.getElementById('sidebar');
  var sidebarToggle = document.getElementById('sidebarToggle');

  function goToPage(key) {
    navButtons.forEach(function (b) { b.classList.toggle('is-active', b.dataset.page === key); });
    Object.keys(pages).forEach(function (k) { if (pages[k]) pages[k].style.display = k === key ? 'block' : 'none'; });
    if (titleEl) titleEl.textContent = pageTitles[key] || '';
    sidebar.classList.remove('is-open');
    window.location.hash = key;
    document.dispatchEvent(new CustomEvent('excoso:page-shown', { detail: { page: key } }));
  }

  navButtons.forEach(function (btn) {
    btn.addEventListener('click', function () { goToPage(btn.dataset.page); });
  });
  if (sidebarToggle) {
    sidebarToggle.addEventListener('click', function () { sidebar.classList.toggle('is-open'); });
  }

  document.addEventListener('excoso:authed', function () {
    var initial = (window.location.hash || '').replace('#', '');
    goToPage(pages[initial] ? initial : 'dashboard');
  });
})();
