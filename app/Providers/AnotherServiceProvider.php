<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;


class AnotherServiceProvider extends ServiceProvider {
  public function register() {
    $this->app->singleton('anotherservice', function($app) {
      return new \App\Services\AnotherService();
    });
  }
}