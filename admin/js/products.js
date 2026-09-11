/*
  products.js
  -----------
  Products tab: load/add/edit/delete against Firestore's `products`
  collection, plus search, category filter, sort, an Active/Inactive
  status, and Firebase Storage image upload (URLs still work too — mix
  and match). Depends on window.CMS (core.js) and CMS.categories being
  populated (categories.js loads it on the same 'excoso:authed' event and
  dispatches 'excoso:categories-updated' whenever that list changes).
*/
(function () {
  var CMS = window.CMS;
  var listEl = document.getElementById('productList');
  var searchEl = document.getElementById('productSearch');
  var filterEl = document.getElementById('productFilter');
  var sortEl = document.getElementById('productSort');
  var state = { q: '', cat: '', sort: 'newest' };

  function renderFilterOptions() {
    var current = filterEl.value;
    filterEl.innerHTML = '<option value="">All categories</option>' + CMS.categories.map(function (c) {
      return '<option value="' + CMS.esc(c.id) + '">' + CMS.esc(c.name) + '</option>';
    }).join('');
    filterEl.value = current;
  }

  function sortList(list) {
    var sorted = list.slice();
    if (state.sort === 'name') sorted.sort(function (a, b) { return a.name.localeCompare(b.name); });
    else if (state.sort === 'price-low') sorted.sort(function (a, b) { return (a.price || 0) - (b.price || 0); });
    else if (state.sort === 'price-high') sorted.sort(function (a, b) { return (b.price || 0) - (a.price || 0); });
    else sorted.sort(function (a, b) { return (b._order || 0) - (a._order || 0); }); // newest first
    return sorted;
  }

  function renderList() {
    var q = state.q.toLowerCase();
    var shown = CMS.products.filter(function (p) {
      var matchesQ = !q || (p.name + ' ' + (p.description || '') + ' ' + (p.id || '')).toLowerCase().indexOf(q) !== -1;
      var matchesCat = !state.cat || p.category === state.cat;
      return matchesQ && matchesCat;
    });
    shown = sortList(shown);

    if (!shown.length) {
      listEl.innerHTML = '<p class="a-empty">' + (CMS.products.length ? 'No products match your filters.' : 'No products yet. Click \u201c+ Add Product\u201d to create your first one.') + '</p>';
      return;
    }
    listEl.innerHTML = shown.map(function (p) {
      var cat = CMS.byId(CMS.categories, p.category);
      var thumb = (p.images && p.images[0]) || '';
      var isActive = p.status !== 'inactive';
      return (
        '<div class="a-card">' +
          '<div class="a-card__thumb">' + (thumb ? '<img src="' + CMS.esc(thumb) + '" alt="">' : 'no photo') + '</div>' +
          '<div class="a-card__body">' +
            '<div class="a-card__title">' + CMS.esc(p.name) +
              (p.featured ? ' <span class="a-pill a-pill--new">Featured</span>' : '') +
              (!isActive ? ' <span class="a-pill">Inactive</span>' : '') +
            '</div>' +
            '<div class="a-card__meta">' + CMS.esc(cat ? cat.name : (p.category || 'uncategorized')) + ' \u00b7 ' + CMS.money(p.price) + ' \u00b7 id: ' + CMS.esc(p.id) + '</div>' +
          '</div>' +
          '<div class="a-card__actions">' +
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
  }

  function loadProducts() {
    listEl.innerHTML = '<p class="a-loading">Loading&hellip;</p>';
    return db.collection('products').get().then(function (snap) {
      CMS.products = snap.docs.map(function (doc, i) { return Object.assign({ id: doc.id, _order: i }, doc.data()); });
      renderList();
      document.dispatchEvent(new CustomEvent('excoso:products-updated', { detail: CMS.products }));
    }).catch(function (err) {
      listEl.innerHTML = '<p class="a-empty">Could not load products.</p>';
      CMS.toast('Failed to load products: ' + err.message, 'error');
      console.error('[products] load failed', err);
    });
  }

  function openProductModal(existing) {
    var isNew = !existing;
    var p = existing ? JSON.parse(JSON.stringify(existing)) : { id: '', name: '', category: (CMS.categories[0] ? CMS.categories[0].id : ''), price: '', description: '', specs: [], images: [], featured: false, status: 'active' };
    var workingImages = (p.images || []).slice();
    var workingSpecs = (p.specs || []).map(function (s) { return { label: s.label || '', value: s.value || '' }; });

    if (!CMS.categories.length) {
      CMS.toast('Add a category first, under the Categories tab.', 'error');
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
        '<div class="a-field"><label class="a-checkbox"><input type="checkbox" id="f-prod-active"' + (p.status !== 'inactive' ? ' checked' : '') + '> Active (visible on the site)</label></div>' +
      '</div>' +
      '<div class="a-field"><label>Images</label><div id="imageRows"></div>' +
        '<div class="a-upload__row" style="margin-top:0.4rem;">' +
          '<input type="file" id="addImageFile" accept="image/*">' +
          '<button type="button" class="a-btn a-btn--ghost a-btn--sm" id="addImageBtn">+ Add Image URL</button>' +
        '</div>' +
        '<p class="a-upload__status" id="prod-upload-status"></p>' +
      '</div>' +
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

      var imageRowsEl = modal.querySelector('#imageRows');
      function renderImageRows() {
        imageRowsEl.innerHTML = workingImages.map(function (url, i) {
          return (
            '<div class="a-image-row" data-idx="' + i + '">' +
              (url ? '<img src="' + CMS.esc(url) + '" alt="">' : '<div class="a-card__thumb" style="width:44px;height:44px;">no photo</div>') +
              '<input type="text" class="img-url-input" data-idx="' + i + '" value="' + CMS.esc(url) + '" placeholder="https://... or upload above">' +
              '<button type="button" class="a-btn a-btn--danger a-btn--sm img-remove-btn" data-idx="' + i + '">Remove</button>' +
            '</div>'
          );
        }).join('') || '<p class="a-empty" style="padding:0.6rem 0;">No images yet \u2014 the site will show a color-block tile instead.</p>';

        Array.prototype.forEach.call(imageRowsEl.querySelectorAll('.img-url-input'), function (input) {
          input.addEventListener('input', function () { workingImages[+input.dataset.idx] = input.value.trim(); });
          input.addEventListener('blur', renderImageRows);
        });
        Array.prototype.forEach.call(imageRowsEl.querySelectorAll('.img-remove-btn'), function (btn) {
          btn.addEventListener('click', function () {
            var removedUrl = workingImages[+btn.dataset.idx];
            workingImages.splice(+btn.dataset.idx, 1);
            renderImageRows();
            window.CMSStorage.deleteImage(removedUrl);
          });
        });
      }
      renderImageRows();
      modal.querySelector('#addImageBtn').addEventListener('click', function () { workingImages.push(''); renderImageRows(); });

      var uploadStatus = modal.querySelector('#prod-upload-status');
      modal.querySelector('#addImageFile').addEventListener('change', function (e) {
        var file = e.target.files[0];
        if (!file) return;
        uploadStatus.textContent = 'Uploading\u2026';
        window.CMSStorage.uploadImage(file, 'products', function (pct) { uploadStatus.textContent = 'Uploading\u2026 ' + pct + '%'; })
          .then(function (url) {
            workingImages.push(url);
            renderImageRows();
            uploadStatus.textContent = 'Uploaded.';
            e.target.value = '';
          })
          .catch(function (err) { uploadStatus.textContent = ''; CMS.toast(err.message, 'error'); });
      });

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
        var price = Number(modal.querySelector('#f-prod-price').value);
        if (!name) { CMS.toast('Please enter a product name.', 'error'); return; }
        if (!modal.querySelector('#f-prod-cat').value) { CMS.toast('Please choose a category.', 'error'); return; }
        if (isNaN(price) || price < 0) { CMS.toast('Please enter a valid price (0 or more).', 'error'); return; }
        var id = isNew ? (idInput.value.trim() ? CMS.slugify(idInput.value) : CMS.slugify(name)) : p.id;
        if (isNew && CMS.byId(CMS.products, id)) { CMS.toast('That product ID is already in use \u2014 pick another.', 'error'); return; }

        var payload = {
          name: name,
          category: modal.querySelector('#f-prod-cat').value,
          price: price,
          description: modal.querySelector('#f-prod-desc').value.trim(),
          featured: modal.querySelector('#f-prod-featured').checked,
          status: modal.querySelector('#f-prod-active').checked ? 'active' : 'inactive',
          specs: workingSpecs.filter(function (s) { return s.label.trim() || s.value.trim(); }),
          images: workingImages.filter(function (url) { return url && url.trim(); })
        };

        var saveBtn = modal.querySelector('#prod-save');
        saveBtn.disabled = true;
        saveBtn.textContent = 'Saving\u2026';
        db.collection('products').doc(id).set(payload).then(function () {
          CMS.closeModal();
          loadProducts();
          CMS.toast(isNew ? 'Product added.' : 'Product updated.');
        }).catch(function (err) {
          saveBtn.disabled = false;
          saveBtn.textContent = isNew ? 'Add Product' : 'Save Changes';
          CMS.toast('Could not save: ' + err.message, 'error');
          console.error('[products] save failed', err);
        });
      });
    });
  }

  function deleteProduct(id) {
    var p = CMS.byId(CMS.products, id);
    CMS.confirmDialog('Delete "' + (p ? p.name : id) + '"? This can\u2019t be undone.', { title: 'Delete product?' }).then(function (ok) {
      if (!ok) return;
      var images = (p && p.images) || [];
      db.collection('products').doc(id).delete().then(function () {
        images.forEach(function (url) { window.CMSStorage.deleteImage(url); });
        loadProducts();
        CMS.toast('Product deleted.');
      }).catch(function (err) {
        CMS.toast('Could not delete product: ' + err.message, 'error');
        console.error('[products] delete failed', err);
      });
    });
  }

  document.getElementById('addProductBtn').addEventListener('click', function () { openProductModal(null); });
  filterEl.addEventListener('change', function () { state.cat = filterEl.value; renderList(); });
  if (searchEl) searchEl.addEventListener('input', CMS.debounce(function () { state.q = searchEl.value.trim(); renderList(); }, 150));
  if (sortEl) sortEl.addEventListener('change', function () { state.sort = sortEl.value; renderList(); });

  document.addEventListener('excoso:authed', function () { loadProducts(); });
  document.addEventListener('excoso:categories-updated', function () {
    renderFilterOptions();
    renderList();
  });

  window.CMSProducts = { loadProducts: loadProducts };
})();
