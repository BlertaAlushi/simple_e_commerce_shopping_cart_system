<?php

namespace App\Services\Collection;

use App\Interfaces\Collection\CollectionRepositoryInterface;

class SkinConcernsService
{
    public function __construct(protected CollectionRepositoryInterface $collectionRepository){

    }

    public function products($option,$filterOptions)
    {
        // TODO: Implement products() method.
    }
}
