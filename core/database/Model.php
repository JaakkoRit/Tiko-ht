<?php

namespace App\Core\Database;

use App\Core\App;

abstract class Model
{
	protected static $primaryKey = 'id';
	protected static $tableName = NULL;

	private static function getTableName() {
		if(is_null(static::$tableName)) {
			return lcfirst(substr(strrchr(get_called_class(), "\\"), 1));
		}

		return static::$tableName;
	}
	public static function selectFrom($table, $selectFields){
	    return "SELECT $selectFields FROM $table";
    }
    public static function selectColumnNames($table){
        return "SELECT `COLUMN_NAME` 
                FROM `INFORMATION_SCHEMA`.`COLUMNS` 
                WHERE `TABLE_SCHEMA`='tiko' 
                AND `TABLE_NAME`='$table'";
    }
    public static function rawQuery($query){
        return App::get('database')
            ->query($query)
            ->getAll(get_called_class());
    }

	public static function all($fields = [])
	{
		$selectFields = '*';
		if(count($fields) > 0) {
			$selectFields = implode(', ', $fields);
		}

		return App::get('database')
			->query("SELECT $selectFields FROM " . static::getTableName())
			->getAll(get_called_class());
	}

	public static function find($id)
	{
		return App::get('database')
			->query("SELECT * FROM "
				. static::getTableName()
				. " WHERE " . static::$primaryKey . " = :id")
			->bind(':id', $id)
			->getOne(get_called_class());
	}

    public static function findWhere($field, $value)
	{
		return App::get('database')
			->query("SELECT * FROM "
				. static::getTableName()
				. " WHERE " . $field . " = :id")
			->bind(':id', $value)
			->getOne(get_called_class());
	}

    public static function findTaskCompletion($field, $value, $field2, $value2)
    {
        return App::get('database')
            ->query("SELECT * FROM "
                . static::getTableName()
                . " WHERE " . $field . " = :id"
                . " AND " . $field2 . " = :id2")
            ->bind(':id', $value)
            ->bind(':id2', $value2)
            ->getOne(get_called_class());
    }

    public static function findAllAttempts($field, $value, $field2, $value2)
    {
        return App::get('database')
            ->query("SELECT * FROM "
                . static::getTableName()
                . " WHERE " . $field . " = :id"
                . " AND " . $field2 . " = :id2")
            ->bind(':id', $value)
            ->bind(':id2', $value2)
            ->getAll(get_called_class());
    }

    public static function findAllWhere($field, $value)
    {
        return App::get('database')
            ->query("SELECT * FROM "
                . static::getTableName()
                . " WHERE " . $field . " = :id")
            ->bind(':id', $value)
            ->getAll(get_called_class());
    }

    public static function findAllTasksFromTaskList($value)
    {
        return App::get('database')
            ->query("SELECT T.ID_TEHTAVA, T.ID_KAYTTAJA, T.LUOMPVM, T.KYSELYTYYPPI, T.KUVAUS"
                . " FROM TEHTAVA T, TEHTAVALISTA TL, TEHTAVALISTANTEHTAVA TLT"
                . " WHERE T.ID_TEHTAVA = TLT.ID_TEHTAVA AND TLT.ID_TLISTA = TL.ID_TLISTA"
                . " AND TL.ID_TLISTA = :id"
                . " ORDER BY T.ID_TEHTAVA ASC")
            ->bind(':id', $value)
            ->getAll(get_called_class());
    }

	public static function create($data)
	{
		$fieldNames = implode(', ', array_keys($data));
		$bindNames = ':' . implode(', :', array_keys($data));

		$statement = App::get('database')
			->query('INSERT INTO '
				. static::getTableName()
				. ' ('.$fieldNames.') VALUES (' . $bindNames .')');

		foreach($data as $key => $value) {
			$statement->bind(':'.$key, $value);
		}

		$statement->execute();

		return App::get('database')->lastInsertId();
	}

	public static function delete($id)
	{
		App::get('database')
			->query('DELETE FROM '
				. static::getTableName()
				. ' WHERE ' . static::$primaryKey . ' = :id')
			->bind(':id', $id)
			->execute();
	}

	public static function update($id, $data)
	{
		$sql = 'UPDATE ' . static::getTableName() . ' SET ';
		foreach($data as $key => $value) {
			$sql .= $key . ' = :' . $key . ', ';
		}
		$sql = substr($sql, 0, -2);
		$sql .= ' WHERE ' . static::$primaryKey . ' = :id';
		$statement = App::get('database')
			->query($sql);

		$statement->bind(':id', $id);
		foreach($data as $key => $value) {
			$statement->bind(':'.$key, $value);
		}

		$statement->execute();
	}

    public static function updateTaskCompletion($idTask, $idSession, $time)
    {
        $sql = 'UPDATE ' . static::getTableName() . ' SET ';
        $sql .= 'LOPAIKA = :time';
        $sql .= ' WHERE ID_TEHTAVA = :id';
        $sql .= ' AND ID_SESSIO = :id2';
        $statement = App::get('database')
            ->query($sql);
        $statement->bind(':time', $time);
        $statement->bind(':id', $idTask);
        $statement->bind(':id2', $idSession);
        $statement->execute();
    }

	public function destroy()
	{
		App::get('database')
			->query('DELETE FROM '
				. static::getTableName()
				. ' WHERE ' . static::$primaryKey . ' = :id')
			->bind(':id', $this->id)
			->execute();
	}
}