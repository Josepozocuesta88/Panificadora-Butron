<?php

namespace App\Listeners;

// use App\Events\Login;
// use Illuminate\Contracts\Queue\ShouldQueue;
// use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Auth\Events\Login;
use App\Models\UserLog;

class UserLogLogin
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
    public function handle(Login $event): void
    {
        //
        // \Log::info('Login event fired', ['user' => $event->user->email]);
        UserLog::create([
            'name' => $event->user->name,
            'email' => $event->user->email,
            'usuclicod' => $event->user->usuclicod,
            'usucencod' => $event->user->usucencod,
            'fechorentrada' => now(),
        ]);
    }
}
