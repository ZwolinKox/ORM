namespace ORM;

use ORM\Model\Model;


class Order extends Model {

    public function init() {
        new RelationKey('users', 'user_id', 'id'),
    }

}
