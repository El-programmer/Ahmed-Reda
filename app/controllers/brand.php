<?php

namespace PHPMVC\Controllers;

use PHPMVC\Models\MarkModel;
use PHPMVC\Models\ModalModel;
use PHPMVC\Models\PostModel;
use PHPMVC\Models\userModel;

class Brand extends AbstractController
{

    public function defaultAction()
    {
        // show all prands
        $this->language->load('template.commen');
        $this->language->load('index.default');
        $this->_data['brandsTomodel'] = MarkModel::getAll();
        $this->_data['brands'] = MarkModel::paginate(12);
        $u = new userModel();
        $this->_view();
    }

    public function modelsAction()
    {
        // show all modals
        $this->language->load('template.commen');
        $this->language->load('index.default');
        $this->_data['brands'] = MarkModel::getAll();
//        if (!isset($this->_param[0]))
//            $this->redirect('/');

        if (isset($this->_param[0]) && $this->_param[0] > 0){
            $this->_data['models'] = ModalModel::paginate(12, ['marke_id' => $this->_param[0]]);
        $this->_data['mybrand'] = MarkModel::getByPK($this->_param[0]);
    }
        else
            $this->_data['models'] = ModalModel::paginate(12);

        $this->_view();
    }
    // showmodel
    public function showmodelAction()
    {
        $this->language->load('template.commen');
        $this->language->load('index.default');

        if (!isset($this->_param[0]) || $this->_param[0] <= 0)
            $this->redirect("/notfound");
        $id = $this->_param[0];
        $this->_data['mymodel'] = ModalModel::getByPK($id);
        $this->_data['mybrand'] = MarkModel::getByPK($this->_data['mymodel']->marke_id);
        $this->_data['title'] = $this->_data['mymodel']->name;
        $this->_data['samemodel'] = PostModel::getBy(['modal_id' => $this->_data['mymodel']->id , 'available' => 1 ]);

        if ($this->_data['samemodel'] == false || sizeof($this->_data['samemodel']) < 10 )
            $this->_data['sameprice'] = PostModel::paginateSQL( "SELECT p.id , p.user_id ,p.tittle ,p.state ,p.images , m.name , p.price   , abs( ". $this->_data['mymodel']->price ."- p.price  ) as diff FROM `car_posts` p , `car_modals` m ,`car_users` u WHERE u.id = p.user_id AND m.id = p.modal_id ORDER by diff " , 12 , "SELECT count(*) FROM `car_posts` p , `car_modals` m ,`car_users` u WHERE u.id = p.user_id AND m.id = p.modal_id" );
        else{
            $this->_data['sameprice'] = false;
            $this->_data['samemodel'] = PostModel::paginate(12 , ['modal_id' => $this->_data['mymodel']->id , 'available' => 1 ]);
        }
        $this->_view();
    }



}