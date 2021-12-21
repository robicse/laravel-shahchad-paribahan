@extends('backend.layouts.master')
@section("title","Driver Salary List")
@push('css')
    <link rel="stylesheet" href="{{asset('backend/plugins/datatables/dataTables.bootstrap4.css')}}">
@endpush
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Driver Salary List</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">Driver Salary List</li>
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
                        <h3 class="card-title float-left">Driver Salary Lists</h3>
                        <div class="float-right">
                            <a href="{{route('admin.driver-salary-create')}}">
                                <button class="btn btn-success">
                                    <i class="fa fa-plus-circle"></i>
                                    Add
                                </button>
                            </a>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>#Id</th>
                                <th>Driver</th>
                                <th>Year</th>
                                <th>Month</th>
                                <th>Salary</th>
                                <th>Paid</th>
                                <th>Due</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($driverSalaries as $key => $driverSalary)
                                @php
                                    //$orderItem = orderItemByOrderId($vehicleVendorRent->id);
                                @endphp
                            <tr>
                                <td>{{$key + 1}}</td>
                                <td>{{$driverSalary->driver->name}}</td>
                                <td>{{$driverSalary->year}}</td>
                                <td>{{$driverSalary->month}}</td>
                                <td>{{$driverSalary->salary}}</td>
                                <td>{{$driverSalary->paid}}</td>
                                <td>
                                    {{$driverSalary->due}}
                                    @if($driverSalary->due > 0)
                                        <a href="" class="btn btn-warning btn-sm mx-1" data-toggle="modal" data-target="#exampleModal-<?= $driverSalary->id;?>"> Pay Due</a>
                                    @endif
                                </td>
                                <td class="d-inline-flex">
{{--                                    <a class="btn btn-info float-left" href="{{route('admin.driver-salary-edit',$driverSalary->id)}}" style="margin-left: 5px">--}}
{{--                                        <i class="fa fa-edit"></i>--}}
{{--                                    </a>--}}
                                    <a class="btn btn-success" href="{{route('admin.driver-salary-show',$driverSalary->id)}}" style="margin-left: 5px">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                                <!-- Modal -->
                                <div class="modal fade" id="exampleModal-{{$driverSalary->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Pay Due</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{route('admin.driver.pay.due')}}" method="post">
                                                    @csrf
                                                    <div class="form-group">
                                                        <label for="due">Enter Due Amount</label>
                                                        <input type="hidden" class="form-control" name="order_id" value="{{$driverSalary->id}}">
                                                        <input type="number" class="form-control" id="due" aria-describedby="emailHelp" name="new_paid" min="" max="{{$driverSalary->due}}" value="{{$driverSalary->due}}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="payment_type">Payment Method</label>
                                                        <select name="payment_type_id" id="payment_type_id" class="form-control" required>
                                                            <option value="">Select One</option>
                                                            @foreach($payment_types as $payment_type)
                                                                <option value="{{$payment_type->id}}" {{$payment_type->id == 1 ? 'selected' : ''}}>{{$payment_type->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <button type="submit" class="btn btn-primary">Submit</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        @push('js')
                                            <script>
                                                $(function() {
                                                    $('#cheque_number').hide();
                                                    $('#payment_type').change(function(){
                                                        if($('#payment_type').val() == 'Cheque') {
                                                            $('#cheque_number').show();
                                                        } else {
                                                            $('#cheque_number').val('');
                                                            $('#cheque_number').hide();
                                                        }
                                                    });
                                                });
                                            </script>
                                        @endpush
                                    </div>
                                </div>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>#Id</th>
                                <th>Driver</th>
                                <th>Year</th>
                                <th>Month</th>
                                <th>Salary</th>
                                <th>Paid</th>
                                <th>Due</th>
                                <th>Action</th>
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
