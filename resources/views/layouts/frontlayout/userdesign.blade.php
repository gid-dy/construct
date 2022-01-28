<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link rel="icon" href="{{ asset('images/frontend_images/favicon.png') }}" type="{{asset ('image/png')}}" />
    <meta content="" name="keywords">
    <meta content="" name="description">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@if(!empty($meta_title)) {{ $meta_title }} @else Home | Ghana-Trek @endif </title>
    @if(!empty($meta_description))
        <meta name="description" content="{{ $meta_description }}">
    @endif

    @if(!empty($meta_keywords))
        <meta name="keywords" content="{{ $meta_keywords }}">
    @endif
  <!-- Favicons -->

  <link rel="stylesheet" href="{{ asset('css/frontend_css/bootstrap.css') }}" />
  <link rel="stylesheet" href="{{ asset('vendors/linericon/style.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/frontend_css/font-awesome.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/frontend_css/themify-icons.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/frontend_css/flaticon.css') }}" />
  <link rel="stylesheet" href="{{ asset('vendors/owl-carousel/owl.carousel.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('vendors/lightbox/simpleLightbox.css') }}" />
  <link rel="stylesheet" href="{{ asset('vendors/nice-select/css/nice-select.css') }}" />
  <link rel="stylesheet" href="{{ asset('vendors/animate-css/animate.css') }}" />
  <link rel="stylesheet" href="{{ asset('vendors/jquery-ui/jquery-ui.css') }}" />
  <!-- main css -->
  <link rel="stylesheet" href="{{ asset('css/frontend_css/style.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/frontend_css/responsive.css') }}" />


  {{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css"> --}}
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flexslider/2.2.0/flexslider-min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.css">
  <script type='text/javascript' src='https://platform-api.sharethis.com/js/sharethis.js#property=5e8d2b907daa0a0012e7bee3&product=inline-share-buttons&cms=website' async='async'></script> 

</head>
</body>

    @include('layouts.frontLayout.user_topbar')
    @include('layouts.frontLayout.user_header')
    @yield('content')
    @include('layouts.frontLayout.user_subscription')
    @include('layouts.frontLayout.user_footer')
{{--  <!-- JavaScript Libraries -->  --}}

<script src="{{ asset('js/frontend_js/theme.js') }}"></script>
<script src="{{ asset('js/frontend_js/jquery-3.2.1.min.js') }}"></script>
<script src="{{ asset('js/frontend_js/popper.js') }}"></script>
<script src="{{ asset('js/frontend_js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/frontend_js/stellar.js') }}"></script>
<script src="{{ asset('vendors/lightbox/simpleLightbox.min.js') }}"></script>
<script src="{{ asset('vendors/nice-select/js/jquery.nice-select.min.js') }}"></script>
<script src="{{ asset('vendors/isotope/imagesloaded.pkgd.min.js') }}"></script>
<script src="{{ asset('vendors/isotope/isotope-min.js') }}"></script>
<script src="{{ asset('vendors/owl-carousel/owl.carousel.min.js') }}"></script>
<script src="{{ asset('js/frontend_js/jquery.ajaxchimp.min.js') }}"></script>
<script src="{{ asset('vendors/counter-up/jquery.waypoints.min.js') }}"></script>
<script src="{{ asset('vendors/counter-up/jquery.counterup.js') }}"></script>
<script src="{{ asset('js/frontend_js/mail-script.js') }}"></script>




    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>--}}

    <script src="https://cdnjs.cloudflare.com/ajax/libs/flexslider/2.2.0/jquery.flexslider-min.js"></script> 




 <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
    <script>
        $('.flexslider').flexslider({
       animation: "slide",
       controlNav: false
   })
   </script>



</body>
</html>
