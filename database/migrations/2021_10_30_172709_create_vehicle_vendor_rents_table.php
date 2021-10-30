<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehicleVendorRentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicle_vendor_rents', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_no');
            $table->integer('vendor_id');
            $table->double('final_discount_amount',8,2)->default(0);
            $table->double('final_rent_amount',8,2);
            $table->double('payment_amount',8,2)->default(0);
            $table->double('due_amount',8,2)->default(0);
            $table->string('date');
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
        Schema::dropIfExists('vehicle_vendor_rents');
    }
}
