
@extends('layouts.frontLayout.userdesign')
    @section('content')
    <?php
use App\Services;
?>


<!--================ New Product Area =================-->
<section class="new_product_area section_gap_top section_gap_bottom_custom">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="main_title">
                         <li class="btn btn-default filter-button dest2" data-filter="hdpe">
                            @if(!empty($search_service))
                                {{ $search_service }}
                            @else
                                {{ $categoryDetails->CategoryName }}
                            @endif
                            ({{ count($servicesAll)  }})
                        </li>
                    </div>
                </div>
            </div>
            </div>
            </section>
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
                <div class="col-lg-12 mt-5 mt-lg-0">
                    <div class="row">
                            @foreach($servicesAll as $service)
                                @if($service->Status=="1")
                                    <div class="col-lg-6 col-md-6">
                                        <div class="single-product">
                                                <a href="{{ url('service/'.$service->id) }}" class="block-5">
                                                    <div class="product-img">
                                                    <h4>{{ $service->ServiceName }}</h4>
                                                        <img src="{{ asset('images/backend_images/services/large/'.$service->image) }}" alt="service image" style="width:400px;" />
                                                        
                                                    </div>
                                                    <h4>{{ $service->ServicePrice}}</h4>
                                                    <button class="main_btn"> Add to cart</button>
                                                </a>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                            @if(empty($search_service))
                            <div align="center">{{ $servicesAll->links() }}</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--================ End New Product Area =================-->


@endsection



