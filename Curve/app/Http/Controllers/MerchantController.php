<?php

namespace App\Http\Controllers;

use App\Models\Money;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class MerchantController extends Controller
{
    public function add(Request $request) {
        $id = DB::table('merchants')->insertGetId(
            [
                'name'=>$request->input('name')
            ]
        );
        $success = ($id > 0);
        return response()->json(['success'=> $success, 'merchant_id'=>$id]);
    }

    public function capture(Request $request, $transId) {
        $transactionCol = DB::table('transactions')->where('id',$transId)->get();
        $transaction = $transactionCol->first();
        if(!$transaction) {
            return response()->json(['success'=> false, 'message'=>'There is no transaction with this id']);
        }

        if($transaction->status === 'paid') {
            return response()->json(['success'=> false, 'message'=>'This transaction is already paid']);
        }

        $cardBalance = DB::table('balance')->where('card_id', $transaction->card_id)->latest()->first();

        if($request->input('amount') > $transaction) {
            return response()->json(['success'=> false, 'message'=>'Amount requested is more than the authorized amount' ]);
        }
        $balMoney = new Money($cardBalance->amount);
        $transMoney = new Money($request->input('amount'));
        $balMoney->deduct($transMoney);

        $blockedMoney = new Money($cardBalance->blocked_amount);
        $blockedMoney->deduct($transMoney);
        $id = DB::table('balance')->insertGetId([
            'card_id'=>$cardBalance->card_id,
            'amount'=>$balMoney->getAmount(),
            'blocked_amount'=> $blockedMoney->getAmount(),
            'created_at'=> date('Y-m-d H:i:s')
        ]);
        if($id) {
            // Update transaction status
            DB::table('transactions')
                ->where('id', $transId)
                ->update(['status' => 'paid', 'updated_at'=>date('Y-m-d H:i:s')]);
        }
        return response()->json(['success'=> true, 'message'=>'Transaction paid']);
    }

    public function refund(Request $request, $transId){
        $transactionCol = DB::table('transactions')->where('id',$transId)->get();
        $transaction = $transactionCol->first();

        if(!$transaction) {
            return response()->json(['success'=> false, 'message'=>'Wrong transaction']);
        }
        if($transaction->status === 'refund') {
            return response()->json(['success'=> false, 'message'=>'Transaction has been already refunded']);
        }
        if($transaction->status !== 'paid') {
            return response()->json(['success'=> false, 'message'=>'Transaction has not been paid yet']);
        }
        $refundAmount = $request->input('amount');
        $cardBalance = DB::table('balance')->where('card_id', $transaction->card_id)->latest()->first();
        $balMoney = new Money($cardBalance->amount);
        $refundMoney = new Money($refundAmount);
        $balMoney->add($refundMoney);
        $id = DB::table('balance')->insertGetId([
            'card_id'=>$cardBalance->card_id,
            'refund'=>$refundMoney->getAmount(),
            'amount'=>$balMoney->getAmount(),
            'blocked_amount'=> $cardBalance->blocked_amount,
            'refunded_by'=>$transaction->merchant_id,
            'created_at'=> date('Y-m-d H:i:s')
        ]);

        if($id) {
            //Update the transaction for it
            DB::table('transactions')
                ->where('id', $transId)
                ->update(['status' => 'refund', 'updated_at'=>date('Y-m-d H:i:s')]);
        }
        $success = $id > 0;
        return response()->json(['success'=> $success, 'message'=>'Request processed']);
    }

    public function getTransactions(Request $request, $merchantId) {
        $transactions = DB::table('transactions')->where('merchant_id', $merchantId)->get();
        return response()->json(['success'=>true, 'transactions'=>$transactions->all()]);
    }
}
