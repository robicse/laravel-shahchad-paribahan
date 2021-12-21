<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\AccessLog;
use App\Model\Customer;
use App\Model\Order;
use App\Model\OrderItem;
use App\Model\Payment;
use App\Model\PaymentType;
use App\Model\Vehicle;
use App\Model\VehicleDriverAssign;
use App\Model\Vendor;
use NumberFormatter;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class ReportController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:report-payment-list', ['only' => ['reportPayment']]);

    }

    public function reportPayment()
    {
        $payments = Payment::latest()->get();
        //dd($payments);
        return view('backend.admin.reports.payment', compact('payments'));
    }


}
