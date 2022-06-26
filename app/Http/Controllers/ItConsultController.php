<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ItConsult;
use App\Ticket;
use App\Sequence;

class ItConsultController extends Controller
{
    public function store(Request $request)
    {

    

        $newItconsult = new ItConsult;
        $newSequence = new Sequence;
        
        $newItconsult->service =  json_encode($request->ticket["service"]);

        $sequence_id = Sequence::select('sequences.id')->max('id') + 1;

        $ticket_no = "CC" . str_pad($sequence_id, 6, "0", STR_PAD_LEFT);
        $newSequence->save();
        $newItconsult->tick_id = $ticket_no;

        $newItconsult->save();
        return $newItconsult;
    }
}
