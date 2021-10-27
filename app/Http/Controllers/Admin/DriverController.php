<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Driver;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class DriverController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:driver-list|driver-create|driver-edit|driver-delete', ['only' => ['index','store']]);
        $this->middleware('permission:driver-create', ['only' => ['create','store']]);
        $this->middleware('permission:driver-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:driver-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $drivers = Driver::all();
        return view('backend.admin.drivers.index', compact('drivers'));
    }

    public function create()
    {
        return view('backend.admin.drivers.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'=> 'required|unique:drivers,name',
        ]);

        $driver = new Driver();
        $driver->name = $request->name;
        $driver->phone = $request->phone;
        $driver->email = $request->email;
        $driver->present_address = $request->present_address;
        $driver->permanent_address = $request->permanent_address;
        $driver->driving_licence_no = $request->driving_licence_no;
        $driver->driving_experience_duration = $request->driving_experience_duration;
        $driver->salary = $request->salary;
        $image = $request->file('logo');
        if (isset($image)) {
            //make unique name for image
            $currentDate = Carbon::now()->toDateString();
            $imagename = $currentDate . '-' . uniqid() . '.' . $image->getClientOriginalExtension();
//            resize image for hospital and upload
            $proImage = Image::make($image)->resize(120, 80)->save($image->getClientOriginalExtension());
            Storage::disk('public')->put('uploads/drivers/' . $imagename, $proImage);

        }else {
            $imagename = "default.png";
        }
        $driver->logo = $imagename;
        $driver->save();
        Toastr::success('Driver Created Successfully');
        return back();


    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $driver = Driver::find($id);
        return view('backend.admin.drivers.edit',compact('driver'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name'=> 'required|unique:drivers,name,'.$id,
        ]);

        $driver = Driver::find($id);
        $driver->name = $request->name;
        $driver->phone = $request->phone;
        $driver->email = $request->email;
        $driver->present_address = $request->present_address;
        $driver->permanent_address = $request->permanent_address;
        $driver->driving_licence_no = $request->driving_licence_no;
        $driver->driving_experience_duration = $request->driving_experience_duration;
        $driver->salary = $request->salary;
        $image = $request->file('logo');
        if (isset($image)) {
            //make unique name for image
            $currentDate = Carbon::now()->toDateString();
            $imagename = $currentDate . '-' . uniqid() . '.' . $image->getClientOriginalExtension();

            if(Storage::disk('public')->exists('uploads/drivers/'.$driver->logo))
            {
                Storage::disk('public')->delete('uploads/drivers/'.$driver->logo);
            }
//            resize image for hospital and upload
            $proImage = Image::make($image)->resize(120, 80)->save($image->getClientOriginalExtension());
            Storage::disk('public')->put('uploads/drivers/' . $imagename, $proImage);

        }else {
            $imagename = $driver->logo;
        }
        $driver->logo = $imagename;
        $driver->save();

        Toastr::success('Driver updated successfully','Success');
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
