<?php

namespace App\Http\Controllers;

use App\Notices;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class AdminNoticesController extends Controller
{
    public function store(Request $request)
    {

        $newnotice = new Notices;

        $newnotice->description = $request->notice["description"];
        $newnotice->end = $request->notice["end"];
        $newnotice->dates =  $request->notice["dates"];
        $newnotice->color =  $request->notice["color"];
        $newnotice->save();
        
        return $newnotice;
    }


    public function get()
    {
        return Notices::get();
    }

    public function update(Request $request)
    {
        $editNotice = new Notices;
        $noticeData = json_decode($request->notice);
        $editNotice = Notices::firstWhere('id', $noticeData->id);

        if ($editNotice) {
            $editNotice->description = $noticeData->description;
            $editNotice->end = $noticeData->end;
            $editNotice->dates = $noticeData->dates;
            $editNotice->color = $noticeData->color;


            $editNotice->save();
            return 'True';
        } else {
            return 'False';
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Notices  $Notices
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleteNotice = Notices::firstWhere('id', $id);
        $deleteNotice->delete();
    }

    public function thisMonthNotices()
    {

        // $currentMonth = Carbon::now()->month;
        // $currentYear = Carbon::now()->year;
        // $from = Carbon::createFromDate($currentYear, $currentMonth, 1);
       $from = Carbon::now()->startOfMonth();
        $to = Carbon::now()->endOfMonth();


       $notices = Notices::whereBetween('dates', array($from,$to))->get();

        return $notices;
    }
}
