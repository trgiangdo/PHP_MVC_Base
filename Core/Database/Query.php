<?php

namespace Core\Database;

class Query
{

	protected $query;
	protected $table;
	protected $selectCol;
	protected $whereClause;
	protected $limitClause;
	protected $joinClause;

	protected $count;
	protected $average;
	protected $min;
	protected $max;
	protected $sum;

	protected $allowedComparisonOperator;

	public function __construct()
	{
		$this->query = "";
		$this->count = FALSE;
		$this->average = FALSE;
		$this->min = FALSE;
		$this->max = FALSE;
		$this->sum = FALSE;

		$this->joinClause = [];

		$this->allowedComparisonOperator = [
			'=', '>', '<', '>=', '<=', '!=', '<>',
			'like', 'in', 'between', 'not in', 'not between', 'not like',
			'and', 'or'
		];

		$this->selectCol = "*";
	}

	protected function buildQuery()
	{
		if(!isset($this->table)){
			throw new Exception('No table specified.');
		}

		if($this->count){
			$this->query = "select count({$this->selectCol}) from {$this->table}";
		} elseif($this->average){
			$this->query = "select average({$this->selectCol}) from {$this->table}";
		} elseif($this->sum){
			$this->query = "select sum({$this->selectCol}) from {$this->table}";
		} elseif($this->min){
			$this->query = "select min({$this->selectCol}) from {$this->table}";
		} elseif($this->max){
			$this->query = "select max({$this->selectCol}) from {$this->table}";
		} else{
			$this->query = "select {$this->selectCol} from {$this->table}";
		}

		if(!empty($this->joinClause)){
			$joinClause = trim(implode(", ", $this->joinClause), ',');

			$this->query .= $joinClause;
		}

		if(isset($this->whereClause)){
			if(is_array($this->whereClause)){
				$this->whereClause = implode(" and ", $this->whereClause);
			}
			$this->query .= ' where ' . $this->whereClause;
		}

		if(isset($this->limitClause)){
			$this->query .= $this->limitClause;
		}

	}

	protected function setTable($table)
	{
		$this->table = $table;
	}

	protected function setSelect($column="*")
	{
		if(is_array($column)){
            $selectCol = implode(', ', $column);
            $selectCol = trim($selectCol, ", ");
        } else {
            $selectCol = $column;
        }

        $this->selectCol = $selectCol;
	}

	protected function setWhere($conditions)
	{
		
		if(is_array($conditions[0])){
			$this->whereClause = [];
			foreach($conditions[0] as $condition){	
				$condition[2] = "'" . $condition[2] . "'";			
				$this->whereClause[] = implode(' ', $condition);

			}
		}else {
			$conditions[2] = "'" . $conditions[2] . "'";
			$this->whereClause = implode(' ', $conditions);
		}
	}

	protected function setJoin($table, $conditions, $typeOfJoin='inner')
	{
		$subQuery = implode(' ', $conditions);
		$this->joinClause[] = " {$typeOfJoin} join {$table} on {$subQuery}";
	}

}