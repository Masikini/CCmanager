<?php

namespace App\Http\Controllers;

use App\Client;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use App\Purchases;
use App\Sales;
use App\Ticket;

class DataItem
{
    public $name;
    public $type = "bar";
    public $stack = "Total";
    public $data;
}

class DataItemPie
{
    public $name;
    public $value;
}

class ReportsController extends Controller
{


    public function getIncomeStatementReport()
    {

        $from = Carbon::now()->startOfMonth();
        $to = Carbon::now()->endOfMonth();

        $startofDay = Carbon::now()->startOfDay();
        $endofDay = Carbon::now()->endOfDay();
        $startofWeek = Carbon::now()->startOfWeek();
        $endofWeek = Carbon::now()->endOfWeek();



        $monthTotalRevenue = Sales::whereBetween('created_at', [$from, $to])->sum('amount');
        // $totalExpenses=Purchases::whereBetween('created_at', [$from, $to])->sum('amount');

        $todayTotalRevenue = Sales::whereBetween('created_at', [$startofDay, $endofDay])->sum('amount');
        $weekTotalRevenue = Sales::whereBetween('created_at', [$startofWeek, $endofWeek])->sum('amount');

        $prodExpenses = Purchases::where('category', 'production')->whereBetween('created_at', [$from, $to])->sum('amount');
        $operateExpenses = Purchases::where('category', 'operation')->whereBetween('created_at', [$from, $to])->sum('amount');

        // $totalExpenses = $prodExpenses + $operateExpenses;
        $totalExpenses =  Purchases::whereBetween('created_at', [$from, $to])->sum('amount');

        $grossProfit = $monthTotalRevenue - $prodExpenses;
        $netProfit = $grossProfit - $totalExpenses;


        $incomeStatementData = array(
            "totalRevenue" => $monthTotalRevenue,
            "totalExpenses" => $totalExpenses,
            "grossProfit" => $grossProfit,
            "netProfit" => $netProfit,
            "todayRevenue" => $todayTotalRevenue,
            "weekRevenue" => $weekTotalRevenue,

        );


        return json_encode($incomeStatementData);
    }

    public function getGeneralReport()
    {

        $firstMonthName = Carbon::now()->subMonths(2)->monthName;
        $firstMonthFrom = Carbon::now()->subMonths(2)->startOfMonth();
        $firstMonthTo = Carbon::now()->subMonths(2)->endOfMonth();
        $firstMonthTotalRevenue = Sales::whereBetween('created_at', [$firstMonthFrom, $firstMonthTo])->sum('amount');
        $firstMonthTotalExpenses = Purchases::whereBetween('created_at', [$firstMonthFrom, $firstMonthTo])->sum('amount');
        $firstMonthNetProfit =   $firstMonthTotalRevenue -   $firstMonthTotalExpenses;

        $secondMonthName = Carbon::now()->subMonths(1)->monthName;
        $secondMonthFrom = Carbon::now()->subMonths(1)->startOfMonth();
        $secondMonthTo = Carbon::now()->subMonths(1)->endOfMonth();
        $secondMonthTotalRevenue = Sales::whereBetween('created_at', [$secondMonthFrom, $secondMonthTo])->sum('amount');
        $secondMonthTotalExpenses = Purchases::whereBetween('created_at', [$secondMonthFrom, $secondMonthTo])->sum('amount');
        $secondMonthNetProfit =   $secondMonthTotalRevenue -   $secondMonthTotalExpenses;


        $currentMonthName = Carbon::now()->monthName;
        $currentMonthFrom = Carbon::now()->startOfMonth();
        $currentMonthTo = Carbon::now()->endOfMonth();
        $currentMonthTotalRevenue = Sales::whereBetween('created_at', [$currentMonthFrom, $currentMonthTo])->sum('amount');
        $currentMonthTotalExpenses = Purchases::whereBetween('created_at', [$currentMonthFrom, $currentMonthTo])->sum('amount');
        $currentMonthNetProfit =   $currentMonthTotalRevenue -   $currentMonthTotalExpenses;


        $data = array([
            ["product", "Revenue", "Expenses", "Net Profit"],
            [$firstMonthName, $firstMonthTotalRevenue, $firstMonthTotalExpenses, $firstMonthNetProfit],
            [$secondMonthName, $secondMonthTotalRevenue, $secondMonthTotalExpenses, $secondMonthNetProfit],
            [$currentMonthName, $currentMonthTotalRevenue, $currentMonthTotalExpenses, $currentMonthNetProfit],

        ]);


        $send = json_encode($data);

        return $send;
    }

    public function getClientDataReport()
    {
        $firstMonthName = Carbon::now()->subMonths(2)->monthName;
        $firstMonthFrom = Carbon::now()->subMonths(2)->startOfMonth();
        $firstMonthTo = Carbon::now()->subMonths(2)->endOfMonth();


        $secondMonthName = Carbon::now()->subMonths(1)->monthName;
        $secondMonthFrom = Carbon::now()->subMonths(1)->startOfMonth();
        $secondMonthTo = Carbon::now()->subMonths(1)->endOfMonth();


        $currentMonthName = Carbon::now()->monthName;
        $currentMonthFrom = Carbon::now()->startOfMonth();
        $currentMonthTo = Carbon::now()->endOfMonth();


        $genderFirstMonthMaleDistribution = Client::whereBetween('created_at', [$firstMonthFrom, $firstMonthTo])->where('gender', 'M')->count();
        $genderFirstMonthFemaleDistribution = Client::whereBetween('created_at', [$firstMonthFrom, $firstMonthTo])->where('gender', 'F')->count();
        $genderFirstMonthOtherDistribution = Client::whereBetween('created_at', [$firstMonthFrom, $firstMonthTo])->where('gender', 'O')->count();

        $genderSecondMonthMaleDistribution = Client::whereBetween('created_at', [$secondMonthFrom, $secondMonthTo])->where('gender', 'M')->count();
        $genderSecondMonthFemaleDistribution = Client::whereBetween('created_at', [$secondMonthFrom, $secondMonthTo])->where('gender', 'F')->count();
        $genderSecondMonthOtherDistribution = Client::whereBetween('created_at', [$secondMonthFrom, $secondMonthTo])->where('gender', 'O')->count();

        $genderCurrentMaleDistribution = Client::whereBetween('created_at', [$currentMonthFrom, $currentMonthTo])->where('gender', 'M')->count();
        $genderCurrentFemaleDistribution = Client::whereBetween('created_at', [$currentMonthFrom, $currentMonthTo])->where('gender', 'F')->count();
        $genderCurrentOtherDistribution = Client::whereBetween('created_at', [$currentMonthFrom, $currentMonthTo])->where('gender', 'O')->count();


        $ageFirstMonth7_17 = Client::whereBetween('created_at', [$firstMonthFrom, $firstMonthTo])->where('age', '7-17')->count();
        $ageFirstMonth18_29 = Client::whereBetween('created_at', [$firstMonthFrom, $firstMonthTo])->where('age', '18-29')->count();
        $ageFirstMonth30_ = Client::whereBetween('created_at', [$firstMonthFrom, $firstMonthTo])->where('age', '30+')->count();

        $ageSecondMonth7_17 = Client::whereBetween('created_at', [$secondMonthFrom, $secondMonthTo])->where('age', '7-17')->count();
        $ageSecondMonth18_29 = Client::whereBetween('created_at', [$secondMonthFrom, $secondMonthTo])->where('age', '18-29')->count();
        $ageSecondMonth30_ = Client::whereBetween('created_at', [$secondMonthFrom, $secondMonthTo])->where('age', '30+')->count();

        $ageThirdMonth7_17 = Client::whereBetween('created_at', [$currentMonthFrom, $currentMonthTo])->where('age', '7-17')->count();
        $ageThirdMonth18_29 = Client::whereBetween('created_at', [$currentMonthFrom, $currentMonthTo])->where('age', '18-29')->count();
        $ageThirdMonth30_ = Client::whereBetween('created_at', [$currentMonthFrom, $currentMonthTo])->where('age', '30+')->count();




        $genderDistributionData = array(
            [
                ["Gender", "Male", "Female", "Other"],
                [$firstMonthName, $genderFirstMonthMaleDistribution, $genderFirstMonthFemaleDistribution, $genderFirstMonthOtherDistribution],
                [$secondMonthName, $genderSecondMonthMaleDistribution, $genderSecondMonthFemaleDistribution, $genderSecondMonthOtherDistribution],
                [$currentMonthName, $genderCurrentMaleDistribution, $genderCurrentFemaleDistribution, $genderCurrentOtherDistribution],
            ],
            [
                ["Age", "7-17", "18-29", "30+"],
                [$firstMonthName, $ageFirstMonth7_17, $ageFirstMonth18_29, $ageFirstMonth30_],
                [$secondMonthName, $ageSecondMonth7_17, $ageSecondMonth18_29, $ageSecondMonth30_],
                [$currentMonthName, $ageThirdMonth7_17, $ageThirdMonth18_29, $ageThirdMonth30_],
            ]
        );

        $send = json_encode($genderDistributionData);

        return $send;
    }


    public function getExpensesDataReport()
    {

        $firstMonthName = Carbon::now()->subMonths(2)->monthName;
        $firstMonthFrom = Carbon::now()->subMonths(2)->startOfMonth();
        $firstMonthTo = Carbon::now()->subMonths(2)->endOfMonth();


        $secondMonthName = Carbon::now()->subMonths(1)->monthName;
        $secondMonthFrom = Carbon::now()->subMonths(1)->startOfMonth();
        $secondMonthTo = Carbon::now()->subMonths(1)->endOfMonth();


        $currentMonthName = Carbon::now()->monthName;
        $currentMonthFrom = Carbon::now()->startOfMonth();
        $currentMonthTo = Carbon::now()->endOfMonth();

        $firstMonthProd = Purchases::whereBetween('created_at', [$firstMonthFrom, $firstMonthTo])->where('category', 'production')->sum('amount');
        $firstMonthPayroll =  Purchases::whereBetween('created_at', [$firstMonthFrom, $firstMonthTo])->where('category', 'payroll')->sum('amount');
        $firstMonthWater =  Purchases::whereBetween('created_at', [$firstMonthFrom, $firstMonthTo])->where('category', 'util:water')->sum('amount');
        $firstMonthPower = Purchases::whereBetween('created_at', [$firstMonthFrom, $firstMonthTo])->where('category', 'util:power')->sum('amount');
        $firstMonthAirtime = Purchases::whereBetween('created_at', [$firstMonthFrom, $firstMonthTo])->where('category', 'util:airtime')->sum('amount');
        $firstMonthData = Purchases::whereBetween('created_at', [$firstMonthFrom, $firstMonthTo])->where('category', 'util:data')->sum('amount');
        $firstMonthFuel = Purchases::whereBetween('created_at', [$firstMonthFrom, $firstMonthTo])->where('category', 'util:fuel')->sum('amount');
        $firstMonthRentals = Purchases::whereBetween('created_at', [$firstMonthFrom, $firstMonthTo])->where('category', 'rentals')->sum('amount');
        $firstMonthOther = Purchases::whereBetween('created_at', [$firstMonthFrom, $firstMonthTo])->where('category', 'other')->sum('amount');

        $secondMonthProd = Purchases::whereBetween('created_at', [$secondMonthFrom, $secondMonthTo])->where('category', 'other')->sum('amount');
        $secondMonthPayroll = Purchases::whereBetween('created_at', [$secondMonthFrom, $secondMonthTo])->where('category', 'payroll')->sum('amount');
        $secondMonthWater = Purchases::whereBetween('created_at', [$secondMonthFrom, $secondMonthTo])->where('category', 'util:water')->sum('amount');
        $secondMonthPower = Purchases::whereBetween('created_at', [$secondMonthFrom, $secondMonthTo])->where('category', 'util:power')->sum('amount');
        $secondMonthAirtime = Purchases::whereBetween('created_at', [$secondMonthFrom, $secondMonthTo])->where('category', 'util:airtime')->sum('amount');
        $secondMonthData = Purchases::whereBetween('created_at', [$secondMonthFrom, $secondMonthTo])->where('category', 'util:data')->sum('amount');
        $secondMonthFuel = Purchases::whereBetween('created_at', [$secondMonthFrom, $secondMonthTo])->where('category', 'util:fuel')->sum('amount');
        $secondMonthRentals = Purchases::whereBetween('created_at', [$secondMonthFrom, $secondMonthTo])->where('category', 'rentals')->sum('amount');
        $secondMonthOther = Purchases::whereBetween('created_at', [$secondMonthFrom, $secondMonthTo])->where('category', 'other')->sum('amount');

        $currentMonthProd = Purchases::whereBetween('created_at', [$currentMonthFrom, $currentMonthTo])->where('category', 'production')->sum('amount');
        $currentMonthPayroll = Purchases::whereBetween('created_at', [$currentMonthFrom, $currentMonthTo])->where('category', 'payroll')->sum('amount');
        $currentMonthWater = Purchases::whereBetween('created_at', [$currentMonthFrom, $currentMonthTo])->where('category', 'util:water')->sum('amount');
        $currentMonthPower = Purchases::whereBetween('created_at', [$currentMonthFrom, $currentMonthTo])->where('category', 'util:power')->sum('amount');
        $currentMonthAirtime =  Purchases::whereBetween('created_at', [$currentMonthFrom, $currentMonthTo])->where('category', 'util:airtime')->sum('amount');
        $currentMonthData = Purchases::whereBetween('created_at', [$currentMonthFrom, $currentMonthTo])->where('category', 'util:data')->sum('amount');
        $currentMonthFuel = Purchases::whereBetween('created_at', [$currentMonthFrom, $currentMonthTo])->where('category', 'util:fuel')->sum('amount');
        $currentMonthRentals = Purchases::whereBetween('created_at', [$currentMonthFrom, $currentMonthTo])->where('category', 'rentals')->sum('amount');
        $currentMonthOther = Purchases::whereBetween('created_at', [$currentMonthFrom, $currentMonthTo])->where('category', 'other')->sum('amount');



        $expensesDistributionData = array();

        $firstMonthItem = new DataItem;
        $firstMonthItem->name = "Production";
        $firstMonthItem->data = array($firstMonthProd, $secondMonthProd, $currentMonthProd);
        array_push($expensesDistributionData, $firstMonthItem);

        $firstMonthItem = new DataItem;
        $firstMonthItem->name = "Payroll";
        $firstMonthItem->data = array($firstMonthPayroll, $secondMonthPayroll, $currentMonthPayroll);
        array_push($expensesDistributionData, $firstMonthItem);


        $firstMonthItem = new DataItem;
        $firstMonthItem->name = "Util:Water";
        $firstMonthItem->data = array($firstMonthWater, $secondMonthWater, $currentMonthWater);
        array_push($expensesDistributionData, $firstMonthItem);


        $firstMonthItem = new DataItem;
        $firstMonthItem->name = "Util:Power";
        $firstMonthItem->data = array($firstMonthPower, $secondMonthPower, $currentMonthPower);
        array_push($expensesDistributionData, $firstMonthItem);

        $firstMonthItem = new DataItem;
        $firstMonthItem->name = "Util:Airtime";
        $firstMonthItem->data = array($firstMonthAirtime, $secondMonthAirtime, $currentMonthAirtime);
        array_push($expensesDistributionData, $firstMonthItem);


        $firstMonthItem = new DataItem;
        $firstMonthItem->name = "Util:Data";
        $firstMonthItem->data = array($firstMonthData, $secondMonthData, $currentMonthData,);
        array_push($expensesDistributionData, $firstMonthItem);

        $firstMonthItem = new DataItem;
        $firstMonthItem->name = "Util:Fuel";
        $firstMonthItem->data = array($firstMonthFuel, $secondMonthFuel, $currentMonthFuel);
        array_push($expensesDistributionData, $firstMonthItem);

        $firstMonthItem = new DataItem;
        $firstMonthItem->name = "Rentals";
        $firstMonthItem->data = array($firstMonthRentals, $secondMonthRentals, $currentMonthRentals,);
        array_push($expensesDistributionData, $firstMonthItem);

        $firstMonthItem = new DataItem;
        $firstMonthItem->name = "Other";
        $firstMonthItem->data = array($firstMonthOther, $secondMonthOther, $currentMonthOther);
        array_push($expensesDistributionData, $firstMonthItem);


        $graphMonths = array($firstMonthName, $secondMonthName, $currentMonthName);

        $send = array(
            $graphMonths,
            $expensesDistributionData,
        );

        return json_encode($send);
    }

    public function getRevenuesDataReport()
    {

        $firstMonthName = Carbon::now()->subMonths(2)->monthName;
        $firstMonthFrom = Carbon::now()->subMonths(2)->startOfMonth();
        $firstMonthTo = Carbon::now()->subMonths(2)->endOfMonth();


        $secondMonthName = Carbon::now()->subMonths(1)->monthName;
        $secondMonthFrom = Carbon::now()->subMonths(1)->startOfMonth();
        $secondMonthTo = Carbon::now()->subMonths(1)->endOfMonth();


        $currentMonthName = Carbon::now()->monthName;
        $currentMonthFrom = Carbon::now()->startOfMonth();
        $currentMonthTo = Carbon::now()->endOfMonth();

        $firstMonthIttraining = Ticket::whereBetween('created_at', [$firstMonthFrom, $firstMonthTo])->where('service', 'IT Training')->sum('paid');
        $firstMonthCompcare = Ticket::whereBetween('created_at', [$firstMonthFrom, $firstMonthTo])->where('service', 'Comp Care')->sum('paid');
        $firstMonthManagedit = Ticket::whereBetween('created_at', [$firstMonthFrom, $firstMonthTo])->where('service', 'Managed It')->sum('paid');

        $secondMonthIttraining = Ticket::whereBetween('created_at', [$secondMonthFrom, $secondMonthTo])->where('service', 'IT Training')->sum('paid');
        $secondMonthCompcare = Ticket::whereBetween('created_at', [$secondMonthFrom, $secondMonthTo])->where('service', 'Comp Care')->sum('paid');
        $secondMonthManagedit = Ticket::whereBetween('created_at', [$secondMonthFrom, $secondMonthTo])->where('service', 'Managed It')->sum('paid');

        $currentMonthIttraining = Ticket::whereBetween('created_at', [$currentMonthFrom, $currentMonthTo])->where('service', 'IT Training')->sum('paid');
        $currentMonthCompcare = Ticket::whereBetween('created_at', [$currentMonthFrom, $currentMonthTo])->where('service', 'Comp Care')->sum('paid');
        $currentMonthManagedit = Ticket::whereBetween('created_at', [$currentMonthFrom, $currentMonthTo])->where('service', 'Managed It')->sum('paid');


        $revenueDistributionData = array();

        $firstMonthItem = new DataItem;
        $firstMonthItem->name = "IT Training";
        $firstMonthItem->data = array($firstMonthIttraining, $secondMonthIttraining, $currentMonthIttraining);
        array_push($revenueDistributionData, $firstMonthItem);


        $secondMonthItem = new DataItem;
        $secondMonthItem->name = "Comp Care";
        $secondMonthItem->data = array($firstMonthCompcare, $secondMonthCompcare, $currentMonthCompcare);
        array_push($revenueDistributionData, $secondMonthItem);

        $secondMonthItem = new DataItem;
        $secondMonthItem->name = "Managed It";
        $secondMonthItem->data = array($firstMonthManagedit, $secondMonthManagedit, $currentMonthManagedit);
        array_push($revenueDistributionData, $secondMonthItem);


        $graphMonths = array($firstMonthName, $secondMonthName, $currentMonthName);

        //get payment method by frequency  and value

        $paymentMethodCashByFrequency = Sales::whereBetween('created_at', [$firstMonthFrom, $currentMonthTo])->where('payment_method', 'CASH')->count();
        $paymentMethodChequeByFrequency = Sales::whereBetween('created_at', [$firstMonthFrom, $currentMonthTo])->where('payment_method', 'CHEQUE')->count();
        $paymentMethodMobileByFrequency = Sales::whereBetween('created_at', [$firstMonthFrom, $currentMonthTo])->where('payment_method', 'MOBILE')->count();

        $paymentMethodCashByValue = Sales::whereBetween('created_at', [$firstMonthFrom, $currentMonthTo])->where('payment_method', 'CASH')->sum('amount');
        $paymentMethodChequeByValue = Sales::whereBetween('created_at', [$firstMonthFrom, $currentMonthTo])->where('payment_method', 'CHEQUE')->sum('amount');
        $paymentMethodMobileByValue = Sales::whereBetween('created_at', [$firstMonthFrom, $currentMonthTo])->where('payment_method', 'MOBILE')->sum('amount');


        $pieFrequencyData = array();

        $pieItemFrequency = new DataItemPie;
        $pieItemFrequency->name = "CASH";
        $pieItemFrequency->value = $paymentMethodCashByFrequency;
        array_push($pieFrequencyData, $pieItemFrequency);

        $pieItemFrequency = new DataItemPie;
        $pieItemFrequency->name = "CHEQUE";
        $pieItemFrequency->value = $paymentMethodChequeByFrequency;
        array_push($pieFrequencyData, $pieItemFrequency);

        $pieItemFrequency = new DataItemPie;
        $pieItemFrequency->name = "MOBILE";
        $pieItemFrequency->value = $paymentMethodMobileByFrequency;
        array_push($pieFrequencyData, $pieItemFrequency);



        $pieValueData = array();
        $pieItemValue = new DataItemPie;
        $pieItemValue->name = "CASH";
        $pieItemValue->value = $paymentMethodCashByValue;
        array_push($pieValueData, $pieItemValue);


        $pieItemValue = new DataItemPie;
        $pieItemValue->name = "CHEQUE";
        $pieItemValue->value = $paymentMethodChequeByValue;
        array_push($pieValueData, $pieItemValue);

        $pieItemValue = new DataItemPie;
        $pieItemValue->name = "MOBILE";
        $pieItemValue->value = $paymentMethodMobileByValue;
        array_push($pieValueData, $pieItemValue);
        
        //

        $send = array(
            $graphMonths,
            $revenueDistributionData,
            $pieFrequencyData,
            $pieValueData,
        );

        return json_encode($send);
    }
}
