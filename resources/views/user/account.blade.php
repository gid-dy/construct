@extends('layouts.frontLayout.userdesign')
    @section('content')
        <section class="banner_area">
                <div class="banner_inner d-flex align-items-center">
                         <div class="container">
                                <div class="banner_content d-md-flex justify-content-between align-items-center" >
                                    <div class="mb-3 mb-md-0">
                                            <h2>Account Information</h2>
                                            <p>Make changes to your account</p>
                                    </div>
                                    <div class="page_link">
                                            <a href="{{ url('/') }}">Home</a>
                                            <a href="{{ url('account') }}">Update account</a>
                                    </div>
                               </div>
                        </div>
                </div>
        </section>

         <section class="checkout_area section_gap">
                <div class="container clearfix">
                    <header class="">
                            <div class="top_menu">
                                    <div class="container">
                                            <div class="row">
                                                <div class="col-lg-4">
                                                        <ul class="right_side">
                                                            <li><a href="{{ url('account') }}">Update Account</a> </li>
                                                        </ul>
                                                </div>
                                                <div class="col-lg-4">
                                                        <ul class="right_side">
                                                                <li><a href="{{ url('change_password') }}"> Change Password</a></li>
                                                        </ul>
                                                </div>
                                                <div class="col-lg-4">
                                                        <ul class="right_side">
                                                            <li><a href="{{ url('Bookings') }}"> Recent Activities</a></li>
                                                        </ul>
                                                </div>
                                            </div>
                                    </div>
                            </div>
                        </header>

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
                    <div class="contact-container">
                        

                                <div class=>
                                    <h2>Profile Details</h2>
                                    <hr>
                                     <div class="returning_customer">
                                        <form  class="row contact_form" name="accountform" method="post" action="{{ url('/account') }}">
                                            @csrf
                                                <div class="col-md-6 form-group p_star">
                                                        <label>Sur Name</label>
                                                        <input type="text" class="form-control" id="SurName" name="SurName"  value="{{ $userDetails->SurName }} "/>
                                                </div>
                                                <div class="col-md-6 form-group p_star">
                                                            <label>Other Names</label>
                                                            <input type="text" class="form-control" id="OtherNames" name="OtherNames"  value="{{ $userDetails->OtherNames }} "/>
                                                    </div>
                                                <div class="col-md-6 form-group p_star">
                                                        <label class="p_star">Email</label>
                                                        <input type="text" class="form-control" id="email" name="email"  value="{{ $userDetails->email }} "/>
                                                </div>
                                                <div class="col-md-6 form-group p_star">
                                                        <label>Contact</label>
                                                        <input type="text" class="form-control" id="Mobile" name="Mobile"  value="{{ $userDetails->Mobile }} "/>
                                                </div>
                                                <div class="col-md-6 form-group p_star">
                                                    <label>Other Contact</label>
                                                    <input type="text" class="form-control" id="OtherContact" name="OtherContact"  value="{{ $userDetails->OtherContact }} "/>
                                                 </div>
                                                <div class="col-md-6 form-group p_star">
                                                        <label>City</label>
                                                        <input type="text" class="form-control" id="City" name="City"  value="{{ $userDetails->City }} "/>
                                                </div>
                                                <div class="col-md-12 form-group">
                                                    <button type="submit" value="submit" class="btn submit_btn">
                                                        Update Account
                                                    </button>
                                             </div>
                                        </form>
                                    </div>
                                </div>
                                 </div>
                    <hr>
                </div>

        </section>
 



@endsection




