@extends('layouts.frontLayout.userdesign')
    @section('content')
    <?php use App\Services; ?>
  <section>
    <!-- checkout-area start -->
        <div class="checkout-area ptb-100">
            <div class="container">
                <div class="row col-md-12">
                    <div class="col-md-5">
                        <div class="billing-details">
                            <h3>Billing Details</h3>
                            <div class="form-group">
                                {{ $userDetails->SurName }}
                            </div>
                            <div class="form-group">
                                {{ $userDetails->OtherNames }}
                            </div>
                            <div class="form-group">
                                {{ $userDetails->Mobile }}
                            </div>
                            <div class="form-group">
                                {{ $userDetails->OtherContact }}
                            </div>
                            <div class="form-group">
                                {{ $userDetails->City }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2"></div>
                    <div class="col-md-5">
                        <div class="travelling-details">
                            <h3>User Details</h3>
                            <div class="form-group">
                                {{ $rentingDetails->SurName }}
                            </div>
                            <div class="form-group">
                                {{ $rentingDetails->OtherNames }}
                            </div>
                            <div class="form-group">
                                {{ $rentingDetails->Mobile }}
                            </div>
                            <div class="form-group">
                                {{ $rentingDetails->OtherContact }}
                            </div>
                            <div class="form-group">
                                {{ $rentingDetails->City }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="table-responsive">
                    <table class="table table-hover your-order">
                        <thead style="background-color:yellow;">
                            <tr>
                                <th>Name</th>
                                <th></th>
                                <th>Type</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $total_amount = 0; ?>
                            @foreach($userCart as $cart)
                                <tr>
                                    <td ><img class="img-responsive" src="{{ asset('images/backend_images/services/large/'.$cart->image) }}" style="width:50px;"></td>
                                    <td><h4><small>{{ $cart->ServiceName }}</small></h4>
                                    </td>
                                    <td><h4><small>{{ $cart->ServiceType }}</small></h4></td>
                                    <td>
                                        <?php $ServicePrice = Services::getServicePrice($cart->Service_id, $cart->ServiceType); ?>
                                        <p>GHS {{ $ServicePrice }}</p>
                                    </td>
                                    <td><h4><small>{{ $cart->Quantity }}</small></h4></td>
                                    <td><p class="">GHS {{ $ServicePrice*$cart->Quantity }}.00</td>
                                </tr>
                                <?php $total_amount = $total_amount + ($ServicePrice*$cart->Quantity);.00 ?>
                            @endforeach
                            <tr>
                                <td colspan="4">&nbsp;</td>
                                <td colspan="2">
                                    <table class="table table-condensed total-result">
                                        <tr>
                                            <td>Cart Sub Total</td>
                                            <td>GHS {{ $total_amount }}</td>
                                        </tr>
                                        <tr>
                                            <td>Discount Amount (-)</td>
                                            <td>@if(!empty(Session::get('CouponAmount')))
                                                GHS {{ Session::get('CouponAmount') }}
                                                @else
                                                    GHS 0
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Grand Total</td>
                                                <?php
                                                    $Grand_total = $total_amount - Session::get('CouponAmount'); ?>
                                                    GHS {{ $Grand_total  }}
                                            <td >
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <form name="paymentform" id="paymentform" action="{{ url('/place-package') }}" method="post">
                    @csrf
                    <input type="hidden" name="Grand_total" value="{{ $Grand_total }}">
                    <div class="payment-method">
                        <div class="panel-group">
                            <span>Select Payment Method:</strong></label></span>
                        </div>
                         <span class="col-md-4">
                            <label><input type="radio" id="flutterwave" name="Payment_method" value="flutterwave">
                                CARD <img src="{{ asset('images/frontend_images/payment.png') }}"></label>
                        </span>
                        <span class="col-md-4">
                            <label><input type="radio" id="ipay" name="Payment_method" value="ipay">
                                MOBILE MONEY <img src="{{ asset('images/frontend_images/ipay.jpg') }}"></label>
                        </span><br><br><br>
                        <span class="col-md-4">
                        <hr>

                        <div class="order-button-payment">
                            <input type="submit" onclick="return selectPaymentMethod();" class="main_btn" value="Proceed to Payment" />
                        </div>
                    </div>
                </form>
            </div>
            <hr>

        </div>
  </section>
@endsection
