<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\TransactionRequest;
use App\Http\Resources\TransactionCollection;
use App\Http\Resources\TransactionResource;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\User;
use \Carbon\Carbon;

class TransactionController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:transactions-list')->only('index');
        $this->middleware('can:add-transaction')->only('store');
        $this->middleware('can:view-transaction')->only('show');
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (auth()->user()->hasRole('Admin')) {
            $transactions = Transaction::all();
        } else {
            $transactions = Transaction::where('payer', auth()->id())->get();
        }

        return new TransactionCollection($transactions);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TransactionRequest $request)
    {
        $transactionData = $request->validated();
        $transactionData['status'] = $this->calculateTransactionStatus($transactionData['due_on']);

        $transaction = Transaction::create($transactionData);
        return new TransactionResource($transaction);
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        return new TransactionResource($transaction->load('payments'));
    }

    private function calculateTransactionStatus($dueDate)
    {
        $currentDateTime = now();
        $dueDateTime = Carbon::parse($dueDate . ' 23:59:59');

        if ($currentDateTime > $dueDateTime) {
            return 'Overdue';
        } else {
            return 'Outstanding';
        }
    }
}
