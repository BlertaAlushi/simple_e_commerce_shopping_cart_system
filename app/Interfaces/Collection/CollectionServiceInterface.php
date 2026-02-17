<?php

namespace App\Interfaces\Collection;

use Illuminate\Http\Request;

interface CollectionServiceInterface
{
    public function products($option,$filterOptions);
}
