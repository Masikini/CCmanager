<?php

namespace App\Http\Controllers;

use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use App\Ticket;

class StatController extends Controller
{

    public function  ticketsData(Request $request)
    {
        $firstMonthName = Carbon::now()->subMonths(2)->monthName;
        $firstMonthFrom = Carbon::now()->subMonths(2)->startOfMonth();
        $firstMonthTo = Carbon::now()->subMonths(2)->endOfMonth();
        $firstMonthAllTickets = Ticket::whereBetween('created_at', [$firstMonthFrom, $firstMonthTo])->count();
        $firstMonthOpenedTickets = Ticket::whereBetween('created_at', [$firstMonthFrom, $firstMonthTo])->where('status', "open")->count();
        $firstMonthClosedTickets = Ticket::whereBetween('created_at', [$firstMonthFrom, $firstMonthTo])->where('status', "closed")->count();
        $firstMonthCheckedTickets = Ticket::whereBetween('created_at', [$firstMonthFrom, $firstMonthTo])->where('status', "chckd")->count();

        $secondMonthName = Carbon::now()->subMonths(1)->monthName;
        $secondMonthFrom = Carbon::now()->subMonths(1)->startOfMonth();
        $secondMonthTo = Carbon::now()->subMonths(1)->endOfMonth();
        $secondMonthAllTickets = Ticket::whereBetween('created_at', [$secondMonthFrom, $secondMonthTo])->count();
        $secondMonthOpenedTickets = Ticket::whereBetween('created_at', [$secondMonthFrom, $secondMonthTo])->where('status', "open")->count();
        $secondMonthClosedTickets = Ticket::whereBetween('created_at', [$secondMonthFrom, $secondMonthTo])->where('status', "closed")->count();
        $secondMonthCheckedTickets = Ticket::whereBetween('created_at', [$secondMonthFrom, $secondMonthTo])->where('status', "chckd")->count();

        $currentMonthName = Carbon::now()->monthName;
        $currentMonthFrom = Carbon::now()->startOfMonth();
        $currentMonthTo = Carbon::now()->endOfMonth();
        $currentMonthAllTickets = Ticket::whereBetween('created_at', [$currentMonthFrom, $currentMonthTo])->count();
        $currentMonthOpenedTickets = Ticket::whereBetween('created_at', [$currentMonthFrom, $currentMonthTo])->where('status', "open")->count();
        $currentMonthClosedTickets = Ticket::whereBetween('created_at', [$currentMonthFrom, $currentMonthTo])->where('status', "closed")->count();
        $currentMonthCheckedTickets = Ticket::whereBetween('created_at', [$currentMonthFrom, $currentMonthTo])->where('status', "chckd")->count();







        // $allTicket = Ticket::all()->count();
        // $openedTicket = Ticket::where('status', "open")->count();
        // $closedTicket = Ticket::where('status', "closed")->count();
        // $checkedTicket = Ticket::where('status', "chckd")->count();



        $data = array([
            ["product", "Total", "Opened", "Checked", "Closed"],
            [$firstMonthName, $firstMonthAllTickets, $firstMonthOpenedTickets, $firstMonthCheckedTickets, $firstMonthClosedTickets],
            [$secondMonthName, $secondMonthAllTickets, $secondMonthOpenedTickets, $secondMonthCheckedTickets, $secondMonthClosedTickets],
            [$currentMonthName, $currentMonthAllTickets, $currentMonthOpenedTickets, $currentMonthCheckedTickets, $currentMonthClosedTickets],

        ]);


        $send = json_encode($data);

        return $send;
    }

    public function ticketsDataPieChart(Request $request)
    {
        $allTickets = Ticket::all()->count();
        $itTraining = Ticket::where('service', "IT Training")->count();
        $compCare = Ticket::where('service', "Computer Care")->count();
        $consultancy = Ticket::where('service', "Consultancy")->count();
        $managedIT = Ticket::where('service', "Computer Care")->count();

        $keyword = "value";
        $nameword = "name";
        $data = array([]);
    }

    public function testFunc()
    {

        // $from = Carbon::now()->subMonths(2)->monthName;
        // $to = Carbon::now()->endOfMonth();
        $toTo = Carbon::now()->endOfWeek();

        return $toTo;
    }
}
