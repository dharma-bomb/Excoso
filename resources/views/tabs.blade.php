<!-- HTML Structure -->
<div class="allprdtdiv">
    @foreach ($allProducts as $category => $products)
    @if ($products->isNotEmpty())
        <a href="{{ route('viewproduct', ['category' => $category]) }}" class="category-link" data-category="{{ $category }}">
            @php
                $routeName = strtolower($category); // Use category name directly
                $firstProduct = $products->first();
                $images = json_decode($firstProduct->images, true);
            @endphp
            {{-- <a href="{{ route('viewproducts.' . $routeName) }}" class="category-link" data-category="{{ $routeName }}"> --}}
                <div class="allprdtdiv1">
                    <div class="allprdtimg">
                        <img src="{{ asset('images/addproduct/' . $images[0]) }}"
                             alt="{{ $firstProduct->product_name }}" height="200px" class="product-image">
                    </div>
                    <div class="allprdtcntnt">
                        <h6>{{ ucfirst($category) }}</h6>
                        <span class="rating">
                            @for ($i = 0; $i < 4; $i++)
                                <img src="{{ asset('images/home/fullstr.png') }}" height="10px" alt="">
                            @endfor
                            <img src="{{ asset('images/home/halfstr.png') }}" height="10px" alt="">
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

{{-- @foreach ($allProducts as $category => $products)
    @if ($products->isNotEmpty())
        <a href="{{ route('viewproduct', ['category' => $category]) }}" class="category-link" data-category="{{ $category }}">
            <!-- Your existing product display HTML -->
        </a>
    @endif
@endforeach --}}


<!-- jQuery Script -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
// $(document).ready(function() {
//     $('.category-link').click(function(e) {
//         e.preventDefault(); // Prevent default link behavior

//         var category = $(this).data('category'); // Get category from data attribute
//         loadProducts(category); // Call function to load products
//     });

//     function loadProducts(category) {
//         $.ajax({
//             url: '/viewproducts/' + category, // URL to your Laravel route
//             type: 'GET',
//             dataType: 'html',
//             success: function(data) {
//                 $('.allprdtdiv').html(data); // Replace content of allprdtdiv with fetched data
//                 // Redirect to a new page after successful product load
//                 window.location.href = '/new-page'; // Replace with your desired URL
//             },
//             error: function(xhr, status, error) {
//                 console.error('Error fetching products:', error);
//             }
//         });
//     }
// });

</script>
