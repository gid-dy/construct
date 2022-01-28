@extends('layouts.frontLayout.userdesign')
    @section('content')

   <section class="banner_area">
                <div class="banner_inner d-flex align-items-center">
                         <div class="container">
                                <div class="banner_content d-md-flex justify-content-between align-items-center" >
                                    <div class="mb-3 mb-md-0"  style="color:white;">
                                            <h2  style="color:white;">Contact Us</h2>
                                            <p>We will assist you with all that you need</p>
                                    </div>
                                    <div class="page_link">
                                            <a  style="color:white;" href="{{ url('/') }}">Home</a>
                                            <a  style="color:white;" href="{{ url('contact') }}">Contact</a>
                                    </div>
                               </div>
                        </div>
                </div>
        </section>
        
  <section class="section_gap">
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
        <div class="col-12">
          <h2 class="contact-title">Get in Touch</h2>
        </div>
        <div class="col-lg-8 mb-4 mb-lg-0">
         <form  class="row contact_form"  method="post" action="{{ url('/contact') }}">
              @csrf
              <div class="row">
              <div class="col-md-4 form-group p_star">
                              <input class="form-control" name="SurName" id="name" type="text" placeholder="Enter your sur name">
                      </div>
                      <div class="col-md-4 form-group p_star">
                              <input class="form-control" name="OtherNames" id="name" type="text" placeholder="Enter your other names">
                      </div>
                  <div class="col-md-4 form-group p_star">
                          <input class="form-control" name="email" id="email" type="email" placeholder="Enter email address">
                  </div>
                  <div class="col-md-12 form-group p_star">
                            <input class="form-control" name="Subject" id="Subject" type="text" placeholder="Enter Subject">
                  </div>
                  <div class="col-md-12 form-group p_star">
                            <textarea class="form-control w-100" name="message" id="message" cols="30" rows="9" placeholder="Enter Message"></textarea>
                  </div>
              </div>
              <div class="form-group mt-lg-3">
                <button class="main_btn"  type="submit">Send Message</button>
              </div>                             
                                               
             </form>

        </div>

        <div class="col-lg-4">
          <div class="media contact-info">
            <span class="contact-info__icon"><i class="ti-home"></i></span>
            <div class="media-body">
              <h3>Kotei, KNUST.</h3>
              <p>AK - 566 - 0554</p>
            </div>
          </div>
          <div class="media contact-info">
            <span class="contact-info__icon"><i class="ti-tablet"></i></span>
            <div class="media-body">
              <h3><a href="tel:0542500499">+233 54 250 0499</a></h3>
              <p>Mon to Sat 7am to 6pm</p>
              <p>Sun 12am to 6pm</p>
            </div>
          </div>
          <div class="media contact-info">
            <span class="contact-info__icon"><i class="ti-email"></i></span>
            <div class="media-body">
              <h3><a href="mailto:support@colorlib.com">einsteingideon@gmail.com</a></h3>
              <p>Send us your query anytime!</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
	<!-- ================ contact section end ================= -->

   @endsection





