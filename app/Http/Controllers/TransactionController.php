<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransactionRequest;
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
            $transactions = Transaction::paginate(10);
        } else {
            $transactions = Transaction::where('payer', auth()->id())->paginate(10);
        }

        return view('transactions.index', compact('transactions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = User::whereHas('roles', function ($query) {
            $query->where('name', 'customer');
        })->get();

        return view('transactions.create', compact('customers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TransactionRequest $request)
    {
        $transactionData = $request->validated();
        $transactionData['is_vat_inclusive'] = $request->has('is_vat_inclusive');
        $transactionData['status'] = $this->calculateTransactionStatus($transactionData['due_on']);

        Transaction::create($transactionData);
        return redirect()->route('transactions.index')->with('success', 'Transaction added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        if(auth()->user()->hasRole('Customer') && auth()->id() != $transaction->payer){
            abort(401);
        }

        $transaction = $transaction->load('payments');
        return view('transactions.show', compact('transaction'));
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
