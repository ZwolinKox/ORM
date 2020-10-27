<?php

namespace ORM;

require_once('./vendor/autoload.php');

$user = new User();

print_r($user->getElement(['name' => 'Szpadel']));