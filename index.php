<?php

namespace ORM;

$orm = new ORM();

print_r($orm->getElementById(3));

print_r($orm->getElement([
    'name' => 'Adam',
    'email' => 'kamil@slimak.com'
]));