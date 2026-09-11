/*
  settings.js
  -----------
  Settings tab: one Firestore document (settings/general) holding company
  contact info and social links. Loaded lazily the first time the tab is
  opened (not on every login) since it rarely changes.
*/
(function () {
  var CMS = window.CMS;
  var form = document.getElementById('settingsForm');
  if (!form) return;
  var statusEl = document.getElementById('settingsStatus');
  var loaded = false;

  var FIELDS = ['companyName', 'phone', 'email', 'address', 'whatsapp', 'facebook', 'instagram', 'linkedin'];

  function load() {
    statusEl.textContent = 'Loading\u2026';
    db.collection('settings').doc('general').get().then(function (doc) {
      var data = doc.exists ? doc.data() : {};
      FIELDS.forEach(function (f) {
        var el = document.getElementById('set-' + f);
        if (el) el.value = data[f] || '';
      });
      statusEl.textContent = '';
      loaded = true;
    }).catch(function (err) {
      statusEl.textContent = '';
      CMS.toast('Could not load settings: ' + err.message, 'error');
      console.error('[settings] load failed', err);
    });
  }

  form.addEventListener('submit', function (ev) {
    ev.preventDefault();
    var payload = {};
    FIELDS.forEach(function (f) {
      var el = document.getElementById('set-' + f);
      if (el) payload[f] = el.value.trim();
    });
    var btn = form.querySelector('button[type=submit]');
    btn.disabled = true; btn.textContent = 'Saving\u2026';
    db.collection('settings').doc('general').set(payload, { merge: true }).then(function () {
      CMS.toast('Settings saved.');
    }).catch(function (err) {
      CMS.toast('Could not save: ' + err.message, 'error');
      console.error('[settings] save failed', err);
    }).finally(function () {
      btn.disabled = false; btn.textContent = 'Save Settings';
    });
  });

  document.addEventListener('excoso:tab-shown', function (ev) {
    if (ev.detail === 'settings' && !loaded) load();
  });
})();
