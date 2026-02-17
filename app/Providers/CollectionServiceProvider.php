<?php

namespace App\Providers;

use App\Http\Controllers\Collections\BodyPartsController;
use App\Http\Controllers\Collections\ExtrasController;
use App\Http\Controllers\Collections\MarksController;
use App\Http\Controllers\Collections\ProductTypesController;
use App\Http\Controllers\Collections\SkinConcernsController;
use App\Http\Controllers\Collections\SkinTypeController;
use App\Interfaces\Collection\CollectionServiceInterface;
use App\Services\Collection\BodyPartsService;
use App\Services\Collection\ExtrasService;
use App\Services\Collection\MarksService;
use App\Services\Collection\ProductTypesService;
use App\Services\Collection\SkinConcernsService;
use App\Services\Collection\SkinTypesService;
use Illuminate\Support\ServiceProvider;

class CollectionServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->app->when(BodyPartsController::class)
            ->needs(CollectionServiceInterface::class)
            ->give(BodyPartsService::class);

        $this->app->when(SkinTypeController::class)
            ->needs(CollectionServiceInterface::class)
            ->give(SkinTypesService::class);

        $this->app->when(SkinConcernsController::class)
            ->needs(CollectionServiceInterface::class)
            ->give(SkinConcernsService::class);

        $this->app->when(ProductTypesController::class)
            ->needs(CollectionServiceInterface::class)
            ->give(ProductTypesService::class);

        $this->app->when(MarksController::class)
            ->needs(CollectionServiceInterface::class)
            ->give(MarksService::class);

        $this->app->when(ExtrasController::class)
            ->needs(CollectionServiceInterface::class)
            ->give(ExtrasService::class);
    }
}
