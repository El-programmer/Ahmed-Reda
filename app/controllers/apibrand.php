<?php

namespace PHPMVC\Controllers;

use PHPMVC\lib\FileUpload;
use PHPMVC\LIB\Inputfilter;
use PHPMVC\Lib\Validate;
use PHPMVC\Lib\Messenger;
use PHPMVC\Models\userModel;
use PHPMVC\Models\MarkModel;
use PHPMVC\Models\ModalModel;


class Apibrand extends AbstractController
{
    use Validate;
    use Inputfilter;


    public function defaultAction()
    {

        $this->language->load("admincars.labels");
        $this->language->load("admincars.messages");

    }

    public function brandallAction()
    {
        $brand = MarkModel::getAll();
        $this->_viewajax($brand );

    }
    public function brandAction()
    {
        $brand = MarkModel::getAll();
        $this->_viewajax($brand );

    }

// modelsonly
    public function modelsonlyAction()
    {

        if (isset($this->_param[0]) && $this->_param[0] > 0){
            $this->_param[0] =  $this->filterInt($this->_param[0]);
        }else
            $this->_viewText(json_encode([]));

        $models =  ModalModel::getModelsonly($this->_param[0]);
        if ($models == false)
            $models = [];
        $this->_viewText(json_encode($models));
    }

    public function modelsallAction()
    {

        if (isset($this->_param[0]) && $this->_param[0] > 0){
            $this->_param[0] =  $this->filterInt($this->_param[0]);
        }else
            $this->_param[0] = 0;

        $models =  ModalModel::getModels($this->_param[0]);
        if ($models == false)
            $models = [];
        $this->_viewText(json_encode($models));
    }
    public function modelAction()
    {
        $models = [];
        if (isset($this->_param[0]) && $this->_param[0] > 0){
            $this->_param[0] =  $this->filterInt($this->_param[0]);
        }else
            $this->_viewText(json_encode([$models]));


        $models =  ModalModel::getByPK($this->_param[0]);
//        if ($models == false)
//            $this->_viewText(json_encode($models));
        $this->_viewText(json_encode($models));
    }


}

