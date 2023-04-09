<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Eloquent\BaseRepository;
use App\Repositories\EloquentRepositoryInterface;

use App\Repositories\UsersRepositoryInterface;
use App\Repositories\Eloquent\UsersRepository;
use App\Repositories\AircraftsRepositoryInterface;
use App\Repositories\Eloquent\AircraftsRepository;
use App\Repositories\FlightsRepositoryInterface;
use App\Repositories\Eloquent\FlightsRepository;
use App\Repositories\PilotsRepositoryInterface;
use App\Repositories\Eloquent\PilotsRepository;
use App\Repositories\FilesRepositoryInterface;
use App\Repositories\Eloquent\FilesRepository;

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
        $this->app->bind(EloquentRepositoryInterface::class, BaseRepository::class);

        $this->app->bind(UsersRepositoryInterface::class, UsersRepository::class);

        $this->app->bind(AircraftsRepositoryInterface::class, AircraftsRepository::class);

        $this->app->bind(FlightsRepositoryInterface::class, FlightsRepository::class);

        $this->app->bind(PilotsRepositoryInterface::class, PilotsRepository::class);
        $this->app->bind(FilesRepositoryInterface::class, FilesRepository::class);
    }
}

