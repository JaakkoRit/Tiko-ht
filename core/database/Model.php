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

    public static function rawQuery($query) {
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

    public static function deleteWhere($field, $id)
    {
        App::get('database')
            ->query('DELETE FROM '
                . static::getTableName()
                . ' WHERE ' . $field . ' = :id')
            ->bind(':id', $id)
            ->execute();
    }

    public static function deleteTaskInTaskList($tlista, $tehtava)
    {
        App::get('database')
            ->query('DELETE FROM '
                . static::getTableName()
                . ' WHERE ID_TLISTA = :tlista'
                . ' AND ID_TEHTAVA = :tehtava')
            ->bind(':tlista', $tlista)
            ->bind(':tehtava', $tehtava)
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

    public static function findTaskInTaskList($tlista, $tehtava)
    {
        return App::get('database')
            ->query("SELECT ID_TLISTA, ID_TEHTAVA"
                . " FROM TEHTAVALISTANTEHTAVA"
                . " WHERE ID_TLISTA = :tlista"
                . " AND ID_TEHTAVA = :tehtava")
            ->bind(':tlista', $tlista)
            ->bind(':tehtava', $tehtava)
            ->getOne(get_called_class());
	}

    public static function updateWhere($field, $id, $data)
    {
        $sql = 'UPDATE ' . static::getTableName() . ' SET ';
        foreach($data as $key => $value) {
            $sql .= $key . ' = :' . $key . ', ';
        }
        $sql = substr($sql, 0, -2);
        $sql .= " WHERE $field = :id";
        $statement = App::get('database')
            ->query($sql);
        $statement->bind(':id', $id);
        foreach($data as $key => $value) {
            $statement->bind(':'.$key, $value);
        }

        $statement->execute();
    }

    public static function updateWhereAnd($field, $id, $field2, $id2, $data)
    {
        $sql = 'UPDATE ' . static::getTableName() . ' SET ';
        foreach($data as $key => $value) {
            $sql .= $key . ' = :' . $key . ', ';
        }
        $sql = substr($sql, 0, -2);
        $sql .= " WHERE $field = :id";
        $sql .= " AND $field2 = :id2";
        $statement = App::get('database')
            ->query($sql);
        $statement->bind(':id', $id);
        $statement->bind(':id2', $id2);
        foreach($data as $key => $value) {
            $statement->bind(':'.$key, $value);
        }
        $statement->execute();
    }

    public static function deleteAnswer($id, $answer)
    {
        App::get('database')
            ->query('DELETE FROM '
                . static::getTableName()
                . ' WHERE ID_TEHTAVA = :id'
                . ' AND VASTAUS = :vastaus')
            ->bind(':id', $id)
            ->bind(':vastaus', $answer)
            ->execute();
    }

    public static function findStudentsWhoHaveDoneUsersSession($id)
    {
        return App::get('database')
            ->query("SELECT DISTINCT O.ID_KAYTTAJA, O.ONRO, O.NIMI, O.PAAAINE, O.SALASANA"
                . " FROM OPISKELIJA O, SESSIO S"
                . " WHERE O.ID_KAYTTAJA = S.ID_KAYTTAJA"
                . " AND S.ID_LUOJA = :id"
                . " AND S.LOPAIKA IS NOT NULL")
            ->bind(':id', $id)
            ->getAll(get_called_class());
    }

    public static function findAllCompletedSessions($field, $value)
    {
        return App::get('database')
            ->query("SELECT * FROM SESSIO"
                . " WHERE " . $field . " = :id"
                . " AND LOPAIKA IS NOT NULL")
            ->bind(':id', $value)
            ->getAll(get_called_class());
    }

    public static function createSchema($id)
    {
        App::get('database')
            ->query(
                "CREATE SCHEMA ESIMTAULUT$id"
            )
            ->execute();
    }

    public static function createExampleTables($id)
    {
        App::get('database')
            ->query("CREATE TABLE esimtaulut$id.kurssit ("
                . "id INT,"
                . "nimi VARCHAR(15) NOT NULL,"
                . "opettaja VARCHAR(15) NOT NULL,"
                . "PRIMARY KEY (id))")
            ->execute();

        App::get('database')
            ->query("CREATE TABLE esimtaulut$id.opiskelijat ("
                . "nro INT,"
                . "nimi VARCHAR(15) NOT NULL,"
                . "p_aine VARCHAR(15) NOT NULL,"
                . "PRIMARY KEY (nro))")
            ->execute();

        App::get('database')
            ->query("CREATE TABLE esimtaulut$id.suoritukset ("
                . "k_id INT,"
                . "op_nro INT NOT NULL,"
                . "arvosana INT NOT NULL,"
                . "PRIMARY KEY (k_id, op_nro),"
                . "FOREIGN KEY(k_id) REFERENCES kurssit,"
                . "FOREIGN KEY(op_nro) REFERENCES opiskelijat)")
            ->execute();
    }

    public static function insertExampleValues($id)
    {
        $db = App::get('database');
        $db->query(
                "INSERT INTO esimtaulut$id.opiskelijat VALUES (1, 'Maija', 'TKO');"
                ." INSERT INTO esimtaulut$id.opiskelijat VALUES (2, 'Ville', 'TKO');"
                ." INSERT INTO esimtaulut$id.opiskelijat VALUES (3, 'Kalle', 'VT');"
                ." INSERT INTO esimtaulut$id.opiskelijat VALUES (4, 'Liisa', 'VT');"
            )
            ->execute();

        $db->query(
                "INSERT INTO esimtaulut$id.kurssit VALUES (1, 'tkp', 'KI');"
                ." INSERT INTO esimtaulut$id.kurssit VALUES (2, 'oope', 'JL');"
                ." INSERT INTO esimtaulut$id.kurssit VALUES (3, 'tiko', 'MJ');"
            )
            ->execute();

        $db->query(
                "INSERT INTO esimtaulut$id.suoritukset VALUES (1, 1, 5);"
                ." INSERT INTO esimtaulut$id.suoritukset VALUES (1, 2, 4);"
                ." INSERT INTO esimtaulut$id.suoritukset VALUES (1, 3, 2);"
                ." INSERT INTO esimtaulut$id.suoritukset VALUES (2, 1, 5);"
                ." INSERT INTO esimtaulut$id.suoritukset VALUES (2, 2, 3);"
                ." INSERT INTO esimtaulut$id.suoritukset VALUES (2, 4, 3);"
                ." INSERT INTO esimtaulut$id.suoritukset VALUES (3, 1, 5);"
                ." INSERT INTO esimtaulut$id.suoritukset VALUES (3, 2, 4);"
            )
            ->execute();
    }

    public static function setSearchPathTo($path)
    {
        App::get('database')
            ->query("USE $path")
            ->execute();
    }

    public static function dropSchema($id)
    {
        App::get('database')
            ->query("DROP SCHEMA esimtaulut$id")
            ->execute();
    }
}