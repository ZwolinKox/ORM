# ORM

[![version](https://img.shields.io/badge/version-1.1.2-yellow.svg)](https://semver.org)
[![Conventional Commits](https://img.shields.io/badge/Conventional%20Commits-1.0.0-yellow.svg)](https://conventionalcommits.org)
[![License: GPL v3](https://img.shields.io/badge/License-GPLv3-blue.svg)](https://www.gnu.org/licenses/gpl-3.0)

Micro ORM system for PHP 



## Table of contents
* [General info](#general-info)
* [Technologies](#technologies)
* [Setup](#instalation)
* [Code Examples](#code-examples)


# General Info
Project was started as teaching resource for Library system

## Technologies
Project is created with:
* PHP 7.2^

## Instalation
##### Setup via Composer
```
$ composer require https://github.com/ZwolinKox/ORM.git
```

## Code Examples

Example ORM class: 

``` php
namespace ORM;
use \Model;

//Class cannot override base constructor
//If you want this you must use parent constructor in constructor of this class

class ORM extends Model {

    //Abstract method for initialize 
    public function setRelation() {
        $this->relations = [
            new RelationKey('users', 'user_id', 'id'),
            new RelationKey('orders', 'order_id', 'id')
        ];
    }

}

```

Get element(s)

``` php
$orm = new ORM();

$foo = $orm->getElementById(3);

$biz = $orm->getElement(['id' => 20, 'is_delete' => 0]);

$bar = $orm->getElements([
    'name' => 'Adam',
]);

print_r($bar); //Array

```

Update Table


``` php
$orm = new ORM();

$orm->update(
    ['id' => 1],
    ['name' => 'Adam', 'email' => 'kamil@slimak.com']
);
```

Drop and Truncate Table


``` php
$orm = new ORM();

$orm->truncate();
$orm->drop();


```


Delete from table


``` php
$orm = new ORM();

$orm->delete(['id' => 5]);


```

Insert Into


``` php
$orm = new ORM();

$orm->insert(['name' => 'John', 'age' => '13']);

```