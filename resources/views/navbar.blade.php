<nav class="navbar navbar-expand-lg xc-navbar" aria-label="Main navigation">
    <div class="container-fluid">
        <div class="responsive-button">
            <div>
                <a href="{{ url('/') }}"><img src="{{ asset('images/logo.png') }}" height="70px" title="Excoso logo" alt="Excoso"></a>
            </div>
            <div>
                <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbarcontent" aria-controls="navbarcontent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
        </div>

        <div class="navbar-collapse d-lg-flex justify-content-evenly collapse mt-1" id="navbarcontent">
            <div class="navbar-brand col-lg-1 me-0 d-none d-lg-block">
                <a href="{{ url('/') }}"><img src="{{ asset('images/logo.png') }}" height="70px" width="70px" title="Excoso logo" alt="Excoso"></a>
            </div>
            <ul class="navbar-nav col-lg-7 justify-content-lg-center">
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/#categories') }}">Shop</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/#quote') }}">Get a Quote</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/#footer') }}">Contact Us</a>
                </li>
                <li class="nav-item searchoption">
                    <form id="searchForm" class="item" action="{{ route('searchprod') }}" method="POST">
                        @csrf
                        <div class="nav-input">
                            <i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>
                            <input type="text" id="search" name="formData" placeholder="Search products&hellip;">
                        </div>
                    </form>
                    <div class="searchlist">
                        <ul id="searchResults">
                            <!-- Results will be dynamically added here -->
                        </ul>
                    </div>
                </li>
            </ul>
            <div class="nav-cta col-lg-2 d-none d-lg-flex justify-content-end">
                <a href="{{ url('/#quote') }}" class="xc-btn xc-btn--primary">Request a Quote</a>
            </div>
        </div>
    </div>
</nav>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $('#search').keyup(function(event) {
            var formData = $('#searchForm').serialize();

            $.ajax({
                type: 'POST',
                url: '{{ route('searchprod') }}',
                data: formData,
                success: function(response) {
                    $('#searchResults').html(response);
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });
    });
</script>
