<?php

namespace App\Services;

use App\Interfaces\Services\LookupInterface;
use App\Models\Language;

class LanguageService extends LookupBaseService implements LookupInterface
{
    public function __construct(){
        $this->model = Language::class;
    }

    public static function getCurrentLanguageId()
    {
        $locale = app()->getLocale();
        return Language::where('code', $locale)->value('id');
    }
}
