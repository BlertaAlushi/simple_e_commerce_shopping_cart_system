<?php

namespace App\Interfaces\Collection;

interface CollectionRepositoryInterface
{
    public function queryMenuOption($option);
    public function queryFilerOptions($filterOptions);
}
