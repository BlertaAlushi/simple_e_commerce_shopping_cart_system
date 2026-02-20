<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Interfaces\Services\LookupInterface;
use Inertia\Inertia;

class SkinTypeController extends Controller
{

    public function __construct(
        protected LookupInterface $lookup
    ){}
    public function index(){
        $skin_types = $this->lookup->index();
        return Inertia::render('admin/skin_types/SkinTypesIndex', ['skin_types' => $skin_types]);
    }
}
