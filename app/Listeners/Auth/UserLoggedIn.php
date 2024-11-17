<?php

namespace App\Listeners\Auth;

use App\Model\Audit;
use Carbon\Carbon;
use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UserLoggedIn
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
     * @param  Login  $event
     * @return void
     */
    public function handle(Login $event)
    {

        $data = [
            'user_type'     =>'App\User',
            'user_id'       => $event->user->id,
            'event'         => "Logged In",
            'auditable_type'=> "Logged In",
            'auditable_id'  => $event->user->id,
            'old_values'    => null,
            'new_values'    => null,
            'url'           => request()->fullUrl(),
            'ip_address'    => request()->getClientIp(),
            // 'user_agent'    => request()->userAgent(),
            'user_agent'    => (strpos(request()->userAgent(),'Dart') !== false) ? $event->user->device : request()->userAgent(),
            'tags'          => (strpos(request()->userAgent(),'Dart') !== false) ? 'Mobile' : 'System',
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now()
        ];

        //create audit trail data
        $details = Audit::create($data);
    }
}
