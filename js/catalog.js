/*
  catalog.js
  ----------
  Loads data/catalog.json and renders every category/product-driven part of
  index.html: nav links, hero carousel, the category rail, "The Edit"
  featured grid, footer shop links, and the quote form's product dropdown.

  Edit data/catalog.json (by hand, or with admin/index.html) to change what
  shows up here — nothing in this file needs to change for normal catalog
  updates.

  Note: fetch() of a local JSON file is blocked by the browser when you open
  index.html directly as a file:// URL. Serve the folder with any static
  server to see live data (`python3 -m http.server`, `npx serve`, or just
  push to GitHub Pages, which serves real HTTP).
*/
(function () {
  var ARROW = '<svg class="icon" viewBox="0 0 24 24"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>';
  var VARIANTS = ['orange', 'deep', 'sand', 'cream'];

  function variantFor(index) {
    return VARIANTS[index % VARIANTS.length];
  }

  function money(n) {
    return '\u20B9' + Number(n).toLocaleString('en-IN');
  }

  function esc(s) {
    return String(s == null ? '' : s).replace(/[&<>"']/g, function (c) {
      return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c];
    });
  }

  function byId(list, id) {
    for (var i = 0; i < list.length; i++) if (list[i].id === id) return list[i];
    return null;
  }

  // ---------- NAV LINKS ----------
  function renderNav(categories) {
    var el = document.getElementById('navLinks');
    if (!el) return;
    var html = categories.map(function (c) {
      return '<a href="catalog.html?cat=' + encodeURIComponent(c.id) + '" class="site-nav__link">' + esc(c.name) + '</a>';
    }).join('');
    el.innerHTML = html;
  }

  // ---------- HERO CAROUSEL ----------
  function renderHero(categories) {
    var slidesEl = document.getElementById('heroSlides');
    var dotsEl = document.getElementById('heroDots');
    var bannerEl = document.getElementById('heroBannerTrack');
    if (!slidesEl || !dotsEl) return;

    var slidesHtml = categories.map(function (c, i) {
      var visual;
      if (c.image) {
        visual =
          '<div class="hero-visual__block hero-visual__block--' + variantFor(i) + '"></div>' +
          '<img src="' + esc(c.image) + '" alt="' + esc(c.name) + '">' +
          '<div class="hero-visual__tag">' + esc(c.name.toUpperCase()) + '</div>';
      } else {
        visual =
          '<div class="hero-visual__block hero-visual__block--' + variantFor(i) + '"></div>' +
          '<span class="hero-visual__word' + (variantFor(i) === 'sand' || variantFor(i) === 'cream' ? ' is-dark' : '') + '">' + esc(c.name.toUpperCase()) + '</span>' +
          '<div class="hero-visual__tag">' + esc(c.tagline || '') + '</div>';
      }
      return (
        '<div class="hero-slide' + (i === 0 ? ' is-active' : '') + '" role="group" aria-roledescription="slide" aria-label="' + (i + 1) + ' of ' + categories.length + ' \u2014 ' + esc(c.name) + '" aria-hidden="' + (i === 0 ? 'false' : 'true') + '">' +
          '<div class="hero-slide__inner">' +
            '<div class="hero__content">' +
              '<span class="eyebrow">' + esc(c.eyebrow || 'Premium Merchandise') + '</span>' +
              '<h1 class="hero__title" style="margin-top:0.6rem;">' + esc(c.tagline || c.name) + '</h1>' +
              '<p class="hero__sub">' + esc(c.description || '') + '</p>' +
              '<div class="hero__actions">' +
                '<a href="catalog.html?cat=' + encodeURIComponent(c.id) + '" class="btn btn-solid">' + esc(c.shopLabel || ('Shop ' + c.name)) + ' ' + ARROW + '</a>' +
                '<a href="#quote" class="btn btn-dark">For Corporates ' + ARROW + '</a>' +
              '</div>' +
            '</div>' +
            '<div class="hero-visual">' + visual + '</div>' +
          '</div>' +
        '</div>'
      );
    }).join('');
    slidesEl.innerHTML = slidesHtml;

    dotsEl.innerHTML = categories.map(function (c, i) {
      return '<button class="hero-dot' + (i === 0 ? ' is-active' : '') + '" data-slide="' + i + '" role="tab" aria-selected="' + (i === 0 ? 'true' : 'false') + '" aria-label="Go to ' + esc(c.name) + ' slide"></button>';
    }).join('');

    if (bannerEl) {
      bannerEl.innerHTML = categories.map(function (c) {
        return '<a href="catalog.html?cat=' + encodeURIComponent(c.id) + '" class="hero__banner-link">' + esc(c.name) + ' ' + ARROW + '</a>';
      }).join('');
    }
  }

  // ---------- COLLECTION RAIL ----------
  function renderRail(categories) {
    var el = document.getElementById('railTrack');
    if (!el) return;
    el.innerHTML = categories.map(function (c, i) {
      if (c.image) {
        return (
          '<a href="catalog.html?cat=' + encodeURIComponent(c.id) + '" class="rail__item rail__item--photo">' +
            '<img src="' + esc(c.image) + '" alt="' + esc(c.name) + '">' +
            '<span class="rail__name">' + esc(c.name) + '</span>' +
            '<span class="rail__cta">View All ' + ARROW + '</span>' +
          '</a>'
        );
      }
      var v = variantFor(i);
      var textStyle = v === 'deep' ? ' style="color:var(--cream)"' : '';
      return (
        '<a href="catalog.html?cat=' + encodeURIComponent(c.id) + '" class="rail__item rail__item--' + v + '">' +
          '<span class="rail__name"' + textStyle + '>' + esc(c.name) + '</span>' +
          '<span class="rail__cta"' + textStyle + '>View All ' + ARROW + '</span>' +
        '</a>'
      );
    }).join('');
  }

  // ---------- "THE EDIT" FEATURED PRODUCTS ----------
  function renderEdit(products, categories) {
    var el = document.getElementById('editGrid');
    if (!el) return;
    var featured = products.filter(function (p) { return p.featured; });
    if (!featured.length) featured = products.slice(0, 6);

    el.innerHTML = featured.slice(0, 6).map(function (p, i) {
      var cat = byId(categories, p.category);
      var catName = cat ? cat.name : p.category;
      var img = p.images && p.images[0];
      if (img) {
        return (
          '<a href="catalog.html?product=' + encodeURIComponent(p.id) + '" class="p-card p-card--photo">' +
            '<img src="' + esc(img) + '" alt="' + esc(p.name) + '">' +
            '<span class="p-card__name">' + esc(p.name) + '</span>' +
            '<span class="p-card__price">' + esc(catName) + ' \u00b7 ' + money(p.price) + '</span>' +
          '</a>'
        );
      }
      var v = variantFor(i);
      var nameStyle = v === 'deep' ? ' style="color:var(--cream)"' : '';
      var priceStyle = v === 'deep' ? ' style="color:rgba(250,247,240,0.7)"' : '';
      return (
        '<a href="catalog.html?product=' + encodeURIComponent(p.id) + '" class="p-card p-card--' + v + '">' +
          '<span class="p-card__name"' + nameStyle + '>' + esc(p.name) + '</span>' +
          '<span class="p-card__price"' + priceStyle + '>' + esc(catName) + ' \u00b7 ' + money(p.price) + '</span>' +
        '</a>'
      );
    }).join('');
  }

  // ---------- FOOTER SHOP LINKS ----------
  function renderFooter(categories) {
    var el = document.getElementById('footerShopLinks');
    if (!el) return;
    el.innerHTML = categories.map(function (c) {
      return '<li><a href="catalog.html?cat=' + encodeURIComponent(c.id) + '">' + esc(c.name) + '</a></li>';
    }).join('');
  }

  // ---------- QUOTE FORM PRODUCT DROPDOWN ----------
  function renderQuoteOptions(categories) {
    var el = document.getElementById('q-product');
    if (!el) return;
    var current = el.value;
    var opts = '<option value="" disabled selected>Select a product</option>' +
      categories.map(function (c) { return '<option>' + esc(c.name) + '</option>'; }).join('') +
      '<option>Welcome Kits / Mixed</option><option>Other</option>';
    el.innerHTML = opts;
    if (current) el.value = current;
  }

  // ---------- CATALOG PAGE (catalog.html only) ----------
  function productCardHtml(p, i, categories) {
    var cat = byId(categories, p.category);
    var catName = cat ? cat.name : p.category;
    var img = p.images && p.images[0];
    var href = 'index.html?product=' + encodeURIComponent(p.id) + '#quote';
    if (img) {
      return (
        '<a href="' + href + '" class="p-card p-card--photo">' +
          '<img src="' + esc(img) + '" alt="' + esc(p.name) + '">' +
          '<span class="p-card__name">' + esc(p.name) + '</span>' +
          '<span class="p-card__price">' + esc(catName) + ' \u00b7 ' + money(p.price) + '</span>' +
        '</a>'
      );
    }
    var v = variantFor(i);
    var nameStyle = v === 'deep' ? ' style="color:var(--cream)"' : '';
    var priceStyle = v === 'deep' ? ' style="color:rgba(250,247,240,0.7)"' : '';
    return (
      '<a href="' + href + '" class="p-card p-card--' + v + '">' +
        '<span class="p-card__name"' + nameStyle + '>' + esc(p.name) + '</span>' +
        '<span class="p-card__price"' + priceStyle + '>' + esc(catName) + ' \u00b7 ' + money(p.price) + '</span>' +
      '</a>'
    );
  }

  function renderCatalogPage(data) {
    var gridEl = document.getElementById('catalogGrid');
    if (!gridEl) return;
    var chipsEl = document.getElementById('filterChips');
    var searchEl = document.getElementById('catalogSearch');
    var countEl = document.getElementById('catalogCount');
    var emptyEl = document.getElementById('catalogEmpty');
    var params = new URLSearchParams(window.location.search);
    var state = {
      cat: params.get('cat') || 'all',
      q: params.get('search') || ''
    };
    if (searchEl) searchEl.value = state.q;

    function renderChips() {
      var chips = [{ id: 'all', name: 'All' }].concat(data.categories);
      chipsEl.innerHTML = chips.map(function (c) {
        return '<button type="button" class="filter-chip' + (state.cat === c.id ? ' is-active' : '') + '" data-cat="' + esc(c.id) + '">' + esc(c.name) + '</button>';
      }).join('');
      Array.prototype.forEach.call(chipsEl.querySelectorAll('.filter-chip'), function (btn) {
        btn.addEventListener('click', function () {
          state.cat = btn.dataset.cat;
          syncUrl();
          renderChips();
          renderGrid();
        });
      });
    }

    function syncUrl() {
      var p = new URLSearchParams();
      if (state.cat && state.cat !== 'all') p.set('cat', state.cat);
      if (state.q) p.set('search', state.q);
      var qs = p.toString();
      history.replaceState(null, '', window.location.pathname + (qs ? '?' + qs : ''));
    }

    function renderGrid() {
      var list = data.products.filter(function (p) {
        var matchesCat = state.cat === 'all' || p.category === state.cat;
        var matchesQ = !state.q || (p.name + ' ' + (p.description || '')).toLowerCase().indexOf(state.q.toLowerCase()) !== -1;
        return matchesCat && matchesQ;
      });
      gridEl.innerHTML = list.map(function (p, i) { return productCardHtml(p, i, data.categories); }).join('');
      if (emptyEl) emptyEl.style.display = list.length ? 'none' : 'block';
      if (countEl) countEl.textContent = list.length + (list.length === 1 ? ' product' : ' products') + (state.cat !== 'all' ? (' in ' + (byId(data.categories, state.cat) ? byId(data.categories, state.cat).name : state.cat)) : '');
    }

    if (searchEl) {
      searchEl.addEventListener('input', function () {
        state.q = searchEl.value.trim();
        syncUrl();
        renderGrid();
      });
    }

    renderChips();
    renderGrid();
  }

  // ---------- PRODUCT -> QUOTE FORM PREFILL (index.html, via ?product=) ----------
  function prefillQuoteFromProduct(data) {
    var select = document.getElementById('q-product');
    if (!select) return;
    var params = new URLSearchParams(window.location.search);
    var productId = params.get('product');
    if (!productId) return;
    var product = byId(data.products, productId);
    if (!product) return;
    var cat = byId(data.categories, product.category);
    if (cat) {
      Array.prototype.forEach.call(select.options, function (opt) {
        if (opt.textContent === cat.name) select.value = cat.name;
      });
    }
    setTimeout(function () {
      var quoteSection = document.getElementById('quote');
      if (quoteSection) quoteSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }, 300);
  }

  function renderAll(data) {
    renderNav(data.categories);
    renderHero(data.categories);
    renderRail(data.categories);
    renderEdit(data.products, data.categories);
    renderFooter(data.categories);
    renderQuoteOptions(data.categories);
    renderCatalogPage(data);
    prefillQuoteFromProduct(data);
    document.dispatchEvent(new CustomEvent('catalog:ready', { detail: data }));
  }

  function loadFromFirestore() {
    return db.collection('categories').get().then(function (catSnap) {
      return db.collection('products').get().then(function (prodSnap) {
        return {
          categories: catSnap.docs.map(function (d) { return Object.assign({ id: d.id }, d.data()); }),
          products: prodSnap.docs.map(function (d) { return Object.assign({ id: d.id }, d.data()); })
        };
      });
    });
  }

  function loadFromStaticFile() {
    return fetch('data/catalog.json', { cache: 'no-store' }).then(function (res) {
      if (!res.ok) throw new Error('catalog.json fetch failed: ' + res.status);
      return res.json();
    });
  }

  window.ExcosoCatalog = {
    load: function () {
      // Prefer live Firestore data (instant admin-panel edits) when
      // js/firebase-config.js has been filled in with a real project;
      // otherwise fall back to the bundled data/catalog.json so the site
      // still works out of the box before Firebase is set up.
      var usesFirestore = typeof firebaseReady !== 'undefined' && firebaseReady && typeof db !== 'undefined' && db;
      var loader = usesFirestore ? loadFromFirestore() : loadFromStaticFile();
      return loader
        .then(function (data) {
          if (!data.categories.length && !data.products.length && usesFirestore) {
            // Firestore is reachable but empty (fresh project) — fall back
            // so the site isn't blank while catalog is still being set up.
            return loadFromStaticFile();
          }
          return data;
        })
        .then(function (data) {
          renderAll(data);
          return data;
        })
        .catch(function (err) {
          console.error('Could not load catalog data:', err);
          // If Firestore failed for some reason, still try the static file
          // once before giving up entirely.
          if (usesFirestore) {
            return loadFromStaticFile().then(function (data) { renderAll(data); return data; }).catch(function (err2) {
              showLoadError(err2);
            });
          }
          showLoadError(err);
        });
    },
    esc: esc,
    money: money,
    variantFor: variantFor,
    byId: byId
  };

  function showLoadError(err) {
    console.error(err);
    var note = document.createElement('div');
    note.style.cssText = 'position:fixed;bottom:0;left:0;right:0;background:#c7480a;color:#faf7f0;font:600 13px/1.4 sans-serif;padding:10px 16px;z-index:9999;text-align:center;';
    note.textContent = 'Could not load catalog data — if you opened this file directly, serve the folder with a local server instead (see README.md).';
    document.body.appendChild(note);
  }

  window.ExcosoCatalog.load();
})();
