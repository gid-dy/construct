@extends('layouts.frontLayout.userdesign')
    @section('content')


    <section>
        <div class="container">
            <div class="row" style="margin-top: 30px;">
                <section class="post-wrapper-top">
                    <div class="container">
                        <div class="breadcrumb withpadding1">
                            <ul class="breadcrumb">
                                <li><a href="{{ url('/') }}">Home</a></li>
                                <li><a href="{{ url('Bookings') }}">Booking</a></li>
                                <li class="active">{{ $bookingDetails->id }}</li>
                            </ul>
                        </div>
                    </div>
                </section>

                <section class="" style="padding-top: 50px;">
                    <div class="container">
                        <div class="heading" style="align:center">
                            <table id="example" class="table table-striped table-bordered nowrap" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>ServiceName</th>
                                        <th>ServiceType</th>
                                        <th>ServicePrice</th>
                                        <th>Quantity</th>
                                </thead>
                                <tbody>
                                    @foreach($bookingDetails->bookings as $pro)
                                    <tr>
                                        <td>{{ $pro->ServiceName }}</td>
                                        <td>{{ $pro->ServiceType }}</td>
                                        <td>{{ $pro->ServicePrice }}</td>
                                        <td>{{ $pro->Quantity }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </section>

@endsection





