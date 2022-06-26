<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\PDF;
use Illuminate\Support\Facades\App;

class InvoiceController extends Controller
{
  public function makeInvoice(){
      $pdf = App::make('dompdf.wrapper');
      $pdf->loadHTML('<h1>Test</h1>');
      return $pdf->stream();
    // return response()->file($pdf);
    // return $pdf->stream("dompdf_out.pdf", array("Attachment" => false));
    // return $pdf->stream("dompdf_out.pdf", array( 'Content-Disposition' => 'inline'));
  }
}
