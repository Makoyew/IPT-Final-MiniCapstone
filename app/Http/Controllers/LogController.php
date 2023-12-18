<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Log;
use Carbon\Carbon;

class LogController extends Controller
{
    public function index()
    {
        $logEntries = Log::orderBy('created_at', 'desc')->get();

        $logEntries->transform(function ($logEntry) {
            $logEntry->formattedCreatedAt = Carbon::parse($logEntry->created_at)->format('F-d-Y');
            return $logEntry;
        });

        return view('Logs/index', ['logEntries' => $logEntries]);
    }
}
