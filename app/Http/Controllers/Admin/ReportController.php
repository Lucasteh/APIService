<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LotteryTicketTransaction;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use PDF;

class ReportController extends Controller
{
    public function SalesGameReport(Request $request){

        $report = LotteryTicketTransaction::getGameTransactionList();

	    $data = [
	            'title' => 'Total Sales Transaction',
	            'game_transactions' => $report
	    ];

	    if($request->has('download'))
	    {
	        $pdf = PDF::loadView('sales_report',$data);
	        return $pdf->download('total_sales_report.pdf');
	    }

        return view('welcome');
    }

    public function DailyTransactionReport(Request $request){

        $rules = [
            'from_date'=>'required|date_format:d-m-Y',
            'to_date' =>'required|date_format:d-m-Y|after_or_equal:from_date'
        ];

        $data = Validator::make($request->all(),$rules);

        if ($data->fails()) {
             return  redirect()->back()->withInput($request->input())->withErrors($data->errors());
        }


        $from_date = Carbon::createFromFormat('d-m-Y',$data['from_date'])->format('Y-m-d').' 00:00:00';
        $to_date = Carbon::createFromFormat('d-m-Y',$data['to_date'])->format('Y-m-d').' 00:00:00';

        $params = [
            'from_date' => $from_date,
            'to_date' => $to_date,
        ];

        $report = LotteryTicketTransaction::getTransactionList($params);

	    $data = [
	            'title' => 'Daily Report Transaction',
	            'transactions' => $report
	    ];

	    if($request->has('download'))
	    {
	        $pdf = PDF::loadView('daily_report',$data);
	        return $pdf->download('daily_transaction_report.pdf');
	    }

        return view('welcome');
    }
}
