<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excoso | View T-Shirts</title>

    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Stylesheets -->
    <link rel="stylesheet" href="./css/navbar.css">
    <link rel="stylesheet" href="./css/footer.css">
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/product.css">

    <!-- jQuery UI -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

    <!-- AOS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Oregano:ital@0;1&display=swap" rel="stylesheet">

    <!-- Carousel -->
    <link href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css" rel="stylesheet">

</head>

<body>

    <!-- Navbar -->
    <?php include('./navbar.php'); ?>

    <!-- Directory Heading -->
    <div class="dheading">
        <div class="dheaddiv">
            <span><a href="./index.php">Home</a></span>
            <span><i class="fa-solid fa-angle-right"></i></span>
            <span><a id="products">T-Shirt</a></span>
            <span><i class="fa-solid fa-angle-right"></i></span>
            <span><a href="" class="dheadactive">View Product</a></span>
        </div>
    </div>

    <!-- Product -->
    <div class="product">
        <div class="productcard">

            <!-- Product Images -->
            <div class="productimg">
                <div class="prdtimg">
                    <img src="./images/product/pimg1.png" id="pimg0" alt="">
                    <img src="./images/product/pimg1.png" style="display: none;" id="pimg1" alt="">
                    <img src="./images/product/pimg2.png" style="display: none;" id="pimg2" alt="">
                    <img src="./images/product/pimg3.png" style="display: none;" id="pimg3" alt="">
                    <img src="./images/product/pimg4.png" style="display: none;" id="pimg4" alt="">
                </div>
                <div class="prdtalbum">
                    <img src="./images/product/pimg1.png" id="pimg01" alt="">
                    <img src="./images/product/pimg2.png" id="pimg02" alt="">
                    <img src="./images/product/pimg1.png" id="pimg00" alt="">
                    <img src="./images/product/pimg3.png" id="pimg03" alt="">
                    <img src="./images/product/pimg4.png" id="pimg04" alt="">
                </div>
            </div>

            <!-- Product Content -->
            <div class="productcntnt">
                <div class="prdtct1">
                    <span class="sales">Sales Off</span>
                    <h5 class="mt-4">Excoso T-Shirts</h5>
                    <h6 class="mt-4">Men's T-Shirts Collection</h6>
                    <div class="ratingdiv mt-4">
                        <img src="./images/product/star.png" height="25px" alt="">
                        <img src="./images/product/star.png" height="25px" alt="">
                        <img src="./images/product/star.png" height="25px" alt="">
                        <img src="./images/product/star.png" height="25px" alt="">
                        <img src="./images/product/star.png" height="25px" alt="">
                        <h6>5.0 <span>(121 Reviews)</span></h6>
                    </div>
                    <div class="pricediv mt-4">
                        <div class="original">
                            <h5>₹ 1299.00</h5>
                        </div>
                        <div class="dashed">
                            <span class="priceylw">26% OFF</span>
                            <span class="priceblk">₹ 399</span>
                        </div>
                    </div>
                    <p class="mt-4">We share common trends and strategies for improving your rental income. With lots of
                        unique
                        blocks, you can easily build a page without coding. Build your next landing page.With lots of
                        unique blocks, you can easily build a page without coding. Build your next landing</p>
                    <div class="color mt-4">
                        <h5>Colors</h5>
                        <div class="colorinp">
                            <div class="clrbox pk"></div>
                            <div class="clrbox pple"></div>
                            <div class="clrbox sl"></div>
                            <div class="clrbox bk"></div>
                            <div class="clrbox gn"></div>
                            <div class="clrbox ph"></div>
                            <div class="clrbox bl"></div>
                        </div>
                    </div>
                    <div class="size mt-4">
                        <h5>Size</h5>
                        <div class="sizebox">
                            <div class="szbox">XS</div>
                            <div class="szbox">S</div>
                            <div class="szbox">M</div>
                            <div class="szbox">L</div>
                            <div class="szbox">XL</div>
                            <div class="szbox">2XL</div>
                            <div class="szbox">3XL</div>
                        </div>
                    </div>
                    <div class="addtocart mt-4">
                        <div class="quantity">
                            <input type="number" name="" id="" placeholder="0" min="0" max="20">
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

    <!-- Description -->
    <div class="details">
        <div class="detailsdiv">
            <div class="detailsnav">
                <h5>Description</h5>
                <h5>Additional Information</h5>
                <h5>(121)Review</h5>
            </div>
            <hr>

            <div class="descriptionct">
                <div class="dscptct">
                    <p>
                        We share common trends and strategies for improving your rental income. With lots of unique
                        blocks,
                        you
                        can easily build a page without coding.
                        Build your next landing page.With lots of unique blocks, you can easily build a page without
                        coding.
                        Build your next landing We share common
                        trends and strategies for improving your rental income.With lots of unique blocks, you can
                        easily
                        build
                        a page without coding. Build your next
                        landing page.With lots of unique blocks, you can easily build a page without coding. Build your
                        next
                        landing We share common trends and strateg
                        ies for improving your rental income.With lots of unique blocks, you can easily build a page
                        without
                        coding. Build your next landing page. With
                        lots of unique blocks, you can easily build a page without coding. Build your next landing We
                        share
                        common trends and strategies for improving
                        your rental income.With lots of unique blocks, you can easily build a page without coding. Build
                        your
                        next landing page. With lots of unique blocks,
                        you can easily build a page without coding. Build your next landing.
                    </p>
                </div>

                <div class="prdttable mt-5">
                    <div class="tblehead">
                        <h5>Product details</h5>
                    </div>
                    <table class="mt-3">
                        <tbody>
                            <tr>
                                <th>Material composition</th>
                                <td>Cotton</td>
                            </tr>
                            <tr>
                                <th>Pattern</th>
                                <td>Printed</td>
                            </tr>
                            <tr>
                                <th>Fit type</th>
                                <td>Oversized Fit</td>
                            </tr>
                            <tr>
                                <th>Sleeve type</th>
                                <td>Half Sleeve</td>
                            </tr>
                            <tr>
                                <th>Length</th>
                                <td>Standard Length</td>
                            </tr>
                            <tr>
                                <th>Neck style</th>
                                <td>Dom</td>
                            </tr>
                            <tr>
                                <th>Country of Origin</th>
                                <td>India</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- About Item -->
                <div class="aboutitem mt-5">
                    <div class="aboutheading">
                        <h5>About this item</h5>
                    </div>

                    <div class="aboutlist">
                        <ul>
                            <li>
                                <i class="fa-solid fa-circle"></i> &nbsp;Comfort & Style : Best Fashionably
                                Comfortable.High Fashion rich culture look will get just teaming up with washed jeans.
                            </li>
                            <li>
                                <i class="fa-solid fa-circle"></i> &nbsp;Fabric: 100% Cotton; Premium Export Quality
                                Branded Full Sleeve T-shirt for Women.
                            </li>
                            <li>
                                <i class="fa-solid fa-circle"></i> &nbsp;Wash Care : Usual Machine wash or Regular wash
                                is preferable.Check the Size chart for perfect fit.
                            </li>
                            <li>
                                <i class="fa-solid fa-circle"></i> &nbsp;Age Range Description: Adult; Closure Type:
                                Pull over; Fit Type: Oversized Fit.
                            </li>
                            <li>
                                <i class="fa-solid fa-circle"></i> &nbsp;This Blue Graphic Oversized T-shirt from
                                Dillinger is a great way to look stylish as ever. It can be paired with denim to have a
                                complete look.
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Related Products -->
                <!-- All Products -->
                <div class="allproducts">
                    <div class="allproductshead">
                        <h4>Related Products</h4>
                    </div>

                    <div class="allprdtdiv">
                        <div class="allprdtdiv1">
                            <div class="allprdtimg">
                                <img src="./images/home/bag1.png" height="200px" alt="">
                            </div>
                            <div class="allprdtcntnt">
                                <h6>Bag</h6>
                                <h5>Urvan Bags</h5>
                                <span class="rating">
                                    <img src="./images/home/fullstr.png" height="10px" alt="">
                                    <img src="./images/home/fullstr.png" height="10px" alt="">
                                    <img src="./images/home/fullstr.png" height="10px" alt="">
                                    <img src="./images/home/fullstr.png" height="10px" alt="">
                                    <img src="./images/home/halfstr.png" height="10px" alt="">
                                    (4 Review)
                                </span>
                                <h6 class="mt-3"><span class="dashed">₹1500</span> &nbsp;<span class="original">₹1299.99</span></h6>
                            </div>
                        </div>
                        <div class="allprdtdiv1">
                            <div class="allprdtimg">
                                <img src="./images/home/bag2.png" height="200px" alt="">
                            </div>
                            <div class="allprdtcntnt">
                                <h6>Bag</h6>
                                <h5>X-Terra Bags</h5>
                                <span class="rating">
                                    <img src="./images/home/fullstr.png" height="10px" alt="">
                                    <img src="./images/home/fullstr.png" height="10px" alt="">
                                    <img src="./images/home/fullstr.png" height="10px" alt="">
                                    <img src="./images/home/fullstr.png" height="10px" alt="">
                                    <img src="./images/home/halfstr.png" height="10px" alt="">
                                    (4 Review)
                                </span>
                                <h6 class="mt-3"><span class="dashed">₹1500</span> &nbsp;<span class="original">₹1299.99</span></h6>
                            </div>
                        </div>
                        <div class="allprdtdiv1">
                            <div class="allprdtimg">
                                <img src="./images/home/cap1.png" height="200px" alt="">
                            </div>
                            <div class="allprdtcntnt">
                                <h6>Cap</h6>
                                <h5>Red Caps</h5>
                                <span class="rating">
                                    <img src="./images/home/fullstr.png" height="10px" alt="">
                                    <img src="./images/home/fullstr.png" height="10px" alt="">
                                    <img src="./images/home/fullstr.png" height="10px" alt="">
                                    <img src="./images/home/fullstr.png" height="10px" alt="">
                                    <img src="./images/home/halfstr.png" height="10px" alt="">
                                    (4 Review)
                                </span>
                                <h6 class="mt-3"><span class="dashed">₹1500</span> &nbsp;<span class="original">₹1299.99</span></h6>
                            </div>
                        </div>
                        <div class="allprdtdiv1">
                            <div class="allprdtimg">
                                <img src="./images/home/jacket1.png" height="200px" alt="">
                            </div>
                            <div class="allprdtcntnt">
                                <h6>Jacket</h6>
                                <h5>Bike Jackets</h5>
                                <span class="rating">
                                    <img src="./images/home/fullstr.png" height="10px" alt="">
                                    <img src="./images/home/fullstr.png" height="10px" alt="">
                                    <img src="./images/home/fullstr.png" height="10px" alt="">
                                    <img src="./images/home/fullstr.png" height="10px" alt="">
                                    <img src="./images/home/halfstr.png" height="10px" alt="">
                                    (4 Review)
                                </span>
                                <h6 class="mt-3"><span class="dashed">₹1500</span> &nbsp;<span class="original">₹1299.99</span></h6>
                            </div>
                        </div>
                        <div class="allprdtdiv1">
                            <div class="allprdtimg">
                                <img src="./images/home/jacket2.png" height="200px" alt="">
                            </div>
                            <div class="allprdtcntnt">
                                <h6>Jacket</h6>
                                <h5>Hoodie Jackets</h5>
                                <span class="rating">
                                    <img src="./images/home/fullstr.png" height="10px" alt="">
                                    <img src="./images/home/fullstr.png" height="10px" alt="">
                                    <img src="./images/home/fullstr.png" height="10px" alt="">
                                    <img src="./images/home/fullstr.png" height="10px" alt="">
                                    <img src="./images/home/halfstr.png" height="10px" alt="">
                                    (4 Review)
                                </span>
                                <h6 class="mt-3"><span class="dashed">₹1500</span> &nbsp;<span class="original">₹1299.99</span></h6>
                            </div>
                        </div>
                        <div class="allprdtdiv1">
                            <div class="allprdtimg">
                                <img src="./images/home/raincoat1.png" height="200px" alt="">
                            </div>
                            <div class="allprdtcntnt">
                                <h6>Raincoat</h6>
                                <h5>Urvan Raincoats</h5>
                                <span class="rating">
                                    <img src="./images/home/fullstr.png" height="10px" alt="">
                                    <img src="./images/home/fullstr.png" height="10px" alt="">
                                    <img src="./images/home/fullstr.png" height="10px" alt="">
                                    <img src="./images/home/fullstr.png" height="10px" alt="">
                                    <img src="./images/home/halfstr.png" height="10px" alt="">
                                    (4 Review)
                                </span>
                                <h6 class="mt-3"><span class="dashed">₹1500</span> &nbsp;<span class="original">₹1299.99</span></h6>
                            </div>
                        </div>
                        <div class="allprdtdiv1">
                            <div class="allprdtimg">
                                <img src="./images/home/tshirt1.png" height="200px" alt="">
                            </div>
                            <div class="allprdtcntnt">
                                <h6>T-Shirt</h6>
                                <h5>Urvan T-Shirts</h5>
                                <span class="rating">
                                    <img src="./images/home/fullstr.png" height="10px" alt="">
                                    <img src="./images/home/fullstr.png" height="10px" alt="">
                                    <img src="./images/home/fullstr.png" height="10px" alt="">
                                    <img src="./images/home/fullstr.png" height="10px" alt="">
                                    <img src="./images/home/halfstr.png" height="10px" alt="">
                                    (4 Review)
                                </span>
                                <h6 class="mt-3"><span class="dashed">₹1500</span> &nbsp;<span class="original">₹1299.99</span></h6>
                            </div>
                        </div>
                        <div class="allprdtdiv1">
                            <div class="allprdtimg">
                                <img src="./images/home/umbrella1.png" height="200px" alt="">
                            </div>
                            <div class="allprdtcntnt">
                                <h6>Umbrella</h6>
                                <h5>Urvan Umbrella</h5>
                                <span class="rating">
                                    <img src="./images/home/fullstr.png" height="10px" alt="">
                                    <img src="./images/home/fullstr.png" height="10px" alt="">
                                    <img src="./images/home/fullstr.png" height="10px" alt="">
                                    <img src="./images/home/fullstr.png" height="10px" alt="">
                                    <img src="./images/home/halfstr.png" height="10px" alt="">
                                    (4 Review)
                                </span>
                                <h6 class="mt-3"><span class="dashed">₹1500</span> &nbsp;<span class="original">₹1299.99</span></h6>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Cards -->
                <div class="card1">
                    <div class="cards">
                        <div class="carddiv">
                            <div class="cimg1">
                                <img src="./images/home/cicon1.png" height="30px" alt="">
                            </div>
                            <div class="cct1">
                                <h5>Free Delivery</h5>
                                <h6>Orders from all item</h6>
                            </div>
                        </div>
                        <div class="carddiv">
                            <div class="cimg1">
                                <img src="./images/home/cicon2.png" height="30px" alt="">
                            </div>
                            <div class="cct1">
                                <h5>Return & Refund</h5>
                                <h6>Money back guarantee</h6>
                            </div>
                        </div>
                        <div class="carddiv">
                            <div class="cimg1">
                                <img src="./images/home/cicon3.png" height="30px" alt="">
                            </div>
                            <div class="cct1">
                                <h5>Member Discount</h5>
                                <h6>One very order over $140.00</h6>
                            </div>
                        </div>
                        <div class="carddiv">
                            <div class="cimg1">
                                <img src="./images/home/cicon4.png" height="30px" alt="">
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
                                    <a href="">Learn More <i class="fa-solid fa-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>


    <!-- Footer -->
    <?php include('./footer.php'); ?>

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
                                <input type="tel" name="tel" id="tel" placeholder="Enter Your Mobile Number">
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
    // Tabs - Tab Buttons Navigate
    $(document).ready(function() {
        $(".button2").click(function() {
            var id = $(this).attr("id");
            $(".button2").removeClass("buttonactive1");
            $(this).addClass("buttonactive1");

            // Hide all sections
            $("#bag, #cap, #raincoat, #jacket, #tshirt, #umbrella").hide();

            if (id === "bg") {
                $("#bag").show();
            } else if (id === "cp") {
                $("#cap").show();
            } else if (id === "rct") {
                $("#raincoat").show();
            } else if (id === "jkt") {
                $("#jacket").show();
            } else if (id === "tst") {
                $("#tshirt").show();
            } else if (id === "ula") {
                $("#umbrella").show();
            }
        });
    });
</script>

<script>
    $(function() {
        $("#pimg00").click(function() {
            showImage("#pimg0");
        });
        $("#pimg01").click(function() {
            showImage("#pimg1");
        });
        $("#pimg02").click(function() {
            showImage("#pimg2");
        });
        $("#pimg03").click(function() {
            showImage("#pimg3");
        });
        $("#pimg04").click(function() {
            showImage("#pimg4");
        });
    });

    function showImage(imgSelector) {
        $(imgSelector).show().siblings().hide();
    }
</script>

<script>
    function showPopup() {
        var modal = document.getElementById("modal");
        modal.style.display = "block";
    }

    setTimeout(showPopup, 15000);

    $(function() {
        $(".close").click(function() {
            $(".modal").hide()
        });
    });
</script>

</html>
