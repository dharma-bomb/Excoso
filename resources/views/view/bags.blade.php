<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excoso | View Bags</title>

    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Stylesheets -->
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/footer.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/product.css') }}">

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
<style>
      .product {
            display: none;
        }

        .product:first-of-type {
            display: block;
        }
</style>

<body>

    <!-- Navbar -->
    @include('navbar')

    <!-- Directory Heading -->
    <div class="dheading">
        <div class="dheaddiv">
            <span><a href="{{ url('/') }}">Home</a></span>
            <span><i class="fa-solid fa-angle-right"></i></span>
            <span><a id="products">Bags</a></span>
            <span><i class="fa-solid fa-angle-right"></i></span>
            <span><a href="" class="dheadactive">View Product</a></span>
        </div>
    </div>

    <!-- Product -->
    <div class="product01 album0">
        <div class="product0">
            <div class="productdiv">
                <div id="bag">
                    <div id="carousel1" class="splide" aria-label="Beautiful Images">
                        <div class="splide__track">
                            <ul class="splide__list">
                                @foreach ($products as $product)
                                    @php
                                        $images = json_decode($product->images);
                                    @endphp
                                    @if (!empty($images))
                                        <li class="splide__slide alb{{ $loop->iteration }}">
                                            <a href="#alb{{ $loop->iteration }}" class="product-link">
                                                <img src="{{ asset('images/addproduct/' . $images[2]) }}"
                                                    alt="{{ $product->product_name }}" height="200px"
                                                    class="productimg">
                                                <div class="splidecntnt">
                                                    <h6>{{ ucfirst($product->cat) }}</h6>
                                                    <h5>{{ $product->Productname }}</h5>
                                                    <span class="rating">
                                                        @for ($i = 0; $i < 4; $i++)
                                                            <img src="{{ asset('images/home/fullstr.png') }}"
                                                                height="10px" alt="">
                                                        @endfor
                                                        <img src="{{ asset('images/home/halfstr.png') }}"
                                                            height="10px" alt="">
                                                        <span class="totalreview">(4 Review)</span>
                                                    </span>
                                                    <h6 class="mt-3">
                                                        <span class="dashed">₹ 1599</span> &nbsp;
                                                        <span class="original">₹ {{ $product->price }}</span>
                                                    </h6>
                                                </div>
                                            </a>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @foreach ($products as $product)
        @php
            $images = json_decode($product->images);
        @endphp
        @if (!empty($images))
            <div class="product alb{{ $loop->iteration }}" id="alb{{ $loop->iteration }}"
                style="{{ $loop->first ? '' : 'display: none;' }}">
                <div class="productcard">
                    <div class="productimg">
                        <div class="prdtimg">
                            @foreach ($images as $index => $image)
                                <img src="{{ asset('images/addproduct/' . $image) }}" class="pimg{{ $index }}"
                                    style="{{ $index > 0 ? 'display: none;' : '' }}" alt="">
                            @endforeach
                        </div>
                        <div class="prdtalbum">
                            @foreach ($images as $index => $image)
                                <img src="{{ asset('images/addproduct/' . $image) }}" class="pimg0{{ $index }}"
                                    data-product-id="{{ $loop->iteration }}" alt="">
                            @endforeach
                        </div>
                    </div>
                    <div class="productcntnt">
                        <div class="prdtct1">
                            <span class="sales">Sales Off</span>
                            <h5 class="mt-4">{{ $product->product_name }}</h5>
                            <h6 class="mt-4">{{ $product->cat }}</h6>
                            <h6 class="mt-3">{{ $product->subcat }}</h6>
                            <div class="ratingdiv mt-4">
                                @for ($i = 0; $i < 5; $i++)
                                    <img src="{{ asset('images/product/star.png') }}" height="25px" alt="">
                                @endfor
                            </div>
                            <div class="pricediv mt-4">
                                <div class="original">
                                    <h5>₹ {{ $product->price }}</h5>
                                </div>
                                <div class="dashed">
                                    <span class="priceylw">26% OFF</span>
                                    <span class="priceblk">₹ 1599</span>
                                </div>
                            </div>
                            <p class="mt-4">{{ $product->description }}</p>
                            <div class="size mt-4">
                                <h5>Size</h5>
                                <div class="sizebox">
                                    {{-- Render sizes here --}}
                                </div>
                            </div>
                            <div class="addtocart mt-5">
                                <div class="quantity">
                                    <input type="number" placeholder="0" min="0" max="20">
                                </div>
                                <div class="acbtn">
                                    <button class="button4">
                                        <i class="fa-solid fa-cart-shopping"></i> &nbsp; Add To Cart
                                    </button>
                                </div>
                                <div class="heartbox">
                                    <i class="fa-regular fa-heart"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endforeach

    <!-- Related Products -->
    <div class="details">
        <div class="detailsdiv">
            <!-- All Products -->
            <div class="allproducts">
                <div class="allproductshead">
                    <h4>Related Products</h4>
                </div>

                <div class="allprdtdiv">
                    @foreach ($allproducts as $category)
                        @php
                            $images = json_decode($category->images);
                            $firstImage = $images[1];
                        @endphp
                        <a href="{{ url('/view-product/' . $category->id) }}">
                            <div class="allprdtdiv1">
                                <div class="allprdtimg">
                                    <img src="{{ asset('images/addproduct/' . $firstImage) }}" height="200px"
                                        alt="{{ $category->product_name }}">
                                </div>
                                <div class="allprdtcntnt">
                                    <h6>{{ $category->cat }}</h6>
                                    <h5>{{ $category->subcat }}</h5>
                                    <span class="rating">
                                        @for ($i = 0; $i < 4; $i++)
                                            <img src="{{ asset('images/home/fullstr.png') }}" height="10px"
                                                alt="">
                                        @endfor
                                        <img src="{{ asset('images/home/halfstr.png') }}" height="10px"
                                            alt="">
                                        {{-- <span class="totalreview">({{ $product->reviews_count }} Reviews)</span> --}}
                                    </span>
                                    <h6 class="mt-3">
                                        <span class="dashed">₹1599</span> &nbsp;
                                        <span class="original">₹{{ $category->price }}</span>
                                    </h6>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>

            </div>


            <!-- Cards -->
            <div class="card1">
                <div class="cards">
                    <div class="carddiv">
                        <div class="cimg1">
                            <img src="{{ asset('images/home/cicon1.png') }}" height="30px" alt="">
                        </div>
                        <div class="cct1">
                            <h5>Free Delivery</h5>
                            <h6>Orders from all item</h6>
                        </div>
                    </div>
                    <div class="carddiv">
                        <div class="cimg1">
                            <img src="{{ asset('images/home/cicon2.png') }}" height="30px" alt="">
                        </div>
                        <div class="cct1">
                            <h5>Return & Refund</h5>
                            <h6>Money back guarantee</h6>
                        </div>
                    </div>
                    <div class="carddiv">
                        <div class="cimg1">
                            <img src="{{ asset('images/home/cicon3.png') }}" height="30px" alt="">
                        </div>
                        <div class="cct1">
                            <h5>Member Discount</h5>
                            <h6>One very order over $140.00</h6>
                        </div>
                    </div>
                    <div class="carddiv">
                        <div class="cimg1">
                            <img src="{{ asset('images/home/cicon4.png') }}" height="30px" alt="">
                        </div>
                        <div class="cct1">
                            <h5>Support 24/7</h5>
                            <h6>Contact us 24 hours a day</h6>
                        </div>
                    </div>
                </div>
            </div>

            <!-- BG Card -->
            <div class="bgcard">
                <div class="bgcarddiv">
                    <div class="bgcard1">
                        <div class="bgcardct1">
                            <h6>Excose</h6>
                            <h5>The Best T-Shirt Collection 2024</h5>
                            <div class="learnmore">
                                <a href="">Shop Now <i class="fa-solid fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="bgcard2">
                        <div class="bgcardct2">
                            <h6>Excose</h6>
                            <h5>The Best Cap Collection 2024</h5>
                            <div class="learnmore">
                                <a href="">Shop Now <i class="fa-solid fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
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
                <div class="modalct container">
                    <form action="">
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
                                <input type="tel" name="tel" id="tel"
                                    placeholder="Enter Your Mobile Number">
                            </div>
                            <div class="col-md-12 mt-4">
                                <button class="button5">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js"></script>
    <script src="./js/script1.js"></script>

</body>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const carousels = [
            '#carousel1'
        ]; // Add more carousel IDs if needed, like ['#carousel1', '#carousel2', ...]

        carousels.forEach(function(carousel) {
            new Splide(carousel, {
                type: 'loop',
                perPage: 2, // Adjust perPage based on your requirement
                perMove: 1,
                autoplay: true,
                interval: 2000,
                rewind: true,
            }).mount();
        });
    });
</script>

<script>
    // Tabs - Tab Buttons Navigate
    // $(document).ready(function() {
    //     $(".button2").click(function() {
    //         var id = $(this).attr("id");
    //         $(".button2").removeClass("buttonactive1");
    //         $(this).addClass("buttonactive1");

    //         // Hide all sections
    //         $("#bag, #cap, #raincoat, #jacket, #tshirt, #umbrella").hide();

    //         if (id === "bg") {
    //             $("#bag").show();
    //         } else if (id === "cp") {
    //             $("#cap").show();
    //         } else if (id === "rct") {
    //             $("#raincoat").show();
    //         } else if (id === "jkt") {
    //             $("#jacket").show();
    //         } else if (id === "tst") {
    //             $("#tshirt").show();
    //         } else if (id === "ula") {
    //             $("#umbrella").show();
    //         }
    //     });
    // });
</script>

<script>
    $(function() {
        $(".pimg00").click(function() {
            showImage(".pimg0");
        });
        $(".pimg01").click(function() {
            showImage(".pimg1");
        });
        $(".pimg02").click(function() {
            showImage(".pimg2");
        });
        $(".pimg03").click(function() {
            showImage(".pimg3");
        });
        $(".pimg04").click(function() {
            showImage(".pimg4");
        });
    });

    function showImage(imgSelector) {
        $(imgSelector).show().siblings().hide();
    }
</script>

<script>
    // function showPopup() {
    //     var modal = document.getElementById("modal");
    //     modal.style.display = "block";
    // }

    // setTimeout(showPopup, 50000);

    // $(function () {
    //     $(".close").click(function () {
    //         $(".modal").hide()
    //     });
    // });
</script>



<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        $('.product-link').click(function(e) {
            e.preventDefault();
            var target = $(this).attr('href');
            $('.product').hide();
            $(target).show();

            // Smooth scroll to the product div
            $('html, body').animate({
                scrollTop: $(target).offset().top
            }, 500); // Adjust the duration (500) as needed for the smooth scroll
        });
    });
</script>


</html>
