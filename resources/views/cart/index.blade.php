@extends('layouts.default')

@section('css')
@endsection


 @section('content')
        
    <div id="cart"></div>


 @endsection


 @section('js')
    <script>
        $(document).ready(function(){
            $('.btn-cart').addClass('cart-active');
        });
    </script>    


 @endsection