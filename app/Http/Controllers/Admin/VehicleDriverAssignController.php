<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Driver;
use App\Model\Vehicle;
use App\Model\Brand;
use App\Model\Category;
use App\Model\VehicleDriverAssign;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class VehicleDriverAssignController extends Controller
{
//    function __construct()
//    {
//        $this->middleware('permission:vehicle-list|vehicle-create|vehicle-edit|vehicle-delete', ['only' => ['index','store']]);
//        $this->middleware('permission:vehicle-create', ['only' => ['create','store']]);
//        $this->middleware('permission:vehicle-edit', ['only' => ['edit','update']]);
//        $this->middleware('permission:vehicle-delete', ['only' => ['destroy']]);
//    }

    public function index()
    {
        $vehicleDriverAssigns = VehicleDriverAssign::all();
        return view('backend.admin.vehicle_driver_assigns.index', compact('vehicleDriverAssigns'));
    }

    public function create()
    {
        $vehicles = Vehicle::all();
        $drivers = Driver::all();
        return view('backend.admin.vehicle_driver_assigns.create', compact('vehicles','drivers'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            //'name'=> 'required|unique:vehicles,name',
        ]);

        $vehicleDriverAssign = new VehicleDriverAssign();
        $vehicleDriverAssign->vehicle_id = $request->vehicle_id;
        $vehicleDriverAssign->driver_id = $request->driver_id;
        $vehicleDriverAssign->start_date = $request->start_date;
        $vehicleDriverAssign->end_date = $request->end_date;
        $vehicleDriverAssign->save();

        Toastr::success('Vehicle Driver Assign Created Successfully');
        return back();
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $vehicles = Vehicle::all();
        $drivers = Driver::all();
        $vehicleDriverAssign = VehicleDriverAssign::find($id);
        return view('backend.admin.vehicle_driver_assigns.edit',compact('vehicleDriverAssign','drivers','vehicles'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            //'name'=> 'required|unique:vehicles,name,'.$id,
        ]);

        $vehicleDriverAssign = VehicleDriverAssign::find($id);
        $vehicleDriverAssign->vehicle_id = $request->vehicle_id;
        $vehicleDriverAssign->driver_idstart_date = $request->driver_idstart_date;
        $vehicleDriverAssign->start_date = $request->start_date;
        $vehicleDriverAssign->end_date = $request->end_date;
        $vehicleDriverAssign->save();

        Toastr::success('Vehicle Driver Assign updated successfully','Success');
        return back();
    }

    public function destroy($id)
    {
        $vehicleDriverAssign = VehicleDriverAssign::find($id);
        $vehicleDriverAssign->delete();

        Toastr::success('Vehicle Driver Assign deleted successfully','Success');
        return back();
    }
}
