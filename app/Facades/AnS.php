<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class AnS extends Facade {
  protected static function getFacadeAccessor() {
    return "anotherservice";
  }
}