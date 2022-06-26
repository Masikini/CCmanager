<?php

namespace App\Http\Controllers;

use App\Ticket;
use Illuminate\Http\Request;
use LaravelDaily\Invoices\Invoice;
use LaravelDaily\Invoices\Classes\Buyer;
use LaravelDaily\Invoices\Classes\InvoiceItem;

class InvoicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function offer(Request $request)
    {

        $data =  json_decode($request->invoiceData);

        // $listItems = [
        //     (new InvoiceItem())->title($data->courses[0]->name)->pricePerUnit($data->courses[0]->fee),

        // ];
        $listItems = array();

        // $data =  json_decode($data);
        // print("Brace for an awesome ting");
        // print($data);
        // echo "Hello from the other side";

        // var_dump($data->ticket->client_name);

        // var_dump($data->courses[0]->id_no);

        // foreach ($data->courses as $key => $value) {
        //     $newItem = (new InvoiceItem())->title($data->courses[$key]->name)->pricePerUnit($data->courses[$key]->fee);
        //     array_push($listItems, $newItem);
        // }

        foreach ($data->costs as $key => $value) {
            $newItem = (new InvoiceItem())->title($data->costs[$key]->name)->pricePerUnit($data->costs[$key]->fee);
            array_push($listItems, $newItem);
        }


        $client_name =  explode(',', $data->ticket->client_name, 2)[0]; //get the name of the client
        $client_phone =  explode(',', $data->ticket->client_name, 2)[1];
        $fname =  explode(' ', $client_name, 2)[0];

        $customer = new Buyer([
            'name'          => $client_name,
            'phone' => $client_phone,
            'address' => 'Lilongwe',
            'custom_fields' => [
                'email' => 'sammasikini1@gmail.com',
            ],
        ]);

        $item = $listItems;
        $name = $client_name;

        $invoice = Invoice::make($name = $name , $fname=$fname)
            ->buyer($customer)
            ->series($data->serialNumber)
            ->addItems($item)
            ->currencyThousandsSeparator(',')
            ->logo(public_path('vendor/invoices/logo.png'));

        return $invoice->download();
    }


    public function balance(Request $request)
    {

        $data =  json_decode($request->invoiceData);

        $listItems = array();

        $costsArray = json_decode($data->costs);
        $amountPaid = $data->paid;


        foreach ( $costsArray as $key => $value) {
            $newItem = (new InvoiceItem())->title($costsArray[$key]->name)->pricePerUnit($costsArray[$key]->fee);
            array_push($listItems, $newItem);
        }

        $client_name =  explode(',', $data->client, 2)[0]; //get the name of the client
        $client_phone =  explode(',', $data->client, 2)[1];
        $fname =  explode(' ', $client_name, 2)[0];

        // var_dump($client_name, $client_phone);

        $customer = new Buyer([
            'name'          => $client_name,
            'phone' => $client_phone,
            'address' => 'Lilongwe',
            'custom_fields' => [
                'email' => 'sammasikini1@gmail.com',
            ],
        ]);

        $item = $listItems;
        $name = $client_name;

        $invoice = Invoice::make($name = $name, $fname= $fname)->template('invoice')
            ->buyer($customer)
            ->series($data->serial_number)
            ->addItems($item)
            ->totalDiscount($amountPaid)
            ->currencyThousandsSeparator(',')
            ->logo(public_path('vendor/invoices/logo.png'));

        return $invoice->download();

        // return json_encode($listItems);
    }
}
