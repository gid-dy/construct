@extends('layouts.adminLayout.admin_design')
@section('content')

<div id="content">
    <div id="content-header">
        <div id="breadcrumb"> <a href="{{ url('admin/dashboard') }}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">Tour Packages</a> <a href="#" class="current">Add Servicetype</a> </div>
            <h1>Servicetype</h1>
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
    </div>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li style="list-style-type:none;">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="container-fluid"><hr>
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
                        <h5>Add Tour Attribute</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <form enctype="multipart/form-data" class="form-horizontal" method="post" action="{{ url('/admin/add-Servicetype/'.$servicesDetails->id) }}" name="add_tourtype" id="add_tourtype">
                            @csrf
                            <input type="hidden" name="Service_id" value="{{ $servicesDetails->id }}" />
                            <div class="control-group">
                                <label class="control-label">Package Name</label>
                                <label class="control-label"><strong>{{ $servicesDetails->ServiceName }}</strong></label>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Package Code</label>
                                <label class="control-label"><strong>{{ $servicesDetails->PackageCode }}</strong></label>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Package Price</label>
                                <label class="control-label"><strong>{{ $servicesDetails->ServicePrice }}</strong></label>
                            </div>
                            <div class="control-group">
                                <label class="control-label"></label>
                                <div class="widget-title" style="margin-top:20px;"> <span class="icon"> <i class="icon-info-sign"></i> </span>
                                    <h5>Attributes</h5>
                                </div>
                                <div class="field_wrapper">
                                    <div>
                                        <input type="text" name="SKU[]" id="SKU" placeholder="SKU" style="width:120px; margin-left:100px;" required/>
                                        <input type="text" name="ServiceSize[]" id="ServiceSize" placeholder="ServiceSize" style="width:120px;" required/>
                                        <input type="text" name="ServiceType[]" id="ServiceType" placeholder="ServiceType" style="width:120px;" required/>
                                        <input type="text" name="ServicePrice[]" id="ServicePrice" placeholder="ServicePrice" style="width:120px;" required/>
                                        <a href="javascript:void(0);" class="add_button" title="Add field">Add</a>
                                    </div>
                                </div>
                            </div>
                            <div class="form-actions">
                                <input type="submit" value="Add Service Attribute" class="btn btn-success">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row-fluid">
        <div class="span12">
            <div class="widget-box">
                <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
                    <h5>View Servicetype</h5>
                </div>
                <div class="widget-content nopadding">
                    <form class="form-horizontal" method="post" action="{{ url('/admin/edit-Servicetype/'.$servicesDetails->id) }}" name="edit_tourtype" id="edit_tourtype" novalidate="novalidate">
                        @csrf
                        <table class="table table-bordered data-table">
                            <thead>
                                <tr>
                                <th>Servicetype Id</th>
                                <th>SKU</th>
                                <th>Servicetype Name</th>
                                <th>Servicetype Size</th>
                                <th>Package Price</th>
                                <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($servicesDetails['servicetypes'] as $Servicetype)
                                    <tr class="gradeX">
                                        <td><input type="hidden" name="idType[]"value="{{ $Servicetype->id }}"> {{ $Servicetype->id }}</td>
                                        <td>{{ $Servicetype->SKU }}</td>
                                        <td>{{ $Servicetype->ServiceType }}</td>
                                        <td><input type="text" name="ServiceSize[]" value="{{ $Servicetype->ServiceSize }}"></td>
                                        <td><input type="text" name="ServicePrice[]" value="{{ $Servicetype->ServicePrice }}"></td>
                                        <td class="center">
                                        <input type="submit" value="update" class="btn btn-primary btn-mini">
                                        <a rel="{{ $Servicetype->id }}" rel1="delete-Servicetype" href="javascript:" class="btn btn-danger btn-mini deleteRecord">Delete</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- <div id="content-header">
        <h1>Tour Transportation</h1>
    </div>
    <div class="container-fluid"><hr>
        <div class="row-fluid">
        <div class="span12">
            <div class="widget-box">
            <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
                <h5>Add Tour Transportation</h5>

            </div>

            <div class="widget-content nopadding">
                <form enctype="multipart/form-data" class="form-horizontal" method="post" action="{{ url('/admin/add-tourtransportation/'.$servicesDetails->id) }}" name="add_transportation" id="add_transportation" novalidate="novalidate">
                    @csrf
                    <div class="control-group">

                        <label class="control-label"></label>
                        <div class="widget-title" style="margin-top:20px;"> <span class="icon"> <i class="icon-info-sign"></i> </span>
                            <h5>Transportation</h5>
                        </div>
                        <div class="field_wrapper_transport">
                            <div>
                                <input type="text" name="TransportName[]" id="TransportName" placeholder="TransportName" style="width:120px; margin-left:100px;" required/>
                                <input type="text" name="TransportCost[]" id="TransportCost" placeholder="TransportCost" style="width:120px;" required/>
                                <a href="javascript:void(0);" class="add_button_trans" title="Add field">Add</a>
                            </div>
                        </div>
                    </div>


                <div class="form-actions">
                    <input type="submit" value="Add Transport" class="btn btn-success">
                </div>
                </form>
            </div>
            </div>
        </div>
        </div>

    </div>
    <div class="row-fluid">
        <div class="span12">
            <div class="widget-box">
            <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
                <h5>View Tour transport</h5>
            </div>
            <div class="widget-content nopadding">
                <form class="form-horizontal" method="post" action="{{ url('/admin/edit-tourtransportation/'.$servicesDetails->id) }}" name="edit_transportation" id="edit_transportation" novalidate="novalidate">
                    @csrf
                    <table class="table table-bordered data-table">
                        <thead>
                            <tr>
                            <th> Transportation ID</th>
                            <th>Transport Name</th>
                            <th>Transport Cost</th>
                            <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($servicesDetails['tourtransports'] as $tourtransportation)
                                <tr class="gradeX">
                                    <td><input type="hidden" name="idTransport[]"value="{{ $tourtransportation->id }}"> {{ $tourtransportation->id }}</td>
                                    <td>{{ $tourtransportation->TransportName }}</td>
                                    <td><input type="text" name="TransportCost[]" value="{{ $tourtransportation->TransportCost }}"></td>
                                    <td class="center">
                                    <input type="submit" value="update" class="btn btn-primary btn-mini">
                                    <a rel="{{ $tourtransportation->id }}" rel1="delete-transport" href="javascript:" class="btn btn-danger btn-mini deleteRecord">Delete</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </form>
            </div>
            </div>
        </div>
    </div> --}}

  


</div>
@endsection
