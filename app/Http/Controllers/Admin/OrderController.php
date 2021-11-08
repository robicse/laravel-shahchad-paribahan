<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\AccessLog;
use App\Model\Order;
use App\Model\OrderItem;
use App\Model\Payment;
use App\Model\PaymentType;
use App\Model\Vehicle;
use App\Model\VehicleDriverAssign;
use App\Model\Vendor;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class OrderController extends Controller
{
//    function __construct()
//    {
//        $this->middleware('permission:vehicle-driver-assign-list|vehicle-driver-assign-create|vehicle-driver-assign-edit|vehicle-driver-assign-delete', ['only' => ['index','store']]);
//        $this->middleware('permission:vehicle-driver-assign-create', ['only' => ['create','store']]);
//        $this->middleware('permission:vehicle-driver-assign-edit', ['only' => ['edit','update']]);
//        $this->middleware('permission:vehicle-driver-assign-delete', ['only' => ['destroy']]);
//    }

    public function vehicle_vendor_rent_list()
    {
        $vehicleVendorRents = Order::where('type','Vendor')->get();
        $payment_types = PaymentType::where('name','!=','Credit')->get();
        return view('backend.admin.orders.vehicle_vendor_rent_list', compact('vehicleVendorRents','payment_types'));
    }

    public function vehicle_vendor_rent_create()
    {
        $vehicles = Vehicle::where('status',1)->where('own_vehicle_status','Rent')->get();
        $vendors = Vendor::where('status',1)->get();
        $payment_types = PaymentType::all();
        return view('backend.admin.orders.vehicle_vendor_rent_create', compact('vehicles','vendors','payment_types'));
    }

    public function vehicle_vendor_rent_store(Request $request)
    {
        //dd($request->all());
        $this->validate($request, [
            //'name'=> 'required|unique:vehicles,name',
        ]);

        $date = date('Y-m-d H:i:s');
        $vehicle = Vehicle::where('id',$request->vehicle_id)->first();
        $vehicleDriver = VehicleDriverAssign::where('vehicle_id',$request->vehicle_id)->first();
        $due_amount = $request->payment_type_id == 1 ? 0 :$request->grand_total;
        $paid_amount = $request->payment_type_id == 2 ? 0 :$request->grand_total;
        //dd($vehicle);

        $order = new Order();
        $order->date = $date;
        $order->invoice_no = '1000';
        $order->order_type = 'Receiving';
        $order->vendor_id = $request->vendor_id;
        $order->type = 'Vendor';
        $order->payment_type_id = $request->payment_type_id;
        $order->sub_total = $request->sub_total;
        $order->grand_total = $request->grand_total;
        $order->due_price = $due_amount;
        $order->status = 'Done';
        $order->save();

        $insert_id = $order->id;
        if($insert_id){
            $orderItem = new OrderItem();
            $orderItem->date = $date;
            $orderItem->order_id=$insert_id;
            $orderItem->vehicle_id=$request->vehicle_id;
            $orderItem->driver_id=$vehicleDriver->driver_id;
            $orderItem->rent_type=$vehicle->rent_type;
            $orderItem->start_date=$request->start_date;
            $orderItem->end_date=$request->end_date;
            $orderItem->rent_duration=$request->rent_duration;
            $orderItem->quantity=$request->quantity;
            $orderItem->price=$request->price;
            $orderItem->discount=$request->discount;
            //$orderItem->per_day_price=$request->per_day_price;
            $orderItem->sub_total=$request->sub_total;
            $orderItem->note=$request->note;
            $orderItem->type = 'Vendor';
            $orderItem->save();

            $payment = new Payment();
            $payment->date=date('Y-m-d');
            $payment->order_id=$insert_id;
            $payment->payment_type_id = $request->payment_type_id;
            $payment->paid = $paid_amount;
            $payment->save();

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

    public function vehicle_vendor_rent_edit($id)
    {
        $vehicles = Vehicle::where('status',1)->where('own_vehicle_status','Rent')->get();
        $vendors = Vendor::where('status',1)->get();
        $payment_types = PaymentType::all();
        $vehicleVendorRent = Order::where('order_type','receiving')->where('id',$id)->first();
        $vehicleVendorRentDetail = OrderItem::where('order_id',$id)->first();
        return view('backend.admin.orders.vehicle_vendor_rent_edit',compact('vehicleVendorRent','vehicleVendorRentDetail','vendors','vehicles','payment_types'));
    }

    public function vehicle_vendor_rent_update(Request $request, $id)
    {
        //dd($request->all());
        //dd($id);
        $this->validate($request, [
            //'name'=> 'required|unique:vehicles,name,'.$id,
        ]);

        $vehicle = Vehicle::where('id',$request->vehicle_id)->first();
        $vehicleDriver = VehicleDriverAssign::where('vehicle_id',$request->vehicle_id)->first();
        $due_amount = $request->payment_type_id == 1 ? 0 :$request->grand_total;
        $paid_amount = $request->payment_type_id == 2 ? 0 :$request->grand_total;

        $order = Order::find($id);
        $order->vendor_id = $request->vendor_id;
        $order->payment_type_id = $request->payment_type_id;
        $order->sub_total = $request->sub_total;
        $order->grand_total = $request->grand_total;
        $order->due_price = $due_amount;
        $updated_row = $order->save();

        if($updated_row){
            $orderItem = OrderItem::where('order_id',$id)->first();
            $orderItem->vehicle_id=$request->vehicle_id;
            $orderItem->driver_id=$vehicleDriver->driver_id;
            $orderItem->rent_type=$vehicle->rent_type;
            $orderItem->start_date=$request->start_date;
            $orderItem->end_date=$request->end_date;
            $orderItem->rent_duration=$request->rent_duration;
            $orderItem->quantity=$request->quantity;
            $orderItem->price=$request->price;
            $orderItem->discount=$request->discount;
            $orderItem->sub_total=$request->sub_total;
            $orderItem->note=$request->note;
            $orderItem->save();

            $payment = Payment::where('order_id',$id)->first();
            $payment->payment_type_id = $request->payment_type_id;
            $payment->paid = $paid_amount;
            $payment->save();

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
