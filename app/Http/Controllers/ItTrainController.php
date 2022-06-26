<?php

namespace App\Http\Controllers;

use App\ItTrain;
// use App\Sequence;
use Illuminate\Http\Request;
use SebastianBergmann\Environment\Console;

class ItTrainController extends Controller
{
    public function store(Request $request)
    {

        $newIttrain = new ItTrain;
        // $newSequence = new Sequence;

        // $newIttrain->course =  $request->ticket["course"];
        $newIttrain->course = str_replace(str_split('"[]'),'',json_encode($request->ticket['list']));
        $newIttrain->start = date('Y-m-d');
        // $sequence_id = Sequence::select('sequences.id')->max('id') + 1;
        $newIttrain->schedule = str_replace(str_split('"[]'),'',json_encode($request->ticket['schedule']));
        // $ticket_no = "CC" . str_pad($sequence_id, 6, "0", STR_PAD_LEFT);

        // $newSequence->save();
        // $newIttrain->tick_id = $ticket_no;
        $newIttrain->tick_id = $request->ticket['SN'];
        $newIttrain->save();
        return $newIttrain;
    }
}
