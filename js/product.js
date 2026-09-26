/*
  product.js
  ----------
  Renders product.html?id=<productId> — gallery, price, description,
  specs, a "Request a Quote" CTA (hands off to index.html's existing
  quote form via ?product=<id>#quote, unchanged), an optional WhatsApp
  link (from Settings), and a related-products rail.

  Waits for 'catalog:ready', dispatched by js/catalog.js once it has
  loaded categories/products/banners/settings (from Firestore, live —
  or data/catalog.json as a static fallback) and rendered the shared
  nav/footer. Nothing here talks to Firestore directly.
*/
(function () {
  var EC = window.ExcosoCatalog;
  var esc = EC.esc, money = EC.money, byId = EC.byId, variantFor = EC.variantFor;

  function relatedCardHtml(p, i, categories) {
    var cat = byId(categories, p.category);
    var catName = cat ? cat.name : p.category;
    var img = p.images && p.images[0];
    var href = 'product.html?id=' + encodeURIComponent(p.id);
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

  function showNotFound() {
    document.getElementById('productLoading').style.display = 'none';
    document.getElementById('productNotFound').style.display = 'block';
    document.title = 'Product not found \u2014 Excoso';
  }

  function renderGallery(images, productName) {
    var galleryEl = document.getElementById('productGallery');
    var mainImg = document.getElementById('pdMainImage');
    var thumbsEl = document.getElementById('pdThumbs');

    if (!images.length) {
      galleryEl.classList.add('product-gallery--empty');
      return;
    }
    mainImg.src = images[0];
    mainImg.alt = productName;

    if (images.length === 1) { thumbsEl.style.display = 'none'; return; }

    thumbsEl.innerHTML = images.map(function (url, i) {
      return '<button type="button" class="product-gallery__thumb' + (i === 0 ? ' is-active' : '') + '" data-idx="' + i + '"><img src="' + esc(url) + '" alt=""></button>';
    }).join('');
    Array.prototype.forEach.call(thumbsEl.querySelectorAll('.product-gallery__thumb'), function (btn) {
      btn.addEventListener('click', function () {
        mainImg.src = images[+btn.dataset.idx];
        Array.prototype.forEach.call(thumbsEl.querySelectorAll('.product-gallery__thumb'), function (b) { b.classList.remove('is-active'); });
        btn.classList.add('is-active');
      });
    });
  }

  function render(data) {
    document.getElementById('productLoading').style.display = 'none';

    var params = new URLSearchParams(window.location.search);
    var id = params.get('id');
    var product = id ? byId(data.products, id) : null;

    if (!product) { showNotFound(); return; }

    var cat = byId(data.categories, product.category);
    var catName = cat ? cat.name : (product.category || '');
    var images = (product.images && product.images.length) ? product.images : (product.image ? [product.image] : []);

    document.title = product.name + ' \u2014 Excoso';
    var metaDesc = document.querySelector('meta[name="description"]');
    if (metaDesc && product.description) metaDesc.setAttribute('content', product.description.slice(0, 160));

    // Breadcrumb
    document.getElementById('crumbCat').textContent = catName;
    document.getElementById('crumbName').textContent = product.name;
    document.getElementById('productCrumb').style.display = 'block';

    // Gallery
    renderGallery(images, product.name);

    // Info panel
    var catLink = document.getElementById('pdCatLink');
    catLink.textContent = catName;
    catLink.href = cat ? ('catalog.html?cat=' + encodeURIComponent(cat.id)) : 'catalog.html';

    document.getElementById('pdName').textContent = product.name;
    document.getElementById('pdPrice').textContent = money(product.price);
    document.getElementById('pdDesc').textContent = product.description || '';

    var badgesEl = document.getElementById('pdBadges');
    var badges = [];
    if (product.featured) badges.push('<span class="product-badge product-badge--featured">\u2605 Featured</span>');
    badgesEl.innerHTML = badges.join('');

    var specs = product.specs || [];
    var specsEl = document.getElementById('pdSpecs');
    if (specs.length) {
      specsEl.innerHTML = specs.map(function (s) {
        return '<div class="product-info__spec-row"><span>' + esc(s.label) + '</span><span>' + esc(s.value) + '</span></div>';
      }).join('');
    } else {
      specsEl.style.display = 'none';
    }

    // Request a Quote — hands off to the existing quote form + prefill on index.html
    document.getElementById('pdQuoteBtn').href = 'index.html?product=' + encodeURIComponent(product.id) + '#quote';

    // Optional WhatsApp quick-contact, from Settings (admin/index.html → Settings)
    if (data.settings && data.settings.whatsapp) {
      var digits = data.settings.whatsapp.replace(/[^\d]/g, '');
      if (digits) {
        var msg = encodeURIComponent('Hi, I\u2019m interested in ' + product.name + ' \u2014 could you share more details?');
        var waBtn = document.getElementById('pdWhatsapp');
        waBtn.href = 'https://wa.me/' + digits + '?text=' + msg;
        waBtn.style.display = 'inline-flex';
      }
    }

    document.getElementById('productDetail').style.display = 'block';

    // Related products — same category first, backfilled with anything else if needed
    var related = data.products.filter(function (p) { return p.id !== product.id && p.category === product.category; });
    if (related.length < 4) {
      data.products.forEach(function (p) {
        if (related.length >= 4) return;
        if (p.id === product.id || related.indexOf(p) !== -1) return;
        related.push(p);
      });
    }
    related = related.slice(0, 4);
    if (related.length) {
      document.getElementById('relatedGrid').innerHTML = related.map(function (p, i) { return relatedCardHtml(p, i, data.categories); }).join('');
      document.getElementById('relatedSection').style.display = 'block';
    }
  }

  document.addEventListener('catalog:ready', function (ev) { render(ev.detail); });
})();
