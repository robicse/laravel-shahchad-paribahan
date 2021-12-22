<?php
/**
 * Created by PhpStorm.
 * User: Ashiqur Rahman
 * Date: 11/11/2021
 * Time: 3:08 PM
 */
use App\Model\VehicleDriverAssign;
use App\Model\OrderItem;
use App\Model\Vehicle;

// order start
if (!function_exists('orderItemByOrderId')) {
    function orderItemByOrderId($order_id) {
        return OrderItem::join('vehicles','order_items.vehicle_id','vehicles.id')
            ->where('order_items.order_id',$order_id)
            ->select('order_items.start_date','order_items.end_date','vehicles.vehicle_name','vehicles.vehicle_code','vehicles.owner_name','vehicles.registration_no')
            ->first();
    }
}
// order end


// driver start
if (!function_exists('checkAlreadyDriverAssignedOrFree')) {
    function checkAlreadyDriverAssignedOrFree($driver_id) {
        return VehicleDriverAssign::where('driver_id',$driver_id)
            ->where('start_date','<=',date('Y-m-d'))
            ->where('end_date','>=',date('Y-m-d'))
            ->get()->count();
    }
}

if (!function_exists('checkAlreadyDriverAssignedOrFreeEdit')) {
    function checkAlreadyDriverAssignedOrFreeEdit($driver_id,$vehicle_driver_assign_id) {
        return VehicleDriverAssign::where('driver_id',$driver_id)
            ->where('start_date','<=',date('Y-m-d'))
            ->where('end_date','>=',date('Y-m-d'))
            ->where('id','!=',$vehicle_driver_assign_id)
            ->get()->count();
    }
}

// driver start
if (!function_exists('checkDriverSalaryInfo')) {
    function checkDriverSalaryInfo($driver_id) {
        return \App\Model\Driver::where('id',$driver_id)
            ->select('id','salary_type','salary','per_day_salary')->first();
    }
}
// driver end

// vehicle start
if (!function_exists('checkAlreadyVehicleAssignedOrFree')) {
    function checkAlreadyVehicleAssignedOrFree($vehicle_id) {
        return VehicleDriverAssign::where('vehicle_id',$vehicle_id)
            ->where('start_date','<=',date('Y-m-d'))
            ->where('end_date','>=',date('Y-m-d'))
            ->get()->count();
    }
}

if (!function_exists('checkAlreadyVehicleAssignedOrFreeEdit')) {
    function checkAlreadyVehicleAssignedOrFreeEdit($vehicle_id, $vehicle_driver_assign_id) {
        return VehicleDriverAssign::where('vehicle_id',$vehicle_id)
            ->where('start_date','<=',date('Y-m-d'))
            ->where('end_date','>=',date('Y-m-d'))
            ->where('id','!=',$vehicle_driver_assign_id)
            ->get()->count();
    }
}

if (!function_exists('getVehiclePrice')) {
    function getVehiclePrice($vehicle_id) {
        return Vehicle::where('id',$vehicle_id)
            ->pluck('price')->first();
    }
}

//if (!function_exists('checkAlreadyVehicleRentOrNot')) {
//    function checkAlreadyVehicleRentOrNot($vehicle_id) {
//        return OrderItem::where('vehicle_id',$vehicle_id)
//            ->where('start_date','<=',date('Y-m-d'))
//            ->where('end_date','>=',date('Y-m-d'))
//            ->get()->count();
//    }
//}

if (!function_exists('checkAlreadyVehicleRentOrNotThisDate')) {
    function checkAlreadyVehicleRentOrNotThisDate($vehicle_id, $start_date) {
        return OrderItem::where('vehicle_id',$vehicle_id)
            ->where('start_date','<=',$start_date)
            ->where('end_date','>=',$start_date)
            ->get()->count();
    }
}

if (!function_exists('getVehicleAssignedDriver')) {
    function getVehicleAssignedDriver($vehicle_id, $start_date) {
        return VehicleDriverAssign::join('drivers','vehicle_driver_assigns.driver_id','drivers.id')
            ->where('vehicle_driver_assigns.vehicle_id',$vehicle_id)
            ->where('vehicle_driver_assigns.start_date','<=',$start_date)
            ->where('vehicle_driver_assigns.end_date','>=',$start_date)
            ->pluck('drivers.name')->first();
    }
}
// vehicle end


if (!function_exists('getPaidToName')) {
    function getPaidToName($id, $transaction_type) {
        if($transaction_type == 'Vehicle Vendor Rent'){
            return \App\Model\Vendor::where('id',$id)->pluck('name')->first();
        }elseif($transaction_type == 'Vehicle Customer Rent'){
            return \App\Model\Customer::where('id',$id)->pluck('name')->first();
        }elseif($transaction_type == 'Driver Salary'){
            return \App\Model\Driver::where('id',$id)->pluck('name')->first();
        }elseif($transaction_type == 'Staff Salary'){
            return \App\User::where('id',$id)->pluck('name')->first();
        }else{
            return 'No Found!';
        }

    }
}











