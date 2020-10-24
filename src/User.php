<?php 

namespace ORM;
use ORM\Model\Model;

//Class cannot override base constructor
//If you want this you must use parent constructor in constructor of this class

class User extends Model {

    public function init() {
        $this->deleteType = Model::SOFT_DELETE;
    }

}
