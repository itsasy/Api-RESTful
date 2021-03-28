<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\ApiController;
use App\Models\Seller;

class SellerController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $sellers = Seller::has('products')->get();

        return $this->showAll($sellers, 200);
    }


    /**
     * Display the specified resource.
     *
     * @param Seller $seller
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Seller $seller)
    {
        return $this->showOne($seller, 200);
    }

}
