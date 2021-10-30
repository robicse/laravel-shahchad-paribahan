<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehicleVendorRentDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicle_vendor_rent_details', function (Blueprint $table) {
            $table->id();
            $table->integer('vehicle_vendor_rent_id');
            $table->integer('vehicle_id');
            $table->enum('rent_type',['Own','Rent'])->default('Rent');
            $table->string('start_date');
            $table->string('end_date');
            $table->integer('rent_duration');
            $table->integer('quantity');
            $table->double('per_day_rent_amount',8,2);
            $table->double('sub_total_amount',8,2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehicle_vendor_rent_details');
    }
}
