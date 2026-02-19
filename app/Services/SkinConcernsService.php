<?php

namespace App\Services;

use App\Interfaces\Repositories\ProductRepositoryInterface;

class SkinConcernsService
{
    public function __construct(protected ProductRepositoryInterface $collectionRepository){

    }

    public function products($option,$filterOptions)
    {
        // TODO: Implement products() method.
    }
}
