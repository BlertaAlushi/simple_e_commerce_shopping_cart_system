<?php

namespace App\Services\Collection;

use App\Interfaces\Collection\CollectionRepositoryInterface;
use App\Interfaces\Collection\CollectionServiceInterface;
use App\Models\BodyPart;
use Illuminate\Http\Request;

class BodyPartsService implements CollectionServiceInterface
{
    public function __construct(protected CollectionRepositoryInterface $collectionRepository){

    }

    public function products($option,$filterOptions)
    {
        return $this->collectionRepository->queryMenuOption($option);
    }

}
