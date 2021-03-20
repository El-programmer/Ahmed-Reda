<?php

namespace PHPMVC\Models;

use PHPMVC\Models\QuestionModel;

class MarkModel extends AbstractModel
{
    public $id;
    public $tittle;
    public $image;
    public $text;

// CHAPTER_ID CHAPTER_NAME


    public static $tableName = 'car_marks';
    protected static $tableSchema = array(
        'tittle' => self::DATA_TYPE_STR,
        'image' => self::DATA_TYPE_STR,
        'text' => self::DATA_TYPE_STR,
    );

    protected static $primaryKey = 'id';

    public static function isunque($tittle , $id = 0 ){
        if ($id == 0)
            return self::get('SELECT * FROM ' . self::$tableName . ' WHERE  tittle = "' .$tittle  . '" ' );

        return self::get('SELECT * FROM ' . self::$tableName . ' WHERE  tittle = "' .$tittle  . '" AND id !='.$id .' ;' );

    }
    public function getmodels(){

        return ModalModel::getBy(['marke_id' => $this->id]);
    }


}
