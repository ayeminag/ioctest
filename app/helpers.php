<?php

use Illuminate\Container\Container;
use Illuminate\Support\Debug\Dumper;

if(!function_exists('app')) {
  function app($make = null, $parameters = []) {
    if (is_null($make)) {
      return Container::getInstance();
    }

    return Container::getInstance()->make($make, $parameters);
  }
}

if(!function_exists('dd')) {
  function dd() {
    array_map(function ($x) { (new Dumper)->dump($x); }, func_get_args());
    die(1);
  }
}