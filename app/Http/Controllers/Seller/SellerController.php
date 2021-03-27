<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Seller;
use App\Traits\ApiResponder;

class SellerController extends Controller
{
    use ApiResponder;

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
        $seller = Seller::has('products')->findOrFail($seller['id']);

        return $this->showOne($seller, 200);
    }

}
