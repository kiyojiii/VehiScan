<?php

namespace App\Listeners;


use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Spatie\Permission\Models\Role;

class AssignDefaultRole
{
    /**
     * Handle the event.
     *
     * @param  Registered  $event
     * @return void
     */
    public function handle(Registered $event)
    {
        // Retrieve the newly registered user
        $user = $event->user;

        // Assign the "Applicant" role to the user
        $role = Role::where('name', 'Applicant')->first();
        if ($role) {
            $user->assignRole($role);
        }
    }
}
