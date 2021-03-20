<?php

namespace PHPMVC\Models;


class PostModel extends AbstractModel
{
    public $user_id;
    public $tittle;
    public $modal_id;
    public $text ;
    public $active = 1 ;
    public $state ;
    public $price ;
    public $images ;
    public $available = 1 ;

// CHAPTER_ID CHAPTER_NAME


    public static $tableName = 'car_posts';
    protected static $tableSchema = array(
        'user_id' => self::DATA_TYPE_INT,
        'tittle' => self::DATA_TYPE_STR,
        'modal_id' => self::DATA_TYPE_INT,
        'price' => self::DATA_TYPE_INT,
        'text' => self::DATA_TYPE_STR,
        'active' => self::DATA_TYPE_INT,
        'state' => self::DATA_TYPE_INT,
        'available' => self::DATA_TYPE_INT,
        'images' => self::DATA_TYPE_STR,
    );

    protected static $primaryKey = 'id';


    public function model()
    {
        if (!isset($this->model))
            $this->model = ModalModel::getByPK($this->marke_id);
        return $this->model;
    }

    public function user()
    {
        if (!isset($this->user))
            $this->user = userModel::getByPK($this->user_id);
        return $this->user;
    }

    public function marke()
    {
        if (!isset($this->marke)){}
            $this->marke = MarkModel::getByPK($this->model()->id);
        return $this->marke;
    }


}
