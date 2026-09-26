/*
  core.js
  -------
  Shared CMS namespace: helpers (esc/slugify/money/byId), the modal system,
  the error banner, and live in-memory caches that other admin modules read
  from (categories, products). Loaded first, before every other admin/js/*
  file.
*/
window.CMS = (function () {
  function slugify(str) {
    return String(str || '')
      .toLowerCase().trim()
      .replace(/[^a-z0-9]+/g, '-')
      .replace(/^-+|-+$/g, '') || 'item';
  }
  function esc(s) {
    return String(s == null ? '' : s).replace(/[&<>"']/g, function (c) {
      return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c];
    });
  }
  function money(n) {
    var num = Number(n);
    return isNaN(num) ? '\u2014' : '\u20B9' + num.toLocaleString('en-IN');
  }
  function byId(list, id) {
    for (var i = 0; i < list.length; i++) if (list[i].id === id) return list[i];
    return null;
  }
  function fmtDate(ts) {
    if (!ts || typeof ts.toDate !== 'function') return '\u2014';
    var d = ts.toDate();
    return d.toLocaleDateString('en-IN', { day: 'numeric', month: 'short', year: 'numeric' }) +
      ' \u00b7 ' + d.toLocaleTimeString('en-IN', { hour: '2-digit', minute: '2-digit' });
  }

  var modalRoot = document.getElementById('modalRoot');
  function openModal(html, onMount) {
    modalRoot.innerHTML = '<div class="a-modal-overlay" id="modalOverlay"><div class="a-modal">' + html + '</div></div>';
    var overlay = document.getElementById('modalOverlay');
    overlay.addEventListener('click', function (ev) { if (ev.target === overlay) closeModal(); });
    if (onMount) onMount(modalRoot.querySelector('.a-modal'));
  }
  function closeModal() { modalRoot.innerHTML = ''; }

  function showErrorBanner(msg) {
    var existing = document.getElementById('cmsErrorBanner');
    if (existing) existing.remove();
    var div = document.createElement('div');
    div.id = 'cmsErrorBanner';
    div.className = 'a-banner a-banner--error';
    div.innerHTML = '<div class="a-wrap">' + esc(msg) + '</div>';
    document.body.insertBefore(div, document.body.firstChild.nextSibling);
    setTimeout(function () { if (div.parentNode) div.remove(); }, 6000);
  }

  function showToast(msg) {
    var existing = document.getElementById('cmsToast');
    if (existing) existing.remove();
    var div = document.createElement('div');
    div.id = 'cmsToast';
    div.className = 'a-toast';
    div.textContent = msg;
    document.body.appendChild(div);
    requestAnimationFrame(function () { div.classList.add('is-visible'); });
    setTimeout(function () {
      div.classList.remove('is-visible');
      setTimeout(function () { if (div.parentNode) div.remove(); }, 250);
    }, 2200);
  }

  return {
    slugify: slugify, esc: esc, money: money, byId: byId, fmtDate: fmtDate,
    openModal: openModal, closeModal: closeModal,
    showErrorBanner: showErrorBanner, showToast: showToast,
    categories: [], // live cache other modules (products.js, dashboard.js) read from
    products: []    // live cache other modules read from
  };
})();
