@extends('backend.layouts.master')
@section("title","Add Vehicle Vendor Rent")
@push('css')
    <link rel="stylesheet" href="{{asset('backend/plugins/bootstrap-datepicker/bootstrap-datepicker.css')}}">
@endpush
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Add Vehicle Vendor Rent</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">Add Vehicle Vendor Rent</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-8 offset-2">
            <!-- general form elements -->
                <div class="card card-info card-outline">
                <div class="card-header">
                    <h3 class="card-title float-left">Add Vehicle Vendor Rent</h3>
                    <div class="float-right">
                        <a href="{{route('admin.vehicle-vendor-rents.index')}}">
                            <button class="btn btn-success">
                                <i class="fa fa-backward"> </i>
                                Back
                            </button>
                        </a>
                    </div>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form role="form" action="{{route('admin.vehicle-vendor-rents.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="vendor_id">Vendor <span>*</span></label>
                            <select name="vendor_id" id="vendor_id" class="form-control select2" required>
                                <option value="">Select</option>
                                @foreach($vendors as $vendor)
                                    <option value="{{$vendor->id}}">{{$vendor->name}} ({{$vendor->phone}})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="vehicle_id">Vehicle <span>*</span></label>
                            <select name="vehicle_id" id="vehicle_id" class="form-control select2" required>
                                <option value="">Select</option>
                                @foreach($vehicles as $vehicle)
                                    <option value="{{$vehicle->id}}">{{$vehicle->vehicle_name}} ({{$vehicle->owner_name}})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="start_date">Start Date</label>
                            <input type="text" class="datepicker form-control" name="start_date" id="start_date" >
                        </div>
                        <div class="form-group">
                            <label for="end_date">End Date</label>
                            <input type="text" class="datepicker form-control" name="end_date" id="end_date" >
                        </div>
                        <div class="form-group">
                            <label for="quantity">Quantity</label>
                            <input type="number" class="form-control" name="quantity" id="quantity" >
                        </div>
                        <div class="form-group">
                            <label for="amount">Amount</label>
                            <input type="number" class="form-control" name="amount" id="amount" >
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
            </div>
        </div>
    </section>

@stop
@push('js')
    <script src="{{asset('backend/plugins/bootstrap-datepicker/bootstrap-datepicker.js')}}"></script>
    <script>
        $('.demo-select2').select2();
        // $("#demo-dp-range .input-daterange").datepicker({
        //     startDate: "-0d",
        //     todayBtn: "linked",
        //     autoclose: true,
        //     todayHighlight: true,
        // });
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            startDate: '-3d',
            //startDate: '-0d',
            todayBtn: "linked",
            autoclose: true,
            todayHighlight: true
        });
    </script>
@endpush
