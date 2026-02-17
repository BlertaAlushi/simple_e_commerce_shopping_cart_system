<?php

namespace App\Services;

use App\Models\Language;

class LanguageService
{
    public static function getCurrentLanguageId()
    {
        $locale = app()->getLocale();
        return Language::where('code', $locale)->value('id');
    }
}
