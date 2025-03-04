@extends('User.app.layout')

@section('content')

<div class="col-md-4">
    @if (!empty($wishlist) && is_array($wishlist))
    @foreach ($wishlist as $id => $product)
        <div class="product-item">
            <a href="#"><img src="{{ asset('storage/' . $product['image']) }}" alt=""></a>
            <div class="down-content">
                <a href="#"><h4>{{ $product['name'] }}</h4></a>
                <h6>{{ $product['price'] }}</h6>
            </div>
        </div>
        <form action="{{ route('user.addtocart', $id) }}" method="POST">
            @csrf
            <input type="number" name="qty" min="1" value="1">
            <button type="submit" class="btn btn-info">Add to Cart</button>
        </form>
    @endforeach
@else
    <p>No products in wishlist.</p>
@endif

@endsection