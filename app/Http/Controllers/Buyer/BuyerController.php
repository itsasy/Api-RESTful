<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Buyer;

class BuyerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $buyers = Buyer::has('transactions')->get();

        return response()->json(['data' => $buyers], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param Buyer $buyer
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Buyer $buyer)
    {
        $buyer->has('transactions')
            ->findOrFail($buyer->id);

        return response()->json(['data' => $buyer], 200);
    }

}
