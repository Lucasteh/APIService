<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;

class LotteryTicketTransaction extends Model
{

    protected $fillable = ['trx_id','game_id','amount','ticket_date','draw_date','status','created_by'];
   
    static function getTransactionList($params){
        
        $select = DB::table('lottery_ticket_transactions')
                        ->select('trx_id as transaction_id','game_id as game_id','amount as amount',DB::raw('date(ticket_date) as ticket_date'),DB::raw('date(draw_date) as draw_date'))
                        ->where('status',1);

        if(!empty($params['user_id'])){
            $select->where('created_by',$params['user_id']);
        }
        if(!empty($params['ticket_date'])){
            $select->where('ticket_date',$params['ticket_date']);
        }
        if(!empty($params['draw_date'])){
            $select->where('draw_date',$params['draw_date']);
        }

        if(!empty($params['from_date']) && !empty($params['to_date'])){
            $select->where('ticket_date','>=',$params['from_date'])
                    ->where('ticket_date', '<=',$params['to_date']);
        }

        $data = $select->get();

        return json_decode(json_encode($data,true));
    }

    static function createLotteryTransaction($params,$admin_user_id){

        do{
            $trx_id = Str::random(40);
            $transaction_id_exists = DB::table('lottery_ticket_transactions')->where('trx_id',$trx_id)->exists();

        }while($transaction_id_exists);

        LotteryTicketTransaction::create([
            'trx_id' => $trx_id,
            'game_id' => $params['game_id'],
            'amount' => $params['amount'],
            'ticket_date' => Carbon::now()->format('Y-m-d H:i:s'),
            'draw_date' => $params['draw_date'],
            'status' => 1,
            'created_by' => $admin_user_id
        ]);

        return $trx_id;
        
    }

}
