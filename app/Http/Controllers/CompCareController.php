<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CompCare;
use App\Sequence;

class CompCareController extends Controller
{
    public function index()
    {
        return CompCare::get();
    }


    public function store(Request $request){

        $newCompcare = new CompCare;
        // $newSequence = new Sequence;
        // $sequence_id = Sequence::select('sequences.id')->max('id') + 1;
        // $ticket_no = "CC" . str_pad($sequence_id, 6, "0", STR_PAD_LEFT);

        $newCompcare->service =  json_encode( $request->ticket["service"]);
        $newCompcare->incidents = json_encode( $request->ticket["incidents"]);
        $newCompcare->item_brand = $request->ticket["item_brand"];
        $newCompcare->item_model = $request->ticket["item_model"];
        $newCompcare->item_sn = $request->ticket["item_sn"];
        // $newSequence->save();
        $newCompcare->tick_id = $request->ticket['SN'];
        $newCompcare->save();
        return $newCompcare;


    }
}
