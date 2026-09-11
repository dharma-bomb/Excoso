/*
  quotes.js
  ---------
  Quotes tab, upgraded into a small CRM: lists everything submitted
  through the public site's "Get a Quote" form (saved by js/main.js into
  Firestore's `quotes` collection). Visitors can only create documents
  here (see firestore.rules) — reading, updating status/notes, and
  deleting all require you to be logged in.

  Status pipeline: new -> qualified -> contacted -> quotation_sent ->
  won / lost. Free-text notes and an optional follow-up date are stored
  per quote so nothing has to be tracked in a separate spreadsheet.
*/
(function () {
  var CMS = window.CMS;
  var STATUSES = [
    { id: 'new', label: 'New' },
    { id: 'qualified', label: 'Qualified' },
    { id: 'contacted', label: 'Contacted' },
    { id: 'quotation_sent', label: 'Quotation Sent' },
    { id: 'won', label: 'Won' },
    { id: 'lost', label: 'Lost' }
  ];
  function statusLabel(id) { var s = STATUSES.filter(function (x) { return x.id === id; })[0]; return s ? s.label : id; }

  var listEl = document.getElementById('quoteList');
  var searchEl = document.getElementById('quoteSearch');
  var statusFilterEl = document.getElementById('quoteStatusFilter');
  var badgeEl = document.getElementById('newQuoteBadge');
  var quotes = [];
  var state = { q: '', status: '' };

  function updateBadge() {
    var newCount = quotes.filter(function (q) { return (q.status || 'new') === 'new'; }).length;
    if (newCount > 0) { badgeEl.textContent = newCount; badgeEl.style.display = 'inline-block'; }
    else { badgeEl.style.display = 'none'; }
    document.dispatchEvent(new CustomEvent('excoso:quotes-updated', { detail: quotes }));
  }

  function renderStatusFilterOptions() {
    statusFilterEl.innerHTML = '<option value="">All statuses</option>' + STATUSES.map(function (s) {
      return '<option value="' + s.id + '">' + s.label + '</option>';
    }).join('');
  }

  function renderList() {
    var q = state.q.toLowerCase();
    var shown = quotes.filter(function (item) {
      var matchesQ = !q || (item.name + ' ' + (item.company || '') + ' ' + (item.email || '') + ' ' + (item.phone || '')).toLowerCase().indexOf(q) !== -1;
      var matchesStatus = !state.status || (item.status || 'new') === state.status;
      return matchesQ && matchesStatus;
    });

    if (!shown.length) {
      listEl.innerHTML = '<p class="a-empty">' + (quotes.length ? 'No quote requests match your filters.' : 'No quote requests yet.') + '</p>';
      return;
    }

    listEl.innerHTML = shown.map(function (item) {
      var status = item.status || 'new';
      var statusOptions = STATUSES.map(function (s) {
        return '<option value="' + s.id + '"' + (s.id === status ? ' selected' : '') + '>' + s.label + '</option>';
      }).join('');
      return (
        '<div class="a-card a-card--quote">' +
          '<div class="a-card__body">' +
            '<div class="a-card__title">' + CMS.esc(item.name) + (item.company ? ' \u2014 ' + CMS.esc(item.company) : '') +
              ' <span class="a-pill' + (status === 'new' ? ' a-pill--new' : '') + '">' + statusLabel(status) + '</span>' +
            '</div>' +
            '<div class="a-card__meta">' + CMS.formatDate(item.submittedAt) + (item.followUpDate ? ' \u00b7 follow up ' + CMS.esc(item.followUpDate) : '') + '</div>' +
            '<div class="a-quote-details">' +
              '<div><strong>Email:</strong> <a href="mailto:' + CMS.esc(item.email) + '">' + CMS.esc(item.email) + '</a></div>' +
              '<div><strong>Phone:</strong> <a href="tel:' + CMS.esc(item.phone) + '">' + CMS.esc(item.phone) + '</a></div>' +
              '<div><strong>Location:</strong> ' + CMS.esc(item.location) + '</div>' +
              '<div><strong>Product:</strong> ' + CMS.esc(item.product) + '</div>' +
              '<div><strong>Quantity:</strong> ' + CMS.esc(item.quantity) + '</div>' +
            '</div>' +
            '<div class="a-quote-controls">' +
              '<label>Status<select class="q-status-select" data-id="' + item.id + '">' + statusOptions + '</select></label>' +
              '<label>Follow-up date<input type="date" class="q-followup-input" data-id="' + item.id + '" value="' + CMS.esc(item.followUpDate || '') + '"></label>' +
            '</div>' +
            '<div class="a-field" style="margin-top:0.6rem;margin-bottom:0;">' +
              '<label>Notes</label>' +
              '<textarea class="q-notes-input" data-id="' + item.id + '" placeholder="Call notes, next steps\u2026">' + CMS.esc(item.notes || '') + '</textarea>' +
            '</div>' +
          '</div>' +
          '<div class="a-card__actions">' +
            '<button class="a-btn a-btn--ghost a-btn--sm q-save-btn" data-id="' + item.id + '">Save</button>' +
            '<button class="a-btn a-btn--danger a-btn--sm" data-delete-quote="' + item.id + '">Delete</button>' +
          '</div>' +
        '</div>'
      );
    }).join('');

    Array.prototype.forEach.call(listEl.querySelectorAll('.q-save-btn'), function (btn) {
      btn.addEventListener('click', function () { saveQuoteRow(btn.dataset.id); });
    });
    Array.prototype.forEach.call(listEl.querySelectorAll('[data-delete-quote]'), function (btn) {
      btn.addEventListener('click', function () { deleteQuote(btn.dataset.deleteQuote); });
    });
  }

  function saveQuoteRow(id) {
    var card = listEl.querySelector('.q-save-btn[data-id="' + id + '"]').closest('.a-card');
    var status = card.querySelector('.q-status-select').value;
    var followUpDate = card.querySelector('.q-followup-input').value;
    var notes = card.querySelector('.q-notes-input').value;
    var btn = card.querySelector('.q-save-btn');
    btn.disabled = true; btn.textContent = 'Saving\u2026';
    db.collection('quotes').doc(id).update({ status: status, followUpDate: followUpDate, notes: notes })
      .then(function () {
        CMS.toast('Saved.');
        loadQuotes();
      })
      .catch(function (err) {
        CMS.toast('Could not save: ' + err.message, 'error');
        console.error('[quotes] update failed', err);
      })
      .finally(function () { btn.disabled = false; btn.textContent = 'Save'; });
  }

  function loadQuotes() {
    listEl.innerHTML = '<p class="a-loading">Loading&hellip;</p>';
    return db.collection('quotes').orderBy('submittedAt', 'desc').get().then(function (snap) {
      quotes = snap.docs.map(function (doc) { return Object.assign({ id: doc.id }, doc.data()); });
      renderList();
      updateBadge();
    }).catch(function (err) {
      listEl.innerHTML = '<p class="a-empty">Could not load quote requests.</p>';
      CMS.toast('Failed to load quotes: ' + err.message, 'error');
      console.error('[quotes] load failed', err);
    });
  }

  function deleteQuote(id) {
    CMS.confirmDialog('Delete this quote request? This can\u2019t be undone.', { title: 'Delete quote?' }).then(function (ok) {
      if (!ok) return;
      db.collection('quotes').doc(id).delete().then(function () {
        loadQuotes();
        CMS.toast('Quote deleted.');
      }).catch(function (err) {
        CMS.toast('Could not delete: ' + err.message, 'error');
        console.error('[quotes] delete failed', err);
      });
    });
  }

  renderStatusFilterOptions();
  if (searchEl) searchEl.addEventListener('input', CMS.debounce(function () { state.q = searchEl.value.trim(); renderList(); }, 150));
  statusFilterEl.addEventListener('change', function () { state.status = statusFilterEl.value; renderList(); });

  document.addEventListener('excoso:authed', function () { loadQuotes(); });

  window.CMSQuotes = { loadQuotes: loadQuotes, STATUSES: STATUSES, get quotes() { return quotes; } };
})();
