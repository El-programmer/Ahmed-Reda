<?php

namespace PHPMVC\Models;

use PHPMVC\Models\QuestionModel;

class ModalModel extends AbstractModel
{
    public $name;
    public $marke_id;
    public $text;
    public $images;

// CHAPTER_ID CHAPTER_NAME


    public static $tableName = 'car_modals';
    protected static $tableSchema = array(
        'name' => self::DATA_TYPE_STR,
        'text' => self::DATA_TYPE_STR,
        'marke_id' => self::DATA_TYPE_INT,
        'images' => self::DATA_TYPE_STR,
        'price' => self::DATA_TYPE_DECIMAL,
    );

    protected static $primaryKey = 'id';


    public static function isunque($tittle , $id = 0 ){
        if ($id == 0)
            return self::get('SELECT * FROM ' . self::$tableName . ' WHERE  name = "' .$tittle  . '" ' );

        return self::get('SELECT * FROM ' . self::$tableName . ' WHERE  name = "' .$tittle  . '" AND id !='.$id .' ;' );

    }


    public static function getModels($id = 0){

        $condtion = "";
        if($id > 0 ){
            $condtion = " AND  marke.id = ".$id;
        }
        return self::get('SELECT * FROM ' . self::$tableName . ' model , '. MarkModel::$tableName .' marke WHERE model.marke_id = marke.id ' . $condtion );
    }
    public static function getModelsonly($id = 0){

        $condtion = "";
        if($id > 0 ){
            $condtion = " WHERE marke_id = ".$id;
        }
        return self::get('SELECT * FROM ' . self::$tableName . ' model ' . $condtion );
    }

    public function marke()
    {
        if (!isset($this->marke))
            $this->marke = MarkModel::getByPK($this->marke_id);
        return $this->marke;
    }


}
