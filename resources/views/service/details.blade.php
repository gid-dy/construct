@extends('layouts.frontLayout.userdesign')
    @section('content')
<?php use App\Services; ?>
<?php use App\Feedback; ?>

    <section>
        <div class="container">
            @if (Session::has('flash_message_error'))
                <div class="alert alert-error alert-block" style="background-color: #f2dfd0">
                    <button type="button" class="close" data-dismiss='alert'></button>
                    <strong>{!! session('flash_message_error') !!}</strong>
                </div>
            @endif
            @if (Session::has('flash_message_success'))
                <div class="alert alert-success alert-block">
                    <button type="button" class="close" data-dismiss='alert'></button>
                    <strong>{!! session('flash_message_success') !!}</strong>
                </div>
            @endif
         
        </div>
     <!--================Single Service Area =================-->
    <div class="product_image_area">
      <div class="container">
        <div class="row s_product_inner">
          <div class="col-lg-6">
            <div class="s_product_img">
              <div id="carouselExampleIndicators"  class="carousel slide" data-ride="carousel" > 
                <div class="carousel-inner">
                  <div class="carousel-item active">
                    <img class="mainImage" src="{{ asset('images/backend_images/services/large/'.$servicesDetails->image) }}" />
                     <div>
                                        @foreach($serviceAltImage as $altimage)
                                            <img class="changeImage" src="{{ asset('images/backend_images/services/large/'.$altimage->Image) }}" style="width:80px; display:inline;float:left;margin-top:20px; padding-right:10px; cursor:pointer;" />
                                        @endforeach
                                    </div>
                  </div>
                  
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-5 offset-lg-1">
          <form name="addtocartform" id="addtocartform" action="{{ url('add-cart') }}" method="post">
                      @csrf
                  <div class="s_product_text">
                        <input type="hidden" name="Service_id" value="{{ $servicesDetails->id }}">
                        <input type="hidden" name="ServiceName" value="{{ $servicesDetails->ServiceName }}">
                        <input type="hidden" name="ServicePrice" id="ServicePrice" value="{{ $servicesDetails->ServicePrice }}">
                    <h3>{{ $servicesDetails->ServiceName }}</h3>
                    
                    <ul class="list">
                          <li>
                                    <select id="SelType" name="ServiceType" class="form-control">
                                        <option value="">Select Service Type</option>
                                            @foreach($servicesDetails->servicetypes as $servetype)
                                                  <option class="form-control" value="{{ $servicesDetails->id }}-{{ $servetype->ServiceType }}">{{ $servetype->ServiceType }}</option>
                                            @endforeach
                                    </select>
                          <li>
                                <h2> <span id="getServicePrice">GHS {{ $servicesDetails->ServicePrice }} </span></h2>
                            </li>
                        </li>
                        <li>
                          <span>Availibility</span> :  @if($total_availability>0) Available @else Sold Out @endif 
                        </li>
                    </ul>
                    <p>
                     {{$servicesDetails->Description}}
                    </p>
                    <div class="product_count">
                        <label for="qty">Quantity:</label>
                        <input  type="text" name="Quantity" id="sst"  maxlength="12" value="1"  title="Quantity:" class="input-text qty" />
                        <button onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst )) result.value++;return false;" class="increase items-count" type="button" >
                            <i class="lnr lnr-chevron-up"></i>
                        </button>
                      <button onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst ) &amp;&amp; sst > 0 ) result.value--;return false;" class="reduced items-count" type="button" >
                          <i class="lnr lnr-chevron-down"></i>
                      </button>
                    </div>
                    @if($total_availability>0)
                        <button class="main_btn" id="cartbutton" type="submit" name="cartbutton " value="Add to Cart" style="margin-left:40px">Add to Cart</button>
                    @endif
                  </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!--================End Single Service Area =================-->


 <!--================Service Description Area =================-->
    <section class="product_description_area">
      <div class="container">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
          <li class="nav-item">
            <a class="nav-link" id="home-tab" data-toggle="tab"  href="#home" role="tab"  aria-controls="home"  aria-selected="true" >Description</a >
          </li>
          <li class="nav-item">
            <a class="nav-link"  id="profile-tab" data-toggle="tab"  href="#profile"  role="tab"  aria-controls="profile"  aria-selected="false">Specification</a >
          </li>
        
          <li class="nav-item">
            <a class="nav-link active"  id="review-tab" data-toggle="tab"  href="#review" role="tab"  aria-controls="review" aria-selected="false" >Reviews</a>
          </li>
        </ul>
        <div class="tab-content" id="myTabContent">
          <div class="tab-pane fade"  id="home" role="tabpanel"  aria-labelledby="home-tab">
            <p>
              {{$servicesDetails->Description}}
            </p>
          </div>
          <div
            class="tab-pane fade"
            id="profile"
            role="tabpanel"
            aria-labelledby="profile-tab"
          >
            <div class="table-responsive">
              <table class="table">
                <tbody>
                  <tr>
                    <td>
                      <h5>Width</h5>
                    </td>
                    <td>
                      <h5>128mm</h5>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <h5>Height</h5>
                    </td>
                    <td>
                      <h5>508mm</h5>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <h5>Depth</h5>
                    </td>
                    <td>
                      <h5>85mm</h5>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <h5>Weight</h5>
                    </td>
                    <td>
                      <h5>52gm</h5>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <h5>Quality checking</h5>
                    </td>
                    <td>
                      <h5>yes</h5>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <h5>Freshness Duration</h5>
                    </td>
                    <td>
                      <h5>03days</h5>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <h5>When packeting</h5>
                    </td>
                    <td>
                      <h5>Without touch of hand</h5>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <h5>Each Box contains</h5>
                    </td>
                    <td>
                      <h5>60pcs</h5>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div
            class="tab-pane fade"
            id="contact"
            role="tabpanel"
            aria-labelledby="contact-tab"
          >
          
          </div>
          <div class="tab-pane fade show active"  id="review"  role="tabpanel"  aria-labelledby="review-tab" >
              @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li style="list-style-type:none;">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            <div class="row">
              <div class="col-lg-6">
                <div class="row total_rate">
                  <div class="col-6">
                    {{-- <div class="box_total">
                      <h5>Overall</h5>
                      <h4>4.0</h4>
                      <h6>(03 Reviews)</h6>
                    </div> --}}
                  </div>
                </div>
                <div class="review_list">
                  @foreach ($feedbacks as $feedback)
                      <div class="review_item">
                        <div class="media">
                          <div class="media-body">
                            <h4>{{ $feedback->SurName }} {{ $feedback->OtherNames }}</h4>
                           {{date('H:i', strtotime($feedback->created_at)) }} <span style="margin:10px; color:orange">{{date('F j, Y', strtotime($feedback->created_at)) }}</span>
                          </div>
                        </div>
                        <p>
                         {{ $feedback->Message }}
                        </p>
                      </div>
                      @endforeach
                </div>
              </div>
              <div class="col-lg-6">
                <div class="review_box">
                  <h4>Add a Review</h4>
                  <form class="form-horizontal" method="post" action="{{ url('/feedback') }}">
                                        @csrf
                                         <input type="hidden" name="Service_id"  value="{{ $servicesDetails->id }}" />
                    <div class="col-md-12">
                      <div class="form-group">
                        <input type="text" class="form-control" name="SurName" id="SurName" placeholder="Enter your SurName" />
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                       <input type="text" class="form-control" name="OtherNames" id="OtherNames" placeholder="Enter your Other names" />
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                       <input type="text" class="form-control" name="email" id="email" placeholder="Enter your Email" />
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                        <textarea  class="form-control" name="Message" id="Message" rows="10"  cols="30" placeholder="Review"></textarea>
                      </div>
                    </div>
                    <div class="col-md-12 text-right">
                      <button  type="submit" value="submit" class="btn submit_btn">
                        Submit Now
                      </button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!--================End Service Description Area =================-->
     

@endsection
