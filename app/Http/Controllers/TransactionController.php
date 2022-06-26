<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Arr;

class TransactionController extends Controller
{

    public function banknamesum()
    {
        $accounts  = Account::get();
        // foreach ($accounts as $key => $account) {
        //     $account->update([
        //         'balance' => 500 + $account->toTransactions()->sum('amount') - $account->toTransactions()->sum('amount')
        //     ]);
        // }

        $accounts = Account::groupBy('bank_name')
           ->selectRaw('sum(balance) as sum, bank_name')
           ->pluck('sum','bank_name');

        echo $accounts;
    }


    public function mosttransfers()
    {
        $accounts = Account::withCount('fromTransactions')->orderByDesc('from_transactions_count')->get();
        echo $accounts;
    }


    public function mostamount()
    {
        $accounts = Account::withSum('toTransactions','amount')->orderByDesc('to_transactions_sum_amount')->get();
        echo $accounts;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        //
    }

}
