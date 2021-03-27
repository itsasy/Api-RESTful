<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Traits\ApiResponder;

class TransactionController extends Controller
{
    use ApiResponder;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $transactions = Transaction::all();

        return $this->showAll($transactions, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param Transaction $transaction
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Transaction $transaction)
    {
        return $this->showOne($transaction, 200);
    }

}
