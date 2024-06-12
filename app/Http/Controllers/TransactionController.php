<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Http;
use App\Http\Resources\TransactionResource;
use App\Http\Requests\StoreTransactionRequest;
use App\Http\Requests\UpdateTransactionRequest;
use App\Services\TransactionService;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('transaction.list');
        return TransactionResource::collection(Transaction::paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTransactionRequest $request, TransactionService $transactionService)
    {
        Gate::authorize('transaction.send');
        $payer = User::findOrFail($request->payer);
        $payee = User::findOrFail($request->payee);
        try{
            $transactionService->createTransaction(['payer' => $payer, 'payee' => $payee, 'value' => $request->value]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Transaction failed.', 'error' => $e->getMessage()]);
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        Gate::authorize('transaction.list');
        return new TransactionResource($transaction);
    }

}
