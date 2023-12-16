<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function report(int $event_id)
    {

        $event = DB::table('event')
        ->where('id', $event_id)->first();

        return response(['data' => $event]);
    }
}
