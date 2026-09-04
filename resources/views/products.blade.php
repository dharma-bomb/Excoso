


@foreach ($products as $product)
    @php
        $images = json_decode($product->images, true);
        $routeName = ($product->cat); // Generate route name based on category
    @endphp
    <li class="splide__slide">
        <a href="{{ route('viewproduct', ['category' => $routeName]) }}" class="ellipsediv">
            <div class="pdtimgdiv">
                <img  src="{{ asset('images/addproduct/' . $images[0]) }}" height="250px alt="" class="productimg">
            </div>
            <div class="splidecntnt">
                <h6>{{ ucfirst($product->cat) }}</h6>
                <h6>Excoso {{ ucfirst($product->subcat) }}</h6>
                <h5>{{ $product->name }}</h5>
                <span class="rating">
                    @for ($i = 0; $i < 5; $i++)
                        <img src="{{ asset('images/home/fullstr.png') }}" height="10px" alt="">
                    @endfor
                    <span class="totalreview">(4 Review)</span>
                </span>
                <h6 class="mt-3"><span class="dashed">₹1500</span> &nbsp;<span class="original">₹{{ $product->price }}</span></h6>
            </div>
        </a>
    </li>
@endforeach

<script>
    lozad('.lazy', {
         load: function(ele) {
             ele.src = ele.dataset.src; // Set the src attribute to the value of data-src
             ele.onload = function() {
                 // ele.classList.add('fade'); // Add 'fade' class after the image is loaded
             }
         }
     }).observe();
  </script>

