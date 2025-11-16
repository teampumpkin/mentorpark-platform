<?php

namespace App\Providers;

use Illuminate\Auth\Events\Login; // <-- Import the Login event
use App\Listeners\UpdateLastLoginAt; // <-- Import your new listener
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
// ... other imports

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
       /* Registered::class => [
            SendEmailVerificationNotification::class,
        ],*/
        // Add this mapping
        Login::class => [
            UpdateLastLoginAt::class,
        ],
    ];

}
