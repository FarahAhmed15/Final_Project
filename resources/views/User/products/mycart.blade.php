@extends('User.app.layout')

@section('content')

<div class="col-md-4">
    @if($cart && count($cart) > 0)
    @foreach ( $cart as $id=>$product )
    
    <div class="product-item">
        <a href="#"><img src="{{asset("storage")}}/{{$product['image']}}" alt=""></a>
        <div class="down-content">
            <a href=""><h4>{{$product['name']}}</h4></a>
            <h6>{{$product['price']}}</h6>
            <span>Quantity: {{$product['qty']}}</span>
        </div>
        <form action="{{route('user.makeorder')}}" method="POST">
            @csrf
            <input type="date" name="requireDate" id="">
            <button type="submit" class="btn btn-info">Make Order</button>
        </form>
    </div>
</div>  

@endforeach
@else
    <p class="text-center">empty cart</p>
@endif
@endsection