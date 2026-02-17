<?php

namespace App\Providers;

use App\Interfaces\Collection\CollectionRepositoryInterface;
use App\Repositories\Collection\BodyPartsRepository;
use App\Repositories\Collection\ExtrasRepository;
use App\Repositories\Collection\MarksRespository;
use App\Repositories\Collection\ProductTypesRepository;
use App\Repositories\Collection\SkinConcernsRepository;
use App\Repositories\Collection\SkinTypesRepository;
use App\Services\Collection\BodyPartsService;
use App\Services\Collection\ExtrasService;
use App\Services\Collection\MarksService;
use App\Services\Collection\ProductTypesService;
use App\Services\Collection\SkinConcernsService;
use App\Services\Collection\SkinTypesService;
use Illuminate\Support\ServiceProvider;

class CollectionRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->when(BodyPartsService::class)
            ->needs(CollectionRepositoryInterface::class)
            ->give(BodyPartsRepository::class);

        $this->app->when(SkinTypesService::class)
            ->needs(CollectionRepositoryInterface::class)
            ->give(SkinTypesRepository::class);

        $this->app->when(SkinConcernsService::class)
            ->needs(CollectionRepositoryInterface::class)
            ->give(SkinConcernsRepository::class);

        $this->app->when(ProductTypesService::class)
            ->needs(CollectionRepositoryInterface::class)
            ->give(ProductTypesRepository::class);

        $this->app->when(MarksService::class)
            ->needs(CollectionRepositoryInterface::class)
            ->give(MarksRespository::class);

        $this->app->when(ExtrasService::class)
            ->needs(CollectionRepositoryInterface::class)
            ->give(ExtrasRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
