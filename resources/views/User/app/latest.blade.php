<div class="latest-products">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="section-heading">
            <h2>Latest Products</h2>
            <a href="products.html">view all products <i class="fa fa-angle-right"></i></a>
          </div>
        </div>
        @foreach ($products as $product )
        <div class="col-md-4">
          <div class="product-item">
            <a href="#"><img src="{{asset("storage/$product->image")}}" alt="">
              @auth
                
              <form action="{{route('user.addtofav',$product->id)}}" method="POST">
                @csrf
                <button type="submit" style="border:none ; background: none;">
                  @if ($product->isfavorites())
                  <div class="fa fa-heart" style="color:red"></div>
                  @else
                  <div class="fa fa-heart" style="color:gray"></div>
                  @endif
                </button>
              </form>
              @endauth
            </a>
            <div class="down-content">
              <a href="{{route('user.show.product',$product->id)}}"><h4>{{$product->name}}</h4></a>
              <h6>{{$product->price}}</h6>
              <p>{{$product->desc}}</p>
              <span>{{$product->quantity}}</span>
              @auth
              <form action="{{route('user.addtocart',$product->id)}}" method="POST">
                @csrf
                <input type="number" name="qty" id="">
                <button type="submit" class="btn btn-info">add to cart</button>
              </form>
              @endauth
              <form action="{{route('user.addtowishlist',$product->id)}}" method="POST">
                @csrf
                <button type="submit" class="btn btn-secondary">add to wishlist</button>
              </form>
            </div>
          </div>
        </div>        
        @endforeach
      </div>
    </div>
  </div>