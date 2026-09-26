/*
  categories.js
  -------------
  Categories page: loading, add/edit/delete against Firestore's
  `categories` collection. Waits for 'excoso:authed' (fired by main.js)
  before touching Firestore. Populates CMS.categories, the shared cache
  products.js and dashboard.js read from.
*/
(function () {
  var CMS = window.CMS;
  var listEl = document.getElementById('categoryList');

  function renderList() {
    var cats = CMS.categories;
    if (!cats.length) {
      listEl.innerHTML = '<p class="a-empty">No categories yet. Click "+ Add Category" to create your first one.</p>';
      return;
    }
    listEl.innerHTML = cats.map(function (c) {
      return (
        '<div class="a-card">' +
          '<div class="a-card__thumb">' + (c.image ? '<img src="' + CMS.esc(c.image) + '" alt="">' : 'no photo') + '</div>' +
          '<div class="a-card__body">' +
            '<div class="a-card__title">' + CMS.esc(c.name) + '</div>' +
            '<div class="a-card__meta">id: ' + CMS.esc(c.id) + '</div>' +
          '</div>' +
          '<div class="a-card__actions">' +
            '<button class="a-btn a-btn--ghost a-btn--sm" data-edit-cat="' + CMS.esc(c.id) + '">Edit</button>' +
            '<button class="a-btn a-btn--danger a-btn--sm" data-delete-cat="' + CMS.esc(c.id) + '">Delete</button>' +
          '</div>' +
        '</div>'
      );
    }).join('');
    Array.prototype.forEach.call(listEl.querySelectorAll('[data-edit-cat]'), function (btn) {
      btn.addEventListener('click', function () { openCategoryModal(CMS.byId(CMS.categories, btn.dataset.editCat)); });
    });
    Array.prototype.forEach.call(listEl.querySelectorAll('[data-delete-cat]'), function (btn) {
      btn.addEventListener('click', function () { deleteCategory(btn.dataset.deleteCat); });
    });
  }

  function loadCategories() {
    listEl.innerHTML = '<p class="a-loading">Loading&hellip;</p>';
    return db.collection('categories').get().then(function (snap) {
      CMS.categories = snap.docs.map(function (doc) { return Object.assign({ id: doc.id }, doc.data()); });
      renderList();
      document.dispatchEvent(new CustomEvent('excoso:categories-updated', { detail: CMS.categories }));
    }).catch(function (err) {
      listEl.innerHTML = '<p class="a-empty">Could not load categories.</p>';
      CMS.showErrorBanner('Failed to load categories: ' + err.message);
    });
  }

  function openCategoryModal(existing) {
    var isNew = !existing;
    var c = existing ? Object.assign({}, existing) : { id: '', name: '', eyebrow: '', tagline: '', description: '', shopLabel: '', image: '' };
    var html =
      '<h3>' + (isNew ? 'Add Category' : 'Edit Category') + '</h3>' +
      '<div class="a-field"><label>Name</label><input type="text" id="f-cat-name" value="' + CMS.esc(c.name) + '" placeholder="e.g. Backpacks"></div>' +
      '<div class="a-field"><label>Category ID (used in URLs, auto-generated from name)</label><input type="text" id="f-cat-id" value="' + CMS.esc(c.id) + '"' + (isNew ? '' : ' disabled') + '></div>' +
      '<div class="a-field"><label>Eyebrow label</label><input type="text" id="f-cat-eyebrow" value="' + CMS.esc(c.eyebrow) + '" placeholder="e.g. Premium Merchandise"></div>' +
      '<div class="a-field"><label>Tagline (short headline)</label><input type="text" id="f-cat-tagline" value="' + CMS.esc(c.tagline) + '" placeholder="e.g. Designed for everyday movement."></div>' +
      '<div class="a-field"><label>Description</label><textarea id="f-cat-desc">' + CMS.esc(c.description) + '</textarea></div>' +
      '<div class="a-field"><label>"Shop" button label</label><input type="text" id="f-cat-shoplabel" value="' + CMS.esc(c.shopLabel) + '" placeholder="e.g. Shop Backpacks"></div>' +
      '<div class="a-field"><label>Category Image</label><div id="catImageUploader"></div></div>' +
      (isNew ? '' : '<p style="font-size:0.8rem;color:var(--graphite);margin-top:-0.4rem;">Category ID can\u2019t be changed after creation \u2014 delete and re-add it under a new ID if you really need to.</p>') +
      '<div class="a-modal__actions">' +
        '<button class="a-btn a-btn--ghost a-btn--sm" id="cat-cancel">Cancel</button>' +
        '<button class="a-btn a-btn--solid" id="cat-save">' + (isNew ? 'Add Category' : 'Save Changes') + '</button>' +
      '</div>';

    CMS.openModal(html, function (modal) {
      var nameInput = modal.querySelector('#f-cat-name');
      var idInput = modal.querySelector('#f-cat-id');
      var idTouched = !isNew;
      nameInput.addEventListener('input', function () { if (!idTouched) idInput.value = CMS.slugify(nameInput.value); });
      idInput.addEventListener('input', function () { idTouched = true; });

      var imageUploader = CMS.mountImageUploader(modal.querySelector('#catImageUploader'), {
        value: c.image, folder: 'categories', onChange: function () {}
      });

      modal.querySelector('#cat-cancel').addEventListener('click', CMS.closeModal);
      modal.querySelector('#cat-save').addEventListener('click', function () {
        var name = nameInput.value.trim();
        if (!name) { alert('Please enter a category name.'); return; }
        var id = isNew ? (idInput.value.trim() ? CMS.slugify(idInput.value) : CMS.slugify(name)) : c.id;
        if (isNew && CMS.byId(CMS.categories, id)) { alert('That category ID is already in use \u2014 pick another.'); return; }

        var payload = {
          name: name,
          eyebrow: modal.querySelector('#f-cat-eyebrow').value.trim(),
          tagline: modal.querySelector('#f-cat-tagline').value.trim(),
          description: modal.querySelector('#f-cat-desc').value.trim(),
          shopLabel: modal.querySelector('#f-cat-shoplabel').value.trim(),
          image: imageUploader.getValue()
        };

        var saveBtn = modal.querySelector('#cat-save');
        saveBtn.disabled = true;
        saveBtn.textContent = 'Saving\u2026';
        db.collection('categories').doc(id).set(payload).then(function () {
          CMS.closeModal();
          CMS.showToast(isNew ? 'Category added' : 'Category saved');
          loadCategories();
        }).catch(function (err) {
          saveBtn.disabled = false;
          saveBtn.textContent = isNew ? 'Add Category' : 'Save Changes';
          alert('Could not save: ' + err.message);
        });
      });
    });
  }

  function deleteCategory(id) {
    if (!confirm('Delete this category? Products already using it will be left with a category ID that no longer matches anything (they\u2019ll still exist, just uncategorized on the site).')) return;
    db.collection('categories').doc(id).delete().then(loadCategories).catch(function (err) {
      CMS.showErrorBanner('Could not delete category: ' + err.message);
    });
  }

  document.getElementById('addCategoryBtn').addEventListener('click', function () { openCategoryModal(null); });

  document.addEventListener('excoso:authed', function () { loadCategories(); });

  // ---------- one-click starter data import ----------
  var importBtn = document.getElementById('importSeedBtn');
  if (importBtn) {
    importBtn.addEventListener('click', function () {
      var btn = this;
      btn.disabled = true;
      btn.textContent = 'Importing\u2026';
      fetch('../data/catalog.json', { cache: 'no-store' })
        .then(function (res) {
          if (!res.ok) throw new Error('Could not fetch data/catalog.json (' + res.status + ')');
          return res.json();
        })
        .then(function (seed) {
          var batch = db.batch();
          var added = 0, skipped = 0;
          var existingCatIds = CMS.categories.map(function (c) { return c.id; });
          (seed.categories || []).forEach(function (c) {
            if (existingCatIds.indexOf(c.id) !== -1) { skipped++; return; }
            var ref = db.collection('categories').doc(c.id);
            var data = Object.assign({}, c); delete data.id;
            batch.set(ref, data);
            added++;
          });
          return db.collection('products').get().then(function (existingProdSnap) {
            var existingProdIds = existingProdSnap.docs.map(function (d) { return d.id; });
            (seed.products || []).forEach(function (p) {
              if (existingProdIds.indexOf(p.id) !== -1) { skipped++; return; }
              var ref = db.collection('products').doc(p.id);
              var data = Object.assign({ active: true }, p); delete data.id;
              batch.set(ref, data);
              added++;
            });
            return batch.commit().then(function () { return { added: added, skipped: skipped }; });
          });
        })
        .then(function (result) {
          alert('Imported ' + result.added + ' item(s). Skipped ' + result.skipped + ' that already existed.');
          loadCategories();
          document.dispatchEvent(new CustomEvent('excoso:authed')); // re-trigger products.js's loader too
        })
        .catch(function (err) {
          alert('Import failed: ' + err.message);
        })
        .finally(function () {
          btn.disabled = false;
          btn.textContent = 'Import Starter Catalog';
        });
    });
  }
})();
