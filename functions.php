#!/usr/bin/env php
<?php

include '_init.php';

$rf = new ReflectionClass($cb);
echo 'Properties: ' . PHP_EOL;
var_dump($rf->getProperties());
echo 'Methods: ' . PHP_EOL;
var_dump($rf->getMethods());

