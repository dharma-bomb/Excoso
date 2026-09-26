/*
  cloudinary-config.js
  ---------------------
  Shared Cloudinary config, loaded by admin/index.html (image uploads) only.
  Not loaded on the public site — the public site only ever displays the
  secure_url strings that get saved to Firestore, it never uploads.

  ============================================================================
  REPLACE THE VALUES BELOW with your own Cloudinary account before uploads
  will work:
    1. Create a free account at https://cloudinary.com
    2. Dashboard -> copy your "Cloud name" -> paste into cloudName below.
    3. Settings (gear icon) -> Upload -> "Upload presets" -> Add upload
       preset -> set "Signing Mode" to UNSIGNED -> Save -> copy its name
       into uploadPreset below.
       (Unsigned presets are required because uploads happen directly from
       the browser with no backend/server — the admin's Firebase Auth
       session is what already protects who can reach the upload button;
       Cloudinary's own preset just controls what/how it accepts.)
    4. Optional: set an upload preset "Folder" or leave `folder` below to
       auto-organize uploads into cloud > excoso > products etc.
  These values are not secret in the sense of needing to be hidden — like
  Firebase's config above, an unsigned upload preset is meant to be public;
  restrict what it accepts (image-only, max file size, allowed formats)
  from the preset's settings in the Cloudinary console.
  ============================================================================
*/
var CLOUDINARY_CONFIG = {
  cloudName: "YOUR_CLOUD_NAME",
  uploadPreset: "excoso_unsigned",
  // Uploads are auto-sorted into subfolders of this root, e.g.
  // excoso/products, excoso/categories, excoso/banners.
  folderRoot: "excoso",
  maxFileSizeMB: 10
};
