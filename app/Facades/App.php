<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class App extends Facade {
  protected static function getFacadeAccessor() {
    return "app";
  }
}