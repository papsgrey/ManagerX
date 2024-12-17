<?php

namespace App\Providers;

use App\Events\CreateRouterOnUMServer;
use App\Events\CreateRadiusOnUMClient;
use App\Listeners\HandleCreateRouterOnUMServer;
use App\Listeners\HandleCreateRadiusOnUMClient;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;


class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        CreateRouterOnUMServer::class => [
            HandleCreateRouterOnUMServer::class,
        ],
        CreateRadiusOnUMClient::class => [
            HandleCreateRadiusOnUMClient::class,
        ],
    ];

    public function boot()
    {
        parent::boot();
    }
}