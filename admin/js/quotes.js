/*
  quotes.js
  ---------
  Quotes CRM page: lists everything submitted through the public site's
  "Get a Quote" form (saved by js/main.js into Firestore's `quotes`
  collection). Visitors can only create documents here (see
  firestore.rules) — reading, updating status, and deleting all require
  you to be logged in.

  Pipeline: New -> Qualified -> Contacted -> Quotation Sent -> Won / Lost
*/
(function () {
  var CMS = window.CMS;
  var listEl = document.getElementById('quoteList');
  var statusFilterEl = document.getElementById('quoteStatusFilter');
  var badgeEl = document.getElementById('newQuoteBadge');
  var quotes = [];

  var STATUSES = ['New', 'Qualified', 'Contacted', 'Quotation Sent', 'Won', 'Lost'];
  var STATUS_CLASS = {
    'New': 'a-pill--new', 'Qualified': 'a-pill--qualified', 'Contacted': 'a-pill--contacted',
    'Quotation Sent': 'a-pill--sent', 'Won': 'a-pill--won', 'Lost': 'a-pill--lost'
  };

  function normalizeStatus(s) {
    // Back-compat with the old lowercase 'new'/'contacted' values.
    if (!s) return 'New';
    if (s === 'new') return 'New';
    if (s === 'contacted') return 'Contacted';
    return STATUSES.indexOf(s) !== -1 ? s : 'New';
  }

  function updateBadge() {
    var newCount = quotes.filter(function (q) { return normalizeStatus(q.status) === 'New'; }).length;
    if (newCount > 0) {
      badgeEl.textContent = newCount;
      badgeEl.style.display = 'inline-block';
    } else {
      badgeEl.style.display = 'none';
    }
  }

  function statusOptionsHtml(current) {
    return STATUSES.map(function (s) {
      return '<option value="' + s + '"' + (s === current ? ' selected' : '') + '>' + s + '</option>';
    }).join('');
  }

  function renderList() {
    var filter = statusFilterEl.value;
    var shown = quotes.filter(function (q) { return !filter || normalizeStatus(q.status) === filter; });

    if (!shown.length) {
      listEl.innerHTML = '<p class="a-empty">' + (quotes.length ? 'No quotes match that status filter.' : 'No quote requests yet.') + '</p>';
      return;
    }

    listEl.innerHTML = shown.map(function (q) {
      var status = normalizeStatus(q.status);
      return (
        '<div class="a-card a-card--quote">' +
          '<div class="a-card__body">' +
            '<div class="a-card__title">' + CMS.esc(q.name) + (q.company ? ' \u2014 ' + CMS.esc(q.company) : '') +
              ' <span class="a-pill ' + (STATUS_CLASS[status] || '') + '">' + status + '</span>' +
            '</div>' +
            '<div class="a-card__meta">' + CMS.fmtDate(q.submittedAt) + '</div>' +
            '<div class="a-quote-details">' +
              '<div><strong>Email:</strong> <a href="mailto:' + CMS.esc(q.email) + '">' + CMS.esc(q.email) + '</a></div>' +
              '<div><strong>Phone:</strong> <a href="tel:' + CMS.esc(q.phone) + '">' + CMS.esc(q.phone) + '</a></div>' +
              '<div><strong>Location:</strong> ' + CMS.esc(q.location) + '</div>' +
              '<div><strong>Product:</strong> ' + CMS.esc(q.product) + '</div>' +
              '<div><strong>Quantity:</strong> ' + CMS.esc(q.quantity) + '</div>' +
            '</div>' +
          '</div>' +
          '<div class="a-card__actions">' +
            '<select class="a-status-select" data-quote-status="' + q.id + '">' + statusOptionsHtml(status) + '</select>' +
            '<button class="a-btn a-btn--danger a-btn--sm" data-delete-quote="' + q.id + '">Delete</button>' +
          '</div>' +
        '</div>'
      );
    }).join('');

    Array.prototype.forEach.call(listEl.querySelectorAll('[data-quote-status]'), function (sel) {
      sel.addEventListener('change', function () { updateStatus(sel.dataset.quoteStatus, sel.value); });
    });
    Array.prototype.forEach.call(listEl.querySelectorAll('[data-delete-quote]'), function (btn) {
      btn.addEventListener('click', function () { deleteQuote(btn.dataset.deleteQuote); });
    });
  }

  function loadQuotes() {
    listEl.innerHTML = '<p class="a-loading">Loading&hellip;</p>';
    return db.collection('quotes').orderBy('submittedAt', 'desc').get().then(function (snap) {
      quotes = snap.docs.map(function (doc) { return Object.assign({ id: doc.id }, doc.data()); });
      renderList();
      updateBadge();
      document.dispatchEvent(new CustomEvent('excoso:quotes-updated', { detail: quotes }));
    }).catch(function (err) {
      listEl.innerHTML = '<p class="a-empty">Could not load quote requests.</p>';
      CMS.showErrorBanner('Failed to load quotes: ' + err.message);
    });
  }

  function updateStatus(id, newStatus) {
    db.collection('quotes').doc(id).update({ status: newStatus }).then(function () {
      var q = CMS.byId(quotes, id);
      if (q) q.status = newStatus;
      renderList();
      updateBadge();
      document.dispatchEvent(new CustomEvent('excoso:quotes-updated', { detail: quotes }));
    }).catch(function (err) {
      CMS.showErrorBanner('Could not update status: ' + err.message);
      loadQuotes();
    });
  }

  function deleteQuote(id) {
    if (!confirm('Delete this quote request? This can\u2019t be undone.')) return;
    db.collection('quotes').doc(id).delete().then(loadQuotes).catch(function (err) {
      CMS.showErrorBanner('Could not delete: ' + err.message);
    });
  }

  statusFilterEl.innerHTML = '<option value="">All statuses</option>' + STATUSES.map(function (s) { return '<option value="' + s + '">' + s + '</option>'; }).join('');
  statusFilterEl.addEventListener('change', renderList);

  document.addEventListener('excoso:authed', function () { loadQuotes(); });
})();
