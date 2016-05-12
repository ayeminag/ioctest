<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class MyServiceProvider extends ServiceProvider {

  public function register() {
    $this->app->singleton('myservice', function($app) {
      return new \App\Services\MyService();
    });
  }
}