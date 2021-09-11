<?php

namespace App\Providers;

use App\Models\Appointment;
use App\Models\Contact;
use App\Models\User;
use App\Repositories\AppointmentRepository;
use App\Repositories\ContactRepository;
use App\Repositories\Contracts\AppointmentRepositoryContract;
use App\Repositories\Contracts\ContactRepositoryContract;
use App\Repositories\Contracts\UserRepositoryContract;
use App\Repositories\UserRepository;
use App\Services\Contracts\GoogleMapServiceContract;
use App\Services\Contracts\PostcodeServiceContract;
use App\Services\GoogleMapService;
use App\Services\PostcodeService;
use Illuminate\Support\ServiceProvider;

class ServiceServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(PostcodeServiceContract::class, PostcodeService::class);
        $this->app->bind(GoogleMapServiceContract::class, GoogleMapService::class);
    }
}
