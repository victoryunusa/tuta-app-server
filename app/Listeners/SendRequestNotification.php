<?php

namespace App\Listeners;

use App\Events\DriverRequested;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendRequestNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  DriverRequested  $event
     * @return void
     */
    public function handle(DriverRequested $event)
    {
        //
    }
}
