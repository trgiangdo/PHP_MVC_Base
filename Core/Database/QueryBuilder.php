<?php

namespace Core\Database;

use \Core\Database\Query;
use \Core\Database\Connection;

class QueryBuilder extends Query
{
    private static $QBInstance;

    protected $pdo;

    private function __construct($table)
    {
        Query::__construct();
        echo "Constructor";
        $this->setTable($table);
        $this->pdo = Connection::create();
    }

    public static function table($table)
    {
        if ( is_null( self::$QBInstance ) ){
          self::$QBInstance = new self($table);
        }

        return self::$QBInstance;
    }

    private function execute()
    {
        $this->buildQuery();

        try {
            $statement = $this->pdo->prepare($this->query);

            $statement->execute();

        } catch(PDOException $pdoErr) {

            echo '<p class="error">'.$pdoErr->getMessage().'</p>';

        }

        return $statement;
    }

    public function get()
    {
        return $this->execute()->fetchAll();
    }

    public function select($column)
    {
        $this->setSelect($column);

        return $this;
    }

    public function where(...$arguments)
    {
        if(sizeof($arguments) == 1 and is_array($arguments[0])){
                $conditions = $arguments;
        } else {
            $conditions = [];
            foreach($arguments as $arg){
                array_push($conditions, $arg);
            }
            if(!in_array($arguments[1], $this->allowedComparisonOperator)){
                array_splice($conditions, 0, 1, [$arguments[0], '=']);
            }
        }

        $this->setWhere($conditions);

        return $this;
    }

    public function join($table, ...$conditions)
    {
        $this->setJoin($table, $conditions);

        return $this;
    }

    public function countRows($table)
    {
        $nRows = $this->pdo->query("select count(*) from {$table}")->fetchColumn();

        return $nRows;
    }

    public function delete($table, $parameters)
    {
        $subQuery = (function() use($parameters) {
            $subQuery = "";
            foreach ($parameters as $columnName => $value) {
                $subQuery .= "{$columnName} = :{$columnName}, ";
            }
            return trim($subQuery, ", ");
        })();

        $this->exec("delete from {$table} where {$subQuery}");
    }

    public function insert($table, $parameters)
    {
        $query = sprintf(
            'insert into %s (%s) values (%s)',
            $table,
            implode(', ', array_keys($parameters)),
            ':' . implode(', :', array_keys($parameters))
        );

        $this->exec($query);
    }

    public function update($table, $id, $parameters)
    {
        $subQuery = (function() use($parameters) {
            $subQuery = "";
            foreach ($parameters as $columnName => $value) {
                $subQuery .= "{$columnName} = :{$columnName}, ";
            }
            return trim($subQuery, ", ");
        })();

        $query = "update {$table} set {$subQuery} where {$table}Id = {$id}";

        $this->exec($query);
    }
}