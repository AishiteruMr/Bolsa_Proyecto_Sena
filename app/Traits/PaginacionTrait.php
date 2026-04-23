<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait PaginacionTrait
{
    protected function getPerPage(Request $request, int $default = 15, int $min = 5, int $max = 50): int
    {
        $perPage = (int) $request->get('per_page', $default);

        return max($min, min($max, $perPage));
    }
}