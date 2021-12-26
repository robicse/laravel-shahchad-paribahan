<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Model\Payment;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:report-payment-list', ['only' => ['reportPayment']]);

    }

    public function reportPayment(Request $request)
    {
        if( (!empty($request->date_from)) && (!empty($request->date_to)) )
        {
            $payments = Payment::whereBetween('date', [$request->date_from, $request->date_from])->latest()->get();
        }else{
            $payments = Payment::latest()->get();
        }

        //dd($payments);

        $date_from = '';
        $date_to = '';

        if($request->date_from)
        {
            $date_from = $request->date_from;
        }
        if($request->date_to)
        {
            $date_to = $request->date_to;
        }
        return view('backend.admin.reports.payment', compact('payments','date_from','date_to'));
    }

    public function report_payment_print($date_from,$date_to)
    {
        if( (!empty($date_from)) && (!empty($date_to)) )
        {
            $payments = Payment::whereBetween('date', [$date_from, $date_to])->latest()->get();
        }else{
            $payments = Payment::latest()->get();
        }

        return view('backend.admin.reports.payment_print', compact('payments','date_from','date_to'));
    }

    public function vendor_balance_sheet_form(Request $request)
    {
        $vendor_previous_total_paid=0;
        $vendor_cash_data_results = '';

        if ($request->isMethod('post')) {
            $vendor_cash_pre_valance_data = DB::table('payments')
                ->select('paid_user_id', DB::raw('SUM(paid) as total_paid'))
                ->where('date', '<',$request->date_from)
                ->where('transaction_type','Vehicle Vendor Rent')
                ->where('payment_type_id',1)
                ->groupBy('paid_user_id')
                ->first();

            if(!empty($vendor_cash_pre_valance_data))
            {
                $vendor_previous_total_paid = $vendor_cash_pre_valance_data->total_paid;
            }

            if( (!empty($request->date_from)) && (!empty($request->date_to)) )
            {
                $vendor_cash_data_results = DB::table('payments')
                    ->select('paid_user_id', DB::raw('SUM(paid) as total_paid'))
                    ->where('transaction_type','Vehicle Vendor Rent')
                    ->where('payment_type_id',1)
                    ->whereBetween('date', [$request->date_from, $request->date_to])
                    ->groupBy('paid_user_id')
                    ->get();
            }else{
                $vendor_cash_data_results = DB::table('payments')
                    ->select('paid_user_id', DB::raw('SUM(paid) as total_paid'))
                    ->where('transaction_type','Vehicle Vendor Rent')
                    ->where('payment_type_id',1)
                    ->groupBy('paid_user_id')
                    ->get();
            }
        }

        $date_from = '';
        $date_to = '';

        if($request->date_from)
        {
            $date_from = $request->date_from;
        }
        if($request->date_to)
        {
            $date_to = $request->date_to;
        }

        return view('backend.admin.reports.vendor_balance_sheet_form', compact('vendor_cash_data_results', 'vendor_previous_total_paid','date_from','date_to'));
    }

    public function report_vendor_balance_sheet_print($date_from,$date_to)
    {
        $vendor_previous_total_paid=0;

        $vendor_cash_pre_valance_data = DB::table('payments')
            //->select('account_no', DB::raw('SUM(debit) as debit, SUM(credit) as credit'))
            ->select('paid_user_id', DB::raw('SUM(paid) as total_paid'))
            ->where('date', '<',$date_from)
            ->where('transaction_type','Vehicle Vendor Rent')
            ->where('payment_type_id',1)
            ->groupBy('paid_user_id')
            ->first();

        if(!empty($vendor_cash_pre_valance_data))
        {
            $vendor_previous_total_paid = $vendor_cash_pre_valance_data->total_paid;
        }

        if( (!empty($date_from)) && (!empty($date_to)) )
        {
            $vendor_cash_data_results = DB::table('payments')
                ->select('paid_user_id', DB::raw('SUM(paid) as total_paid'))
                ->where('transaction_type','Vehicle Vendor Rent')
                ->where('payment_type_id',1)
                ->whereBetween('date', [$date_from, $date_to])
                ->groupBy('paid_user_id')
                ->get();
        }else{
            $vendor_cash_data_results = DB::table('payments')
                ->select('paid_user_id', DB::raw('SUM(paid) as total_paid'))
                ->where('transaction_type','Vehicle Vendor Rent')
                ->where('payment_type_id',1)
                ->groupBy('paid_user_id')
                ->get();
        }

        return view('backend.admin.reports.vendor_balance_sheet_print', compact('vendor_cash_data_results', 'vendor_previous_total_paid','date_from','date_to'));
    }

    public function customer_balance_sheet_form(Request $request)
    {
        $customer_previous_total_paid=0;
        $customer_cash_data_results = '';

        if ($request->isMethod('post')) {
            $customer_cash_pre_valance_data = DB::table('payments')
                ->select('paid_user_id', DB::raw('SUM(paid) as total_paid'))
                ->where('date', '<',$request->date_from)
                ->where('payment_type_id',1)
                ->where('transaction_type','Vehicle Customer Rent')
                ->groupBy('paid_user_id')
                ->first();

            if(!empty($customer_cash_pre_valance_data))
            {
                $customer_previous_total_paid = $customer_cash_pre_valance_data->total_paid;
            }

            if( (!empty($request->date_from)) && (!empty($request->date_to)) )
            {
                $customer_cash_data_results = DB::table('payments')
                    ->select('paid_user_id', DB::raw('SUM(paid) as total_paid'))
                    ->where('transaction_type','Vehicle Customer Rent')
                    ->where('payment_type_id',1)
                    ->whereBetween('date', [$request->date_from, $request->date_to])
                    ->groupBy('paid_user_id')
                    ->get();
            }else{
                $customer_cash_data_results = DB::table('payments')
                    ->select('paid_user_id', DB::raw('SUM(paid) as total_paid'))
                    ->where('transaction_type','Vehicle Customer Rent')
                    ->where('payment_type_id',1)
                    ->groupBy('paid_user_id')
                    ->get();
            }
        }

        $date_from = '';
        $date_to = '';

        if($request->date_from)
        {
            $date_from = $request->date_from;
        }
        if($request->date_to)
        {
            $date_to = $request->date_to;
        }

        return view('backend.admin.reports.customer_balance_sheet_form', compact('customer_cash_data_results', 'customer_previous_total_paid','date_from','date_to'));
    }

    public function report_customer_balance_sheet_print($date_from,$date_to)
    {
        $customer_previous_total_paid=0;

        $customer_cash_pre_valance_data = DB::table('payments')
            //->select('account_no', DB::raw('SUM(debit) as debit, SUM(credit) as credit'))
            ->select('paid_user_id', DB::raw('SUM(paid) as total_paid'))
            ->where('date', '<',$date_from)
            ->where('payment_type_id',1)
            ->where('transaction_type','Vehicle Customer Rent')
            ->groupBy('paid_user_id')
            ->first();

        if(!empty($customer_cash_pre_valance_data))
        {
            $customer_previous_total_paid = $customer_cash_pre_valance_data->total_paid;
        }

        if( (!empty($date_from)) && (!empty($date_to)) )
        {
            $customer_cash_data_results = DB::table('payments')
                ->select('paid_user_id', DB::raw('SUM(paid) as total_paid'))
                ->where('transaction_type','Vehicle Customer Rent')
                ->where('payment_type_id',1)
                ->whereBetween('date', [$date_from, $date_to])
                ->groupBy('paid_user_id')
                ->get();
        }else{
            $customer_cash_data_results = DB::table('payments')
                ->select('paid_user_id', DB::raw('SUM(paid) as total_paid'))
                ->where('transaction_type','Vehicle Customer Rent')
                ->where('payment_type_id',1)
                ->groupBy('paid_user_id')
                ->get();
        }

        return view('backend.admin.reports.customer_balance_sheet_print', compact('customer_cash_data_results', 'customer_previous_total_paid','date_from','date_to'));
    }

    public function driver_balance_sheet_form(Request $request)
    {
        $driver_previous_total_paid=0;
        $driver_cash_data_results = '';

        if ($request->isMethod('post')) {
            $driver_cash_pre_valance_data = DB::table('payments')
                //->select('account_no', DB::raw('SUM(debit) as debit, SUM(credit) as credit'))
                ->select('paid_user_id', DB::raw('SUM(paid) as total_paid'))
                ->where('date', '<',$request->date_from)
                ->where('payment_type_id',1)
                ->where('transaction_type','Driver Salary')
                ->groupBy('paid_user_id')
                ->first();

            if(!empty($driver_cash_pre_valance_data))
            {
                $driver_previous_total_paid = $driver_cash_pre_valance_data->total_paid;
            }

            if( (!empty($request->date_from)) && (!empty($request->date_to)) )
            {
                $driver_cash_data_results = DB::table('payments')
                    ->select('paid_user_id', DB::raw('SUM(paid) as total_paid'))
                    ->where('transaction_type','Driver Salary')
                    ->where('payment_type_id',1)
                    ->whereBetween('date', [$request->date_from, $request->date_to])
                    ->groupBy('paid_user_id')
                    ->get();
            }else{
                $driver_cash_data_results = DB::table('payments')
                    ->select('paid_user_id', DB::raw('SUM(paid) as total_paid'))
                    ->where('transaction_type','Driver Salary')
                    ->where('payment_type_id',1)
                    ->groupBy('paid_user_id')
                    ->get();
            }
        }

        $date_from = '';
        $date_to = '';

        if($request->date_from)
        {
            $date_from = $request->date_from;
        }
        if($request->date_to)
        {
            $date_to = $request->date_to;
        }

        return view('backend.admin.reports.driver_balance_sheet_form', compact('driver_cash_data_results', 'driver_previous_total_paid','date_from','date_to'));
    }

    public function report_driver_balance_sheet_print($date_from,$date_to)
    {
        $driver_previous_total_paid=0;

        $driver_cash_pre_valance_data = DB::table('payments')
            //->select('account_no', DB::raw('SUM(debit) as debit, SUM(credit) as credit'))
            ->select('paid_user_id', DB::raw('SUM(paid) as total_paid'))
            ->where('date', '<',$date_from)
            ->where('payment_type_id',1)
            ->where('transaction_type','Driver Salary')
            ->groupBy('paid_user_id')
            ->first();

        if(!empty($driver_cash_pre_valance_data))
        {
            $driver_previous_total_paid = $driver_cash_pre_valance_data->total_paid;
        }

        if( (!empty($date_from)) && (!empty($date_to)) )
        {
            $driver_cash_data_results = DB::table('payments')
                ->select('paid_user_id', DB::raw('SUM(paid) as total_paid'))
                ->where('transaction_type','Driver Salary')
                ->where('payment_type_id',1)
                ->whereBetween('date', [$date_from, $date_to])
                ->groupBy('paid_user_id')
                ->get();
        }else{
            $driver_cash_data_results = DB::table('payments')
                ->select('paid_user_id', DB::raw('SUM(paid) as total_paid'))
                ->where('transaction_type','Driver Salary')
                ->where('payment_type_id',1)
                ->groupBy('paid_user_id')
                ->get();
        }

        return view('backend.admin.reports.driver_balance_sheet_print', compact('driver_cash_data_results', 'driver_previous_total_paid','date_from','date_to'));
    }

    public function staff_balance_sheet_form(Request $request)
    {
        $staff_previous_total_paid=0;
        $staff_cash_data_results = '';

        if ($request->isMethod('post')) {
            $staff_cash_pre_valance_data = DB::table('payments')
                //->select('account_no', DB::raw('SUM(debit) as debit, SUM(credit) as credit'))
                ->select('paid_user_id', DB::raw('SUM(paid) as total_paid'))
                ->where('date', '<',$request->date_from)
                ->where('payment_type_id',1)
                ->where('transaction_type','Staff Salary')
                ->groupBy('paid_user_id')
                ->first();

            if(!empty($staff_cash_pre_valance_data))
            {
                $staff_previous_total_paid = $staff_cash_pre_valance_data->total_paid;
            }

            if( (!empty($request->date_from)) && (!empty($request->date_to)) )
            {
                $staff_cash_data_results = DB::table('payments')
                    ->select('paid_user_id', DB::raw('SUM(paid) as total_paid'))
                    ->where('transaction_type','Staff Salary')
                    ->where('payment_type_id',1)
                    ->whereBetween('date', [$request->date_from, $request->date_to])
                    ->groupBy('paid_user_id')
                    ->get();
            }else{
                $staff_cash_data_results = DB::table('payments')
                    ->select('paid_user_id', DB::raw('SUM(paid) as total_paid'))
                    ->where('transaction_type','Staff Salary')
                    ->where('payment_type_id',1)
                    ->groupBy('paid_user_id')
                    ->get();
            }
        }

        $date_from = '';
        $date_to = '';

        if($request->date_from)
        {
            $date_from = $request->date_from;
        }
        if($request->date_to)
        {
            $date_to = $request->date_to;
        }

        return view('backend.admin.reports.staff_balance_sheet_form', compact('staff_cash_data_results', 'staff_previous_total_paid','date_from','date_to'));
    }

    public function report_staff_balance_sheet_print($date_from,$date_to)
    {
        $staff_previous_total_paid=0;

        $staff_cash_pre_valance_data = DB::table('payments')
            //->select('account_no', DB::raw('SUM(debit) as debit, SUM(credit) as credit'))
            ->select('paid_user_id', DB::raw('SUM(paid) as total_paid'))
            ->where('date', '<',$date_from)
            ->where('payment_type_id',1)
            ->where('transaction_type','Staff Salary')
            ->groupBy('paid_user_id')
            ->first();

        if(!empty($staff_cash_pre_valance_data))
        {
            $staff_previous_total_paid = $staff_cash_pre_valance_data->total_paid;
        }

        if( (!empty($date_from)) && (!empty($date_to)) )
        {
            $staff_cash_data_results = DB::table('payments')
                ->select('paid_user_id', DB::raw('SUM(paid) as total_paid'))
                ->where('transaction_type','Staff Salary')
                ->where('payment_type_id',1)
                ->whereBetween('date', [$date_from, $date_to])
                ->groupBy('paid_user_id')
                ->get();
        }else{
            $staff_cash_data_results = DB::table('payments')
                ->select('paid_user_id', DB::raw('SUM(paid) as total_paid'))
                ->where('transaction_type','Staff Salary')
                ->where('payment_type_id',1)
                ->groupBy('paid_user_id')
                ->get();
        }

        return view('backend.admin.reports.staff_balance_sheet_print', compact('staff_cash_data_results', 'staff_previous_total_paid','date_from','date_to'));
    }
}
