<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Procedures;

class ProceduresController extends Controller
{
    public function store(Request $request)
    {

        $newTicket = new Procedures;
        $newTicket->summary =  json_encode($request->procedure["summary"]);
        $newTicket->change =  json_encode($request->procedure["change"]);
        $newTicket->carrier_id = $request->procedure["carrier"];
        $newTicket->tick_id = $request->procedure["tick_id"];
        $newTicket->save();
        return $newTicket;
    }


    public function delete_procedure($id)
    {
        $existingprocedure = Procedures::find($id);
        if ($existingprocedure) {
            $existingprocedure->delete();
            // $existingprocedure = Procedures::where('tick_id', '=', $request->procedure_id)->get();
            // return $existingprocedure; 
        }

        return null;
    }







    public function all_procedures(Request $request)
    {
        $existingprocedure = Procedures::get();
        return $existingprocedure;
    }

    public function get_procedures(Request $request, $id)
    {
        $existingprocedure = Procedures::where('tick_id', '=', $id)->get();
        return $existingprocedure;
    }
}
