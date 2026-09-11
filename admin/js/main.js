/*
  main.js
  -------
  Handles: detecting whether Firebase is configured, the login form,
  auth-state changes (showing the dashboard vs. the login screen),
  logging out, and tab switching. Category/product/quote/settings logic
  lives in their own files, all of which wait for the 'excoso:authed'
  event fired below before loading anything from Firestore.
*/
(function () {
  var loginScreen = document.getElementById('loginScreen');
  var dashboard = document.getElementById('dashboard');
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
    console.warn('[excoso-admin] Firebase is not configured — see js/firebase-config.js and README.md.');
    return; // Nothing else in this file can safely run without Firebase.
  }

  if (!(window.CMSStorage && window.CMSStorage.available())) {
    console.warn('[excoso-admin] Firebase Storage isn\u2019t available — image uploads will fall back to URL-only until it\u2019s set up (see README.md).');
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
        console.error('[auth] sign-in failed', err);
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
      dashboard.style.display = 'block';
      userEmailEl.textContent = user.email || '';
      document.dispatchEvent(new CustomEvent('excoso:authed', { detail: { user: user } }));
    } else {
      dashboard.style.display = 'none';
      loginScreen.style.display = 'flex';
    }
  });

  // ---------- tab switching ----------
  var tabButtons = document.querySelectorAll('.a-tab');
  var panels = {
    dashboard: document.getElementById('dashboardPanel'),
    categories: document.getElementById('categoriesPanel'),
    products: document.getElementById('productsPanel'),
    quotes: document.getElementById('quotesPanel'),
    settings: document.getElementById('settingsPanel')
  };
  tabButtons.forEach(function (btn) {
    btn.addEventListener('click', function () {
      tabButtons.forEach(function (b) { b.classList.remove('is-active'); });
      btn.classList.add('is-active');
      Object.keys(panels).forEach(function (key) {
        if (panels[key]) panels[key].style.display = key === btn.dataset.tab ? 'block' : 'none';
      });
      document.dispatchEvent(new CustomEvent('excoso:tab-shown', { detail: btn.dataset.tab }));
    });
  });
})();
