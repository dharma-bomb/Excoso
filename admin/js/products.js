/*
  products.js
  -----------
  Products page: loading, add/edit/delete against Firestore's `products`
  collection, plus search, category filter, and a Featured/Active toggle
  on every card. Depends on window.CMS (core.js) and on CMS.categories
  being populated (categories.js loads categories on the same
  'excoso:authed' event and dispatches 'excoso:categories-updated'
  whenever that list changes).

  Images are uploaded straight to Cloudinary (see cloudinary.js) — the
  first image in the gallery is the product's primary/listing image.
*/
(function () {
  var CMS = window.CMS;
  var listEl = document.getElementById('productList');
  var filterEl = document.getElementById('productFilter');
  var searchEl = document.getElementById('productSearch');

  function renderFilterOptions() {
    var current = filterEl.value;
    filterEl.innerHTML = '<option value="">All categories</option>' + CMS.categories.map(function (c) {
      return '<option value="' + CMS.esc(c.id) + '">' + CMS.esc(c.name) + '</option>';
    }).join('');
    filterEl.value = current;
  }

  function renderList() {
    var filter = filterEl.value;
    var query = (searchEl.value || '').trim().toLowerCase();
    var shown = CMS.products.filter(function (p) {
      var matchesCat = !filter || p.category === filter;
      var matchesQuery = !query || (p.name + ' ' + (p.description || '')).toLowerCase().indexOf(query) !== -1;
      return matchesCat && matchesQuery;
    });
    if (!shown.length) {
      listEl.innerHTML = '<p class="a-empty">' + (CMS.products.length ? 'No products match that search/filter.' : 'No products yet. Click "+ Add Product" to create your first one.') + '</p>';
      return;
    }
    listEl.innerHTML = shown.map(function (p) {
      var cat = CMS.byId(CMS.categories, p.category);
      var thumb = (p.images && p.images[0]) || '';
      var active = p.active !== false; // default true for legacy docs without the field
      return (
        '<div class="a-card' + (active ? '' : ' a-card--inactive') + '">' +
          '<div class="a-card__thumb">' + (thumb ? '<img src="' + CMS.esc(thumb) + '" alt="">' : 'no photo') + '</div>' +
          '<div class="a-card__body">' +
            '<div class="a-card__title">' + CMS.esc(p.name) + (p.featured ? ' <span class="a-pill a-pill--featured">\u2605 Featured</span>' : '') +
              (!active ? ' <span class="a-pill a-pill--inactive">Inactive</span>' : '') +
            '</div>' +
            '<div class="a-card__meta">' + CMS.esc(cat ? cat.name : (p.category || 'uncategorized')) + ' \u00b7 ' + CMS.money(p.price) + ' \u00b7 id: ' + CMS.esc(p.id) + '</div>' +
          '</div>' +
          '<div class="a-card__actions">' +
            '<label class="a-toggle" title="Featured on homepage">' +
              '<input type="checkbox" data-toggle-featured="' + CMS.esc(p.id) + '"' + (p.featured ? ' checked' : '') + '><span class="a-toggle__track"></span><span class="a-toggle__label">Featured</span>' +
            '</label>' +
            '<label class="a-toggle" title="Visible on the public site">' +
              '<input type="checkbox" data-toggle-active="' + CMS.esc(p.id) + '"' + (active ? ' checked' : '') + '><span class="a-toggle__track"></span><span class="a-toggle__label">Active</span>' +
            '</label>' +
            '<button class="a-btn a-btn--ghost a-btn--sm" data-edit-prod="' + CMS.esc(p.id) + '">Edit</button>' +
            '<button class="a-btn a-btn--danger a-btn--sm" data-delete-prod="' + CMS.esc(p.id) + '">Delete</button>' +
          '</div>' +
        '</div>'
      );
    }).join('');
    Array.prototype.forEach.call(listEl.querySelectorAll('[data-edit-prod]'), function (btn) {
      btn.addEventListener('click', function () { openProductModal(CMS.byId(CMS.products, btn.dataset.editProd)); });
    });
    Array.prototype.forEach.call(listEl.querySelectorAll('[data-delete-prod]'), function (btn) {
      btn.addEventListener('click', function () { deleteProduct(btn.dataset.deleteProd); });
    });
    Array.prototype.forEach.call(listEl.querySelectorAll('[data-toggle-featured]'), function (input) {
      input.addEventListener('change', function () { quickUpdate(input.dataset.toggleFeatured, { featured: input.checked }); });
    });
    Array.prototype.forEach.call(listEl.querySelectorAll('[data-toggle-active]'), function (input) {
      input.addEventListener('change', function () { quickUpdate(input.dataset.toggleActive, { active: input.checked }); });
    });
  }

  function quickUpdate(id, patch) {
    db.collection('products').doc(id).update(patch).then(function () {
      var p = CMS.byId(CMS.products, id);
      if (p) Object.assign(p, patch);
      renderList();
    }).catch(function (err) {
      CMS.showErrorBanner('Could not update product: ' + err.message);
      loadProducts();
    });
  }

  function loadProducts() {
    listEl.innerHTML = '<p class="a-loading">Loading&hellip;</p>';
    return db.collection('products').get().then(function (snap) {
      CMS.products = snap.docs.map(function (doc) { return Object.assign({ id: doc.id }, doc.data()); });
      renderList();
      document.dispatchEvent(new CustomEvent('excoso:products-updated', { detail: CMS.products }));
    }).catch(function (err) {
      listEl.innerHTML = '<p class="a-empty">Could not load products.</p>';
      CMS.showErrorBanner('Failed to load products: ' + err.message);
    });
  }

  function openProductModal(existing) {
    var isNew = !existing;
    var p = existing ? JSON.parse(JSON.stringify(existing)) : { id: '', name: '', category: (CMS.categories[0] ? CMS.categories[0].id : ''), price: '', description: '', specs: [], images: [], featured: false, active: true };
    var workingSpecs = (p.specs || []).map(function (s) { return { label: s.label || '', value: s.value || '' }; });

    if (!CMS.categories.length) {
      alert('Add a category first, under the Categories page.');
      return;
    }

    var catOptions = CMS.categories.map(function (c) {
      return '<option value="' + CMS.esc(c.id) + '"' + (c.id === p.category ? ' selected' : '') + '>' + CMS.esc(c.name) + '</option>';
    }).join('');

    var html =
      '<h3>' + (isNew ? 'Add Product' : 'Edit Product') + '</h3>' +
      '<div class="a-field-row">' +
        '<div class="a-field"><label>Name</label><input type="text" id="f-prod-name" value="' + CMS.esc(p.name) + '" placeholder="e.g. Zenso Backpack"></div>' +
        '<div class="a-field"><label>Product ID</label><input type="text" id="f-prod-id" value="' + CMS.esc(p.id) + '"' + (isNew ? '' : ' disabled') + '></div>' +
      '</div>' +
      '<div class="a-field-row">' +
        '<div class="a-field"><label>Category</label><select id="f-prod-cat">' + catOptions + '</select></div>' +
        '<div class="a-field"><label>Price (\u20B9)</label><input type="number" id="f-prod-price" min="0" step="1" value="' + CMS.esc(p.price) + '"></div>' +
      '</div>' +
      '<div class="a-field"><label>Description</label><textarea id="f-prod-desc">' + CMS.esc(p.description) + '</textarea></div>' +
      '<div class="a-field-row">' +
        '<div class="a-field"><label class="a-checkbox"><input type="checkbox" id="f-prod-featured"' + (p.featured ? ' checked' : '') + '> Featured in "The Edit" on the homepage</label></div>' +
        '<div class="a-field"><label class="a-checkbox"><input type="checkbox" id="f-prod-active"' + (p.active !== false ? ' checked' : '') + '> Active (visible on the public site)</label></div>' +
      '</div>' +
      '<div class="a-field"><label>Product Images</label><div id="prodGalleryUploader"></div></div>' +
      '<div class="a-field"><label>Specs (optional)</label><div id="specRows"></div>' +
        '<button type="button" class="a-btn a-btn--ghost a-btn--sm" id="addSpecBtn">+ Add Spec</button></div>' +
      '<div class="a-modal__actions">' +
        '<button class="a-btn a-btn--ghost a-btn--sm" id="prod-cancel">Cancel</button>' +
        '<button class="a-btn a-btn--solid" id="prod-save">' + (isNew ? 'Add Product' : 'Save Changes') + '</button>' +
      '</div>';

    CMS.openModal(html, function (modal) {
      var nameInput = modal.querySelector('#f-prod-name');
      var idInput = modal.querySelector('#f-prod-id');
      var idTouched = !isNew;
      nameInput.addEventListener('input', function () { if (!idTouched) idInput.value = CMS.slugify(nameInput.value); });
      idInput.addEventListener('input', function () { idTouched = true; });

      // Fault-isolated: if the Cloudinary uploader fails to mount (bad
      // config, network hiccup, etc.), fall back to keeping whatever
      // images the product already has, instead of letting the error
      // stop every line of setup below it — which was silently breaking
      // the Specs button and the Save button.
      var galleryUploader = { getValue: function () { return p.images || []; } };
      try {
        var mounted = CMS.mountGalleryUploader(modal.querySelector('#prodGalleryUploader'), {
          value: p.images || [], folder: 'products', onChange: function () {}
        });
        if (mounted && typeof mounted.getValue === 'function') galleryUploader = mounted;
      } catch (err) {
        console.error('[products] gallery uploader failed to mount:', err);
        var uploaderEl = modal.querySelector('#prodGalleryUploader');
        if (uploaderEl) uploaderEl.innerHTML = '<p class="a-empty">Image uploader failed to load \u2014 existing images were kept as-is. Check the console for details.</p>';
      }

      var specRowsEl = modal.querySelector('#specRows');
      function renderSpecRows() {
        specRowsEl.innerHTML = workingSpecs.map(function (s, i) {
          return (
            '<div class="a-spec-row" data-idx="' + i + '">' +
              '<input type="text" class="spec-label-input" data-idx="' + i + '" placeholder="Label, e.g. Capacity" value="' + CMS.esc(s.label) + '">' +
              '<input type="text" class="spec-value-input" data-idx="' + i + '" placeholder="Value, e.g. 28 Litres" value="' + CMS.esc(s.value) + '">' +
              '<button type="button" class="a-btn a-btn--danger a-btn--sm spec-remove-btn" data-idx="' + i + '">\u00d7</button>' +
            '</div>'
          );
        }).join('');
        Array.prototype.forEach.call(specRowsEl.querySelectorAll('.spec-label-input'), function (input) {
          input.addEventListener('input', function () { workingSpecs[+input.dataset.idx].label = input.value; });
        });
        Array.prototype.forEach.call(specRowsEl.querySelectorAll('.spec-value-input'), function (input) {
          input.addEventListener('input', function () { workingSpecs[+input.dataset.idx].value = input.value; });
        });
        Array.prototype.forEach.call(specRowsEl.querySelectorAll('.spec-remove-btn'), function (btn) {
          btn.addEventListener('click', function () { workingSpecs.splice(+btn.dataset.idx, 1); renderSpecRows(); });
        });
      }
      renderSpecRows();
      modal.querySelector('#addSpecBtn').addEventListener('click', function () { workingSpecs.push({ label: '', value: '' }); renderSpecRows(); });

      modal.querySelector('#prod-cancel').addEventListener('click', CMS.closeModal);
      modal.querySelector('#prod-save').addEventListener('click', function () {
        var name = nameInput.value.trim();
        if (!name) { alert('Please enter a product name.'); return; }
        var id = isNew ? (idInput.value.trim() ? CMS.slugify(idInput.value) : CMS.slugify(name)) : p.id;
        if (isNew && CMS.byId(CMS.products, id)) { alert('That product ID is already in use \u2014 pick another.'); return; }

        var images = galleryUploader.getValue();
        var payload = {
          name: name,
          category: modal.querySelector('#f-prod-cat').value,
          price: Number(modal.querySelector('#f-prod-price').value) || 0,
          description: modal.querySelector('#f-prod-desc').value.trim(),
          featured: modal.querySelector('#f-prod-featured').checked,
          active: modal.querySelector('#f-prod-active').checked,
          specs: workingSpecs.filter(function (s) { return s.label.trim() || s.value.trim(); }),
          images: images,
          image: images[0] || '' // primary image, convenience field for simple lookups
        };

        var saveBtn = modal.querySelector('#prod-save');
        saveBtn.disabled = true;
        saveBtn.textContent = 'Saving\u2026';
        db.collection('products').doc(id).set(payload).then(function () {
          CMS.closeModal();
          CMS.showToast(isNew ? 'Product added' : 'Product saved');
          loadProducts();
        }).catch(function (err) {
          saveBtn.disabled = false;
          saveBtn.textContent = isNew ? 'Add Product' : 'Save Changes';
          alert('Could not save: ' + err.message);
        });
      });
    });
  }

  function deleteProduct(id) {
    if (!confirm('Delete this product? This can\u2019t be undone.')) return;
    db.collection('products').doc(id).delete().then(loadProducts).catch(function (err) {
      CMS.showErrorBanner('Could not delete product: ' + err.message);
    });
  }

  document.getElementById('addProductBtn').addEventListener('click', function () { openProductModal(null); });
  filterEl.addEventListener('change', renderList);
  searchEl.addEventListener('input', renderList);

  document.addEventListener('excoso:authed', function () { loadProducts(); });
  document.addEventListener('excoso:categories-updated', function () {
    renderFilterOptions();
    renderList(); // category names shown per product may have changed
  });
})();
