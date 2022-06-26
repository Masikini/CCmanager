<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ManagedIt;
// use App\Sequence;

class ManagedItController extends Controller
{
    public function store(Request $request)
    {

        $newManagedit = new ManagedIt;
        // $newSequence = new Sequence;
        $newManagedit->service =  json_encode($request->ticket["service"]);
        // $sequence_id = Sequence::select('sequences.id')->max('id') + 1;
        // $ticket_no = "CC" . str_pad($sequence_id, 6, "0", STR_PAD_LEFT);
        $newManagedit->tick_id =  $request->ticket['SN'];
        // $newSequence->save();
        $newManagedit->save();
        return $newManagedit;
    }
}
