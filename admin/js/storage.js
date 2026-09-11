/*
  storage.js
  ----------
  Thin wrapper around Firebase Storage for product/category image uploads.
  Falls back gracefully (rejects with a clear error) if Storage isn't
  available — e.g. the storage-compat SDK script tag is missing, or the
  Firebase project is still on a plan without Storage enabled.
*/
window.CMSStorage = (function () {
  function available() {
    return typeof firebaseReady !== 'undefined' && firebaseReady && typeof storage !== 'undefined' && !!storage;
  }

  // folder: 'products' | 'categories'. Returns a Promise<downloadURL>.
  function uploadImage(file, folder, onProgress) {
    if (!available()) return Promise.reject(new Error('Firebase Storage isn\u2019t set up yet (see README.md).'));
    if (!file || !/^image\//.test(file.type)) return Promise.reject(new Error('Please choose an image file.'));
    if (file.size > 5 * 1024 * 1024) return Promise.reject(new Error('Images must be under 5MB.'));

    var ext = (file.name.split('.').pop() || 'jpg').toLowerCase().replace(/[^a-z0-9]/g, '') || 'jpg';
    var path = folder + '/' + Date.now() + '-' + Math.random().toString(36).slice(2, 8) + '.' + ext;
    var ref = storage.ref().child(path);
    var task = ref.put(file, { contentType: file.type });

    return new Promise(function (resolve, reject) {
      task.on('state_changed', function (snap) {
        if (onProgress) onProgress(Math.round((snap.bytesTransferred / snap.totalBytes) * 100));
      }, function (err) {
        reject(new Error('Upload failed: ' + err.message));
      }, function () {
        task.snapshot.ref.getDownloadURL().then(resolve).catch(reject);
      });
    });
  }

  // Best-effort delete — only works for URLs that are actually Firebase
  // Storage download URLs (pasted external URLs are silently skipped).
  function deleteImage(url) {
    if (!available() || !url || url.indexOf('firebasestorage') === -1) return Promise.resolve();
    return storage.refFromURL(url).delete().catch(function (err) {
      console.warn('Could not delete storage file (may already be gone):', err.message);
    });
  }

  return { available: available, uploadImage: uploadImage, deleteImage: deleteImage };
})();
