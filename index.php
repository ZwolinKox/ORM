<?php

namespace ORM;

require_once('./vendor/autoload.php');

$user = new User();

$userelements = $user->getElement(['id' => '4']);

if(is_object($userelements))
    echo $userelements->name;

$user->update(['id' => '4'], ['name' => 'Jacob Hear']);