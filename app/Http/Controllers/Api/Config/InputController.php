<?php

namespace App\Http\Controllers\Api\Config;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\Controller;

class InputController extends Controller
{

    public function index(){
       return $this->response->array(config('definedInput'));
    }
}
