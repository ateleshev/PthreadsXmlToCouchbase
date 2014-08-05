#!/usr/bin/env php
<?php

include '_init.php';

$rf = new ReflectionClass($cb);

//echo 'Properties: ' . PHP_EOL;
//var_dump($rf->getProperties());

echo "Methods: " . PHP_EOL;
foreach ($rf->getMethods() as $rfMethod)
{
  $parameters = [];
  foreach ($rfMethod->getParameters() as $rfParameter)
  {
    $parameter = trim("{$rfParameter->getClass()} \${$rfParameter->getName()}");

    if ($rfParameter->isDefaultValueAvailable())
    {
      $parameter .= " = {$rfParameter->getDefaultValue()}";
    }

    if ($parameter)
    {
      $parameters[] = $parameter;
    }
  }
  
  echo "{$rfMethod->class}::{$rfMethod->name}(" . implode(', ', $parameters) . ")" . PHP_EOL;
}

