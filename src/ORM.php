<?php 

namespace ORM;
use \Model;

class ORM extends Model {

    //Abstract method for initialize 
    public function setRelation() {
        $this->relations = [
            new RelationKey('users', 'user_id', 'id'),
            new RelationKey('orders', 'order_id', 'id')
        ];
    }

}
