<?php

namespace PHPMVC\Controllers;

use PHPMVC\Models\MarkModel;
use PHPMVC\Models\ModalModel;
use PHPMVC\Models\PostModel;
use PHPMVC\Models\userModel;

class Post extends AbstractController
{

    public function defaultAction()
    {
        $this->language->load('template.commen');
        $this->language->load('index.default');
        $this->_data['brands'] = MarkModel::getAll();
        $this->_data['posts'] = PostModel::paginate(12);
        $this->_view();
    }
    public function aboutAction()
    {
        $this->_language->load('template.commen');
        $this->_language->load('index.default');
        $this->_view();
    }
    public function contactAction()
    {
        $this->_language->load('template.commen');
        $this->_language->load('index.default');
        $this->_view();
    }


}