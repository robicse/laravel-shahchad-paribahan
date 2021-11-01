<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\AccessLog;
use App\Model\Driver;
use App\Model\Vehicle;
use App\Model\VehicleDriverAssign;
use App\Model\VehicleVendorRent;
use App\Model\VehicleVendorRentDetail;
use App\Model\Vendor;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class VehicleVendorRentController extends Controller
{
//    function __construct()
//    {
//        $this->middleware('permission:vehicle-driver-assign-list|vehicle-driver-assign-create|vehicle-driver-assign-edit|vehicle-driver-assign-delete', ['only' => ['index','store']]);
//        $this->middleware('permission:vehicle-driver-assign-create', ['only' => ['create','store']]);
//        $this->middleware('permission:vehicle-driver-assign-edit', ['only' => ['edit','update']]);
//        $this->middleware('permission:vehicle-driver-assign-delete', ['only' => ['destroy']]);
//    }

    public function index()
    {
        $vehicleVendorRents = VehicleVendorRent::all();
        return view('backend.admin.vehicle_vendor_rents.index', compact('vehicleVendorRents'));
    }

    public function create()
    {
        $vehicles = Vehicle::where('status',1)->where('own_vehicle_status','Rent')->get();
        $vendors = Vendor::where('status',1)->get();
        return view('backend.admin.vehicle_vendor_rents.create', compact('vehicles','vendors'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            //'name'=> 'required|unique:vehicles,name',
        ]);

        $vehicleVendorRent = new VehicleVendorRent();
        $vehicleVendorRent->invoice_no = $request->invoice_no;
        $vehicleVendorRent->vendor_id = $request->vendor_id;
        $vehicleVendorRent->final_rent_amount = $request->final_rent_amount;
        $vehicleVendorRent->date = $request->date;
        $vehicleVendorRent->save();
        $insert_id = $vehicleVendorRent->id;
        if($insert_id){
            $vehicleVendorRentDetail = new VehicleVendorRentDetail();
            $vehicleVendorRentDetail->vehicle_vendor_rent_id=$insert_id;
            $vehicleVendorRentDetail->vehicle_id=$request->vehicle_id;
            $vehicleVendorRentDetail->rent_type=$request->rent_type;
            $vehicleVendorRentDetail->start_date=$request->start_date;
            $vehicleVendorRentDetail->end_date=$request->end_date;
            $vehicleVendorRentDetail->rent_duration=$request->rent_duration;
            $vehicleVendorRentDetail->quantity=$request->quantity;
            $vehicleVendorRentDetail->per_day_rent_amount=$request->per_day_rent_amount;
            $vehicleVendorRentDetail->sub_total_amount=$request->sub_total_amount;
            $vehicleVendorRentDetail->save();

            $accessLog = new AccessLog();
            $accessLog->user_id=Auth::user()->id;
            $accessLog->action_module='Vehicle Vendor Rent';
            $accessLog->action_done='Create';
            $accessLog->action_remarks='Vehicle Vendor Rent ID: '.$insert_id;
            $accessLog->action_date=date('Y-m-d');
            $accessLog->save();
        }

        Toastr::success('Vehicle Vendor Rent Created Successfully');
        return back();
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $vehicles = Vehicle::where('status',1)->where('own_vehicle_status','Rent')->get();
        $vendors = Vendor::where('status',1)->get();
        $vehicleDriverAssign = VehicleDriverAssign::find($id);
        return view('backend.admin.vehicle_vendor_rents.edit',compact('vehicleDriverAssign','vendors','vehicles'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            //'name'=> 'required|unique:vehicles,name,'.$id,
        ]);

        $vehicleVendorRent = VehicleVendorRent::find($id);
        $vehicleVendorRent->invoice_no = $request->invoice_no;
        $vehicleVendorRent->vendor_id = $request->vendor_id;
        $vehicleVendorRent->final_rent_amount = $request->final_rent_amount;
        $vehicleVendorRent->date = $request->date;
        $updated_row = $vehicleVendorRent->save();
        if($updated_row){
            $vehicleVendorRentDetail = VehicleVendorRentDetail::find($request->vehicle_vendor_rent_id);
            $vehicleVendorRentDetail->vehicle_id=$request->vehicle_id;
            $vehicleVendorRentDetail->rent_type=$request->rent_type;
            $vehicleVendorRentDetail->start_date=$request->start_date;
            $vehicleVendorRentDetail->end_date=$request->end_date;
            $vehicleVendorRentDetail->rent_duration=$request->rent_duration;
            $vehicleVendorRentDetail->quantity=$request->quantity;
            $vehicleVendorRentDetail->per_day_rent_amount=$request->per_day_rent_amount;
            $vehicleVendorRentDetail->sub_total_amount=$request->sub_total_amount;
            $vehicleVendorRentDetail->save();

            $accessLog = new AccessLog();
            $accessLog->user_id=Auth::user()->id;
            $accessLog->action_module='Vehicle Vendor Rent';
            $accessLog->action_done='Update';
            $accessLog->action_remarks='Vehicle Vendor Rent ID: '.$id;
            $accessLog->action_date=date('Y-m-d');
            $accessLog->save();
        }

        Toastr::success('Vehicle Vendor Rent updated successfully','Success');
        return back();
    }

//    public function destroy($id)
//    {
//        $vehicleDriverAssign = VehicleDriverAssign::find($id);
//        $deleted_row = $vehicleDriverAssign->delete();
//        if($deleted_row){
//            $accessLog = new AccessLog();
//            $accessLog->user_id=Auth::user()->id;
//            $accessLog->action_module='Vehicle Driver Assign';
//            $accessLog->action_done='Delete';
//            $accessLog->action_remarks='Vehicle Driver Assign ID: '.$id;
//            $accessLog->action_date=date('Y-m-d');
//            $accessLog->save();
//        }
//
//        Toastr::success('Vehicle Driver Assign deleted successfully','Success');
//        return back();
//    }
}
