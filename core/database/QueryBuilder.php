<?php

namespace App\Core\Database;

class QueryBuilder {

	protected $pdo;
	protected $statement;

	// Dependency injection pattern
	public function __construct(\PDO $pdo) {
		$this->pdo = $pdo;
	}

	public function query($query) {
		$this->statement = $this->pdo->prepare($query);
		return $this;
	}

	public function bind($param, $value, $type = null)
	{
		if(is_null($type)) {
			switch (true) {
				case is_int($value):
					$type = \PDO::PARAM_INT;
					break;
				case is_bool($value):
					$type = \PDO::PARAM_BOOL;
					break;
				case is_null($value):
					$type = \PDO::PARAM_NULL;
					break;
				default:
					$type = \PDO::PARAM_STR;
			}
		}
		$this->statement->bindValue($param, $value, $type);
		return $this;
	}

	public function execute() {
		return $this->statement->execute();
	}

	public function getAll($asClass) {
		$this->execute();
		return $this->statement->fetchAll(\PDO::FETCH_CLASS, $asClass);
	}

	public function getOne($asClass) {
		$this->execute();
		$this->statement->setFetchMode(\PDO::FETCH_CLASS, $asClass);
		return $this->statement->fetch();
	}

	public function rowCount() {
		return $this->statement->rowCount();
	}

	public function lastInsertId() {
		return $this->pdo->lastInsertId();
	}
}