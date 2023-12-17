<?php

namespace App\Http\Controllers\Api;

use App\Export\EventReportExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function report(int $event_id)
    {

        $data = DB::table('event')
            ->join('event_participants_attendance as p', 'p.event_id', '=', 'event.id')
            ->join('employee as e', 'e.id', '=', 'p.participants_attendance_key')
            ->select('e.firstname as name', 'e.lastname as surname', 'event.start_date_time as date_event',
                DB::raw('CASE WHEN p.participants_attendance = 1 THEN "пришел" ELSE "не пришел" END as status'),
            'event.name as event_name')
            ->where('event.id', $event_id)->get();
        $event = DB::table('event')->where('event.id', $event_id)->first();
        return Excel::download(new EventReportExport($data), $event->name.'.xlsx');
    }
}
