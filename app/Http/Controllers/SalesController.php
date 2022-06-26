<?php

namespace App\Http\Controllers;

use App\Sales;
use App\Notes;
use App\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Storage;
use SebastianBergmann\Environment\Console;

class SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sales = Sales::select('sales.*')->get();
        return $sales;
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
        $newSale = new Sales;



        //create sale

        $newSale->payment_method = $request->tick_payment_method;
        $newSale->ref = $request->tick_ref;
        $newSale->description =  $request->tick_description;
        $newSale->tick_id = $request->tick_tick_id;
        $newSale->amount = $request->tick_amount;
        $file = $request->receipt_attach;
        //get file attachement
        if ($file) {


            $filename = $request->tick_tick_id . '.' . $file->getClientOriginalExtension();
            $file->move('assets', $filename);

            $newSale->attach = $filename;
            $newSale->save();

            //create new note on payment
            $newNote = new Notes;

            // $sequence_id =  str_replace('-', '', Carbon::now()->format('Y-m-d-m-s'));
            // $note_no = "CCn" . $sequence_id;

            // $newNote->note_id = $note_no;
            $newNote->ticket_id =  $request->tick_tick_id;
            $newNote->note_body = "Paid :MWK$request->tick_amount";
            $newNote->note_type = "trans";
            $newNote->note_author = "Transaction";

            $newNote->save();

            //check the ticket on the ticket controller
            $existingTicket =  Ticket::where('id_no', $request->tick_tick_id)->first();

            // return $existingTicket;
            if ($existingTicket) {

                $existingTicket->paid = $existingTicket->paid + $request->tick_amount;
                if ($existingTicket->paid >= $existingTicket->cost) {
                    $existingTicket->status = "closed";
                } else {
                    $existingTicket->status = "chckd";
                }

                $existingTicket->save();
                // return true;
                // $existingprocedure = Procedures::where('tick_id', '=', $request->procedure_id)->get();
                return $existingTicket;
            }

            // return true;
        } else {
            response()->json(['data' => [], 'error' => 1,  'error_msg' => 'file is required', 'message' => 'File is required for upload']);
        }

        return false;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Sales  $sales
     * @return \Illuminate\Http\Response
     */
    public function find($id)
    {
        // $saleExists = Sales::find($id)->exists();
        $saleExists = DB::table('sales')->where('tick_id', $id)->exists();

        return $saleExists;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Sales  $sales
     * @return \Illuminate\Http\Response
     */
    public function edit(Sales $sales)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Sales  $sales
     * @return \Illuminate\Http\Response
     */
    // public function download($file)
    // {
    //     $source=public_path('assets/'.$file);
    //     return response()->file($source);
    //     // return response()->download($source);
    //     // return $file;
    // }

    public function download($file)
    {
        $myFile = public_path('assets/' . $file);
        // $headers = ['Content-Type: application/pdf'];
        $newName = 'nicesnippets-pdf-file-' . time() . '.pdf';

        // return response()->download($myFile, $newName, $headers);
        return response()->download($myFile, $newName);
    }

    public function view($file)
    {
        if ($file) {
            // return public_path('assets/'.$file);
            $filepath = public_path('assets/' . $file);
            // $headers = ['Content-Type: application/pdf'];
            // return response()->file($filepath, $headers);
            // return response()->download($filepath, 'example.pdf', [], 'inline');
            if ($filepath) {
                //    return response()->file("$filepath");
                return $filepath;
            }
        }

        return false;

        // return $file;
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Sales  $sales
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sales $sales)
    {
        //
    }
}
