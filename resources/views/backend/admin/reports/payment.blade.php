@extends('backend.layouts.master')
@section("title","Payment List")
@push('css')
    <link rel="stylesheet" href="{{asset('backend/plugins/datatables/dataTables.bootstrap4.css')}}">
@endpush
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Payment List</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">Payment List</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card card-info card-outline">
                    <div class="card-header">
                        <h3 class="card-title float-left">Payment Lists</h3>
                        <div class="float-right">
{{--                            <a href="{{route('admin.vehicle-customer-rent-create')}}">--}}
{{--                                <button class="btn btn-success">--}}
{{--                                    <i class="fa fa-plus-circle"></i>--}}
{{--                                    Add--}}
{{--                                </button>--}}
{{--                            </a>--}}
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>#SL NO</th>
                                <th>Invoice NO</th>
                                <th>Date Time</th>
{{--                                <th>Vehicle</th>--}}
                                <th>Paid To</th>
                                <th>Method</th>
                                <th>Amount</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($payments as $key => $payment)
                            <tr>
                                <td>{{$key + 1}}</td>
                                <td>{{$payment->order->invoice_no}}</td>
                                <td>{{$payment->created_at}}</td>
{{--                                <td>--}}
{{--                                    @if($payment->transaction_type == 'Vehicle Vendor Rent' || $payment->transaction_type == 'Vehicle Customer Rent')--}}
{{--                                        @php--}}
{{--                                            $orderItem = orderItemByOrderId($payment->order_id);--}}
{{--                                        @endphp--}}
{{--                                        {{$orderItem->vehicle_name}}({{$orderItem->registration_no}})--}}
{{--                                    @endif--}}
{{--                                </td>--}}
                                <td>
{{--                                    @if($payment->order->order_type == 'Purchases')--}}
{{--                                        {{$payment->order->vendor->name}}--}}
{{--                                    @elseif($payment->order->order_type == 'Sales')--}}
{{--                                        {{$payment->order->customer->name}}--}}
{{--                                    @else--}}

{{--                                    @endif--}}
                                    @php
                                        //$orderItem = orderItemByOrderId($payment->order_id);
                                    @endphp
                                    {{getPaidToName($payment->paid_user_id, $payment->transaction_type)}}
                                </td>
                                <td>{{$payment->payment_type->name}}</td>
                                <td>{{$payment->paid}}</td>
                            </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>#SL NO</th>
                                <th>Invoice NO</th>
                                <th>Date Time</th>
{{--                                <th>Vehicle</th>--}}
                                <th>Paid To</th>
                                <th>Method</th>
                                <th>Amount</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>
    </section>

@stop
@push('js')
    <script src="{{asset('backend/plugins/datatables/jquery.dataTables.js')}}"></script>
    <script src="{{asset('backend/plugins/datatables/dataTables.bootstrap4.js')}}"></script>
    <script src="https://unpkg.com/sweetalert2@7.19.1/dist/sweetalert2.all.js"></script>
    <script>
        $(function () {
            $("#example1").DataTable();
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false
            });
        });

        //sweet alert
        function deleteVehicle(id) {
            swal({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    document.getElementById('delete-form-'+id).submit();
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    swal(
                        'Cancelled',
                        'Your Data is save :)',
                        'error'
                    )
                }
            })
        }
    </script>
@endpush
