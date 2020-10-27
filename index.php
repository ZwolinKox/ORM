<?php

namespace ORM;

require_once('./vendor/autoload.php');

$user = new User();

$user->update(['name' => 'Jacob Hear'], ['name' => 'Jakub Slysz']);

echo $user->getElementById(2)->name;
