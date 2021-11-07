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
            ->select('order_items.start_date','order_items.end_date','vehicles.vehicle_name','vehicles.owner_name')
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
// vehicle end











