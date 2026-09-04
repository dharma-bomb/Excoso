<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excoso | Home</title>

    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Stylesheets -->
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/footer.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">

    <!-- jQuery UI -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

    <!-- AOS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Oregano:ital@0;1&display=swap" rel="stylesheet">

    <!-- Carousel -->
    <link href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css" rel="stylesheet">

</head>



<body>

    <!-- Navbar -->
    @include('navbar')

    <!-- Carousel -->
    <div class="carousel1">
        <section id="carousel1" class="splide" aria-label="Beautiful Images">
            <div class="splide__track">
                <ul class="splide__list">
                    <li class="splide__slide slide1">
                        <div class="carouselct">
                            <h6>Starting at <span style="font-weight: 700;">₹ 1500.00</span></h6>
                            <h3>The best Bag Collection 2024</h3>
                            <h5>Exclusive offer <span class="span1">-35%</span> off this week</h5>
                            <button>Shop Now <i class="fa-solid fa-arrow-right"></i></button>
                        </div>
                    </li>
                    <li class="splide__slide slide2">
                        <div class="carouselct">
                            <h6>Starting at ₹ 1500.00</h6>
                            <h3>The best Bag Collection 2024</h3>
                            <h5>Exclusive offer <span class="span1">-35%</span> off this week</h5>
                            <button>Shop Now <i class="fa-solid fa-arrow-right"></i></button>
                        </div>
                    </li>
                    <li class="splide__slide slide3">
                        <div class="carouselct">
                            <h6>Starting at ₹ 1500.00</h6>
                            <h3>The best Bag Collection 2024</h3>
                            <h5>Exclusive offer <span class="span1">-35%</span> off this week</h5>
                            <button>Shop Now <i class="fa-solid fa-arrow-right"></i></button>
                        </div>
                    </li>
                </ul>
            </div>
        </section>
    </div>

    {{-- This will receive the data as allproducts from the index controller and
    display the content by => specify --}}

    {{-- The images will be stored in public->images and reterieve by {{ asset('images/--name--') }} asset is the folder
    that have the
    images , css, js , etc whcih have the depencies for the frontend --}}


    <!-- Ellipse -->
    <div class="ellipse">
        <div class="ellipsecard">
            @foreach ($allProducts as $category => $products)
                @php
                    // $routeName = 'viewproduct.' . strtolower($category); // Adjusted routeName
                    $firstProduct = $products->first();
                    $images = json_decode($firstProduct->images, true);
                @endphp
                <a href="{{ route('viewproduct', ['category' => $category]) }}" class="ellipsediv">
                    <div class="eimg">
                        <img class="lazy" data-src="{{ asset('images/addproduct/' . $images[0]) }}"
                            alt="{{ $firstProduct->product_name }}" loading="lazy" style="height: 125px;">
                    </div>
                    <div class="ect">
                        <h5>{{ ucfirst($category) }}</h5>
                        <h6>{{ $products->count() }} Product{{ $products->count() > 1 ? 's' : '' }}</h6>
                    </div>
                </a>
            @endforeach
        </div>
    </div>

    <!-- Card1 -->
    <div class="card1">
        <div class="cards">
            <div class="carddiv">
                <div class="cimg1">
                    <img class="lazy" data-src="{{ asset('images/home/cicon1.png') }}" height="30px" alt="">
                </div>
                <div class="cct1">
                    <h5>Free Delivery</h5>
                    <h6>Orders from all item</h6>
                </div>
            </div>
            <div class="carddiv">
                <div class="cimg1">
                    <img class="lazy" data-src="{{ asset('images/home/cicon2.png') }}" height="30px" alt="">
                </div>
                <div class="cct1">
                    <h5>Return & Refund</h5>
                    <h6>Money back guarantee</h6>
                </div>
            </div>
            <div class="carddiv">
                <div class="cimg1">
                    <img class="lazy" data-src="{{ asset('images/home/cicon3.png') }}" height="30px" alt="">
                </div>
                <div class="cct1">
                    <h5>Member Discount</h5>
                    <h6>One very order over $140.00</h6>
                </div>
            </div>
            <div class="carddiv">
                <div class="cimg1">
                    <img class="lazy" data-src="{{ asset('images/home/cicon4.png') }}" height="30px" alt="">
                </div>
                <div class="cct1">
                    <h5>Support 24/7</h5>
                    <h6>Contact us 24 hours a day</h6>
                </div>
            </div>

        </div>
    </div>

    <!-- Card2 -->
    <div class="card2">
        <div class="cards1">
            <div class="card2heading">
                <h2>Our Products</h2>
                <img src="{{ asset('images/home/borderimg2.png') }}" alt="">
            </div>

            <!-- Bags -->
            <div class="carddiv1 mt-5">
                <div class="cimg2">
                    <img src="{{ asset('images/home/cardimg1.png') }}" width="90%" alt="">
                </div>
                <div class="cct2">
                    <h6>Excoso</h6>
                    <h4>The Best Bag Collection 2024</h4>
                    <span>Welcome to Excoso, where we proudly present the Best Bag Collection of 2024. This year, we've
                        elevated our designs to new heights, combining unparalleled craftsmanship with cutting-edge
                        materials to offer a range of bags that are as functional as they are stylish. From sleek,
                        minimalist backpacks to chic, versatile totes, each piece in our 2024 collection is crafted with
                        meticulous attention to detail, ensuring both durability and elegance. Experience the perfect
                        blend of fashion and practicality with Excoso's latest collection, designed to complement your
                        lifestyle and elevate your everyday carry. Discover your new favorite bag today and step into a
                        world where style meets functionality.</span>
                    <div class="cct3 mt-5">
                        <div class="clrdiv">
                            <h5>10+</h5>
                            <h6>Color</h6>
                        </div>
                        <div class="border1">
                            <img src="{{ asset('images/home/borderimg.png') }}" height="50px" alt="">
                        </div>
                        <div class="vrtsdiv">
                            <h5>10+</h5>
                            <h6>Variants</h6>
                        </div>
                        <div class="border1">
                            <img src="{{ asset('images/home/borderimg.png') }}" height="50px" alt="">
                        </div>
                        <div class="ratediv">
                            <div class="stars">
                                <img src="{{ asset('images/home/star.png') }}" height="30px" alt="">
                                <img src="{{ asset('images/home/star.png') }}" height="30px" alt="">
                                <img src="{{ asset('images/home/star.png') }}" height="30px" alt="">
                                <img src="{{ asset('images/home/star.png') }}" height="30px" alt="">
                                <img src="{{ asset('images/home/star.png') }}" height="30px" alt="">
                            </div>
                            <h6 class="mt-3">Review</h6>
                        </div>
                    </div>
                    {{-- <div class="learnmore mt-5 text-center">
                        <a href="">Learn More <i class="fa-solid fa-arrow-right"></i></a>
                    </div> --}}
                </div>
            </div>

            <!-- Jackets -->
            <div class="carddiv1 mt-5">
                <div class="cct2">
                    <h6>Excoso</h6>
                    <h4>The Best Jackets Collection 2024</h4>
                    <span>Exploring Excoso Jackets reveals a world where cutting-edge design meets unmatched
                        functionality. Our 2024 collection features a diverse array of jackets tailored for every
                        lifestyle, from sleek, urban windbreakers to robust, insulated parkas for the great outdoors.
                        Each jacket is crafted with premium materials, ensuring not only exceptional warmth and
                        protection but also a contemporary, stylish look. Whether you're navigating city streets or
                        embarking on an adventurous trek, Excoso Jackets offer the perfect blend of innovation,
                        durability, and elegance. Dive into the Excoso experience and discover the ultimate in outerwear
                        excellence.</span>
                    <div class="cct3 mt-5">
                        <div class="clrdiv">
                            <h5>10+</h5>
                            <h6>Color</h6>
                        </div>
                        <div class="border1">
                            <img class="lazy" data-src="{{ asset('images/home/borderimg.png') }}" height="50px"
                                alt="">
                        </div>
                        <div class="vrtsdiv">
                            <h5>10+</h5>
                            <h6>Variants</h6>
                        </div>
                        <div class="border1">
                            <img class="lazy" data-src="{{ asset('images/home/borderimg.png') }}" height="50px"
                                alt="">
                        </div>
                        <div class="ratediv">
                            <div class="stars">
                                <img class="lazy" data-src="{{ asset('images/home/star.png') }}" height="30px"
                                    alt="">
                                <img class="lazy" data-src="{{ asset('images/home/star.png') }}" height="30px"
                                    alt="">
                                <img class="lazy" data-src="{{ asset('images/home/star.png') }}" height="30px"
                                    alt="">
                                <img class="lazy" data-src="{{ asset('images/home/star.png') }}" height="30px"
                                    alt="">
                                <img class="lazy" data-src="{{ asset('images/home/star.png') }}" height="30px"
                                    alt="">
                            </div>
                            <h6 class="mt-3">Review</h6>
                        </div>
                    </div>
                    {{-- <div class="learnmore mt-5 text-center">
                        <a href="">Learn More <i class="fa-solid fa-arrow-right"></i></a>
                    </div> --}}
                </div>
                <div class="cimg2">
                    <img class="lazy" data-src="{{ asset('images/home/cardimg2.png') }}" width="90%"
                        alt="">
                </div>
            </div>
        </div>
    </div>

    <!-- Card Div2 -->



    <!-- Raincoats -->
    <div class="carddiv2">
        <div class="cimg3">
            <img class="lazy" data-src="{{ asset('images/home/cardimg3.png') }}" width="90%" alt="">
        </div>
        <div class="cct2">
            <h6>Excoso</h6>
            <h4>Embrace the Elements with Excoso Raincoats</h4>
            <span>
                Stay stylish and dry with Excoso's premium raincoats, designed to offer unparalleled protection against
                the elements. Our 2024 collection features raincoats that blend cutting-edge waterproof technology with
                sleek, modern designs. Each raincoat is crafted from high-quality, breathable materials that ensure you
                remain comfortable and dry, no matter the weather. Whether you're commuting in the city or adventuring
                in the great outdoors, Excoso raincoats provide the perfect combination of functionality and style.
                Embrace the rain with confidence and elegance, wearing a raincoat from Excoso.
            </span>
            <div class="cct4 mt-5">
                <div class="comfortable">
                    <div class="cmfimg">
                        <img class="lazy" data-src="{{ asset('images/home/comfort.png') }}" height="40px"
                            alt="">
                    </div>
                    <div class="cmfct">
                        <h5>Comfortable</h5>
                        <h6>With lots of unique blocks, you can easily build a page without coding.</h6>
                    </div>
                </div>
                <div class="comfortable">
                    <div class="cmfimg">
                        <img class="lazy" data-src="{{ asset('images/home/powerful.png') }}" height="40px"
                            alt="">
                    </div>
                    <div class="cmfct">
                        <h5>Powerful Bass</h5>
                        <h6>With lots of unique blocks, you can easily build a page without coding.</h6>
                    </div>
                </div>
            </div>
            <div class="cct3 mt-5">
                <div class="clrdiv">
                    <h5>10+</h5>
                    <h6>Color</h6>
                </div>
                <div class="border1">
                    <img class="lazy" data-src="{{ asset('images/home/borderimg.png') }}" height="50px"
                        alt="">
                </div>
                <div class="vrtsdiv">
                    <h5>10+</h5>
                    <h6>Variants</h6>
                </div>
                <div class="border1">
                    <img class="lazy" data-src="{{ asset('images/home/borderimg.png') }}" height="50px"
                        alt="">
                </div>
                <div class="ratediv">
                    <div class="stars">
                        <img class="lazy" data-src="{{ asset('images/home/star.png') }}" height="30px"
                            alt="">
                        <img class="lazy" data-src="{{ asset('images/home/star.png') }}" height="30px"
                            alt="">
                        <img class="lazy" data-src="{{ asset('images/home/star.png') }}" height="30px"
                            alt="">
                        <img class="lazy" data-src="{{ asset('images/home/star.png') }}" height="30px"
                            alt="">
                        <img class="lazy" data-src="{{ asset('images/home/star.png') }}" height="30px"
                            alt="">
                    </div>
                    <h6 class="mt-3">Review</h6>
                </div>
            </div>
            {{-- <div class="learnmore mt-5 text-center">
                <a href="">Learn More <i class="fa-solid fa-arrow-right"></i></a>
            </div> --}}
        </div>
    </div>

    <!-- Feature -->
    <div class="feature">
        <div class="featurect">
            <button class="button1">NEW</button><span>We've added a new exciting feature in v3.0. Get it now for
                $49.</span>
        </div>
    </div>

    <!-- Card3 -->
    <div class="card3">
        <div class="cards2">
            <div class="carddiv3">
                <div class="c3div1">
                    <div class="c3d1">
                        <h6>Excoso</h6>
                        <h4>Style with Excoso Caps</h4>
                        <p class="c3dp1">Elevate your style with Excoso's 2024 Caps collection, blending fashion and
                            functionality with high-quality materials. Perfect for sun protection or adding flair, these
                            caps offer a contemporary style and a perfect fit in various colors and designs.</p>
                        <div class="cct5 mt-3">
                            <div class="clrylw">
                                <h5>10+</h5>
                                <h6>Color</h6>
                            </div>
                            <div class="vrtsylw">
                                <h5>10+</h5>
                                <h6>Variants</h6>
                            </div>
                            <div class="rateylw">
                                <h5>4.5</h5>
                                <h6>Review</h6>
                            </div>
                        </div>
                        <div class="learnmore2 hover1 mt-4">
                            <h6 class="learnbtn1">Learn More <i class="fa-solid fa-arrow-right"></i></h6>
                        </div>
                    </div>
                </div>
                <div class="c3div2 mt-2">
                    <div class="c3d1">
                        <h6>Excoso</h6>
                        <h4>Stylish Dry Excoso Umbrellas</h4>
                        <p class="c3dp2">Stay stylish and dry with Excoso's 2024 Umbrellas, featuring wind resistance
                            and ergonomic handles. Available in various colors and styles, they blend durability with
                            sleek design for superior protection and comfort in any weather.</p>
                        <div class="cct5 mt-3">
                            <div class="clrblue">
                                <h5>10+</h5>
                                <h6>Color</h6>
                            </div>
                            <div class="vrtsblue">
                                <h5>10+</h5>
                                <h6>Variants</h6>
                            </div>
                            <div class="rateblue">
                                <h5>4.5</h5>
                                <h6>Review</h6>
                            </div>
                        </div>
                        <div class="learnmore2 hover2 mt-4">
                            <h6 class="learnbtn2">Learn More <i class="fa-solid fa-arrow-right"></i></h6>
                        </div>
                    </div>
                </div>
            </div>
            <div class="carddiv4">
                <div class="c3div3">
                    <div class="c3d2">
                        <h6>Excoso</h6>
                        <h4>Experience Ultimate Comfort with Excoso T-Shirts</h4>
                        <p>Experience ultimate comfort with Excoso's 2024 T-Shirt collection, crafted from premium,
                            breathable fabrics for softness and durability. Whether you favor classic or contemporary
                            styles, each shirt is designed to keep you stylish and comfortable all day. Perfect for
                            layering or standalone wear, Excoso T-shirts are versatile essentials that elevate any
                            wardrobe with their quality and comfort.</p>
                        <div class="cct6">
                            <div class="clrylw">
                                <h5>10+</h5>
                                <h6>Color</h6>
                            </div>
                            <div class="border1">
                                <img class="lazy" data-src="{{ asset('images/home/borderimg.png') }}"
                                    height="50px" alt="">
                            </div>
                            <div class="vrtsylw">
                                <h5>10+</h5>
                                <h6>Variants</h6>
                            </div>
                            <div class="border1">
                                <img class="lazy" data-src="{{ asset('images/home/borderimg.png') }}"
                                    height="50px" alt="">
                            </div>
                            <div class="ratediv">
                                <div class="stars">
                                    <img class="lazy" data-src="{{ asset('images/home/star.png') }}"
                                        height="20px" alt="">
                                    <img class="lazy" data-src="{{ asset('images/home/star.png') }}"
                                        height="20px" alt="">
                                    <img class="lazy" data-src="{{ asset('images/home/star.png') }}"
                                        height="20px" alt="">
                                    <img class="lazy" data-src="{{ asset('images/home/star.png') }}"
                                        height="20px" alt="">
                                    <img class="lazy" data-src="{{ asset('images/home/star.png') }}"
                                        height="20px" alt="">
                                </div>
                                <h6 class="mt-3">Review</h6>
                            </div>
                        </div>
                        <div class="learnmore">
                            <a href="">Learn More <i class="fa-solid fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Why Choose Us -->
    <div class="choose">
        <div class="choosect">
            <div class="choosediv">
                <h4>Why Choose Us</h4>
            </div>
            <div class="choosediv">
                <h5>Superior Quality and Craftsmanship</h5>
                <h6>At Excoso, we craft high-quality products with premium materials and skilled craftsmanship. Our
                    durable raincoats, stylish T-shirts, innovative umbrellas, and functional backpacks are meticulously
                    designed to last. Each item meets our exacting standards of excellence.</h6>
                {{-- <a href="">More Info <i class="fa-solid fa-arrow-right"></i></a> --}}
            </div>
            <div class="choosediv">
                <h5>Innovation and Functional Design</h5>
                <h6>Experience innovation with Excoso's products. Our wind-resistant umbrellas, waterproof raincoats,
                    stylish jackets, versatile T-shirts, and practical backpacks offer comfort, durability, and
                    contemporary style. Elevate your lifestyle with Excoso.</h6>
                {{-- <a href="">More Info <i class="fa-solid fa-arrow-right"></i></a> --}}
            </div>
            <div class="choosediv">
                <h5>Commitment to Customer Satisfaction</h5>
                <h6>At Excoso, we prioritize your satisfaction with exceptional customer service. From product advice to
                    post-purchase support, our dedicated team ensures your experience exceeds expectations.</h6>
                {{-- <a href="">More Info <i class="fa-solid fa-arrow-right"></i></a> --}}
            </div>
        </div>
    </div>

    <!-- Selling Products -->



    <div class="product">
        <div class="productdiv">
            <div class="carousel2">
                <div class="carousel2heading text-center">
                    <h4>Best Selling Products Excoso</h4>
                </div>
                <div class="tabbuttons">
                    @foreach ($allProducts as $category => $products)
                        <button class="viewcatbtn button2 {{ $loop->first ? 'buttonactive1' : '' }}"
                            id="{{ strtolower($category) }}" data-category="{{ $category }}">
                            {{-- it will have the category names --}}
                            {{ $category }}
                        </button>
                    @endforeach
                </div>

                <div id="carousel-container">
                    <div id="carousel2" class="splide" aria-label="Beautiful Images">
                        <div class="splide__track">
                            <ul class="splide__list content-container" id="carousel-content">
                                <!-- Carousel items will be injected here dynamically -->
                                {{-- the dynamic content is display here which in the ajax page --}}
                            </ul>
                        </div>
                    </div>
                </div>


                {{-- @foreach ($allProducts as $category => $products) --}}
                <div class="viewall text-center mt-5">
                    <a class="btnview"> View All <i class="fa-solid fa-arrow-right"></i></a>
                </div>
                {{-- @endforeach --}}
            </div>
        </div>
    </div>

    {{-- @foreach ($allProducts as $category => $products)
    @php
    $routeName = 'view.' . strtolower($category);
    $firstProduct = $products->first();
    $images = json_decode($firstProduct->images, true);

    @endphp
    <a href="{{ route($routeName) }}" class="ellipsediv">
        <div class="eimg">

            <img src="{{ asset('images/addproduct/' . $images[0]) }}" alt="{{ $firstProduct->product_name }}"
                style="max-width: 50px; margin: 5px;">

        </div>
        <div class="ect">
            <h5>{{ $category }}</h5>
            <h6>{{ count($products) }} Product</h6>
        </div>
    </a>
    @endforeach --}}

    <!-- All Products -->
    <div class="allproducts">
        <div class="allproductshead">
            <h4>Explore All Products</h4>
        </div>

        <div class="allprdtdiv">
            @foreach ($allProducts as $category => $products)
                @if ($products->isNotEmpty())
                    <a href="{{ route('viewproduct', ['category' => $category]) }}" class="category-link"
                        {{-- it will dsiplay
                                the dynamic pages name 'category' in the name of viewproduct/--category-- --}} data-category="{{ $category }}">
                        @php
                            $routeName = strtolower($category); // Use category name directly
                            $firstProduct = $products->first();
                            $images = json_decode($firstProduct->images, true);
                        @endphp
                        {{-- <a href="{{ route('viewproducts.' . $routeName) }}" class="category-link"
                                    data-category="{{ $routeName }}"> --}}
                        <div class="allprdtdiv1">
                            <div class="allprdtimg">
                                <img class="lazy" data-src="{{ asset('images/addproduct/' . $images[0]) }}"
                                    alt="{{ $firstProduct->product_name }}" height="200px" class="product-image">
                            </div>
                            <div class="allprdtcntnt">
                                <h6>{{ ucfirst($category) }}</h6>
                                <span class="rating">
                                    @for ($i = 0; $i < 4; $i++)
                                        <img class="lazy" data-src="{{ asset('images/home/fullstr.png') }}"
                                            height="10px" alt="">
                                    @endfor
                                    <img class="lazy" data-src="{{ asset('images/home/halfstr.png') }}"
                                        height="10px" alt="">
                                    <span class="totalreview">(4 Review)</span>
                                </span>
                                <h6 class="mt-3">
                                    <span class="dashed">₹1500</span> &nbsp;
                                    <span class="original">₹{{ number_format($firstProduct->price) }}</span>
                                </h6>
                            </div>
                        </div>
                    </a>
                @endif
            @endforeach
        </div>
        <div class="viewall text-center mt-5">
            <a href="">View All <i class="fa-solid fa-arrow-right"></i></a>
        </div>
    </div>

    <!-- Review -->
    <div class="review">
        <div class="carousel3">
            <section id="carousel8" class="splide" aria-label="Beautiful Images">
                <div class="splide__track">
                    <ul class="splide__list">
                        <li class="splide__slide">
                            <div class="carousel3ct">
                                <div class="quotes">
                                    <img src="{{ asset('images/home/quotes.png') }}" height="50px" alt="">
                                </div>
                                <div class="reviewrate">
                                    <img src="{{ asset('images/home/fullstr.png') }}" height="25px" alt="">
                                    <img src="{{ asset('images/home/fullstr.png') }}" height="25px" alt="">
                                    <img src="{{ asset('images/home/fullstr.png') }}" height="25px" alt="">
                                    <img src="{{ asset('images/home/fullstr.png') }}" height="25px" alt="">
                                    <img src="{{ asset('images/home/halfstr.png') }}" height="25px" alt="">
                                </div>
                                <div class="reviewct">
                                    “ OMG! I cannot believe that I have got a brand new Bag after getting your services.
                                    It was super easy to order and get started. ”
                                    <br><br>
                                    <div class="reviewname">
                                        <i class="fa-solid fa-minus"></i>&nbsp; Divya USA
                                    </div>
                                </div>
                            </div>
                            <div class="carosuel3img">
                                <div class="carousel3bg">
                                    <img src="{{ asset('images/home/reviewbg.png') }}" id="rvwbg" height="450px"
                                        alt="">
                                    <img src="{{ asset('images/home/reviewimg.png') }}" id="rvwimg"
                                        height="450px" alt="">
                                </div>
                            </div>
                        </li>
                        <li class="splide__slide">
                            <div class="carousel3ct">
                                <div class="quotes">
                                    <img src="{{ asset('images/home/quotes.png') }}" height="50px" alt="">
                                </div>
                                <div class="reviewrate">
                                    <img src="{{ asset('images/home/fullstr.png') }}" height="25px" alt="">
                                    <img src="{{ asset('images/home/fullstr.png') }}" height="25px" alt="">
                                    <img src="{{ asset('images/home/fullstr.png') }}" height="25px" alt="">
                                    <img src="{{ asset('images/home/fullstr.png') }}" height="25px" alt="">
                                    <img src="{{ asset('images/home/halfstr.png') }}" height="25px" alt="">
                                </div>
                                <div class="reviewct">
                                    “ OMG! I cannot believe that I have got a brand new Bag after getting your services.
                                    It was super easy to order and get started. ”
                                    <br><br>
                                    <div class="reviewname">
                                        <i class="fa-solid fa-minus"></i>&nbsp; Divya USA
                                    </div>
                                </div>
                            </div>
                            <div class="carosuel3img">
                                <div class="carousel3bg">
                                    <img src="{{ asset('images/home/reviewbg.png') }}" id="rvwbg" height="450px"
                                        alt="">
                                    <img src="{{ asset('images/home/reviewimg.png') }}" id="rvwimg"
                                        height="450px" alt="">
                                </div>
                            </div>
                        </li>
                        <li class="splide__slide">
                            <div class="carousel3ct">
                                <div class="quotes">
                                    <img src="{{ asset('images/home/quotes.png') }}" height="50px" alt="">
                                </div>
                                <div class="reviewrate">
                                    <img src="{{ asset('images/home/fullstr.png') }}" height="25px" alt="">
                                    <img src="{{ asset('images/home/fullstr.png') }}" height="25px" alt="">
                                    <img src="{{ asset('images/home/fullstr.png') }}" height="25px" alt="">
                                    <img src="{{ asset('images/home/fullstr.png') }}" height="25px" alt="">
                                    <img src="{{ asset('images/home/halfstr.png') }}" height="25px" alt="">
                                </div>
                                <div class="reviewct">
                                    “ OMG! I cannot believe that I have got a brand new Bag after getting your services.
                                    It was super easy to order and get started. ”
                                    <br><br>
                                    <div class="reviewname">
                                        <i class="fa-solid fa-minus"></i>&nbsp; Divya USA
                                    </div>
                                </div>
                            </div>
                            <div class="carosuel3img">
                                <div class="carousel3bg">
                                    <img src="{{ asset('images/home/reviewbg.png') }}" id="rvwbg" height="450px"
                                        alt="">
                                    <img src="{{ asset('images/home/reviewimg.png') }}" id="rvwimg"
                                        height="450px" alt="">
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </section>
        </div>
    </div>

    <!-- Subscribe -->
    <div class="subscribe">
        <div class="subscribediv">
            <div class="envelope mt-3">
                <i class="fa-solid fa-envelope"></i>
            </div>
            <div class="subscribehead mt-2">
                <h4>Subscribe to our Excoso to get latest <br> news on your inbox.</h4>
            </div>
            <div class="subscribeinp mt-2">
                <input type="text" name="" id="" placeholder="Enter your Email">
                <button class="button3">Subscribe</button>
            </div>
            <div class="subscribect mt-3">
                <p>
                    We'll never share your details with third parties. <br>
                    View our Privacy Policy for more info.
                </p>
            </div>
        </div>
    </div>


    <!-- Footer -->

    @include('footer')

    <!-- Popup -->
    <div class="modal" id="modal">
        <div class="modal1">
            <div class="modaldiv">
                <div class="modalheading d-flex justify-content-between align-items-center">
                    <h5>Get in touch With us?</h5>
                    <span class="close">&times;</span>
                </div>
                <!-- Modal Container -->
                <div class="modalct container">
                    <form id="modalForm" method="POST" action="{{ route('formajax') }}">
                        @csrf
                        <div class="formdiv row">
                            <div class="col-md-12 mt-4">
                                <label for="name">Name</label><br>
                                <input type="text" name="name" id="name" placeholder="Enter Your Name">
                            </div>
                            <div class="col-md-12 mt-4">
                                <label for="email">Email Address</label><br>
                                <input type="email" name="email" id="email" placeholder="Enter Your Email">
                            </div>
                            <div class="col-md-12 mt-4">
                                <label for="tel">Mobile Number</label><br>
                                <input type="tel" name="mobile" id="mobile" placeholder="Enter Your Mobile Number">
                            </div>
                            <div class="col-md-12 mt-4">
                                <button type="submit" id="formsubmit" class="button5">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Scripts -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js"></script>
    <script src="./js/script1.js"></script>
    {{--
    <script src="path/to/jquery.lazyload.min.js"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/lozad@latest"></script>
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>


</body>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        new Splide('#carousel1', {
            type: 'fade',
            perPage: 1,
            autoplay: true,
            interval: 2000,
            rewind: true,
        }).mount();
    });

    document.addEventListener('DOMContentLoaded', function() {
        new Splide('#carousel8', {
            type: 'fade',
            perPage: 1,
            autoplay: true,
            interval: 1500,
            rewind: true,
        }).mount();
    });
</script>

<script>
    $(document).ready(function() {
        $('.btnview').on('click', function() {
            let activeTab = $('.tabbuttons').find('.viewcatbtn.buttonactive1');

            // Get the id attribute of the active tab button
            let categoryId = activeTab.attr('id');

            console.table(categoryId);
            window.location.href = '/viewproduct/' + categoryId;

        });


    });
</script>
{{-- this is the ajax page that will take the category from the tab and disply the related content fetch
from the ajax in the respective div and it will display the first tab content in onload the page --}}
<script>
    $(document).ready(function() {
        // Function to initialize Splide carousel
        function initializeCarousel() {
            var itemCount = $('#carousel-content .splide__slide').length;
            var loop = itemCount > 1; // Enable loop only if there is more than one item

            var splide = new Splide('#carousel2', {
                type: loop ? 'loop' : 'slide',
                perPage: 2,
                perMove: 1,
                autoplay: true,
                interval: 7000,
                rewind: false,
            }).mount();
        }

        // Function to fetch products based on category
        function fetchProducts(category) {
            var url = '{{ route('fetchproducts') }}'; // Endpoint URL

            $.ajax({
                url: url,
                type: 'GET',
                data: {
                    category: category
                },
                success: function(response) {
                    $('.content-container').html(
                        response); // Update content container with fetched data
                    initializeCarousel(); // Initialize the carousel after updating the content
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching data:', error);
                }
            });
        }

        // Fetch products for the first tab on page load
        var firstCategory = $('.tabbuttons .button2').first().data('category');
        fetchProducts(firstCategory);

        // Handle tab button clicks
        $('.tabbuttons .button2').on('click', function() {
            var category = $(this).data('category').trim();
            fetchProducts(category);

            // Update active class
            $('.tabbuttons .button2').removeClass('buttonactive1');
            $(this).addClass('buttonactive1');

            return false; // Prevent default behavior of button click
        });
    });
</script>
{{-- this is the button active script for the Tabs div --}}
<script>
    $(document).ready(function() {
        $('.button2').click(function() {
            var tabId = $(this).attr('id'); // Get the ID of the clicked tab button
            var categoryName = tabId.substring(4); // Extract category name from the tab ID

            // Hide all content divs
            $('.content').hide();

            // Remove active class from all tab buttons
            $('.button2').removeClass('buttonactive1');

            // Show the selected content div
            $('#' + categoryName + '-content').show();

            // Add active class to the clicked tab button
            $(this).addClass('buttonactive1');
        });
    });
</script>
{{-- this is the lazy loading script --}}
<script>
    lozad('.lazy', {
        load: function(ele) {
            ele.src = ele.dataset.src; // Set the src attribute to the value of data-src
            ele.onload = function() {
                //  ele.classList.add('fade');   // Add 'fade' class after the image is loaded
            }
        }
    }).observe();
</script>
<script>
    $(document).ready(function() {
        $('.learnmore2 .learnbtn1').click(function() {
            $('.c3dp1').slideToggle('slow', function() {
                // Toggle opacity based on visibility
                $(this).css('opacity', function() {
                    return $(this).is(':visible') ? 1 : 0;
                });
            });
            $('.hover1').hide();
        });
    });
    $(document).ready(function() {
        $('.learnmore2 .learnbtn2').click(function() {
            $('.c3dp2').slideToggle('slow', function() {
                // Toggle opacity based on visibility
                $(this).css('opacity', function() {
                    return $(this).is(':visible') ? 1 : 0;
                });
            });
            $('.hover2').hide();
        });
    });
</script>
<script>
   $(function() {
    // Function to show the modal
    function showPopup() {
        $('#modal').show(); // Show modal
    }

    // Automatically show modal after 1 second
    setTimeout(showPopup, 15000);

    // Function to hide modal
    function hidePopup() {
        $('#modal').hide(); // Hide modal
    }

    // Close modal when clicking on close button
    $('.close').click(function() {
        hidePopup();
    });

    // AJAX form submission
    $('#modalForm').submit(function(e) {
        e.preventDefault();

        // var formData = {
        //     name: $('#name').val(),
        //     email: $('#email').val(),
        //     mobile: $('#mobile').val() // Corrected from 'phone' to 'tel'
        // };

        var formData = {
            name: $('#name').val(),
            email: $('#email').val(),
            mobile: $('#mobile').val(),
            _token: '{{ csrf_token() }}'
        };



        console.log(formData);

        $.ajax({
            type: 'POST',
            url: '{{ route('formajax') }}',
            data: formData,


            success: function(response) {
                console.log('Form submitted successfully');
                hidePopup(); // Hide modal on success
                // Handle success scenario (e.g., show success message, redirect, etc.)
            },
            error: function(xhr, status, error) {
                console.error(xhr);
                // Handle error scenario (e.g., display error message)
            }
        });
    });
});

</script>

</html>
