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

        $vendor = new Vehicle();
        $vendor->name = $request->name;
        $vendor->phone = $request->phone;
        $vendor->email = $request->email;
        $vendor->vendor_address = $request->vendor_address;
        $vendor->company_name = $request->company_name;
        $vendor->company_address = $request->company_address;
        $image = $request->file('logo');
        if (isset($image)) {
            //make unique name for image
            $currentDate = Carbon::now()->toDateString();
            $imagename = $currentDate . '-' . uniqid() . '.' . $image->getClientOriginalExtension();
//            resize image for hospital and upload
            $proImage = Image::make($image)->resize(120, 80)->save($image->getClientOriginalExtension());
            Storage::disk('public')->put('uploads/vendors/' . $imagename, $proImage);

        }else {
            $imagename = "default.png";
        }
        $vendor->logo = $imagename;
        $vendor->save();
        Toastr::success('Vendor Created Successfully');
        return back();


    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $vendor = Vendor::find($id);
        return view('backend.admin.vendors.edit',compact('vendor'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name'=> 'required|unique:vendors,name,'.$id,
        ]);

        $vendor = Vendor::find($id);
        $vendor->name = $request->name;
        $vendor->phone = $request->phone;
        $vendor->email = $request->email;
        $vendor->vendor_address = $request->vendor_address;
        $vendor->company_name = $request->company_name;
        $vendor->company_address = $request->company_address;
        $image = $request->file('logo');
        if (isset($image)) {
            //make unique name for image
            $currentDate = Carbon::now()->toDateString();
            $imagename = $currentDate . '-' . uniqid() . '.' . $image->getClientOriginalExtension();

            if(Storage::disk('public')->exists('uploads/vendors/'.$vendor->logo))
            {
                Storage::disk('public')->delete('uploads/vendors/'.$vendor->logo);
            }
//            resize image for hospital and upload
            $proImage = Image::make($image)->resize(120, 80)->save($image->getClientOriginalExtension());
            Storage::disk('public')->put('uploads/vendors/' . $imagename, $proImage);

        }else {
            $imagename = $vendor->logo;
        }
        $vendor->logo = $imagename;
        $vendor->save();

        Toastr::success('Vendor updated successfully','Success');
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
