(function(){
  var navToggle = document.getElementById('navToggle');
  var navLinks = document.getElementById('navLinks');
  if (navToggle && navLinks) {
    navToggle.addEventListener('click', function(){
      navLinks.classList.toggle('is-open');
      navToggle.classList.toggle('is-open');
    });
  }
  var searchToggle = document.getElementById('searchToggle');
  var navSearch = document.getElementById('navSearch');
  var searchClose = document.getElementById('searchClose');
  if (searchToggle && navSearch) { searchToggle.addEventListener('click', function(){ navSearch.classList.toggle('is-open'); }); }
  if (searchClose && navSearch) { searchClose.addEventListener('click', function(){ navSearch.classList.remove('is-open'); }); }

  try {
    var reveals = document.querySelectorAll('.reveal');
    if ('IntersectionObserver' in window) {
      var io = new IntersectionObserver(function(entries){
        entries.forEach(function(e){ if (e.isIntersecting) { e.target.classList.add('is-visible'); io.unobserve(e.target); } });
      }, { threshold: 0.12 });
      reveals.forEach(function(el){ io.observe(el); });
    } else { reveals.forEach(function(el){ el.classList.add('is-visible'); }); }
  } catch(e) {}

  // Hero category carousel — initialized once catalog.js has rendered the
  // slides (it fires 'catalog:ready' after populating #heroSlides/#heroDots
  // from data/catalog.json). Falls back to running immediately if the event
  // never fires (e.g. catalog.js failed to load) so the hardcoded fallback
  // slides in index.html still work as a carousel.
  function initHeroCarousel(){
    var root = document.getElementById('heroCarousel');
    if (!root || root.dataset.carouselInit) return;
    root.dataset.carouselInit = '1';
    var slides = Array.prototype.slice.call(root.querySelectorAll('.hero-slide'));
    var dots = Array.prototype.slice.call(root.querySelectorAll('.hero-dot'));
    var prevBtn = document.getElementById('heroPrev');
    var nextBtn = document.getElementById('heroNext');
    var idx = 0;
    var timer = null;
    var AUTOPLAY_MS = 6000;
    var reduceMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    function show(i){
      idx = (i + slides.length) % slides.length;
      slides.forEach(function(s, si){
        var active = si === idx;
        s.classList.toggle('is-active', active);
        s.setAttribute('aria-hidden', active ? 'false' : 'true');
      });
      dots.forEach(function(d, di){
        var active = di === idx;
        d.classList.toggle('is-active', active);
        d.setAttribute('aria-selected', active ? 'true' : 'false');
      });
    }
    function next(){ show(idx + 1); }
    function prev(){ show(idx - 1); }
    function stopAuto(){ if (timer) { clearInterval(timer); timer = null; } }
    function startAuto(){ if (reduceMotion) return; stopAuto(); timer = setInterval(next, AUTOPLAY_MS); }

    if (prevBtn) prevBtn.addEventListener('click', function(){ prev(); startAuto(); });
    if (nextBtn) nextBtn.addEventListener('click', function(){ next(); startAuto(); });
    dots.forEach(function(d, di){ d.addEventListener('click', function(){ show(di); startAuto(); }); });

    root.addEventListener('mouseenter', stopAuto);
    root.addEventListener('mouseleave', startAuto);
    root.addEventListener('focusin', stopAuto);
    root.addEventListener('focusout', startAuto);

    show(0);
    startAuto();
  }
  document.addEventListener('catalog:ready', initHeroCarousel);
  // Safety net: if catalog.js is missing/broken and never fires the event,
  // still start the carousel on the hardcoded fallback slides.
  setTimeout(function(){ initHeroCarousel(); }, 1500);

  // Search box — jumps to the catalog page with the query applied.
  var navSearchForm = document.querySelector('#navSearch form');
  var navSearchInput = navSearchForm ? navSearchForm.querySelector('input') : null;
  if (navSearchForm && navSearchInput) {
    navSearchForm.addEventListener('submit', function(ev){
      ev.preventDefault();
      var q = navSearchInput.value.trim();
      window.location.href = 'catalog.html' + (q ? ('?search=' + encodeURIComponent(q)) : '');
    });
  }

  var quoteForm = document.getElementById('quoteForm');
  if (quoteForm) {
    var quoteUsesFirestore = typeof firebaseReady !== 'undefined' && firebaseReady && typeof db !== 'undefined' && db;
    var quoteNoteEl = document.getElementById('quoteNote');
    if (quoteNoteEl && quoteUsesFirestore) {
      quoteNoteEl.textContent = 'Submits directly to us \u2014 no email app needed.';
    }

    quoteForm.addEventListener('submit', function(ev){
      ev.preventDefault();
      var get = function(id){ return document.getElementById(id).value.trim(); };
      var note = document.getElementById('quoteNote');
      var submitBtn = quoteForm.querySelector('button[type="submit"]');
      var submitBtnOriginalHTML = submitBtn ? submitBtn.innerHTML : '';

      var fields = {
        name: get('q-name'),
        company: get('q-company'),
        email: get('q-email'),
        phone: get('q-phone'),
        location: get('q-location'),
        product: get('q-product'),
        quantity: get('q-qty')
      };

      if (quoteUsesFirestore) {
        if (submitBtn) { submitBtn.disabled = true; submitBtn.textContent = 'Sending\u2026'; }
        db.collection('quotes').add(Object.assign({}, fields, {
          status: 'new',
          submittedAt: firebase.firestore.FieldValue.serverTimestamp()
        })).then(function () {
          quoteForm.reset();
          if (note) {
            note.textContent = 'Thanks! Your request has been sent \u2014 we\u2019ll be in touch shortly.';
            note.classList.add('is-active');
          }
        }).catch(function (err) {
          console.error('Could not save quote request:', err);
          if (note) {
            note.textContent = 'Something went wrong sending that \u2014 please try again, or email us directly at sales@expertcorporatesolutions.com.';
            note.classList.add('is-active');
          }
        }).finally(function () {
          if (submitBtn) { submitBtn.disabled = false; submitBtn.innerHTML = submitBtnOriginalHTML; }
        });
      } else {
        // Firebase not configured yet — fall back to opening the visitor's
        // email app, same as before, so the form still works out of the box.
        var lines = [
          'Name: ' + fields.name,
          'Company Name: ' + fields.company,
          'Email ID: ' + fields.email,
          'Phone Number: ' + fields.phone,
          'Location: ' + fields.location,
          'Required Product: ' + fields.product,
          'Required Quantity: ' + fields.quantity
        ];
        var subject = encodeURIComponent('New Enquiry \u2014 ' + fields.company);
        var body = encodeURIComponent(lines.join('\n'));
        window.location.href = 'mailto:sales@expertcorporatesolutions.com?subject=' + subject + '&body=' + body;
        if (note) {
          note.textContent = 'Opening your email app with these details filled in \u2014 hit send there to reach us.';
          note.classList.add('is-active');
        }
      }
    });
  }

  var form = document.getElementById('newsletterForm');
  if (form) {
    form.addEventListener('submit', function(ev){
      ev.preventDefault();
      var input = document.getElementById('newsletterEmail');
      var btn = form.querySelector('button');
      btn.textContent = 'Subscribed';
      input.value = '';
    });
  }
})();
