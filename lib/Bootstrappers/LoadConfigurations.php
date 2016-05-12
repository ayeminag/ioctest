<?php

namespace IoCTest\Bootstrappers;

use Illuminate\Contracts\Config\Repository as RepositoryContract;
use Illuminate\Config\Repository;

use IoCTest\Application;

class LoadConfigurations {

  public function bootstrap(Application $app) {
    $app->instance('config', $config = new Repository(array()));
    $this->loadConfigurationFiles($app, $config);
  }

  protected function loadConfigurationFiles(Application $app, Repository $config) {
    foreach($this->getConfigurationFiles($app) as $key => $path) {
      $config->set($key, require $path);
    }
  }
  protected function getConfigurationFiles(Application $app) {
    $configpath = $app['path.config'];
    $files = [];
    $configDir = opendir($configpath);
    while($file = readdir($configDir)) {
      if($file == '.' || $file == '..') {
        continue;
      }
      $file = $configpath . DIRECTORY_SEPARATOR . $file;
      if(is_file($file) && preg_match("/\.php$/",  $file)) {
        $files[basename($file, '.php')] = $file;
      }
    }
    return $files;
  }
}