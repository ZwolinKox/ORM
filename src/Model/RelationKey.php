<?php

namespace ORM\Model;

class RelationKey {

    public $tableName;
    public $leftSideField;
    public $rightSideField;
    public $relationType;

    public function __construct($tableName, $leftSideField, $rightSideField, $relationType="INNER JOIN") {
        $this->tableName = $tableName;
        $this->leftSideField = $leftSideField;
        $this->rightSideField = $rightSideField;
        $this->relationType = $relationType;
    }
}