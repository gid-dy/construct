
@extends('layouts.adminLayout.admin_design')
@section('content')


{{-- main-container-part --}}
<div id="content">
    <!--breadcrumbs-->
    <div id="content-header">
            <div id="breadcrumb"> <a href="{{ url('admin/dashboard') }}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a></div>
    </div>
    <!--End-breadcrumbs-->
    @if (Session::has('flash_message_error'))
            <div class="alert alert-error alert-block">
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

    <!--Action boxes-->
    <div class="container-fluid">
        <div class="quick-actions_homepage">
            <ul class="quick-actions">
                <li class="bg_lb"> <a href="{{ url('admin/dashboard') }}"> <i class="icon-dashboard"></i> <span class="label label-important"></span> My Dashboard </a> </li>
                {{-- <li class="bg_lg span3"> <a href="charts.html"> <i class="icon-signal"></i> Charts</a> </li> --}}
                

            </ul>
        </div>
        <!--End-Action boxes-->

        <!--Chart-box-->
        <div class="row-fluid">
        <div class="widget-box">
            <div class="widget-title bg_lg"><span class="icon"><i class="icon-signal"></i></span>
            <h5>Users Reporting</h5>
            </div>
            <div class="widget-content" >
            <div class="row-fluid">
                <div class="span12">
                    <div id="users" style="height: 370px; width: 100%;"></div>
                </div>

            </div>
            </div>
        </div>
        </div>
        <!--End-Chart-box-->
        <hr/>
        <div class="row-fluid">
            <div class="span6">
                <div class="widget-box">
                    <div class="widget-title bg_ly" ><span class="icon"><i class="icon-chevron-down"></i></span>
                        <h5>Bookings Reporting</h5>
                    </div>
                    <div class="widget-content nopadding collapse in" id="collapseG2">
                        <div id="booking" style="height: 370px; width: 100%;"></div>
                    </div>
                </div>
            </div>
            <div class="span6">
                <div class="widget-box">
                    <div class="widget-title bg_ly" ><span class="icon"><i class="icon-chevron-down"></i></span>
                        <h5>Registered Users by Country</h5>
                    </div>
                    <div class="widget-content nopadding collapse in" id="collapseG2">
                        <div id="country" style="height: 370px; width: 100%;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--end-main-container-part-->
@endsection
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
