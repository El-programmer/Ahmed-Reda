<?php

namespace PHPMVC\Controllers;

use PHPExcel_IOFactory;
use PHPMVC\lib\FileUpload;
use PHPMVC\LIB\Inputfilter;
use PHPMVC\Lib\Validate;
use PHPMVC\Lib\Messenger;
use PHPMVC\Models\userModel;
use PHPMVC\Models\MarkModel;
use PHPMVC\Models\ModalModel;


class Adminmodels extends AbstractController
{
    use Validate;
    use Inputfilter;

    protected $create_role = [
        'name' => 'req',
        'text' => 'req',
        'marke_id' => 'req|num|min(1)',
        'file' => 'file'
    ];
    protected $edite_role = [
        'name' => 'req',
        'text' => 'req',
        'marke_id' => 'req|num|min(1)'
    ];

    public function defaultAction()
    {

        $this->language->load("adminmodel.labels");
        $this->language->load("adminmodel.messages");
        $this->_data['title'] = "Models";
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->language->load("validation.errors");
            $this->isajax = true;
            if (!$this->isValid($this->create_role, $_POST)) {
                $this->_viewjson(['error' => $this->errors, 'message' => '']);
            }
            if (ModalModel::isunque($_POST['name']) !== false){
                $this->_viewjson(['error' => [$this->language->feedKey('text_error_exist'  , [$this->language->get('text_label_name'  )])] , 'message' => '']);
            }
            if (MarkModel::getByPK($_POST['marke_id']) == false){
                $this->_viewjson(['error' => [$this->language->feedKey('text_error_exist'  , [$this->language->get('text_label_marke_id'  )])] , 'message' => '']);
            }
            $item = new ModalModel();
            if (empty($_FILES['file'])) {
                $this->_viewjson(['error' => $this->errors , 'message' => '']);
            } else {
                $image = new FileUpload($_FILES['file']);
                $item->images = "/public/uploads/images/" . $image->upload();
            }
            $item->name = $_POST['name'];
            $item->text = $_POST['text'];
            $item->marke_id = $_POST['marke_id'];
            if ($item->save()) {
                $this->_viewjson(['error' => [] , 'message' => $this->language->get('message_create_success') , 'state'=> 1 ,'data' => $item]);
            }
            $this->_viewjson(['error' => [$this->language->get('message_create_failed')] , 'message' => $this->language->get('message_create_failed') , 'state'=> 1]);            $this->_viewjson(['error' => [$this->language->get('message_create_failed')], 'message' => $this->language->get('message_create_failed'), 'state' => 1]);
        }
        $this->_data['brands'] = MarkModel::getAll();
        $this->_view();
    }


// delete
    public function deletechapterAction()
    {


    }

    public function editAction()
    {
        $this->language->load("validation.errors");
        $this->language->load("adminmodel.labels");
        $this->language->load("adminmodel.messages");


        if (!isset($this->_param[0]) || $this->_param[0] <= 0)
            $this->_viewjson(['error' => [$this->language->get('text_error_notfound')], 'message' => '']);
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $this->isajax = true;
            if (!$this->isValid($this->edite_role, $_POST)) {
                $this->_viewjson(['error' => $this->errors, 'message' => '']);
            }
            if (MarkModel::getByPK($_POST['marke_id']) == false){
                $this->_viewjson(['error' => [$this->language->feedKey('text_error_exist'  , [$this->language->get('text_label_marke_id'  )])] , 'message' => '']);
            }
            $id = $this->_param[0];

            if (ModalModel::isunque($_POST['name'] ,$id) !== false){
                $this->_viewjson(['error' => [$this->language->feedKey('text_error_exist'  , [$this->language->get('text_label_name'  )])] , 'message' => '']);
            }

            $item = ModalModel::getByPK($id);

            if ($item == false){
                $this->_viewjson(['error' => [$this->language->get('message_updated_failed')], 'message' => $this->language->get('message_create_failed'), 'state' => 1]);
            }
            if (!empty($_FILES['file'])) {
                $image = new FileUpload($_FILES['file']);
                $item->images = "/public/uploads/images/" . $image->upload();
            }
            $item->name = $_POST['name'];
            $item->text = $_POST['text'];
//            $item->text = $_POST['text'];
            if ($item->save()) {
                $this->_viewjson(['error' => [], 'message' => $this->language->get('message_update_success'), 'state' => 1, 'data' => $item]);
            }
            $this->_viewjson(['error' => [$this->language->get('message_updated_failed')], 'message' => $this->language->get('message_create_failed'), 'state' => 1]);
        }

    }


    public function deleteAction()
    {

        $this->language->load("validation.errors");
        $this->language->load("admincars.labels");
        $this->language->load("admincars.messages");

        if (!isset($this->_param[0]) || $this->_param[0] <= 0)
            $this->_viewjson(['error' => [$this->language->get('text_error_notfound')], 'message' => '']);
        $id = $this->_param[0];
        $item = ModalModel::getByPK($id);
        if ($item == false)
            $this->_viewjson(['error' => [$this->language->get('text_error_notfound')], 'message' => '']);

        if ($item->delete()) {
            $this->_viewjson(['error' => [], 'message' => $this->language->get('message_delete_success'), 'state' => 1, 'data' => $item]);
        }
        $this->_viewjson(['error' => [$this->language->get('message_delete_failed')], 'message' => $this->language->get('message_create_failed'), 'state' => 1]);

    }

}

