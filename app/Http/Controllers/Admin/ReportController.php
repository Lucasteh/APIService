<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LotteryTicketTransaction;
use Carbon\Carbon;
use PDF;

class ReportController extends Controller
{
    public function SalesGameReport(Request $request){
    
	    // $user = User::get();

	    $data = [
	            'title' => 'How To Create PDF File Using DomPDF In Laravel 9 - Techsolutionstuff',
	            'date' => date('d/m/Y'),
	            'users' => $users
	    ];

	    if($request->has('download'))
	    {
	        $pdf = PDF::loadView('index',$data);
	        return $pdf->download('users_pdf_example.pdf');
	    } 
    }

    public function DailyTransactionReport(Request $request){

        $rules = [
            'from_date'=>'required|date_format:d-m-Y',
            'to_date' =>'required|date_format:d-m-Y|after_or_equal:from_date'
        ];

        try{
            $data = $request->validate($rules);

        }catch(\Exception $e){
            dd($e);
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
