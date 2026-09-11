/*
  core.js
  -------
  Shared helpers used by every other admin/js/*.js file: small formatting
  utilities, the add/edit modal, and toast notifications. Loaded first, and
  attaches everything to window.CMS. `CMS.categories` / `CMS.products` are
  live caches other modules read from and update.
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
  function formatDate(ts) {
    if (!ts) return '\u2014';
    var d = typeof ts.toDate === 'function' ? ts.toDate() : new Date(ts);
    if (isNaN(d.getTime())) return '\u2014';
    return d.toLocaleDateString('en-IN', { day: 'numeric', month: 'short', year: 'numeric' });
  }
  function debounce(fn, ms) {
    var t;
    return function () {
      var args = arguments, ctx = this;
      clearTimeout(t);
      t = setTimeout(function () { fn.apply(ctx, args); }, ms || 250);
    };
  }

  // ---------- modal ----------
  var modalRoot = document.getElementById('modalRoot');
  function openModal(html, onMount) {
    modalRoot.innerHTML = '<div class="a-modal-overlay" id="modalOverlay"><div class="a-modal">' + html + '</div></div>';
    var overlay = document.getElementById('modalOverlay');
    overlay.addEventListener('click', function (ev) { if (ev.target === overlay) closeModal(); });
    if (onMount) onMount(modalRoot.querySelector('.a-modal'));
  }
  function closeModal() { modalRoot.innerHTML = ''; }

  // ---------- toast notifications ----------
  var toastRoot = document.getElementById('toastRoot');
  function toast(msg, type) {
    if (!toastRoot) return;
    var el = document.createElement('div');
    el.className = 'a-toast a-toast--' + (type || 'success');
    el.textContent = msg;
    toastRoot.appendChild(el);
    requestAnimationFrame(function () { el.classList.add('is-visible'); });
    setTimeout(function () {
      el.classList.remove('is-visible');
      setTimeout(function () { el.remove(); }, 250);
    }, type === 'error' ? 5500 : 3200);
  }
  // Back-compat name used by older code / a clearer alias for error toasts.
  function showErrorBanner(msg) { toast(msg, 'error'); }

  // ---------- confirm dialog (styled, but same sync-feeling API as confirm()) ----------
  function confirmDialog(message, opts) {
    opts = opts || {};
    return new Promise(function (resolve) {
      var html =
        '<h3>' + esc(opts.title || 'Are you sure?') + '</h3>' +
        '<p style="margin:0 0 1.4rem;color:var(--graphite);">' + esc(message) + '</p>' +
        '<div class="a-modal__actions">' +
          '<button class="a-btn a-btn--ghost a-btn--sm" id="confirm-no">Cancel</button>' +
          '<button class="a-btn a-btn--danger a-btn--sm" id="confirm-yes">' + esc(opts.confirmLabel || 'Delete') + '</button>' +
        '</div>';
      openModal(html, function (modal) {
        modal.querySelector('#confirm-no').addEventListener('click', function () { closeModal(); resolve(false); });
        modal.querySelector('#confirm-yes').addEventListener('click', function () { closeModal(); resolve(true); });
      });
    });
  }

  return {
    slugify: slugify, esc: esc, money: money, byId: byId, formatDate: formatDate, debounce: debounce,
    openModal: openModal, closeModal: closeModal,
    toast: toast, showErrorBanner: showErrorBanner, confirmDialog: confirmDialog,
    categories: [], // live cache — categories.js loads it, others read it
    products: []    // live cache — products.js loads it, dashboard/categories read it
  };
})();
