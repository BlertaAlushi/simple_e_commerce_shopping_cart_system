<?php

namespace App\Services;

use App\Interfaces\Repositories\ProductRepositoryInterface;
use App\Interfaces\Services\CollectProductsServiceInterface;

class BodyPartsService implements CollectProductsServiceInterface
{
    public function __construct(protected ProductRepositoryInterface $collectionRepository){

    }

    public function products($option,$filterOptions)
    {
        return $this->collectionRepository->queryMenuOption($option);
    }

}
