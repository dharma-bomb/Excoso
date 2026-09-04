<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excoso | Premium Bags, Apparel &amp; Corporate Merchandise</title>

    <!-- Bootstrap CDN (grid + navbar toggle only — visual styling is theme.css) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Archivo+Black&family=Inter:wght@400;500;600;700;800&family=IBM+Plex+Mono:wght@500;600&display=swap" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />

    <!-- Carousel (used for the Best Sellers rail) -->
    <link href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css" rel="stylesheet">

    <!-- Excoso theme — new site-wide look for the homepage (see DEPLOYMENT.md) -->
    <link rel="stylesheet" href="{{ asset('css/theme.css') }}">
</head>

<body>

    <!-- Navbar -->
    @include('navbar')

    <!-- Hero carousel -->
    <section class="hero" id="hero">
        <div class="hero-slides" id="heroCarousel">
            <div class="hero-slide is-active" data-slide="0">
                <div class="hero-slide__visual hero-slide__visual--bags"><span>BAGS</span></div>
                <div class="hero-slide__copy">
                    <p class="eyebrow">Category 01 / Bags</p>
                    <h1>Built for the daily carry.</h1>
                    <p class="sub">Backpacks, totes and duffels engineered for teams that move — branded, durable, and ready in bulk.</p>
                    <a href="{{ url('/#categories') }}" class="xc-btn xc-btn--primary">Shop Bags</a>
                </div>
            </div>
            <div class="hero-slide" data-slide="1">
                <div class="hero-slide__visual hero-slide__visual--tshirt"><span>T-SHIRTS</span></div>
                <div class="hero-slide__copy">
                    <p class="eyebrow">Category 02 / T-Shirts</p>
                    <h1>Everyday wear, on-brand.</h1>
                    <p class="sub">Soft, breathable staples that hold your logo and their shape, wash after wash.</p>
                    <a href="{{ url('/#categories') }}" class="xc-btn xc-btn--primary">Shop T-Shirts</a>
                </div>
            </div>
            <div class="hero-slide" data-slide="2">
                <div class="hero-slide__visual hero-slide__visual--jacket"><span>JACKETS</span></div>
                <div class="hero-slide__copy">
                    <p class="eyebrow">Category 03 / Jackets</p>
                    <h1>Outerwear that means business.</h1>
                    <p class="sub">Windbreakers to insulated shells — a sharper way to keep a team warm and consistent.</p>
                    <a href="{{ url('/#categories') }}" class="xc-btn xc-btn--primary">Shop Jackets</a>
                </div>
            </div>
            <div class="hero-slide" data-slide="3">
                <div class="hero-slide__visual hero-slide__visual--umbrella"><span>UMBRELLAS</span></div>
                <div class="hero-slide__copy">
                    <p class="eyebrow">Category 04 / Umbrellas</p>
                    <h1>Weatherproof, branded, everywhere.</h1>
                    <p class="sub">Wind-resistant frames and a canopy that carries your logo through any storm.</p>
                    <a href="{{ url('/#categories') }}" class="xc-btn xc-btn--primary">Shop Umbrellas</a>
                </div>
            </div>
            <div class="hero-slide" data-slide="4">
                <div class="hero-slide__visual hero-slide__visual--raincoat"><span>RAINCOATS</span></div>
                <div class="hero-slide__copy">
                    <p class="eyebrow">Category 05 / Raincoats</p>
                    <h1>All-weather, all-team.</h1>
                    <p class="sub">Sealed seams and breathable shells for field teams who don't stop for rain.</p>
                    <a href="{{ url('/#categories') }}" class="xc-btn xc-btn--primary">Shop Raincoats</a>
                </div>
            </div>
            <div class="hero-slide" data-slide="5">
                <div class="hero-slide__visual hero-slide__visual--caps"><span>CAPS</span></div>
                <div class="hero-slide__copy">
                    <p class="eyebrow">Category 06 / Caps</p>
                    <h1>Small item, big visibility.</h1>
                    <p class="sub">Structured and unstructured caps built for embroidery that holds its shape.</p>
                    <a href="{{ url('/#categories') }}" class="xc-btn xc-btn--primary">Shop Caps</a>
                </div>
            </div>

            <button class="hero-arrow hero-arrow--prev" id="heroPrev" aria-label="Previous category">&#8592;</button>
            <button class="hero-arrow hero-arrow--next" id="heroNext" aria-label="Next category">&#8594;</button>
        </div>
        <div class="hero-dots" id="heroDots"></div>
    </section>

    <!-- Shop by Category (live — pulled from your product catalog) -->
    <section class="cat-rail" id="categories">
        <div class="xc-container">
            <div class="section-head">
                <p class="eyebrow">Shop by category</p>
                <h2>Every category, one place.</h2>
            </div>

            @if (count($allProducts) > 0)
                <div class="cat-rail__track">
                    @foreach ($allProducts as $category => $products)
                        @if ($products->isNotEmpty())
                            @php
                                $firstProduct = $products->first();
                                $catImages = json_decode($firstProduct->images, true) ?: [];
                            @endphp
                            <a href="{{ route('viewproduct', ['category' => $category]) }}" class="cat-card">
                                <div class="cat-card__img">
                                    @if (!empty($catImages))
                                        <img src="{{ asset('images/addproduct/' . $catImages[0]) }}" alt="{{ $firstProduct->Productname }}" loading="lazy">
                                    @endif
                                </div>
                                <div class="cat-card__meta">
                                    <h3>{{ ucfirst($category) }}</h3>
                                    <span>{{ $products->count() }} product{{ $products->count() > 1 ? 's' : '' }}</span>
                                </div>
                            </a>
                        @endif
                    @endforeach
                </div>
            @else
                <p class="cat-rail__empty">Categories you add from the admin panel will appear here automatically.</p>
            @endif
        </div>
    </section>

    <!-- Feature strip -->
    <section class="feature-strip">
        <div class="xc-container feature-strip__grid">
            <div class="feature-item">
                <i class="fa-solid fa-award"></i>
                <h4>Premium Quality</h4>
            </div>
            <div class="feature-item">
                <i class="fa-solid fa-stamp"></i>
                <h4>Custom Branding</h4>
            </div>
            <div class="feature-item">
                <i class="fa-solid fa-boxes-stacked"></i>
                <h4>Bulk Orders</h4>
            </div>
            <div class="feature-item">
                <i class="fa-solid fa-truck-fast"></i>
                <h4>On-Time Delivery</h4>
            </div>
            <div class="feature-item">
                <i class="fa-solid fa-headset"></i>
                <h4>Dedicated Support</h4>
            </div>
        </div>
    </section>

    <!-- Best Selling Products (live — category tabs + AJAX) -->
    @if (count($allProducts) > 0)
        <section class="bestsellers">
            <div class="xc-container">
                <div class="section-head section-head--center">
                    <p class="eyebrow">Best sellers</p>
                    <h2>Best Selling Products</h2>
                </div>

                <div class="tabbuttons">
                    @foreach ($allProducts as $category => $products)
                        @if ($products->isNotEmpty())
                            <button class="viewcatbtn button2 {{ $loop->first ? 'buttonactive1' : '' }}"
                                id="{{ strtolower($category) }}" data-category="{{ $category }}">
                                {{ $category }}
                            </button>
                        @endif
                    @endforeach
                </div>

                <div id="carousel-container">
                    <div id="carousel2" class="splide" aria-label="Best selling products">
                        <div class="splide__track">
                            <ul class="splide__list content-container" id="carousel-content">
                                <!-- Injected by fetchProducts() via AJAX -->
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    <!-- Why Excoso -->
    <section class="why-excoso">
        <div class="xc-container">
            <div class="section-head">
                <p class="eyebrow">Why Excoso</p>
                <h2>Merchandise your team will actually use.</h2>
            </div>
            <div class="why-list">
                <div class="why-row">
                    <span class="why-row__num">01</span>
                    <h3>Superior Quality</h3>
                    <p>Premium materials and careful construction across every category — bags, apparel, and accessories that hold up to daily use.</p>
                </div>
                <div class="why-row">
                    <span class="why-row__num">02</span>
                    <h3>Built for Branding</h3>
                    <p>Consistent surfaces for embroidery and print, so your logo looks intentional — not stuck on as an afterthought.</p>
                </div>
                <div class="why-row">
                    <span class="why-row__num">03</span>
                    <h3>Bulk-Order Ready</h3>
                    <p>From a 50-piece onboarding kit to a 5,000-piece rollout, our production and fulfillment scale with you.</p>
                </div>
                <div class="why-row">
                    <span class="why-row__num">04</span>
                    <h3>A Real Team Behind It</h3>
                    <p>One point of contact from quote to delivery — not a ticket queue.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Get a Quote -->
    <section class="quote-section" id="quote">
        <div class="xc-container quote-grid">
            <div class="quote-intro">
                <p class="eyebrow">Get a quote</p>
                <h2>Tell us what you need. We'll take it from there.</h2>
                <p class="sub">Share a few details about your order and our sales team will get back to you with pricing, samples, and timelines.</p>
                <p class="quote-email">Prefer email? Write to us directly at
                    <a href="mailto:sales@expertcorporatesolutions.com">sales@expertcorporatesolutions.com</a>
                </p>
            </div>

            <form id="quoteForm" class="quote-form">
                @csrf
                <div id="quoteStatus" class="quote-status" hidden></div>
                <div class="quote-form__row">
                    <label for="q_name">Name</label>
                    <input type="text" id="q_name" name="name" required>
                </div>
                <div class="quote-form__row">
                    <label for="q_company">Company Name</label>
                    <input type="text" id="q_company" name="company">
                </div>
                <div class="quote-form__row">
                    <label for="q_email">Email ID</label>
                    <input type="email" id="q_email" name="email" required>
                </div>
                <div class="quote-form__row">
                    <label for="q_phone">Phone Number</label>
                    <input type="tel" id="q_phone" name="phone" required>
                </div>
                <div class="quote-form__row">
                    <label for="q_location">Location</label>
                    <input type="text" id="q_location" name="location">
                </div>
                <div class="quote-form__row">
                    <label for="q_product">Required Product</label>
                    <select id="q_product" name="product">
                        <option value="">Select a product</option>
                        @foreach (array_keys($allProducts) as $category)
                            <option value="{{ $category }}">{{ ucfirst($category) }}</option>
                        @endforeach
                        <option value="Other">Other</option>
                    </select>
                </div>
                <div class="quote-form__row">
                    <label for="q_quantity">Required Quantity</label>
                    <input type="text" id="q_quantity" name="quantity" placeholder="e.g. 100 pieces">
                </div>
                <button type="submit" id="quoteSubmit" class="xc-btn xc-btn--primary xc-btn--block">Submit</button>
            </form>
        </div>
    </section>

    <!-- Final CTA -->
    <section class="final-cta">
        <div class="xc-container">
            <h2>Ready to outfit your team?</h2>
            <a href="{{ url('/#quote') }}" class="xc-btn xc-btn--inverse">Request a Quote</a>
        </div>
    </section>

    <!-- Footer -->
    @include('footer')

    <!-- Quick-contact popup (existing lead form — saved to your users list) -->
    <div class="modal xc-popup" id="modal">
        <div class="xc-popup__card">
            <div class="xc-popup__head">
                <h5>Get in touch with us?</h5>
                <span class="close" aria-label="Close">&times;</span>
            </div>
            <div class="xc-popup__body">
                <form id="modalForm" method="POST" action="{{ route('formajax') }}">
                    @csrf
                    <div class="xc-form-row">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name" placeholder="Enter your name">
                    </div>
                    <div class="xc-form-row">
                        <label for="email">Email Address</label>
                        <input type="email" name="email" id="email" placeholder="Enter your email">
                    </div>
                    <div class="xc-form-row">
                        <label for="mobile">Mobile Number</label>
                        <input type="tel" name="mobile" id="mobile" placeholder="Enter your mobile number">
                    </div>
                    <button type="submit" id="formsubmit" class="xc-btn xc-btn--primary xc-btn--block">Submit</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js"></script>

    <script>
        // ---- Hero carousel ----
        (function () {
            var slides = document.querySelectorAll('#heroCarousel .hero-slide');
            var dotsWrap = document.getElementById('heroDots');
            var current = 0;
            var timer;

            slides.forEach(function (_, i) {
                var dot = document.createElement('button');
                dot.setAttribute('aria-label', 'Go to slide ' + (i + 1));
                if (i === 0) dot.classList.add('is-active');
                dot.addEventListener('click', function () { show(i); restart(); });
                dotsWrap.appendChild(dot);
            });

            function show(i) {
                slides[current].classList.remove('is-active');
                dotsWrap.children[current].classList.remove('is-active');
                current = (i + slides.length) % slides.length;
                slides[current].classList.add('is-active');
                dotsWrap.children[current].classList.add('is-active');
            }

            function next() { show(current + 1); }
            function prev() { show(current - 1); }

            function start() {
                if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
                timer = setInterval(next, 5000);
            }
            function stop() { clearInterval(timer); }
            function restart() { stop(); start(); }

            document.getElementById('heroNext').addEventListener('click', function () { next(); restart(); });
            document.getElementById('heroPrev').addEventListener('click', function () { prev(); restart(); });

            var hero = document.getElementById('hero');
            hero.addEventListener('mouseenter', stop);
            hero.addEventListener('mouseleave', start);

            start();
        })();
    </script>

    @if (count($allProducts) > 0)
        <script>
            // ---- Best Sellers tabs + AJAX (unchanged wiring from the previous homepage) ----
            $(document).ready(function() {
                function initializeCarousel() {
                    var itemCount = $('#carousel-content .splide__slide').length;
                    var loop = itemCount > 1;

                    new Splide('#carousel2', {
                        type: loop ? 'loop' : 'slide',
                        perPage: 3,
                        perMove: 1,
                        gap: '1.5rem',
                        autoplay: true,
                        interval: 7000,
                        rewind: false,
                        breakpoints: {
                            900: { perPage: 2 },
                            600: { perPage: 1 }
                        }
                    }).mount();
                }

                function fetchProducts(category) {
                    $.ajax({
                        url: '{{ route('fetchproducts') }}',
                        type: 'GET',
                        data: { category: category },
                        success: function(response) {
                            $('.content-container').html(response);
                            initializeCarousel();
                        },
                        error: function(xhr, status, error) {
                            console.error('Error fetching data:', error);
                        }
                    });
                }

                var firstCategory = $('.tabbuttons .button2').first().data('category');
                if (firstCategory) fetchProducts(firstCategory);

                $('.tabbuttons .button2').on('click', function() {
                    var category = $(this).data('category');
                    fetchProducts(category);
                    $('.tabbuttons .button2').removeClass('buttonactive1');
                    $(this).addClass('buttonactive1');
                });
            });
        </script>
    @endif

    <script>
        // ---- Get a Quote form ----
        $(document).ready(function () {
            $('#quoteForm').on('submit', function (e) {
                e.preventDefault();
                var $btn = $('#quoteSubmit');
                var $status = $('#quoteStatus');
                $btn.prop('disabled', true).text('Sending...');

                $.ajax({
                    url: '{{ route('quote.submit') }}',
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function (response) {
                        $status.text(response.message || 'Thanks — we\'ll be in touch shortly.')
                            .removeClass('is-error').addClass('is-success').prop('hidden', false);
                        document.getElementById('quoteForm').reset();
                    },
                    error: function (xhr) {
                        var msg = 'Something went wrong — please try again, or email sales@expertcorporatesolutions.com directly.';
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            msg = Object.values(xhr.responseJSON.errors).flat().join(' ');
                        }
                        $status.text(msg).removeClass('is-success').addClass('is-error').prop('hidden', false);
                    },
                    complete: function () {
                        $btn.prop('disabled', false).text('Submit');
                    }
                });
            });
        });
    </script>

    <script>
        // ---- Quick-contact popup (existing behavior, unchanged) ----
        $(function() {
            function showPopup() { $('#modal').addClass('is-open'); }
            function hidePopup() { $('#modal').removeClass('is-open'); }

            setTimeout(showPopup, 15000);
            $('.close').click(hidePopup);

            $('#modalForm').submit(function(e) {
                e.preventDefault();
                var formData = {
                    name: $('#name').val(),
                    email: $('#email').val(),
                    mobile: $('#mobile').val(),
                    _token: '{{ csrf_token() }}'
                };
                $.ajax({
                    type: 'POST',
                    url: '{{ route('formajax') }}',
                    data: formData,
                    success: function(response) {
                        hidePopup();
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr);
                    }
                });
            });
        });
    </script>

</body>

</html>
