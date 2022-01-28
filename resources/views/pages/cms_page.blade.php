<?php
use App\Services;
?>
@extends('layouts.frontLayout.userdesign')
    @section('content')
      <section class="banner_area">
      <div class="banner_inner d-flex align-items-center">
        <div class="container">
          <div
            class="banner_content d-md-flex justify-content-between align-items-center"
          >
            <div class="mb-3 mb-md-0" style="color:white;" >
              <h2 style="color:white;" >{{ $cmsPagesDetails->Title }}</h2>
              <p>All you need to know</p>
            </div>
            <div class="page_link">
              <a href="index.html" style="color:white;" >Home</a>
              <a href="{{('/About Us')}}" style="color:white;" >About Us</a>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section>
        <div class="container">
            <div class="col-md-12">
                <p><?php echo nl2br($cmsPagesDetails->Description); ?></p>
            </div>
        </div>
    </section>
    <script>
        $('.collapse').collapse()
    </script>

   @endsection






