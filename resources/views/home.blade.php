@extends('layouts.default')
@section('title')
    127.0.0.1
@endsection
@section('content')
<div id="cart" class="mt-2"></div>
@endsection
@section('js')
<script>
    $(document).ready(function(){
        $('#store').addClass('focus');
    })
</script>
@endsection
