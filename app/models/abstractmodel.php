<?php

namespace PHPMVC\Models;

use PHPMVC\Lib\Database\DatabaseHandler;

class AbstractModel
{
    const DATA_TYPE_BOOL = \PDO::PARAM_BOOL;
    const DATA_TYPE_STR = \PDO::PARAM_STR;
    const DATA_TYPE_INT = \PDO::PARAM_INT;
    const DATA_TYPE_DECIMAL = 4;
    const DATA_TYPE_DATE = 5;
    const VALIDATE_DATE_STRING = '/^[1-2][0-9][0-9][0-9]-(?:(?:0[1-9])|(?:1[0-2]))-(?:(?:0[1-9])|(?:(?:1|2)[0-9])|(?:3[0-1]))$/';
    const VALIDATE_DATE_NUMERIC = '^\d{6,8}$';
    const DEFAULT_MYSQL_DATE = '1970-01-01';
    private static $db;

    private function prepareValues(\PDOStatement &$stmt)
    {
        foreach (static::$tableSchema as $columnName => $type) {
            if ($type == 4) {
                $sanitizedValue = filter_var($this->$columnName, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                $stmt->bindValue(":{$columnName}", $sanitizedValue);
            } else {
                $stmt->bindValue(":{$columnName}", $this->$columnName, $type);
            }
        }
    }

    private function buildNameParametersSQL()
    {
        $namedParams = '';
        foreach (static::$tableSchema as $columnName => $type) {
            $namedParams .= $columnName . ' = :' . $columnName . ', ';
        }
        return trim($namedParams, ', ');
    }

    private function create()
    {
        $sql = 'INSERT INTO ' . static::$tableName . ' SET ' . $this->buildNameParametersSQL();
        $stmt = DatabaseHandler::factory()->prepare($sql);
        $this->prepareValues($stmt);
        if ($stmt->execute()) {
            $this->{static::$primaryKey} = DatabaseHandler::factory()->lastInsertId();
            return true;
        }
        return false;
    }

    private function update()
    {
        $sql = 'UPDATE ' . static::$tableName . ' SET ' . $this->buildNameParametersSQL() . ' WHERE ' . static::$primaryKey . ' = ' . $this->{static::$primaryKey};
        $stmt = DatabaseHandler::factory()->prepare($sql);
        $this->prepareValues($stmt);
        return $stmt->execute();
    }

    public function save($primaryKeyCheck = true)
    {
        if (false === $primaryKeyCheck) {
            return $this->create();
        }
        return $this->{static::$primaryKey} === null ? $this->create() : $this->update();
    }

    public function delete()
    {
        $sql = 'DELETE FROM ' . static::$tableName . '  WHERE ' . static::$primaryKey . ' = ' . $this->{static::$primaryKey};
        $stmt = DatabaseHandler::factory()->prepare($sql);
        return $stmt->execute();
    }

    public static function getAll()
    {
        $sql = 'SELECT * FROM ' . static::$tableName;
        $stmt = DatabaseHandler::factory()->prepare($sql);
        $stmt->execute();
        if (method_exists(get_called_class(), '__construct')) {
            $results = $stmt->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, get_called_class(), array_keys(static::$tableSchema));
        } else {
            $results = $stmt->fetchAll(\PDO::FETCH_CLASS, get_called_class());
        }
        if ((is_array($results) && !empty($results))) {
            return new \ArrayIterator($results);
        };
        return false;
    }

    public static function getByPK($pk)
    {
        $sql = 'SELECT * FROM ' . static::$tableName . '  WHERE ' . static::$primaryKey . ' = "' . $pk . '"';
        $stmt = DatabaseHandler::factory()->prepare($sql);
        if ($stmt->execute() === true) {
            if (method_exists(get_called_class(), '__construct')) {
                $obj = $stmt->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, get_called_class(), array_keys(static::$tableSchema));
            } else {
                $obj = $stmt->fetchAll(\PDO::FETCH_CLASS, get_called_class());
            }
            return !empty($obj) ? array_shift($obj) : false;
        }
        return false;
    }

    public static function getBy($columns, $options = array() , $orderWord = "")
    {
        $whereClauseColumns = array_keys($columns);
        $whereClauseValues = array_values($columns);
        $whereClause = [];
        for ($i = 0, $ii = count($whereClauseColumns); $i < $ii; $i++) {
            $whereClause[] = $whereClauseColumns[$i] . ' = "' . $whereClauseValues[$i] . '"';
        }
        $whereClause = implode(' AND ', $whereClause);
        $sql = 'SELECT * FROM ' . static::$tableName . '  WHERE ' . $whereClause;
        return static::get($sql, $options , $orderWord);
    }

    public static function get($sql, $options = array() , $orderWord = "")
    {
        $sql .=' '.$orderWord;
        $stmt = DatabaseHandler::factory()->prepare($sql);
//        var_dump($sql);
        if (!empty($options)) {
            foreach ($options as $columnName => $type) {
                if ($type[0] == 4) {
                    $sanitizedValue = filter_var($type[1], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                    $stmt->bindValue(":{$columnName}", $sanitizedValue);
                } elseif ($type[0] == 5) {
                    if (!preg_match(self::VALIDATE_DATE_STRING, $type[1]) || !preg_match(self::VALIDATE_DATE_NUMERIC, $type[1])) {
                        $stmt->bindValue(":{$columnName}", self::DEFAULT_MYSQL_DATE);
                        continue;
                    }
                    $stmt->bindValue(":{$columnName}", $type[1]);
                } else {
                    $stmt->bindValue(":{$columnName}", $type[1], $type[0]);
                }
            }
        }

        $stmt->execute();
        if (method_exists(get_called_class(), '__construct')) {
            $results = $stmt->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, get_called_class(), array_keys(static::$tableSchema));
        } else {
            $results = $stmt->fetchAll(\PDO::FETCH_CLASS, get_called_class());
        }
        if ((is_array($results) && !empty($results))) {
            return new \ArrayIterator($results);
        };
        return false;
    }

    public static function getOne($sql, $options = array())
    {
        $result = static::get($sql, $options);

        return $result === false ? false : $result->current();
    }

    public static function getModelTableName()
    {
        return static::$tableName;
    }

//    public function __get($attr){
//        return $this->$attr;
//    }

    public function __set($attr, $value)
    {
        $this->$attr = $value;
    }

    public function setvalue($array)
    {
        foreach ($array as $key => $value) {
            if ($value != '') {
                $this->$key = $value;
            }
        }
    }


    public function __get($attr)
    {

        if (isset($this->$attr)) {
            return $this->$attr;
        } elseif (method_exists(static::class, $attr)) {

            return $this->$attr();
        }
    }


    static function paginate($number = 10 , array  $array = [] , $order = ""){
        $page = 1;
        $condtion = "";
        if (!empty($array)){
            $condtion = " WHERE ";
            $i = 0 ;
            foreach ($array as $key => $value){
                if ($i > 0){
                    $condtion .=" AND ";
                }
                $condtion .=  $key .' = "' . $value .'" ' ;
                $i++;
            }
        }
        if ( !isset($_GET['page']) || !is_numeric($_GET['page']))
            $_GET['page'] = 1;
        $stmt = DatabaseHandler::factory()->prepare("SELECT COUNT(*) FROM ".static::$tableName .$condtion );
        $stmt->execute();
        $count = $stmt->fetch()[0];
        $_GET['totalpages'] = (int) ($count / $number);
        if (( $count % $number ) > 0 )
            $_GET['totalpages'] += 1;

        if ($count <= $_GET['totalpages']  )
            $_GET['page'] = 1;
        $limitstart = ($_GET['page'] -1) * $number ;
        $limitend = $limitstart + $number;

        if ($order == "")
            $order = static::$primaryKey;
        $sql = 'SELECT * FROM ' . static::$tableName.$condtion . "  ORDER BY " . $order ." DESC  LIMIT $limitstart , $limitend ";

        $stmt = DatabaseHandler::factory()->prepare($sql );
        $stmt->execute();

        if (method_exists(get_called_class(), '__construct')) {
            $results = $stmt->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, get_called_class(), array_keys(static::$tableSchema));
        } else {
            $results = $stmt->fetchAll(\PDO::FETCH_CLASS, get_called_class());
        }
        if ((is_array($results) && !empty($results))) {
            return new \ArrayIterator($results);
        };
        return false;
    }

    static function paginateSQL($sql , $number , $sqlcount){
        $page = 1;
        $condtion = "";
        if ( !isset($_GET['page']) || !is_numeric($_GET['page']))
            $_GET['page'] = 1;
        $stmt = DatabaseHandler::factory()->prepare($sqlcount );
        $stmt->execute();
        $count = $stmt->fetch()[0];
        $_GET['totalpages'] = (int) ($count / $number);
        if (( $count % $number ) > 0 )
            $_GET['totalpages'] += 1;

        if ($count <= $_GET['totalpages']  )
            $_GET['page'] = 1;
        if ($_GET['totalpages'] > 10 )
            $_GET['totalpages'] = 10;
        $limitstart = ($_GET['page'] -1) * $number ;
        $limitend = $limitstart + $number;

//        $sql = 'SELECT * FROM ' . static::$tableName.$condtion . "  ORDER BY " . static::$primaryKey ." DESC  LIMIT $limitstart , $limitend ";

        $stmt = DatabaseHandler::factory()->prepare($sql ."LIMIT  $limitstart , $limitend " );
        $stmt->execute();
        if (method_exists(get_called_class(), '__construct')) {
            $results = $stmt->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, get_called_class(), array_keys(static::$tableSchema));
        } else {
            $results = $stmt->fetchAll(\PDO::FETCH_CLASS, get_called_class());
        }
        if ((is_array($results) && !empty($results))) {
            return new \ArrayIterator($results);
        };
        return false;
    }


}
