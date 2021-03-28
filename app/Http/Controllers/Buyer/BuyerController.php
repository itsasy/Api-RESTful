<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\ApiController;
use App\Models\Buyer;

class BuyerController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $buyers = Buyer::has('transactions')->get();

        return $this->showAll($buyers, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param Buyer $buyer
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Buyer $buyer)
    {
        return $this->showOne($buyer, 200);
    }

}
