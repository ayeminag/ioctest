<?php

namespace IoCTest;

use Illuminate\Container\Container;
use Illuminate\Support\ServiceProvider;
use IoCTest\Bootstrappers\LoadConfigurations;
use Illuminate\Support\Arr;
use IoCTest\Bootstrappers\RegisterFacades;

class Application extends Container {

  protected $basepath;

  protected $serviceProviders = array();

  protected $loadedProviders = array();

  public function __construct($basepath) {
    $this->setBasePath($basepath);

    $this->registerBaseBindings();

    $this->bootstrapWithConfigurations();

    $this->regsiterConfiguredProviders();
  }

  protected function registerBaseBindings() {
    $this['app'] = $this;
    $this->singleton('Illuminate\Container\Container', $this);
    $this->singleton('Illuminate\Contracts\Container\Container', $this);

    $this->registerBasePaths();
  }

  protected function registerBasePaths() {

    $this->instance('path', $this->getBasePath());
    $this->instance('path.config', $this->getConfigPath());
    $this->instance('path.app', $this->getAppPath());

  }

  protected function bootstrapWithConfigurations() {

    (new LoadConfigurations)->bootstrap($this);
    (new RegisterFacades)->bootstrap($this);

  }

  protected function regsiterConfiguredProviders() {
    $providers = $this['config']->get('app.providers');
    if(!is_null($providers) && is_array($providers)) {
      foreach($providers as $provider) {
        $this->register($provider);
      }
    }
  }

  public function register($provider, $options = [], $force = false) {
    if (($registered = $this->getProvider($provider)) && ! $force) {
        return $registered;
    }

    if (is_string($provider)) {
        $provider = $this->resolveProviderClass($provider);
    }

    $provider->register();

    foreach ($options as $key => $value) {
        $this[$key] = $value;
    }

    $this->markAsRegistered($provider);

    return $provider;
  }

  public function getProvider($provider) {
    $name = is_string($provider) ? $provider : get_class($provider);

    return Arr::first($this->serviceProviders, function ($key, $value) use ($name) {
        return $value instanceof $name;
    });
  }

  public function resolveProviderClass($provider) {
    return new $provider($this);
  }

  protected function markAsRegistered($provider) {
    $class = get_class($provider);
    $this->serviceProviders[] = $provider;

    $this->loadedProviders[$class] = true;
  }

  protected function setBasePath($basepath) {

    $this->basepath = $basepath;

  }

  protected function getBasePath() {

    return $this->basepath;

  }
  protected function getAppPath() {

    return $this->basepath . DIRECTORY_SEPARATOR . 'app';

  }

  protected function getConfigPath() {

    return $this->basepath . DIRECTORY_SEPARATOR . 'config';

  }
}