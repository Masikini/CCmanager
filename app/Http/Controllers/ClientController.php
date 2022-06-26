<?php

namespace App\Http\Controllers;

use App\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function store(Request $request)
    {
        $newClient = new Client;
        $newClient->name =  $request->client["name"];
        $newClient->id_type =  $request->client["id_type"];
        $newClient->id_no =  $request->client["id_no"];
        $newClient->email =  $request->client["email"];
        $newClient->phone =  $request->client["phone"];
        $newClient->residence =  $request->client["residence"];
        $newClient->institution =  $request->client["institution"];
        $newClient->age =  $request->client["age"];
        $newClient->gender =  $request->client["gender"];
        $newClient->save();
        return $newClient;

    }

    public function getClients(Request $request){
        return Client::get();

    }
}
