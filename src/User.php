<?php 

namespace ORM;

//Class cannot override base constructor
//If you want this you must use parent constructor in constructor of this class

class User extends Model\Model {

    public function init() {}

}
