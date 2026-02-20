<?php

namespace App\Services;

class LookupBaseService
{
    protected $model;

    public function index(){
        return $this->model::all();
    }
}
