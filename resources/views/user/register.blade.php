@extends('layouts.frontLayout.userdesign')
    @section('content')
        <section class="banner_area">
                <div class="banner_inner d-flex align-items-center">
                         <div class="container">
                                <div class="banner_content d-md-flex justify-content-between align-items-center" style="color:white;" >
                                    <div class="mb-3 mb-md-0">
                                            <h2  style="color:white;" >Product Checkout</h2>
                                            <p>Very us move be blessed multiply night</p>
                                    </div>
                                    <div class="page_link" >
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
                            <div class="check_title" >
                                    <h2 style="color:white;" >Returning Customer?<a href="{{ url('/login') }}" style="color:white;" > Click here to login</a> </h2>
                            </div>
                            <p> If you have shopped with us before, please enter your details in the boxes below. If you are a new customer, please proceed to the Billing & Shipping section.</p>
                            <form  class="row contact_form" name="registerform" method="post" action="{{ url('/register') }}">
                                        @csrf
                                        <div class="col-md-6 form-group p_star">
                                                <label>Sur Name</label>
                                                <input type="text" class="form-control" id="SurName" name="SurName"  value=" "/>
                                        </div>
                                        <div class="col-md-6 form-group p_star">
                                                <label>Other Names</label>
                                                <input type="text" class="form-control" id="OtherNames" name="OtherNames"  value=" "/>
                                        </div>
                                        <div class="col-md-6 form-group p_star">
                                                <label class="p_star">Email</label>
                                                <input type="text" class="form-control" id="email" name="email"  value=" "/>
                                        </div>
                                        <div class="col-md-6 form-group p_star">
                                                <label>Contact</label>
                                                <input type="text" class="form-control" id="Mobile" name="Mobile"  value=" "/>
                                        </div>
                                        <div class="col-md-6 form-group p_star">
                                                <label>Password</label>
                                                <input type="password" class="form-control" id="password" name="password"  value=" "/>
                                        </div>
                                        <div class="col-md-6 form-group p_star">
                                                <label>Confirm Password</label>
                                                <input type="password" class="form-control" id="password_confirmation"  name="password_confirmation" value="" />
                                        </div>
                                        <div class="col-md-12 form-group">
                                                <button type="submit" value="submit" class="btn submit_btn">
                                                    Register
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




