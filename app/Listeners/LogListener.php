<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\UserLog;
use App\Models\Log;

class LogListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UserLog $event): void
    {
        Log::create([
            'user_id'   => auth()->user()->id,
            'log_entry' => $event->log_entry
        ]);
    }
}
