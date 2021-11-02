<?php
/**
 * Created by PhpStorm.
 * User: Ashiqur Rahman
 * Date: 11/11/2021
 * Time: 3:08 PM
 */
use App\Model\FlashDeal;
use App\Model\FlashDealProduct;
use App\Model\Product;
use App\Model\Category;
use App\Model\Subcategory;
use App\Model\Brand;
use App\Model\OrderItem;


if (!function_exists('orderItemByOrderId')) {
    function orderItemByOrderId($order_id) {
        return OrderItem::join('vehicles','order_items.vehicle_id','vehicles.id')
            ->where('order_items.order_id',$order_id)
            ->select('order_items.start_date','order_items.end_date','vehicles.vehicle_name','vehicles.owner_name')
            ->first();
    }
}






