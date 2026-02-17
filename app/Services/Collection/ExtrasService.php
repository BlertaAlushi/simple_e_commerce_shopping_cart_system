<?php

namespace App\Services\Collection;

use App\Interfaces\Collection\CollectionRepositoryInterface;

class ExtrasService
{
    public function __construct(protected CollectionRepositoryInterface $collectionRepository){

    }

    public function products($option,$filterOptions)
    {
        // TODO: Implement products() method.
    }
}
