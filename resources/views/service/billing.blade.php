@extends('layouts.frontLayout.userdesign')
    @section('content')
    <?php use App\Services; ?>

    <!--================Checkout Area =================-->
    <section class="checkout_area section_gap">
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
           
            <div class="billing_details">
                    <div class="row">
                        <div class="col-lg-12">
                                <h3>Billing Details</h3>
                                <form  class="row contact_form" action="{{ url('/billing') }}" method="post">
                                        @csrf
                                    <div class="col-md-6 form-group">
                                            <label>SurName</label>
                                            <input  type="text" class="form-control" @if(!empty($userDetails->SurName)) value="{{ $userDetails->SurName }}"@endif  id="billing_SurName" type="text"  name="billing_SurName" />
                                            <span  class="placeholder" ></span>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label>Other names</label>
                                        <input type="text" class="form-control"@if(!empty($userDetails->OtherNames)) value="{{ $userDetails->OtherNames }}"@endif  id="billing_OtherNames" type="text"  name="billing_OtherNames"/>
                                        <span class="placeholder" ></span>
                                    </div>
                                    <div class="col-md-6 form-group ">
                                            <label>Mobile</label>
                                            <input type="text" class="form-control"  @if(!empty($userDetails->Mobile)) value="{{ $userDetails->Mobile }}"@endif id="billing_Mobile" type="text"  name="billing_Mobile"/>
                                            <span  class="placeholder"></span>
                                     </div>
                                    <div class="col-md-6 form-group ">
                                        <label>Other Contact</label>
                                        <input type="text"  class="form-control"@if(!empty($userDetails->OtherContact)) value="{{ $userDetails->OtherContact }}"@endif id="billing_OtherContact" type="text"  name="billing_OtherContact" />
                                        <span class="placeholder" ></span>
                                    </div>
                                    <div class="col-md-12 form-group ">
                                            <label>City</label>
                                            <input type="text" class="form-control"  @if(!empty($userDetails->City)) value="{{ $userDetails->City }}"@endif id="billing_City" type="text"  name="billing_City"  />
                                            <span class="placeholder"  ></span>
                                    </div>
                                  
                           
                                        <div class="col-md-12">
                                            <div class="creat_account">
                                                <h3>Renting Details</h3>
                                                <input value="{{ $userDetails->SurName }} {{ $userDetails->OtherNames }}" type="checkbox" id="ship-box"  />
                                                <label for="f-option3">Rent to a different address?</label>
                                            </div>
                                         </div>
                                            <div class="col-md-6 form-group">
                                                    <label>SurName</label>
                                                    <input  type="text" class="form-control" @if(!empty($rentingDetails->SurName)) value="{{ $rentingDetails->SurName }}"@endif  id="renting_SurName" type="text"  name="renting_SurName" />
                                                    <span  class="placeholder" ></span>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label>Other names</label>
                                                <input type="text" class="form-control"@if(!empty($rentingDetails->OtherNames)) value="{{ $rentingDetails->OtherNames }}"@endif  id="renting_OtherNames" type="text"  name="renting_OtherNames"/>
                                                <span class="placeholder" ></span>
                                            </div>
                                            <div class="col-md-6 form-group ">
                                                    <label>Mobile</label>
                                                    <input type="text" class="form-control"  @if(!empty($rentingDetails->Mobile)) value="{{ $rentingDetails->Mobile }}"@endif id="renting_Mobile" type="text"  name="renting_Mobile"/>
                                                    <span  class="placeholder"></span>
                                            </div>
                                            <div class="col-md-6 form-group ">
                                                <label>Other Contact</label>
                                                <input type="text"  class="form-control"@if(!empty($rentingDetails->OtherContact)) value="{{ $rentingDetails->OtherContact }}"@endif id="renting_OtherContact" type="text"  name="renting_OtherContact" />
                                                <span class="placeholder" ></span>
                                            </div>
                                            <div class="col-md-12 form-group ">
                                                    <label>City</label>
                                                    <input type="text" class="form-control"  @if(!empty($rentingDetails->City)) value="{{ $rentingDetails->City }}"@endif id="renting_City" type="text"  name="renting_City"  />
                                                    <span class="placeholder"  ></span>
                                            </div>
                                            <div class="col-md-12">
                                        <div class="order-button-payment">
                                            <button type="submit" class="main_btn">Checkout</button>
                                        </div>
                                    </div>
                                </form>
                      
                       
                    </div>
            </div>
        </div>
    </section>
    <!--================End Checkout Area =================-->

   @endsection
