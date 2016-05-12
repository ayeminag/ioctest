<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class MS extends Facade {
  protected static function getFacadeAccessor() {
    return "myservice";
  }
}