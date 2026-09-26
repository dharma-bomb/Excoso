/*
  cloudinary.js
  -------------
  All Cloudinary integration lives here. Firebase Storage is not used
  anywhere in this project (no firebase-storage-compat.js is loaded, and
  no code references firebase.storage()) — every image in this CMS is
  uploaded directly from the browser straight to Cloudinary via its
  unsigned upload API, and only the returned secure HTTPS URL is written
  to Firestore.

  Exposes on window.CMS:
    CMS.uploadToCloudinary(file, onProgress) -> Promise<secureUrl>
    CMS.mountImageUploader(container, opts)  -> single-image "Choose Image"
                                                 widget (categories, banners)
    CMS.mountGalleryUploader(container, opts)-> multi-image widget (products)
*/
(function () {
  var CMS = window.CMS;

  function checkConfigured() {
    return typeof CLOUDINARY_CONFIG !== 'undefined' &&
      CLOUDINARY_CONFIG.cloudName &&
      CLOUDINARY_CONFIG.cloudName !== 'YOUR_CLOUD_NAME';
  }

  // ---------- Core upload call ----------
  CMS.uploadToCloudinary = function (file, folder, onProgress) {
    return new Promise(function (resolve, reject) {
      if (!checkConfigured()) {
        reject(new Error('Cloudinary isn\u2019t configured yet \u2014 open js/cloudinary-config.js and fill in your cloud name and unsigned upload preset. See README.md.'));
        return;
      }
      if (!file || !file.type || file.type.indexOf('image/') !== 0) {
        reject(new Error('Please choose an image file (PNG, JPG, WEBP, etc).'));
        return;
      }
      var maxBytes = (CLOUDINARY_CONFIG.maxFileSizeMB || 10) * 1024 * 1024;
      if (file.size > maxBytes) {
        reject(new Error('That image is larger than ' + (CLOUDINARY_CONFIG.maxFileSizeMB || 10) + 'MB \u2014 please choose a smaller file.'));
        return;
      }

      var endpoint = 'https://api.cloudinary.com/v1_1/' + CLOUDINARY_CONFIG.cloudName + '/image/upload';
      var fd = new FormData();
      fd.append('file', file);
      fd.append('upload_preset', CLOUDINARY_CONFIG.uploadPreset);
      var fullFolder = [CLOUDINARY_CONFIG.folderRoot, folder].filter(Boolean).join('/');
      if (fullFolder) fd.append('folder', fullFolder);

      var xhr = new XMLHttpRequest();
      xhr.open('POST', endpoint, true);
      xhr.upload.onprogress = function (ev) {
        if (onProgress && ev.lengthComputable) onProgress(Math.round((ev.loaded / ev.total) * 100));
      };
      xhr.onload = function () {
        var res = null;
        try { res = JSON.parse(xhr.responseText); } catch (e) {}
        if (xhr.status >= 200 && xhr.status < 300 && res && res.secure_url) {
          resolve(res.secure_url);
        } else {
          var msg = (res && res.error && res.error.message) || ('Cloudinary upload failed (HTTP ' + xhr.status + ').');
          reject(new Error(msg));
        }
      };
      xhr.onerror = function () { reject(new Error('Network error while uploading to Cloudinary. Check your connection and try again.')); };
      xhr.send(fd);
    });
  };

  // ---------- Single image "Choose Image" widget ----------
  // opts: { value: string, folder: string, onChange: function(url) }
  CMS.mountImageUploader = function (container, opts) {
    opts = opts || {};
    var value = opts.value || '';
    var folder = opts.folder || '';
    var onChange = opts.onChange || function () {};

    function paint() {
      container.innerHTML =
        '<div class="a-uploader">' +
          '<div class="a-uploader__preview">' + (value ? '<img src="' + CMS.esc(value) + '" alt="">' : '<span>No image</span>') + '</div>' +
          '<div class="a-uploader__controls">' +
            '<label class="a-btn a-btn--ghost a-btn--sm a-uploader__choose">Choose Image<input type="file" accept="image/*" hidden></label>' +
            '<button type="button" class="a-btn a-btn--danger a-btn--sm a-uploader__remove"' + (value ? '' : ' style="display:none;"') + '>Remove</button>' +
            '<span class="a-uploader__status"></span>' +
          '</div>' +
        '</div>';

      var fileInput = container.querySelector('input[type=file]');
      var previewEl = container.querySelector('.a-uploader__preview');
      var removeBtn = container.querySelector('.a-uploader__remove');
      var statusEl = container.querySelector('.a-uploader__status');

      fileInput.addEventListener('change', function () {
        var file = fileInput.files[0];
        fileInput.value = '';
        if (!file) return;
        statusEl.textContent = 'Uploading\u2026 0%';
        CMS.uploadToCloudinary(file, folder, function (pct) { statusEl.textContent = 'Uploading\u2026 ' + pct + '%'; })
          .then(function (url) {
            value = url;
            previewEl.innerHTML = '<img src="' + CMS.esc(url) + '" alt="">';
            removeBtn.style.display = 'inline-flex';
            statusEl.textContent = '\u2713 Uploaded';
            setTimeout(function () { if (statusEl) statusEl.textContent = ''; }, 1800);
            onChange(value);
          })
          .catch(function (err) {
            statusEl.textContent = '\u26a0 ' + err.message;
            statusEl.classList.add('a-uploader__status--error');
            CMS.showErrorBanner(err.message);
          });
      });

      removeBtn.addEventListener('click', function () {
        value = '';
        previewEl.innerHTML = '<span>No image</span>';
        removeBtn.style.display = 'none';
        onChange(value);
      });
    }
    paint();

    return {
      getValue: function () { return value; },
      setValue: function (v) { value = v || ''; paint(); }
    };
  };

  // ---------- Multi-image gallery widget (products) ----------
  // opts: { value: string[], folder: string, onChange: function(urls[]) }
  CMS.mountGalleryUploader = function (container, opts) {
    opts = opts || {};
    var items = (opts.value || []).slice();
    var folder = opts.folder || '';
    var onChange = opts.onChange || function () {};

    function paint() {
      container.innerHTML =
        '<div class="a-gallery">' +
          (items.length ? items.map(function (url, i) {
            return (
              '<div class="a-gallery__item" data-idx="' + i + '">' +
                '<img src="' + CMS.esc(url) + '" alt="">' +
                (i === 0 ? '<span class="a-gallery__primary">Primary</span>' : '') +
                '<button type="button" class="a-gallery__remove" data-idx="' + i + '" title="Remove">\u00d7</button>' +
              '</div>'
            );
          }).join('') : '<p class="a-empty" style="padding:0.6rem 0;">No images yet \u2014 add at least one.</p>') +
        '</div>' +
        '<div class="a-uploader__controls" style="margin-top:0.6rem;">' +
          '<label class="a-btn a-btn--ghost a-btn--sm a-uploader__choose">+ Add Image<input type="file" accept="image/*" hidden></label>' +
          '<span class="a-uploader__status"></span>' +
        '</div>';

      var fileInput = container.querySelector('input[type=file]');
      var statusEl = container.querySelector('.a-uploader__status');

      Array.prototype.forEach.call(container.querySelectorAll('.a-gallery__remove'), function (btn) {
        btn.addEventListener('click', function () {
          items.splice(+btn.dataset.idx, 1);
          paint();
          onChange(items);
        });
      });

      fileInput.addEventListener('change', function () {
        var file = fileInput.files[0];
        fileInput.value = '';
        if (!file) return;
        statusEl.textContent = 'Uploading\u2026 0%';
        CMS.uploadToCloudinary(file, folder, function (pct) { statusEl.textContent = 'Uploading\u2026 ' + pct + '%'; })
          .then(function (url) {
            items.push(url);
            paint();
            onChange(items);
          })
          .catch(function (err) {
            statusEl.textContent = '\u26a0 ' + err.message;
            statusEl.classList.add('a-uploader__status--error');
            CMS.showErrorBanner(err.message);
          });
      });
    }
    paint();

    return {
      getValue: function () { return items.slice(); },
      setValue: function (v) { items = (v || []).slice(); paint(); }
    };
  };
})();
