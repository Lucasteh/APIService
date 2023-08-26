<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class LotteryTicketTransaction extends Model
{
   
    static function getLotteryList($params){
        
        $select = DB::table('lottery_ticket_transaction')->where('status',1);

        if(!empty($params['user_id'])){
            $select->where('created_by',$params['user_id']);
        }
        if(!empty($params['ticket_date'])){
            $select->where('ticket_date',$params['ticket_date']);
        }
        if(!empty($params['draw_date'])){
            $select->where('draw_date',$params['draw_date']);
        }

        $data = $select->get();

        return json_decode(json_encode($data,true));
    }

    static function createLotteryTransaction(Request $request){
        
    }

}
