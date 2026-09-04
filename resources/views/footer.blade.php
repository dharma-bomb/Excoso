<footer class="footer xc-footer" id="footer">
    <div class="w-100 mt-4 row row-cols-1 row-cols-sm-2 row-cols-md-5 d-flex justify-content-around" id="footerdiv">
        <div class="col-md-2 mb-3 d-flex justify-content-center align-items-center flex-column mx-auto">
            <div class="d-flex justify-content-center align-items-center flex-column">
                <img src="{{ asset('images/logo.png') }}" height="70px" width="70px" alt="Excoso">
            </div>
            <div class="d-flex justify-content-center align-items-center mt-4 gap-4" id="brands">
                <a href="" aria-label="X (Twitter)"><i class="fa-brands fa-x-twitter"></i></a>
                <a href="" aria-label="Facebook"><i class="fa-brands fa-square-facebook"></i></a>
                <a href="" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
                <a href="" aria-label="LinkedIn"><i class="fa-brands fa-linkedin"></i></a>
            </div>
        </div>

        <div class="col-md-2 mb-3">
            <h5>Company</h5>
            <ul class="nav flex-column">
                <li class="nav-item mb-2"><a href="" class="p-0">About Us</a></li>
                <li class="nav-item mb-2"><a href="{{ url('/#footer') }}" class="p-0">Contact Us</a></li>
                <li class="nav-item mb-2"><a href="" class="p-0">Careers</a></li>
            </ul>
        </div>

        <div class="col-md-2 mb-3">
            <h5>Products</h5>
            <ul class="nav flex-column">
                <li class="nav-item mb-2"><a href="{{ url('/#categories') }}" class="p-0">Bags</a></li>
                <li class="nav-item mb-2"><a href="{{ url('/#categories') }}" class="p-0">Caps</a></li>
                <li class="nav-item mb-2"><a href="{{ url('/#categories') }}" class="p-0">Jackets</a></li>
                <li class="nav-item mb-2"><a href="{{ url('/#categories') }}" class="p-0">Raincoats</a></li>
                <li class="nav-item mb-2"><a href="{{ url('/#categories') }}" class="p-0">T-Shirts</a></li>
                <li class="nav-item mb-2"><a href="{{ url('/#categories') }}" class="p-0">Umbrellas</a></li>
            </ul>
        </div>

        <div class="col-md-2 mb-3">
            <h5>Contact Us</h5>
            <ul class="nav flex-column">
                <li class="nav-item mb-2"><a href="mailto:sales@expertcorporatesolutions.com" target="_blank" class="p-0">sales@expertcorporatesolutions.com</a></li>
                <li class="nav-item mb-2"><a class="p-0">+91 99946 99776</a></li>
                <li class="nav-item mb-2"><a class="p-0">+91 99446 99907</a></li>
                <li class="nav-item mb-2"><a class="p-0">+91 99620 08436</a></li>
            </ul>
        </div>

        <div class="col-md-2 mb-3">
            <h5>Get a Quote</h5>
            <ul class="nav flex-column">
                <li class="nav-item mb-2"><a href="{{ url('/#quote') }}" class="p-0">Bulk &amp; corporate orders</a></li>
            </ul>
        </div>

    </div>

    <div class="d-flex justify-content-center align-items-center mt-4">
        <span class="xc-footer-rule"></span>
    </div>
    <div class="d-flex justify-content-center align-items-center mt-3 mb-3">
        <span>&copy; {{ date('Y') }} Excoso. All rights reserved.</span>
    </div>

</footer>
