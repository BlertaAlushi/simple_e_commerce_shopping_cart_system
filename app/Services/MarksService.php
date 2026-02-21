<?php

namespace App\Services;

use App\Interfaces\Services\LookupInterface;
use App\Models\Mark;

class MarksService extends LookupBaseService implements LookupInterface
{
    public function __construct(){
        $this->model = Mark::class;
    }
}
