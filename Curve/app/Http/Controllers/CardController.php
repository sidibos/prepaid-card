<?php

namespace App\Http\Controllers;

use App\Models\CardModel;
use App\Models\Money;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class CardController extends Controller
{
    public function add(Request $request) {

        $id = DB::table('cards')->insertGetId(
            [
                'name'=>$request->input('name'),
                'user_id'=>$request->input('user_id'),
                'currency'=> $request->input('currency')
            ]
        );

        return response()->json(['Card_id'=>$id]);
    }

    public function topUp(Request $request, $cardId) {
        $topUp = $request->input('top_up');
        $balance = DB::table('balance')->where('card_id', $cardId)->latest()->first();
        $amount = $topUp;
        if($balance) {
            $amount += $balance->amount;
        }
        $id = DB::table('balance')->insertGetId(
            [
                'card_id'=>$cardId,
                'amount'=> $amount,
                'top_up'=> $topUp,
                'created_at'=> date('Y-m-d H:i:s'),
            ]
        );
        return response()->json(['success'=>true, 'message'=>'Your card has been topped up by '.$topUp .' GBP']);
    }

    public function all(Request $request) {
        $card = DB::table('balance')->get();
        return response()->json(['success'=>true, 'list'=>$card->all()]);
    }

    public function availableBalance(Request $request, $cardId) {
        $balance = DB::table('balance')->where('card_id', $cardId)->latest()->first();
        $balanceMoney = new Money($balance->amount);
        $blockedAmountMoney = new Money($balance->blocked_amount);
        $cardModel = new CardModel($balanceMoney, $blockedAmountMoney);
        $availableBalance = $cardModel->getAvailableBalance();
        $money = new Money($availableBalance);
        return response()->json(['success'=>true, 'message'=>'Available to spend '.$money->getAmount() .' GBP']);
    }

    public function getActivity(Request $request, $cardId) {
        $balance = DB::table('balance')->where('card_id', $cardId)->get();
        return response()->json(['success'=>true, 'activities'=>$balance->all()]);
    }


    public function requestPayment(Request $request, $cardId) {
        $amount = $request->input('amount');
        $merchantId = $request->input('merchant_id');
        $balance = DB::table('balance')->where('card_id', $cardId)->latest()->first();
        $balanceMoney = new Money($balance->amount);
        $blockedAmountMoney = new Money($balance->blocked_amount);
        $cardModel = new CardModel($balanceMoney, $blockedAmountMoney);

        if (!$cardModel->hasSufficientFund(new Money($amount))) {
            $message = "You have insufficient fund for this transction";
            return response()->json(['status'=>false, 'message'=>$message]);
        }
        $blockedAmountMoney->add(new Money($amount));
        // Block the amount in user account
        $id = DB::table('balance')->insertGetId(
            [
                'card_id'=>$cardId,
                'amount'=> $balance->amount,
                'blocked_amount'=> $blockedAmountMoney->getAmount(),
                'blocked_by'=> $merchantId,
                'created_at'=> date('Y-m-d H:i:s'),
            ]
        );

        $transId = 0;

        if($id) {
            // Insert a transaction
            $transId = DB::table('transactions')->insertGetId(
                [
                    'card_id'=>$cardId,
                    'merchant_id'=> $merchantId,
                    'amount'=> $amount,
                    'reference'=> $request->input('reference'),
                    'status'=>'completed',
                    'created_at'=> date('Y-m-d H:i:s'),
                ]
            );
        }
        $success = $id > 0 && $transId > 0;
        return response()->json(['success'=>$success, 'message'=>'tranasction complete Id '.$transId]);
    }
}