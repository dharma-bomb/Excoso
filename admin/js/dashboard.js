/*
  dashboard.js
  ------------
  The Dashboard tab: live counts pulled straight from Firestore whenever
  it's the active tab (and refreshed after any save elsewhere, via the
  excoso:*-updated events other modules already dispatch).
*/
(function () {
  var CMS = window.CMS;
  var els = {
    products: document.getElementById('statTotalProducts'),
    categories: document.getElementById('statTotalCategories'),
    quotes: document.getElementById('statTotalQuotes'),
    newQuotes: document.getElementById('statNewQuotes'),
    contacted: document.getElementById('statContactedQuotes'),
    thisMonth: document.getElementById('statThisMonthQuotes')
  };
  var grid = document.getElementById('dashboardStats');
  if (!grid) return;

  function isThisMonth(ts) {
    if (!ts || typeof ts.toDate !== 'function') return false;
    var d = ts.toDate();
    var now = new Date();
    return d.getFullYear() === now.getFullYear() && d.getMonth() === now.getMonth();
  }

  function render() {
    var quotes = (window.CMSQuotes && window.CMSQuotes.quotes) || [];
    els.products.textContent = CMS.products.length;
    els.categories.textContent = CMS.categories.length;
    els.quotes.textContent = quotes.length;
    els.newQuotes.textContent = quotes.filter(function (q) { return (q.status || 'new') === 'new'; }).length;
    els.contacted.textContent = quotes.filter(function (q) { return q.status === 'contacted' || q.status === 'quotation_sent'; }).length;
    els.thisMonth.textContent = quotes.filter(function (q) { return isThisMonth(q.submittedAt); }).length;
  }

  document.addEventListener('excoso:products-updated', render);
  document.addEventListener('excoso:categories-updated', render);
  document.addEventListener('excoso:quotes-updated', render);
  document.addEventListener('excoso:authed', function () {
    // initial render happens once products/categories/quotes finish loading
    // (each dispatches its own *-updated event above), but show zeros
    // immediately rather than a blank flash.
    render();
  });
})();
