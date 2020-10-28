<?php

namespace ORM;

require_once('./vendor/autoload.php');

$user = new User();
$order = new Order();

print_r($order->getElements(['orders.id' => '2']));