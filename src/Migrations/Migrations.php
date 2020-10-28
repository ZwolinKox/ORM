<?php

namespace ORM\Migrations;

class Migrations {

    protected $options = [];
    protected $migration = [];
    protected $pdo;
    protected $sqls = [];

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

    public function __construct() {
        
        $jsonIterator = new \RecursiveIteratorIterator(
            new \RecursiveArrayIterator(json_decode(file_get_contents('./settings.json'), true)),
            \RecursiveIteratorIterator::SELF_FIRST);
        
        foreach ($jsonIterator as $key => $value) {
            array_push($this->options, [$key => $value]);
        }
        
        $this->migration = json_decode(file_get_contents('./migration.json'));

        foreach ($this->migration->tables as $element) {
            $top = 'CREATE TABLE ';
            $sql = '';

           foreach ($element as $key => $value) {
               if($value == 'TABLE_NAME')
                $top .= $key.' (';
               else {
                   $sql .= $key.' '.$value.', ';
               }
           }

           $sql = substr($sql, 0, -2);

           $sql .= ");";
           array_push($this->sqls, $top.$sql);
        }
        
    }

    public function migrate() {
        $this->makePDO();

        foreach ($this->sqls as $value) {
            $this->pdo->query($value);
        }
    }
}