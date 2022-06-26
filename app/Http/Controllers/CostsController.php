<?php

namespace App\Http\Controllers;

use App\Costs;
use Illuminate\Http\Request;

class CostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $costs = Costs::all();
        return $costs;
    }

    public function categoryCosts($id)
    {
        $costs = Costs::where('category', $id)->get();
        return $costs;
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
        $newCost = new Costs;

        $newCost->id_no = $request->cost['id_no'];
        $newCost->name = $request->cost['name'];
        $newCost->category = $request->cost['category'];
        $newCost->description = $request->cost['description'];
        $newCost->fee = $request->cost['fee'];
        $newCost->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Costs  $costs
     * @return \Illuminate\Http\Response
     */
    public function show(Costs $costs)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Costs  $costs
     * @return \Illuminate\Http\Response
     */
    public function edit(Costs $costs)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Costs  $costs
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $editCost = new Costs;
        $costData = json_decode($request->cost);
        $editCost = Costs::firstWhere('id_no', $costData->id_no);

        if ($editCost) {

            $editCost->id_no =  $costData->id_no;
            $editCost->name =  $costData->name;
            $editCost->description = $costData->description;
            $editCost->fee = $costData->fee;

            $editCost->save();
            return 'True';
        } else {
            return 'False';
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Costs  $costs
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleteCost = Costs::firstWhere('id_no', $id);
        $deleteCost->delete();
    }
}
