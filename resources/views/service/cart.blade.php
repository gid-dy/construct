@extends('layouts.frontLayout.userdesign')
    @section('content')
    <?php use App\Services; ?>

    <!--================Cart Area =================-->
    <section class="cart_area">
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
        <div class="cart_inner">
          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th scope="col">Product</th>
                  <th scope="col">Service Type</th>
                  <th scope="col">Price</th>
                  <th scope="col">Quantity</th>
                  <th scope="col">Total</th>
                  <th scope="col"></th>
                </tr>
              </thead>
              <tbody>
              <?php $total_amount = 0; ?>
                      @foreach($userCart as $cart)
                            <tr>
                              <td >
                                <div class="media">
                                      <div class="d-flex">
                                            <img  src="{{ asset('images/backend_images/services/large/'.$cart->image) }}" style="width:50px;" />
                                      </div>
                                      <div class="media-body">
                                          <p>{{ $cart->ServiceName }}</p>
                                      </div>
                                </div>
                              </td>
                              <td>
                                <h5>{{ $cart->ServiceType }}</h5>
                              </td>
                              <td>
                                <h5><?php $ServicePrice = Services::getServicePrice($cart->Service_id, $cart->ServiceType); ?>
                                    <p>GHS {{ $ServicePrice }}</p></h5>
                              </td>
                              <td>
                                <div class="product_count">
                                    <a href="{{ url('/cart/update-quantity/'.$cart->id.'/1') }}"> <i class="lnr lnr-chevron-up"></i> </a>
                                      <input  type="text"  name="Quantity"  id="sst"  maxlength="12" value="{{ $cart->Quantity }}"  title="Quantity:" class="input-text qty" />
                                      @if($cart->Quantity>1)
                                          <a href="{{ url('/cart/update-quantity/'.$cart->id.'/-1') }}">  <i class="lnr lnr-chevron-down"></i> </a>
                                      @endif
                                 </div>
                              </td>
                              <td>
                                <h5>GHS {{ $ServicePrice*$cart->Quantity }}.00</h5>
                              </td>
                              <td>
                                <a class ="cart_quantity_delete button" href="{{ url('/cart/delete-service/'.$cart->id) }}"><i class="fa fa-trash"></i> </a>
                              </td>
                            </tr>
                 <?php $total_amount = $total_amount + ($ServicePrice*$cart->Quantity);.00?>
                      @endforeach
                <tr class="bottom_button">
                  <td>
                    <a class="gray_btn" href="#">Update Cart</a>
                  </td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td>
                      <form method="post" action="{{ url('cart/apply-coupon') }}">
                              @csrf
                              <div class="cupon_text">
                               <input type="text" name="CouponCode" placeholder="Coupon code" />
                                <button class="main_btn" >Apply Coupon</button>
                              </div>
                        </form>
                  </td>
                </tr>
                
                <tr>
                 <td></td>
                  <td></td>
                  <td></td>
                  <td>
                    <h5>Subtotal</h5>
                  </td>
                  <td>
                    <h5>GHS <?php echo $total_amount; ?>.00</h5>
                  </td>
                </tr>
                @if(!empty(Session::get('CouponAmount')))
                <tr>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td>
                    <h5>Coupon Discount</h5>
                  </td>
                  <td>
                   <h5>GHS <?php echo Session::get('CouponAmount'); ?></h5>
                   
                  </td>
                 </tr>

                  <tr>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td>
                    <h5>Grand Total</h5>
                  </td>
                  <td>
                   <h5>GHS <?php echo  $total_amount - Session::get('CouponAmount');  ?></h5>
                  </td>
                  @else
                  <tr>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td>
                    <h5>Grand Total</h5>
                  </td>
                 <td>
                   <h5>GHS <?php echo  $total_amount;?></h5>
                  </td>
                </tr>
                @endif
                <tr class="out_button_area">
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td>
                    <div class="checkout_btn_inner">
                      <a class="gray_btn" href="#">Continue Shopping</a>
                      <a class="main_btn" href="{{ url('/billing') }}">Proceed to checkout</a>
                    </div>
                  </td>
                </tr>
                
               
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </section>
    <!--================End Cart Area =================-->
@endsection

