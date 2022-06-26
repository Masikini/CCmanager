<?php

namespace App\Http\Controllers;

use App\Campaign;
use App\Ticket;

use App\ItConsult;
use App\ItTrain;
use App\CompCare;
use App\ManagedIt;
use App\Client;
use App\Sequence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class TicketController extends Controller
{

    public function index()
    {


        // $tickets = Ticket::select('tickets.*')->join('it_consult', 'it_consult.tick_id', '=', 'tickets.id_no')->join('it_train', 'it_train.tick_id', '=', 'tickets.id_no')->get();
        $tickets = Ticket::select('tickets.*')->get();
        return $tickets;

        //    return Ticket::get();

    }


    public function store(Request $request)
    {

        
        
        $newTicket = new Ticket;


        // // return $highest_id;
        // $sequence_id = Sequence::select('sequences.id')->max('id') + 1;

        // $ticket_no = "CC" . str_pad($sequence_id, 6, "0", STR_PAD_LEFT);

        $sequence_id =  str_replace('-', '', Carbon::now()->format('Y-m-d-m-s'));
        $ticket_no = "CCt" . $sequence_id;

        $newTicket->id_no = $ticket_no;
        $newTicket->service = str_replace('"', '', json_encode($request->ticket['main_service']));
        $newTicket->list =  str_replace(str_split('"[]'), '', json_encode($request->ticket['list']));
        $newTicket->client_id = $request->ticket["client_name"];
        $newTicket->description =  $request->ticket["description"];
        $newTicket->cost =  $request->ticket["totalCost"];
        $newTicket->issuer = $request->ticket["issuer"];
        $newTicket->campaign_title = $request->ticket["campaign_title"];
        $newTicket->costs_metadata = json_encode($request->ticket["costs_metadata"]);

        $newTicket->save();
        // if ($newTicket->campaign_title){
        //  $campaign = Campaign::where('campaing')
        // }
        return  $ticket_no;
    }

    public function close_ticket($id)
    {
        $existingticket = Ticket::find($id);
        if ($existingticket) {
            $existingticket->status = "closed";
            $existingticket->save();
            return true;
            // $existingprocedure = Procedures::where('tick_id', '=', $request->procedure_id)->get();
            // return $existingprocedure; 
        }

        return false;
    }
    public function handle_ticket(Request $request)
    {
        $existingticket = Ticket::find($request->ticket['id']);
        if ($existingticket) {
            $existingticket->handler = $request->ticket['handler'];
            $existingticket->save();
            return $existingticket;
            // $existingprocedure = Procedures::where('tick_id', '=', $request->procedure_id)->get();
            // return $existingprocedure; 
        }

        return false;
    }


    public function get_ticket($id)
    {
        return Ticket::where("id_no", $id)->firstorFail();
    }

    public function get_managedIt_tickets()
    {
        $tickets = DB::table('tickets')->join('managed_it', 'managed_it.tick_id', '=', 'tickets.id_no')->select('tickets.*')->get();
        return $tickets;
    }

    public function get_itTraining_tickets()
    {
        $tickets = DB::table('tickets')->join('it_train', 'it_train.tick_id', '=', 'tickets.id_no')->select('tickets.*', 'it_train.course', 'it_train.start')->get();
        return $tickets;
    }

    public function get_computercare_tickets()
    {
        $tickets = DB::table('tickets')->join('comp_care', 'comp_care.tick_id', '=', 'tickets.id_no')->select('tickets.*', 'comp_care.*')->get();
        return $tickets;
    }

    public function check_ticket(Request $request)
    {
        $ticketData =  json_decode($request->ticketPayload);
        $id = $ticketData->ticket_id;
        $amount_paid = $ticketData->amount_paid;

        $existingticket = Ticket::find($id);
        if ($existingticket && $amount_paid > 0) {


            $existingticket->paid = $existingticket->paid + $amount_paid;
            if ($existingticket->paid >= $existingticket->cost) {
                $existingticket->status = "closed";
            } else {
                $existingticket->status = "chckd";
            }

            $existingticket->save();
            // return true;
            // $existingprocedure = Procedures::where('tick_id', '=', $request->procedure_id)->get();
            return $existingticket;
        }

        return false;
    }
}
