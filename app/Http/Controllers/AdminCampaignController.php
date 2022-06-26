<?php

namespace App\Http\Controllers;

use App\Campaign;
use App\Ticket;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AdminCampaignController extends Controller
{
    public function store(Request $request)
    {

        $newcamp = new Campaign;
        $newcamp->title = $request->campaign["title"];
        $newcamp->description = $request->campaign["description"];
        $newcamp->facilitator = $request->campaign["facilitator"];
        $newcamp->target = $request->campaign["target"];
        $newcamp->category = $request->campaign["category"];
        $newcamp->start = date('Y-m-d');
        $newcamp->end = $request->campaign["end"];

        $newcamp->save();
        return $newcamp;
    }

    public function get()
    {
        return Campaign::all();
    }
    public function getCampScore($id)
    {
        return  $campaignScore = Ticket::select("issuer")->where('campaign_title', $id)->count();
    }
    public function campaigners($id)
    {


        $campaigners = Ticket::select("issuer", DB::raw('count(*) as total'))->where('campaign_title', $id)->groupBy('issuer')->orderByDesc('total')->get();
        $campaignScore = Ticket::select("issuer")->where('campaign_title', $id)->count();
        $campaignDataCounts = array(
            "campaigners" => $campaigners,
            "score" => $campaignScore,

        );

        return json_encode($campaignDataCounts);
    }


    public function getCampaignsCategory($id)
    {
        $campaigns = Campaign::where('category', $id)->get();
        return $campaigns;
    }
    public function checkCamp($id)
    {
        $existingCamp = Campaign::find($id);

        if ($existingCamp) {

            $existingCamp->end = date('Y-m-d');
            $existingCamp->save();
            return true;
        }
        return false;
    }
}
