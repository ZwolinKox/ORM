<?php

namespace ORM\Model;

abstract class Model {

    protected $options;
    protected $pdo;

    public $relations = [];

    public abstract function setRelation();

    public function __construct() {
        $this->setRelation();
        $options = json_encode(file_get_contents('./settings.json', true))['orm'];
        $this->makePDO();
    }

    public function getElementById($id) {
        $stmt = $pdo->prepare('SELECT * FROM '.$this->tableName.$this->getRelationSQL().' WHERE id = :id');
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function getElement($where = []) {
        $where = $this->getWhereSQL($where);
        $stmt = $pdo->prepare('SELECT * FROM '.$this->tableName.$this->getRelationSQL().$this->getWhereSQL());
        $stmt->execute($where);
        return $stmt->fetch();
    }

    public function truncate() {
        $stmt = $pdo->prepare('TRUNCATE TABLE '.$this->tableName());
        $stmt->execute($where);
    }

    public function drop() {
        $stmt = $pdo->prepare('DROP TABLE '.$this->tableName());
        $stmt->execute($where);
    }

    protected function getWhereSQL(array $where) : string {
        if(empty($where))
            return '';

        $sql = ' WHERE ';

        foreach ($where as $key => $value) {

            $prefix = '';

            if(!preg_match('/\./'))
                $prefix = $this->tableName().'.';

            $sql .= $prefix.$key.' = '.':'.$key;

            if ($key !== array_key_last($array)) {
                $sql .= ' AND ';
            }
        }

        return $sql;
    }

    protected function getRelationSQL() : string {
        $sql = '';
        
        foreach ($relations as $value) {
            $sql .= ' '.$value->relationType.' '.$value->tableName.' ON '.$this->tableName().'.'.$value->leftSideField.'='.$value->tableName.'.'.$value->rightSideField;
        }

        return $sql;
    }

    protected function makePDO() {
        $host = $options['host'];
        $db   =  $options['db'];
        $user =  $options['user'];
        $pass =  $options['pass'];
        $charset =  $options['charset'];

        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";

        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false
        ];

        try {
            $this->pdo = new PDO($dsn, $user, $pass, $options);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    protected function tableName() : string {
        return strtolower(get_class($this)).'s';
    }
}
