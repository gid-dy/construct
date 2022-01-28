@extends('layouts.frontLayout.userdesign')
    @section('content')
        <?php use App\Services; ?>



      <div class="flexslider">
        <ul class="slides">
            @foreach($banners as $key => $banner)
            <li class=" @if($key==0) active @endif">
                <img src="images/frontend_images/banners/{{ $banner->Image }}">
                <div class="meta">
                    <h4>{{ $banner->Title }}</h4>
                    <h6>Your Quality, Timely and Satisfaction</h6>
                </div>
            </li>
            @endforeach

        </ul>
    </div>










   <!--================Category Product Area =================-->
    <section class="cat_product_area section_gap">
      <div class="container">
        <div class="row flex-row-reverse">
          <div class="col-lg-9">
            <div class="product_top_bar">
              <div class="left_dorp">
                <div class="nav-item">
                        <form class="form-inline ml-auto" action="{{ url('/search-service') }}" method="post">
                            @csrf
                            <input  class="form-control" placeholder="Search Services" name="service" style="margin:5px" />
                                <button class="btn btn-outline-warning bg-warning button" style="border=0px;"  type="submit"> Search  <i class="fa fa-search"></i></button>
                        </form>
                    </div>
              </div>
            </div>

            <div class="latest_product_inner">
              <div class="row">
                   @foreach($servicesAll as $service)
                                    @if($service->Status=="1")
                <div class="col-lg-4 col-md-6">
                      <div class="single-product">
                            <div class="product-img">
                                    <img  class="card-img" src="{{ asset('images/backend_images/services/large/'.$service->image) }}" alt="" />
                                  <div class="p_icon">
                                    <a href="#">
                                      <i class="ti-eye"></i>
                                    </a>
                                    <a href="#">
                                      <i class="ti-heart"></i>
                                    </a>
                                    <a href="{{ url('/service/'.$service->id) }}">
                                      <i class="ti-shopping-cart"></i>
                                    </a>
                                  </div>
                            </div>
                            <div class="product-btm">
                                  <a href="#" class="d-block">
                                    <h4>{{ $service->ServiceName}}</h4>
                                  </a>
                                  <div class="mt-3">
                                      <span class="mr-4">GHS {{ $service->ServicePrice}}</span>
                                  </div>
                            </div>
                      </div>
                </div>
                @endif
                                @endforeach
              </div>
            </div>
          </div>

          <div class="col-lg-3">
             @include('layouts.frontlayout.user_sidebar')
          </div>
        </div>
           <!--================ New Product Area =================-->
  <section class="new_product_area section_gap_top section_gap_bottom_custom">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-12">
          <div class="main_title">
            <h2><span>new products</span></h2>
            <p>Bring called seed first of third give itself now ment</p>
          </div>
        </div>

      </div>

      <div class="row">
        <div class="col-lg-6">
          <div class="new_product">
            <h5 class="text-uppercase">collection of 2019</h5>
            <h3 class="text-uppercase">Men’s summer t-shirt</h3>
            <div class="product-img">
              <img class="img-fluid" src="{{ asset('images/frontend_images/product/new-product/new-product1.png') }}" alt="" />
            </div>
            <h4>$120.70</h4>
            <a href="#" class="main_btn">Add to cart</a>
          </div>
        </div>

        <div class="col-lg-6 mt-5 mt-lg-0">
          <div class="row">
            <div class="col-lg-6 col-md-6">
              <div class="single-product">
                <div class="product-img">
                  <img class="img-fluid w-100" src="{{ asset('images/frontend_images/product/new-product/n1.png') }}" alt="" />

                </div>
                <div class="product-btm">
                  <a href="#" class="d-block">
                    <h4>Fill Tank</h4>
                  </a>
                  <div class="mt-3">
                    <span class="mr-4">GHS 255.00</span>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-lg-6 col-md-6">
              <div class="single-product">
                <div class="product-img">
                  <img class="img-fluid w-100" src="{{ asset('images/frontend_images/product/new-product/n2.png') }}" alt="" />

                </div>
                <div class="product-btm">
                  <a href="#" class="d-block">
                    <h4>wheel Barrow</h4>
                  </a>
                  <div class="mt-3">
                    <span class="mr-4">GHS 8.00</span>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-lg-6 col-md-6">
              <div class="single-product">
                <div class="product-img">
                  <img class="img-fluid w-100" src="{{ asset('images/frontend_images/product/new-product/n3.png') }}" alt="" />

                </div>
                <div class="product-btm">
                  <a href="#" class="d-block">
                    <h4>concrete Mixture</h4>
                  </a>
                  <div class="mt-3">
                    <span class="mr-4">GHS 525.00</span>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-lg-6 col-md-6">
              <div class="single-product">
                <div class="product-img">
                  <img class="img-fluid w-100" src="{{ asset('images/frontend_images/product/new-product/n4.png') }}" alt="" />

                </div>
                <div class="product-btm">
                  <a href="#" class="d-block">
                    <h4>Wheel Barrow</h4>
                  </a>
                  <div class="mt-3">
                    <span class="mr-4">GHS 8.00</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!--================ End New Product Area =================-->
      </div>
    </section>
    <!--================End Category Product Area =================-->


   @endsection







