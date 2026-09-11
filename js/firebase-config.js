/*
  firebase-config.js
  ------------------
  Shared by both the public site (index.html / catalog.html) and the admin
  panel (admin/index.html). Loaded AFTER the Firebase compat SDK <script>
  tags and BEFORE any other app script on every page that uses it.

  ============================================================================
  REPLACE THE VALUES BELOW with your own project's config before this will
  do anything. To get them:
    1. Go to https://console.firebase.google.com and create a project
       (the free "Spark" plan is enough for this site).
    2. Project settings (gear icon) -> General -> "Your apps" -> click the
       web icon (</>) -> register an app (any nickname) -> Firebase Hosting
       checkbox can stay unchecked, you don't need it for this.
    3. It will show you a `firebaseConfig` object exactly like the shape
       below — copy those real values in here.
  These values are NOT secret — Firebase's security model relies on
  Firestore Security Rules and Authentication, not on hiding this config.
  It's normal and expected for it to be visible in your public site's code.
  ============================================================================
*/
// For Firebase JS SDK v7.20.0 and later, measurementId is optional
const firebaseConfig = {
  apiKey: "AIzaSyA9loajRGsQ4LyiqUmSH-XKfpLz7S57CGE",
  authDomain: "excoso.firebaseapp.com",
  databaseURL: "https://excoso-default-rtdb.firebaseio.com",
  projectId: "excoso",
  storageBucket: "excoso.firebasestorage.app",
  messagingSenderId: "971330358995",
  appId: "1:971330358995:web:a9e5c72049d2a6aa438e26",
  measurementId: "G-TMMNH6LK6Y"
};

var firebaseReady = false;
try {
  if (firebaseConfig.apiKey !== "YOUR_API_KEY" && typeof firebase !== 'undefined') {
    firebase.initializeApp(firebaseConfig);
    firebaseReady = true;
  }
} catch (e) {
  console.warn('Firebase did not initialize:', e);
  firebaseReady = false;
}

// Shared handles other scripts use. Guarded so pages that haven't set up
// Firebase yet don't throw — they just fall back to static-file behavior
// (see js/catalog.js on the public site, and the "not configured" banner
// in admin/js/main.js). `storage` is only meaningful on pages that also
// load the firebase-storage-compat.js script tag (currently just
// admin/index.html) — on other pages `firebase.storage` won't exist, so
// this is guarded to stay `null` there instead of throwing.
var db = firebaseReady ? firebase.firestore() : null;
var auth = firebaseReady ? firebase.auth() : null;
var storage = (firebaseReady && typeof firebase.storage === 'function') ? firebase.storage() : null;
