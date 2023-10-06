@extends('layout.app')
@section('content')
    @include('component.MenuBar')
    @include('component.product-details')
    @include('component.Footer')
    <script>
        (async () => {
            await Category();
            await getProductDetails()
            $(".preloader").delay(90).fadeOut(100).addClass('loaded');
        })()
    </script>
@endsection
