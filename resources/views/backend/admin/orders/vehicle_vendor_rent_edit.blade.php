@extends('backend.layouts.master')
@section("title","Edit Vehicle Vendor Rent")
@push('css')
    <link rel="stylesheet" href="{{asset('backend/plugins/bootstrap-datepicker/bootstrap-datepicker.css')}}">
@endpush
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Vehicle Vendor Rent</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">Edit Vehicle Vendor Rent</li>
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
                        <h3 class="card-title float-left">Edit Vehicle Vendor Rent</h3>
                        <div class="float-right">
                            <a href="{{route('admin.vehicle-vendor-rent-list')}}">
                                <button class="btn btn-success">
                                    <i class="fa fa-backward"> </i>
                                    Back
                                </button>
                            </a>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form role="form" action="{{route('admin.vehicle-vendor-rent-update',$vehicleVendorRent->id)}}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="form-group">
                                <label for="vendor_id">Vendor <span>*</span></label>
                                <select name="vendor_id" id="vendor_id" class="form-control select2" required>
                                    <option value="">Select</option>
                                    @foreach($vendors as $vendor)
                                        <option value="{{$vendor->id}}" {{$vehicleVendorRent->vendor_id == $vendor->id ? 'selected' : ''}}>{{$vendor->name}} ({{$vendor->phone}})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="vehicle_id">Vehicle <span>*</span></label>
                                <select name="vehicle_id" id="vehicle_id" class="form-control select2" required>
                                    <option value="">Select</option>
                                    @foreach($vehicles as $vehicle)
                                        <option value="{{$vehicle->id}}" {{$vehicleVendorRentDetail->vehicle_id == $vehicle->id ? 'selected' : ''}}>{{$vehicle->vehicle_name}} ({{$vehicle->owner_name}})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="start_date">Start Date <span>*</span></label>
                                <input type="text" class="datepicker form-control" name="start_date" id="start_date" value="{{$vehicleVendorRentDetail->start_date}}">
                            </div>
                            <div class="form-group">
                                <label for="end_date">End Date <span>*</span></label>
                                <input type="text" class="datepicker form-control" name="end_date" id="end_date" value="{{$vehicleVendorRentDetail->end_date}}">
                            </div>
                            <div class="form-group">
                                <label for="rent_duration">Rent Duration <span>*</span></label>
                                <input type="text" class="form-control" name="rent_duration" id="rent_duration" value="{{$vehicleVendorRentDetail->rent_duration}}" readonly>
                            </div>
                            <div class="form-group">
                                <label for="quantity">Quantity <span>*</span></label>
                                <input type="number" class="form-control" name="quantity" id="quantity" value="{{$vehicleVendorRentDetail->quantity}}">
                            </div>
                            <div class="form-group">
                                <label for="rent_type">Rent Type <span>*</span></label>
                                <select name="rent_type" id="rent_type" class="form-control select2" required>
                                    <option value="">Select</option>
                                    <option value="Daily" {{$vehicleVendorRentDetail->rent_type == 'Daily' ? 'selected' : ''}}>Daily</option>
                                    <option value="Monthly {{$vehicleVendorRentDetail->rent_type == 'Monthly' ? 'selected' : ''}}">Monthly</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="price">Price</label>
                                <input type="number" class="form-control" name="price" id="price" value="{{$vehicleVendorRentDetail->price}}" >
                            </div>
                            <div class="form-group">
                                <label for="sub_total">Sub Total</label>
                                <input type="number" class="form-control" name="sub_total" id="sub_total" value="{{$vehicleVendorRent->sub_total}}" readonly>
                            </div>
                            <div class="form-group">
                                <label for="discount">Discount</label>
                                <input type="number" class="form-control" name="discount" id="discount" value="{{$vehicleVendorRentDetail->discount}}" >
                            </div>
                            <div class="form-group">
                                <label for="grand_total">Grand Total</label>
                                <input type="number" class="form-control" name="grand_total" id="grand_total" value="{{$vehicleVendorRent->grand_total}}" readonly>
                            </div>
                            <div class="form-group">
                                <label for="payment_type_id">Payment Type <span>*</span></label>
                                <select name="payment_type_id" id="payment_type_id" class="form-control select2" required>
                                    <option value="">Select</option>
                                    @foreach($payment_types as $payment_type)
                                        <option value="{{$payment_type->id}}" {{$vehicleVendorRent->payment_type_id == $payment_type->id ? 'selected' : ''}}>{{$payment_type->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group" id="paid_div">
                                <label for="paid">Paid</label>
                                <input type="number" class="form-control" name="paid" id="paid" value="{{$vehicleVendorRent->paid}}">
                            </div>
                            <div class="form-group" id="due_price_div">
                                <label for="due_price">Due</label>
                                <input type="number" class="form-control" name="due_price" id="due_price"  value="{{$vehicleVendorRent->due_price}}" readonly>
                            </div>
                            {{--                        <div class="form-group">--}}
                            {{--                            <label for="exchange">Exchange</label>--}}
                            {{--                            <input type="number" class="form-control" name="exchange" id="exchange" >--}}
                            {{--                        </div>--}}
                            <div class="form-group">
                                <label for="note">Note</label>
                                <textarea type="text" class="form-control" name="note" id="note" >{{$vehicleVendorRentDetail->note}}</textarea>
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

        $('#start_date').change(function (){
            var start_date = $('#start_date').val();
            //var end_date = $('#end_date').val();
            var vehicle_id = $('#vehicle_id').val();
            if(vehicle_id == ''){
                alert('Vehicle Select First!');
                $('#start_date').val('');
            }

            $.ajax({
                url: "{{URL('admin/check/already/vehicle/rent/or/not/this/date')}}",
                method:"POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    vehicle_id : vehicle_id,
                    start_date : start_date,
                    //end_date : end_date,
                },
                success:function (data){
                    console.log(data)
                    if(data > 0){
                        alert('Please select another vehicle, This vehicle already rent now.');
                        $('#vehicle_id').val('');
                    }else{
                        $.ajax({
                            url:"{{URL('/admin/get/vehicle/assigned/driver')}}",
                            method:"POST",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: {
                                vehicle_id : vehicle_id,
                                start_date : start_date,
                                //end_date : end_date,
                            },
                            success:function (res){
                                console.log(res)
                                if(res == 0){
                                    alert('Please select another vehicle Or Date, This vehicle already rent now OR Not driver assign yet!');
                                    $('#vehicle_id').val('');
                                }else{
                                    $('#driver_id').val(res);
                                }
                            },
                            error:function (err){
                                console.log(err)
                            }
                        })
                    }

                },
                error:function (err){
                    console.log(err)
                }
            })
        })

        $('#rent_type').change(function (){
            //alert();
            var vehicle_id = $('#vehicle_id').val();
            if(vehicle_id == ''){
                alert('Vehicle Select First!');
                $('#rent_type').val('');
            }
            var rent_duration = $('#rent_duration').val();
            if(rent_duration == ''){
                alert('Start Date And End Date Select First!');
                $('#rent_type').val('');
            }
            var quantity = $('#quantity').val();
            var rent_type = $('#rent_type').val();
            $.ajax({
                url:"{{URL('/admin/get/vehicle/price')}}",
                method:"POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    vehicle_id : vehicle_id
                },
                success:function (result){
                    console.log(result)
                    $('#price').val(result)
                    $('#sub_total').val(result*quantity)
                    $('#discount').val(0)
                    $('#grand_total').val(result*quantity)
                },
                error:function (err){
                    console.log(err)
                }
            })
        })

        $('#end_date').change(function (){
            var start_date = $('#start_date').val();
            var end_date = $('#end_date').val();
            if(start_date == ''){
                alert('Start Date Select First!');
                $('#end_date').val('');
            }


            //alert(start_date);
            const oneDay = 24 * 60 * 60 * 1000; // hours*minutes*seconds*milliseconds
            const firstDate = new Date(start_date);
            const secondDate = new Date(end_date);

            const diffDays = Math.round(Math.abs((firstDate - secondDate) / oneDay));
            $('#rent_duration').val(diffDays);
        })

        $('#paid').keyup(function (){
            var grand_total = $('#grand_total').val();
            var paid = $('#paid').val();
            var due_price = grand_total - paid;
            $('#due_price').val(due_price);
        })

        // check cash or credit paid
        var current_payment_type_id = $('#payment_type_id').val();
        if(current_payment_type_id == 1){
            $('#paid_div').hide();
            $('#due_price_div').hide();
        }
        $('#payment_type_id').change(function (){
            var payment_type_id = $('#payment_type_id').val();
            if(payment_type_id == 2){
                $('#paid_div').show();
                $('#due_price_div').show();
                // $('#paid').val(0);
                // var grand_total = $('#grand_total').val();
                // $('#due_price').val(grand_total);
            }else{
                $('#paid_div').hide();
                $('#due_price_div').hide();
                $('#paid').val(0);
                $('#due_price').val(0);
            }
        })
    </script>
@endpush
