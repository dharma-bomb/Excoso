/*
  banners.js
  ----------
  Banners page: add/edit/delete against Firestore's `banners` collection.
  Fields: title, subtitle, image, active, sortOrder.
  The public homepage (js/catalog.js) loads only banners where
  active == true, ordered by sortOrder, into the #promoBanners section.
*/
(function () {
  var CMS = window.CMS;
  var listEl = document.getElementById('bannerList');
  var banners = [];

  function renderList() {
    if (!banners.length) {
      listEl.innerHTML = '<p class="a-empty">No banners yet. Click "+ Add Banner" to create your first one.</p>';
      return;
    }
    var sorted = banners.slice().sort(function (a, b) { return (a.sortOrder || 0) - (b.sortOrder || 0); });
    listEl.innerHTML = sorted.map(function (b) {
      return (
        '<div class="a-card' + (b.active ? '' : ' a-card--inactive') + '">' +
          '<div class="a-card__thumb">' + (b.image ? '<img src="' + CMS.esc(b.image) + '" alt="">' : 'no photo') + '</div>' +
          '<div class="a-card__body">' +
            '<div class="a-card__title">' + CMS.esc(b.title) + (!b.active ? ' <span class="a-pill a-pill--inactive">Inactive</span>' : ' <span class="a-pill a-pill--featured">Active</span>') + '</div>' +
            '<div class="a-card__meta">' + CMS.esc(b.subtitle || '') + ' \u00b7 order: ' + CMS.esc(b.sortOrder != null ? b.sortOrder : 0) + '</div>' +
          '</div>' +
          '<div class="a-card__actions">' +
            '<button class="a-btn a-btn--ghost a-btn--sm" data-edit-banner="' + CMS.esc(b.id) + '">Edit</button>' +
            '<button class="a-btn a-btn--danger a-btn--sm" data-delete-banner="' + CMS.esc(b.id) + '">Delete</button>' +
          '</div>' +
        '</div>'
      );
    }).join('');
    Array.prototype.forEach.call(listEl.querySelectorAll('[data-edit-banner]'), function (btn) {
      btn.addEventListener('click', function () { openBannerModal(CMS.byId(banners, btn.dataset.editBanner)); });
    });
    Array.prototype.forEach.call(listEl.querySelectorAll('[data-delete-banner]'), function (btn) {
      btn.addEventListener('click', function () { deleteBanner(btn.dataset.deleteBanner); });
    });
  }

  function loadBanners() {
    listEl.innerHTML = '<p class="a-loading">Loading&hellip;</p>';
    return db.collection('banners').get().then(function (snap) {
      banners = snap.docs.map(function (doc) { return Object.assign({ id: doc.id }, doc.data()); });
      renderList();
      document.dispatchEvent(new CustomEvent('excoso:banners-updated', { detail: banners }));
    }).catch(function (err) {
      listEl.innerHTML = '<p class="a-empty">Could not load banners.</p>';
      CMS.showErrorBanner('Failed to load banners: ' + err.message);
    });
  }

  function openBannerModal(existing) {
    var isNew = !existing;
    var b = existing ? Object.assign({}, existing) : { id: '', title: '', subtitle: '', image: '', active: true, sortOrder: banners.length };
    var html =
      '<h3>' + (isNew ? 'Add Banner' : 'Edit Banner') + '</h3>' +
      '<div class="a-field"><label>Title</label><input type="text" id="f-ban-title" value="' + CMS.esc(b.title) + '" placeholder="e.g. Monsoon Sale \u2014 20% Off"></div>' +
      '<div class="a-field"><label>Subtitle</label><input type="text" id="f-ban-subtitle" value="' + CMS.esc(b.subtitle) + '" placeholder="e.g. On all raincoats and umbrellas, this week only."></div>' +
      '<div class="a-field-row">' +
        '<div class="a-field"><label class="a-checkbox"><input type="checkbox" id="f-ban-active"' + (b.active !== false ? ' checked' : '') + '> Active (shown on homepage)</label></div>' +
        '<div class="a-field"><label>Sort Order (lower shows first)</label><input type="number" id="f-ban-sort" step="1" value="' + CMS.esc(b.sortOrder != null ? b.sortOrder : 0) + '"></div>' +
      '</div>' +
      '<div class="a-field"><label>Banner Image</label><div id="banImageUploader"></div></div>' +
      '<div class="a-modal__actions">' +
        '<button class="a-btn a-btn--ghost a-btn--sm" id="ban-cancel">Cancel</button>' +
        '<button class="a-btn a-btn--solid" id="ban-save">' + (isNew ? 'Add Banner' : 'Save Changes') + '</button>' +
      '</div>';

    CMS.openModal(html, function (modal) {
      var imageUploader = CMS.mountImageUploader(modal.querySelector('#banImageUploader'), {
        value: b.image, folder: 'banners', onChange: function () {}
      });

      modal.querySelector('#ban-cancel').addEventListener('click', CMS.closeModal);
      modal.querySelector('#ban-save').addEventListener('click', function () {
        var title = modal.querySelector('#f-ban-title').value.trim();
        if (!title) { alert('Please enter a banner title.'); return; }
        var image = imageUploader.getValue();
        if (!image) { alert('Please upload a banner image.'); return; }

        var payload = {
          title: title,
          subtitle: modal.querySelector('#f-ban-subtitle').value.trim(),
          image: image,
          active: modal.querySelector('#f-ban-active').checked,
          sortOrder: Number(modal.querySelector('#f-ban-sort').value) || 0
        };

        var saveBtn = modal.querySelector('#ban-save');
        saveBtn.disabled = true;
        saveBtn.textContent = 'Saving\u2026';
        var ref = isNew ? db.collection('banners').doc() : db.collection('banners').doc(b.id);
        ref.set(payload).then(function () {
          CMS.closeModal();
          CMS.showToast(isNew ? 'Banner added' : 'Banner saved');
          loadBanners();
        }).catch(function (err) {
          saveBtn.disabled = false;
          saveBtn.textContent = isNew ? 'Add Banner' : 'Save Changes';
          alert('Could not save: ' + err.message);
        });
      });
    });
  }

  function deleteBanner(id) {
    if (!confirm('Delete this banner? This can\u2019t be undone.')) return;
    db.collection('banners').doc(id).delete().then(loadBanners).catch(function (err) {
      CMS.showErrorBanner('Could not delete banner: ' + err.message);
    });
  }

  document.getElementById('addBannerBtn').addEventListener('click', function () { openBannerModal(null); });
  document.addEventListener('excoso:authed', function () { loadBanners(); });
})();
