<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class DriverSalary extends Model
{
    public function customer(){
        return $this->belongsTo(Customer::class);
    }
}
