<?php

return array(
  'providers' => array(
      \App\Providers\MyServiceProvider::class,
      \App\Providers\AnotherServiceProvider::class
    ),

  'aliases' => array(
      'MS' => \App\Facades\MS::class,
      'AnS' => \App\Facades\AnS::class,
    )
);