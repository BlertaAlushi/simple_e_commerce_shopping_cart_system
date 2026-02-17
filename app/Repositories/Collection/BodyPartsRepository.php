<?php

namespace App\Repositories\Collection;

use App\Interfaces\Collection\CollectionRepositoryInterface;
use App\Services\Collection\BodyPartsService;

class BodyPartsRepository implements CollectionRepositoryInterface
{
    public function queryMenuOption($option)
    {
       return [];
    }

    public function queryFilerOptions($filterOptions){
        return [];
    }
}
