<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Category;
use App\Models\Response;
use App\Models\Ticket;
use App\Models\User;
use App\Policies\CategoryPolicy;
use App\Policies\ResponsePolicy;
use App\Policies\TicketPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Response::class => ResponsePolicy::class,
        Category::class => CategoryPolicy::class,
        User::class     => UserPolicy::class,
        Ticket::class   => TicketPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
