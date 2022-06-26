<?php

namespace App\Http\Controllers;

use App\Purchases;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;

class PurchasesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Purchases::all();
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


        $newPurchase = new Purchases;

        // $newPurchase->attach = $request->
        $sequence_id =  str_replace('-', '', Carbon::now()->format('Y-m-d'));
        $purchase_no = "CCp" . $sequence_id;

        $newPurchase->item_service = $request->item_service;
        $newPurchase->payment_method = $request->payment_method;
        $newPurchase->ref = $request->ref;
        $newPurchase->description =  $request->description;
        $newPurchase->amount = $request->amount;
        $newPurchase->approved_by = $request->approved_by;
        $newPurchase->requested_by = $request->requested_by;
        $newPurchase->category = $request->category;
        $newPurchase->date = Carbon::now()->format('Y-m-d');
        $file = $request->receipt_attach;

        if ($file) {
            $filename = $request->ref . '.' . $file->getClientOriginalExtension();
            $file->move('assets', $filename);

            $newPurchase->attach = $filename;
            $newPurchase->save();
            return $newPurchase;

        } else {
           return response()->json(['data' => [], 'error' => 1,  'error_msg' => 'file is required', 'message' => 'File is required for upload']);
        }


      
        // return $purchase_no;


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Purchases  $purchases
     * @return \Illuminate\Http\Response
     */
    public function show(Purchases $purchases)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Purchases  $purchases
     * @return \Illuminate\Http\Response
     */
    public function edit(Purchases $purchases)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Purchases  $purchases
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Purchases $purchases)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Purchases  $purchases
     * @return \Illuminate\Http\Response
     */
    public function destroy(Purchases $purchases)
    {
        //
    }
}
