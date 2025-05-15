<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Auth\Events\Login;


class UpdateLastLoginAt
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
    
    public function handle(Login $event)
    {
      if ($event->user instanceof \App\Models\User) {
       
        $event->user->last_login_at = now();
        $event->user->save();
    } else {
       
        DB::table('users')
            ->where('id', $event->user->id)
            ->update(['last_login_at' => now()]);
    }
    }
}
