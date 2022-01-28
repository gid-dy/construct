<?php
use App\Services;
$cartCount = Services::cartCount();
?>
<header class="header_area">
    <div class="top_menu">
      <div class="container">
        <div class="row">
          <div class="col-lg-8">
            <div class="float-left">
              <p>Phone: +01 256 25 235</p>
              <p>email: info@eiser.com</p>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="float-right">
              <ul class="right_side">
                <li>
                  <a href="{{ url('cart') }}">
                    gift card
                  </a>
                </li>
                <li>
                  <a href="{{ url('tracking') }}">
                    track order
                  </a>
                </li>
                <li>
                  <a href="{{ url('contact') }}">
                    Contact Us
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="main_menu">
      <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light w-100">
          <!-- Brand and toggle get grouped for better mobile display -->
          <a class="navbar-brand logo_h" href="{{ url('/')}}">
            <img src="{{ asset('images/frontend_images/logo.png')}}" alt="" />
          </a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <!-- Collect the nav links, forms, and other content for toggling -->
          <div class="collapse navbar-collapse offset w-100" id="navbarSupportedContent">
            <div class="row w-100 mr-0">
              <div class="col-lg-8 pr-0">
                <ul class="nav navbar-nav center_nav pull-right">
                  <li class="nav-item active">
                    <a class="nav-link" href="{{ url('/')}}">Home</a>
                  </li>
                  
                   <li class="nav-item">
                    <a class="nav-link" href="{{ url('cart') }}">{{ __('Cart') }}({{ $cartCount }})</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="{{ url('contact') }}">Contact</a>
                  </li>
                   
                            @if(empty(Auth::check()))
                            <li class="nav-item"><a class="nav-link" href="{{ url('register') }}"><i class="fa fa-user-plus"></i> {{ __('Sign Up') }}</a></li>
                                        <li class="nav-item"><a class="nav-link" href="{{ url('login') }}"><i class="fa fa-sign-in"></i> {{ __('Sign In') }}</a></li>
                                @else
                                <li class="nav-item submenu dropdown">
                                    <a  class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        {{ Auth::user()->SurName }} 
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li class="nav-item">
                                            <a class="nav-link"   href="{{ url('account') }}"><i class="fa fa-user"></i> {{ __('Account') }}</a>
                                        </li>
                                        <li class="nav-item">
                                        <a class="nav-link" href="{{ url('logout') }}"><i class="fa fa-sign-out"></i>
                                            {{ __('Logout') }}
                                        </a>
                                        </li>
                                    </ul>
                                </li>
                            @endif

                         
                </ul>
              </div>

              <div class="col-lg-4 pr-0">
                <ul class="nav navbar-nav navbar-right right_nav pull-right">
                  <li class="nav-item">
                    <a href="#" class="icons">
                      <i class="ti-search" aria-hidden="true"></i>
                    </a>
                  </li>

                  <li class="nav-item">
                    <a href="#" class="icons">
                      <i class="ti-shopping-cart"></i>
                    </a>
                  </li>

                  <li class="nav-item">
                    <a href="#" class="icons">
                      <i class="ti-user" aria-hidden="true"></i>
                    </a>
                  </li>

                  <li class="nav-item">
                    <a href="#" class="icons">
                      <i class="ti-heart" aria-hidden="true"></i>
                    </a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </nav>
      </div>
    </div>
  </header>
  <!-- end header -->
