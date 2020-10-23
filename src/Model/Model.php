<?php

namespace ORM\Model;

use \RecursiveIteratorIterator;

abstract class Model {

    protected $options = [];
    protected $pdo;

    const SOFT_DELETE = 0;
    const HARD_DELETE = 1;

    protected $deleteType = Model::HARD_DELETE;
    public $relations = [];

    public abstract function init();

    public function __construct() {
        $this->init();
        
        $jsonIterator = new \RecursiveIteratorIterator(
            new \RecursiveArrayIterator(json_decode(file_get_contents('./settings.json'), true)),
            \RecursiveIteratorIterator::SELF_FIRST);
        
        foreach ($jsonIterator as $key => $value) {
            array_push($this->options, [$key => $value]);
        }

        $this->makePDO();
    }

    public function getElementById(int $id) {
        $stmt = $this->pdo->prepare('SELECT * FROM '.$this->tableName().$this->getRelationSQL().' WHERE id = :id');
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function getElement($where = []) {
        $stmt = $this->pdo->prepare('SELECT * FROM '.$this->tableName().$this->getRelationSQL().$this->getWhereSQL($where));
        $stmt->execute($where);
        return $stmt->fetch();
    }

    public function truncate() {
        $stmt = $this->pdo->prepare('TRUNCATE TABLE '.$this->tableName());
        $stmt->execute();
    }

    public function drop() {
        $stmt = $this->pdo->prepare('DROP TABLE '.$this->tableName());
        $stmt->execute();
    }

    protected function getWhereSQL(array $where) : string {
        if(empty($where))
            return '';

        $sql = ' WHERE ';

        foreach ($where as $key => $value) {

            $prefix = '';

            if(!preg_match('/\./', $key))
                $prefix = $this->tableName().'.';

            $sql .= $prefix.$key.' = '.':'.$key;

            if ($key !== array_key_last($where)) {
                $sql .= ' AND ';
            }
        }

        return $sql;
    }

    protected function getRelationSQL() : string {
        $sql = '';
        
        foreach ($this->relations as $value) {
            $sql .= ' '.$value->relationType.' '.$value->tableName.' ON '.$this->tableName().'.'.$value->leftSideField.'='.$value->tableName.'.'.$value->rightSideField;
        }

        return $sql;
    }

    protected function makePDO() {

        $host = $this->options[0]['orm']['host'];
        $db   =  $this->options[0]['orm']['db'];
        $user =  $this->options[0]['orm']['user'];
        $pass =  $this->options[0]['orm']['password'];
        $charset =  $this->options[0]['orm']['charset'];

        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";

        $options = [
            \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_OBJ,
            \PDO::ATTR_EMULATE_PREPARES   => false
        ];

        try {
            $this->pdo = new \PDO($dsn, $user, $pass, $options);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    protected function tableName() : string {
        $tableName = explode('\\', strtolower(get_class($this)));
        return end($tableName).'s';
    }
}
