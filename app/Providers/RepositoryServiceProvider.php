<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\PacienteRepositoryInterface;
use App\Repositories\PacienteRepository as RepositoriesPacienteRepository;
use App\Repository\PacienteRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(PacienteRepositoryInterface::class, RepositoriesPacienteRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
