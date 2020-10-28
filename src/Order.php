<?php 

namespace ORM;

use ORM\Model\Model;

class Order extends Model {

    public function init() {
        $this->relations = [
            new \ORM\Model\RelationKey('users', 'user_id', 'id'),
        ];
    }

}
