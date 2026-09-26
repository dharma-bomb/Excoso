/*
  dashboard.js
  ------------
  Dashboard page: summary cards only (Total Products, Total Categories,
  Total Quotes, New Quotes, Won Deals). Reads counts straight from
  Firestore on load, then keeps in sync with the live caches other pages
  populate (CMS.categories, CMS.products) and the quotes list.
*/
(function () {
  var CMS = window.CMS;
  var els = {
    totalProducts: document.getElementById('statTotalProducts'),
    totalCategories: document.getElementById('statTotalCategories'),
    totalQuotes: document.getElementById('statTotalQuotes'),
    newQuotes: document.getElementById('statNewQuotes'),
    wonDeals: document.getElementById('statWonDeals')
  };
  var quotesCache = [];

  function normalizeStatus(s) {
    if (!s) return 'New';
    if (s === 'new') return 'New';
    if (s === 'contacted') return 'Contacted';
    return s;
  }

  function render() {
    if (els.totalProducts) els.totalProducts.textContent = CMS.products.length;
    if (els.totalCategories) els.totalCategories.textContent = CMS.categories.length;
    if (els.totalQuotes) els.totalQuotes.textContent = quotesCache.length;
    if (els.newQuotes) els.newQuotes.textContent = quotesCache.filter(function (q) { return normalizeStatus(q.status) === 'New'; }).length;
    if (els.wonDeals) els.wonDeals.textContent = quotesCache.filter(function (q) { return normalizeStatus(q.status) === 'Won'; }).length;
  }

  function loadInitialCounts() {
    Promise.all([
      db.collection('products').get(),
      db.collection('categories').get(),
      db.collection('quotes').get()
    ]).then(function (results) {
      if (!CMS.products.length) CMS.products = results[0].docs.map(function (d) { return Object.assign({ id: d.id }, d.data()); });
      if (!CMS.categories.length) CMS.categories = results[1].docs.map(function (d) { return Object.assign({ id: d.id }, d.data()); });
      quotesCache = results[2].docs.map(function (d) { return Object.assign({ id: d.id }, d.data()); });
      render();
    }).catch(function (err) {
      CMS.showErrorBanner('Could not load dashboard stats: ' + err.message);
    });
  }

  document.addEventListener('excoso:authed', function () { loadInitialCounts(); });
  document.addEventListener('excoso:categories-updated', render);
  document.addEventListener('excoso:products-updated', render);
  document.addEventListener('excoso:quotes-updated', function (ev) { quotesCache = ev.detail || quotesCache; render(); });
})();
