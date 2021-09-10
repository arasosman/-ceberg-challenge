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
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
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
        $this->app->bind(UserRepositoryContract::class, function () {
            return new UserRepository(new User());
        });
        $this->app->bind(ContactRepositoryContract::class, function () {
            return new ContactRepository(new Contact());
        });
        $this->app->bind(AppointmentRepositoryContract::class, function () {
            return new AppointmentRepository(new Appointment());
        });
    }
}
