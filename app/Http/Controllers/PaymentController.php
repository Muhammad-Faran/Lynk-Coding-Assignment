<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentRequest;
use App\Models\Payment;
use App\Models\Transaction;

class PaymentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(PaymentRequest $request)
    {
        $paymentData = $request->validated();
        
        $transaction = Transaction::where('transaction_id',$request->transaction_id)->first();

        $transaction->payments()->create($paymentData);
        
        $transaction->paid_amount = $transaction->paid_amount + $request->amount;
        $transaction->balance = $transaction->amount - $transaction->paid_amount;
        if($transaction->amount == $transaction->paid_amount){
            $transaction->status = 'Paid';
        }
        $transaction->update();

        return response()->json(['message' => 'Payment added successfully']);
    }
}
