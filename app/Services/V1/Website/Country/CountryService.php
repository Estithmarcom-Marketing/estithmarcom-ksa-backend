<?php

namespace App\Services\V1\Website\Country;

use App\Models\Country;

class CountryService
{
    public function list()
    {
        $locale = app()->getLocale();
        return Country::select(['id', "name_$locale as name", "title_$locale as title", "description_$locale as description"])
            ->active(true)
            ->with('media')
            ->get();
    }
    public function listWithoutPagination()
    {
        $locale = app()->getLocale();
        return Country::select(['id', "name_$locale as name"])
            ->withCount('residencies')
            ->active(true)
            ->get();
    }
}
