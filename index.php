<?php

namespace ORM;

require_once('./vendor/autoload.php');

$user = new User();

$userelements = $user->getElement(['id' => '4', 'login' => 'xddd']);

if(is_object($userelements))
    echo $userelements->login;

$user->drop();