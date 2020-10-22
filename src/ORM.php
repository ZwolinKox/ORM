<?php 

namespace ORM;
use \Model;

class ORM extends Model {
    public $relations = [
        new RelationKey();
    ];
}