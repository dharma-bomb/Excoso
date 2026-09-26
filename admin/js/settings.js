/*
  settings.js
  -----------
  Settings page: a single Firestore document at settings/main holding
  site-wide company info. The public site's footer (js/catalog.js) reads
  this document and renders it dynamically.
*/
(function () {
  var CMS = window.CMS;
  var formEl = document.getElementById('settingsForm');
  var statusEl = document.getElementById('settingsStatus');
  var SETTINGS_REF = null;

  var FIELDS = ['companyName', 'phone', 'email', 'address', 'whatsapp', 'instagram', 'linkedin'];

  function loadSettings() {
    SETTINGS_REF = db.collection('settings').doc('main');
    statusEl.textContent = 'Loading\u2026';
    SETTINGS_REF.get().then(function (doc) {
      var data = doc.exists ? doc.data() : {};
      FIELDS.forEach(function (f) {
        var el = document.getElementById('f-set-' + f);
        if (el) el.value = data[f] || '';
      });
      statusEl.textContent = '';
    }).catch(function (err) {
      statusEl.textContent = '';
      CMS.showErrorBanner('Could not load settings: ' + err.message);
    });
  }

  formEl.addEventListener('submit', function (ev) {
    ev.preventDefault();
    var payload = {};
    FIELDS.forEach(function (f) {
      var el = document.getElementById('f-set-' + f);
      payload[f] = el ? el.value.trim() : '';
    });
    var saveBtn = document.getElementById('settingsSaveBtn');
    saveBtn.disabled = true;
    saveBtn.textContent = 'Saving\u2026';
    SETTINGS_REF.set(payload, { merge: true }).then(function () {
      CMS.showToast('Settings saved');
    }).catch(function (err) {
      CMS.showErrorBanner('Could not save settings: ' + err.message);
    }).finally(function () {
      saveBtn.disabled = false;
      saveBtn.textContent = 'Save Settings';
    });
  });

  document.addEventListener('excoso:authed', function () { loadSettings(); });
})();
