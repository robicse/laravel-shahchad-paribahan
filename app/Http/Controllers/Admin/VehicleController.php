<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Vehicle;
use App\Model\Brand;
use App\Model\Category;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class VehicleController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:vehicle-list|vehicle-create|vehicle-edit|vehicle-delete', ['only' => ['index','store']]);
        $this->middleware('permission:vehicle-create', ['only' => ['create','store']]);
        $this->middleware('permission:vehicle-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:vehicle-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $vehicles = Vehicle::all();
        return view('backend.admin.vehicles.index', compact('vehicles'));
    }

    public function create()
    {
        $brands = Brand::all();
        $categories = Category::all();
        return view('backend.admin.vehicles.create', compact('brands','categories'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            //'name'=> 'required|unique:vehicles,name',
        ]);

        $vehicle = new Vehicle();
        $vehicle->owner_name = $request->owner_name;
        $vehicle->vehicle_name = $request->vehicle_name;
        $vehicle->brand_id = $request->brand_id;
        $vehicle->category_id = $request->category_id;
        $vehicle->model = $request->model;
        $vehicle->licence_no = $request->licence_no;
        $vehicle->registration_date = $request->registration_date;
        $vehicle->chassis_no = $request->chassis_no;
        $vehicle->engine_no = $request->engine_no;
        $vehicle->vehicle_class = $request->vehicle_class;
        $vehicle->fuel_type = $request->fuel_type;
        $vehicle->fitness = $request->fitness;
        $vehicle->rc_status = $request->rc_status;
        $vehicle->own_vehicle_status = $request->own_vehicle_status;
        $vehicle->rent_type = $request->rent_type;
        $image = $request->file('image');
        if (isset($image)) {
            //make unique name for image
            $currentDate = Carbon::now()->toDateString();
            $imagename = $currentDate . '-' . uniqid() . '.' . $image->getClientOriginalExtension();
//            resize image for hospital and upload
            $proImage = Image::make($image)->resize(120, 80)->save($image->getClientOriginalExtension());
            Storage::disk('public')->put('uploads/vehicles/' . $imagename, $proImage);

        }else {
            $imagename = "default.png";
        }
        $vehicle->image = $imagename;
        $vehicle->save();
        Toastr::success('Vehicle Created Successfully');
        return back();


    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $brands = Brand::all();
        $categories = Category::all();
        $vehicle = Vehicle::find($id);
        return view('backend.admin.vehicles.edit',compact('vehicle','brands','categories'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            //'name'=> 'required|unique:vehicles,name,'.$id,
        ]);

        $vehicle = Vehicle::find($id);
        $vehicle->owner_name = $request->owner_name;
        $vehicle->vehicle_name = $request->vehicle_name;
        $vehicle->brand_id = $request->brand_id;
        $vehicle->category_id = $request->category_id;
        $vehicle->model = $request->model;
        $vehicle->licence_no = $request->licence_no;
        $vehicle->registration_date = $request->registration_date;
        $vehicle->chassis_no = $request->chassis_no;
        $vehicle->engine_no = $request->engine_no;
        $vehicle->vehicle_class = $request->vehicle_class;
        $vehicle->fuel_type = $request->fuel_type;
        $vehicle->fitness = $request->fitness;
        $vehicle->rc_status = $request->rc_status;
        $vehicle->own_vehicle_status = $request->own_vehicle_status;
        $vehicle->rent_type = $request->rent_type;
        $vehicle->status = $request->status;
        $image = $request->file('image');
        if (isset($image)) {
            //make unique name for image
            $currentDate = Carbon::now()->toDateString();
            $imagename = $currentDate . '-' . uniqid() . '.' . $image->getClientOriginalExtension();

            if(Storage::disk('public')->exists('uploads/vehicles/'.$vehicle->image))
            {
                Storage::disk('public')->delete('uploads/vehicles/'.$vehicle->image);
            }
//            resize image for hospital and upload
            $proImage = Image::make($image)->resize(120, 80)->save($image->getClientOriginalExtension());
            Storage::disk('public')->put('uploads/vehicles/' . $imagename, $proImage);

        }else {
            $imagename = $vehicle->image;
        }
        $vehicle->image = $imagename;
        $vehicle->save();

        Toastr::success('Vehicle updated successfully','Success');
        return back();
    }

//    public function destroy($id)
//    {
//        $vendor = Vendor::find($id);
//        if(Storage::disk('public')->exists('uploads/vendors/'.$vendor->image))
//        {
//            Storage::disk('public')->delete('uploads/vendors/'.$vendor->image);
//        }
//        $vendor->delete();
//
//        Toastr::success('Vendor deleted successfully','Success');
//        return back();
//    }
}