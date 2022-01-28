@extends('layouts.frontLayout.userdesign')
    @section('content')
        <section class="banner_area">
      <div class="banner_inner d-flex align-items-center">
        <div class="container">
          <div
            class="banner_content d-md-flex justify-content-between align-items-center"
          >
            <div class="mb-3 mb-md-0" style="color:white;" >
              <h2 style="color:white;" >Product Checkout</h2>
              <p>Very us move be blessed multiply night</p>
            </div>
            <div class="page_link">
              <a href="index.html" style="color:white;" >Home</a>
              <a href="checkout.html" style="color:white;" >Product Checkout</a>
            </div>
          </div>
        </div>
      </div>
    </section>
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
            <section class="checkout_area section_gap">
                    <div class="returning_customer">
                            <div class="check_title">
                                    <h2 style="color:white;" >New Customer?<a href="{{ url('/register') }}" style="color:white;" > Click here to register</a> </h2>
                            </div>
                            <p> If you have shopped with us before, please enter your details in the boxes below. If you are a new customer, please proceed to the Billing & Shipping section.</p>
                            <form  class="row contact_form"method="POST" action="{{ url('/login') }}">
                                        @csrf
                                        <div class="col-md-6 form-group p_star">
                                                <input type="text" class="form-control" id="email" name="email"  value=" "/>
                                                <span  class="placeholder" data-placeholder="User Email" ></span>
                                        </div>
                                        <div class="col-md-6 form-group p_star">
                                                <input type="password" class="form-control" id="password"  name="password" value="" />
                                                <span class="placeholder" data-placeholder="Password"></span>
                                        </div>
                                        <div class="col-md-12 form-group">
                                                <button type="submit" value="submit" class="btn submit_btn">
                                                   Login
                                                </button>
                                                <div class="creat_account">
                                                    <input type="checkbox" id="f-option" name="selector" />
                                                    <label for="f-option">Remember me</label>
                                                </div>
                                                <a class="lost_pass" href="#">Lost your password?</a>
                                        </div>
                            </form>
                    </div>
            </section>
        {{--  < end section >  --}}
    </div>

  @endsection




