<?php 

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
