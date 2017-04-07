<?php

namespace App\App\Models;

use App\Core\Database\Model;

class Task extends Model
{
	protected static $tableName = 'task';

	public $description;
	public $completed;
	public $id;

	public function isCompleted()
	{
		return $this->completed;
	}

	public function complete()
	{
		$this->completed = true;
	}
}