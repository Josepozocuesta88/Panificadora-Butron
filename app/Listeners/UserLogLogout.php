<?php

namespace App\Listeners;

// use App\Events\Logout;
// use Illuminate\Contracts\Queue\ShouldQueue;
// use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Auth\Events\Logout;
use App\Models\UserLog;

class UserLogLogout
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
    public function handle(Logout $event): void
    {
        //
        $lastLogin = UserLog::where('email', $event->user->email)
        ->whereNull('fechorsalida')
        ->latest('fechorentrada')
        ->first();

        if ($lastLogin) {
            $lastLogin->update([
                'fechorsalida' => now(),
            ]);
        }
    }
}
