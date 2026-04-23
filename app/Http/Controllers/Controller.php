<?php

namespace App\Http\Controllers;

use App\Traits\PaginacionTrait;
use App\Traits\ValidacionMensajes;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests, ValidacionMensajes, PaginacionTrait;
}
