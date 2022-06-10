<?php

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

if (!function_exists('paginate')) {
    function paginate($items, $perPage = 15, $page = null, $options = [])
    {
        $page  = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}

function escapeSpecialChar($value)
{
    if (preg_match("/^[!@#\$%^\&\*\(\)+=\[\]]*$/", $value)) {
        return '';
    }

    if (preg_match("/[\_]*/", $value)) {
        return '%' . str_replace("_", "\_", $value) . '%';
    }

    return '%' . $value . '%';
}
