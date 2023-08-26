<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\LotteryTicketTransaction;
use Nunahsan\ApiDocs\Docs;

class LotteryTicketTransactionController extends Controller
{
    protected $error_mapping = array(
		'0'	  =>"Success",
		// ibstf error code
		'1000'=>"Bad parameters",
		'1500' =>"Internal error",
	);

    public function GetTransactionList(Request $request){
        $ApiDocs=[
			"name"=>"Get Transaction List",
			"url"=>"/get-transaction-list",
			"method"=>"post",
			"description"=>"for user to get game report",
			"validation"=>[
				"header"=>[],
				"body"=>[
					// "period"=>"required",
					// "m_id"=>"required",
					// "a_id"=>"required",
					// "currency"=>"required",
					// "mu_membercode"=>"nullable",
					// "game_code"=>"nullable",
					// "page"=>"nullable|integer|min:1"
				]
			],
			"response"=>'{"status": true,"code": 0,"data":{
				"items":[
					{
                        "trx_id" : "XDA1032SSA",
						"game_id": "103",
                        "amount" : 3.00,
                        "draw_date" : "2023-02-01 00:00:00",
                        "ticket_date" : "2023-01-19 00:00:00"
					}
				}
			}'
		];
        try {
			// validate input 
        	// $validator = Validator::make($request->all(), Docs::cleanUpRule($ApiDocs));
            
            // $lottery_list = LotteryTicketTransaction::getTransactionList($request->all());
            
			$game = Gamelist::getGameList();

			$response = [
				'status'=>true,
				'code'=>0,
				'logo_img'=>'https://dsgmoon.net/Thumbnail/Potrait/en-us/RichGaming.png',
				'game_list'=>$game
			];

			return response()->json($response);

        }catch(\Exception $e){
			$error_code = ($e->getCode() == 0 || !isset($this->error_mapping[$e->getCode()])) ? 1500 : $e->getCode();
			$result = [
				'status'=>false,
				'code'=> $error_code,
				'error_msg'=>$this->error_mapping[$error_code]??'Invalid Request',
				'error_desp'=>$e->getMessage(),
				'ticket_id'=> isset($lsm_response['lsm_id']) ? 'lsm-'.$lsm_response['lsm_id'] : ''
			];

			return response()->json(
				$result
			);
        }
    }

    public function CreateLotteryTicket(Request $request){
        $ApiDocs=[
			"name"=>"Get Transaction List",
			"url"=>"/get-transaction-list",
			"method"=>"post",
			"description"=>"for user to get game report",
			"validation"=>[
				"header"=>[],
				"body"=>[
                    'game_id' => 'required',
                    'amount' => 'required|numeric|between:0,9999999999',
                    'draw_date' => 'required|date_format:Y-m-d|after:today',
				]
			],
			"response"=>'{"status": true,"code": 0,"message": "Ticket Has Generate with Transaction ID : XXXXXX"}'
		];

        try {
			// validate input 
        	$validator = Validator::make($request->all(), Docs::cleanUpRule($ApiDocs));
            if ($validator->fails()) {
				throw new \Exception($validator->errors()->first(),1000);
	        }

			$transaction_id = LotteryTicketTransaction::createLotteryTransaction($request->all(),$request->user()->id);

			$response = [
				'status'=>true,
				'code'=>0,
				'message' => "Ticket has Generated with transaction ID : ".$transaction_id
			];

			return response()->json($response);

        }catch(\Exception $e){
			$error_code = ($e->getCode() == 0 || !isset($this->error_mapping[$e->getCode()])) ? 1500 : $e->getCode();
			$result = [
				'status'=>false,
				'code'=> $error_code,
				'error_msg'=>$this->error_mapping[$error_code]??'Invalid Request',
				'error_desp'=>$e->getMessage(),
			];

			return response()->json(
				$result
			);
        }
    }
}
