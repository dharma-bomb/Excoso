/*
  categories.js
  -------------
  Categories tab: load/add/edit/delete against Firestore's `categories`
  collection, plus search and a product-count column. Depends on
  window.CMS (core.js) and reads CMS.products (kept fresh by products.js)
  to show counts and to block deleting a category still in use.
*/
(function () {
  var CMS = window.CMS;
  var listEl = document.getElementById('categoryList');
  var searchEl = document.getElementById('categorySearch');
  var query = '';

  function productCount(catId) {
    return CMS.products.filter(function (p) { return p.category === catId; }).length;
  }

  function renderList() {
    var cats = CMS.categories.filter(function (c) {
      return !query || c.name.toLowerCase().indexOf(query) !== -1 || c.id.toLowerCase().indexOf(query) !== -1;
    });
    if (!cats.length) {
      listEl.innerHTML = '<p class="a-empty">' + (CMS.categories.length ? 'No categories match your search.' : 'No categories yet. Click \u201c+ Add Category\u201d to create your first one.') + '</p>';
      return;
    }
    listEl.innerHTML = cats.map(function (c) {
      var count = productCount(c.id);
      return (
        '<div class="a-card">' +
          '<div class="a-card__thumb">' + (c.image ? '<img src="' + CMS.esc(c.image) + '" alt="">' : 'no photo') + '</div>' +
          '<div class="a-card__body">' +
            '<div class="a-card__title">' + CMS.esc(c.name) + '</div>' +
            '<div class="a-card__meta">id: ' + CMS.esc(c.id) + ' \u00b7 ' + count + (count === 1 ? ' product' : ' products') + '</div>' +
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
      CMS.toast('Failed to load categories: ' + err.message, 'error');
      console.error('[categories] load failed', err);
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
      '<div class="a-field"><label>Cover image</label>' +
        '<div class="a-upload" id="cat-upload">' +
          '<img class="a-upload__preview' + (c.image ? ' is-visible' : '') + '" id="cat-img-preview" src="' + CMS.esc(c.image) + '">' +
          '<div class="a-upload__row">' +
            '<input type="file" id="f-cat-file" accept="image/*">' +
            '<span class="a-upload__or">or paste a URL</span>' +
          '</div>' +
          '<input type="text" id="f-cat-image" value="' + CMS.esc(c.image) + '" placeholder="https://... or leave blank for a color-block tile">' +
          '<p class="a-upload__status" id="cat-upload-status"></p>' +
        '</div>' +
      '</div>' +
      (isNew ? '' : '<p style="font-size:0.8rem;color:var(--graphite);margin-top:-0.4rem;">Category ID can\u2019t be changed after creation \u2014 delete and re-add it under a new ID if you really need to.</p>') +
      '<div class="a-modal__actions">' +
        '<button class="a-btn a-btn--ghost a-btn--sm" id="cat-cancel">Cancel</button>' +
        '<button class="a-btn a-btn--solid" id="cat-save">' + (isNew ? 'Add Category' : 'Save Changes') + '</button>' +
      '</div>';

    CMS.openModal(html, function (modal) {
      var nameInput = modal.querySelector('#f-cat-name');
      var idInput = modal.querySelector('#f-cat-id');
      var imageInput = modal.querySelector('#f-cat-image');
      var preview = modal.querySelector('#cat-img-preview');
      var status = modal.querySelector('#cat-upload-status');
      var idTouched = !isNew;
      nameInput.addEventListener('input', function () { if (!idTouched) idInput.value = CMS.slugify(nameInput.value); });
      idInput.addEventListener('input', function () { idTouched = true; });
      imageInput.addEventListener('input', function () {
        preview.src = imageInput.value.trim();
        preview.classList.toggle('is-visible', !!imageInput.value.trim());
      });

      modal.querySelector('#f-cat-file').addEventListener('change', function (e) {
        var file = e.target.files[0];
        if (!file) return;
        status.textContent = 'Uploading\u2026';
        window.CMSStorage.uploadImage(file, 'categories', function (pct) { status.textContent = 'Uploading\u2026 ' + pct + '%'; })
          .then(function (url) {
            imageInput.value = url;
            preview.src = url;
            preview.classList.add('is-visible');
            status.textContent = 'Uploaded.';
          })
          .catch(function (err) { status.textContent = ''; CMS.toast(err.message, 'error'); });
      });

      modal.querySelector('#cat-cancel').addEventListener('click', CMS.closeModal);
      modal.querySelector('#cat-save').addEventListener('click', function () {
        var name = nameInput.value.trim();
        if (!name) { CMS.toast('Please enter a category name.', 'error'); return; }
        var id = isNew ? (idInput.value.trim() ? CMS.slugify(idInput.value) : CMS.slugify(name)) : c.id;
        if (isNew && CMS.byId(CMS.categories, id)) { CMS.toast('That category ID is already in use \u2014 pick another.', 'error'); return; }

        var payload = {
          name: name,
          eyebrow: modal.querySelector('#f-cat-eyebrow').value.trim(),
          tagline: modal.querySelector('#f-cat-tagline').value.trim(),
          description: modal.querySelector('#f-cat-desc').value.trim(),
          shopLabel: modal.querySelector('#f-cat-shoplabel').value.trim(),
          image: imageInput.value.trim()
        };

        var saveBtn = modal.querySelector('#cat-save');
        saveBtn.disabled = true;
        saveBtn.textContent = 'Saving\u2026';
        db.collection('categories').doc(id).set(payload).then(function () {
          CMS.closeModal();
          loadCategories();
          CMS.toast(isNew ? 'Category added.' : 'Category updated.');
        }).catch(function (err) {
          saveBtn.disabled = false;
          saveBtn.textContent = isNew ? 'Add Category' : 'Save Changes';
          CMS.toast('Could not save: ' + err.message, 'error');
          console.error('[categories] save failed', err);
        });
      });
    });
  }

  function deleteCategory(id) {
    var count = productCount(id);
    if (count > 0) {
      CMS.toast(count + ' product' + (count === 1 ? '' : 's') + ' still use this category \u2014 reassign or delete them first.', 'error');
      return;
    }
    CMS.confirmDialog('Delete this category? This can\u2019t be undone.', { title: 'Delete category?' }).then(function (ok) {
      if (!ok) return;
      db.collection('categories').doc(id).delete().then(function () {
        loadCategories();
        CMS.toast('Category deleted.');
      }).catch(function (err) {
        CMS.toast('Could not delete category: ' + err.message, 'error');
        console.error('[categories] delete failed', err);
      });
    });
  }

  document.getElementById('addCategoryBtn').addEventListener('click', function () { openCategoryModal(null); });
  if (searchEl) {
    searchEl.addEventListener('input', CMS.debounce(function () {
      query = searchEl.value.trim().toLowerCase();
      renderList();
    }, 150));
  }

  document.addEventListener('excoso:authed', function () { loadCategories(); });
  document.addEventListener('excoso:products-updated', function () { renderList(); }); // counts may have changed

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
              var data = Object.assign({}, p); delete data.id;
              data.status = data.status || 'active';
              batch.set(ref, data);
              added++;
            });
            return batch.commit().then(function () { return { added: added, skipped: skipped }; });
          });
        })
        .then(function (result) {
          CMS.toast('Imported ' + result.added + ' item(s). Skipped ' + result.skipped + ' that already existed.');
          loadCategories();
          document.dispatchEvent(new CustomEvent('excoso:authed')); // re-trigger products.js's loader too
        })
        .catch(function (err) {
          CMS.toast('Import failed: ' + err.message, 'error');
          console.error('[import] failed', err);
        })
        .finally(function () {
          btn.disabled = false;
          btn.textContent = 'Import Starter Catalog';
        });
    });
  }

  window.CMSCategories = { loadCategories: loadCategories };
})();
