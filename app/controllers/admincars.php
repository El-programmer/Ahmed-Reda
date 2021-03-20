<?php

namespace PHPMVC\Controllers;

use PHPMVC\lib\FileUpload;
use PHPMVC\LIB\Inputfilter;
use PHPMVC\Lib\Validate;
use PHPMVC\Lib\Messenger;

;

use PHPMVC\Models\userModel;
use PHPMVC\Models\MarkModel;


class Admincars extends AbstractController
{
    use Validate;
    use Inputfilter;

    protected $create_role = [
        'title' => 'req',
        'text' => 'req',
        'file' => 'file'
    ];
    protected $edite_role = [
        'title' => 'req',
        'text' => 'req',
    ];

    public function defaultAction()
    {

        $this->language->load("admincars.labels");
        $this->language->load("admincars.messages");
        $this->_data['title'] = "car marks";
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->language->load("validation.errors");
            $this->isajax = true;
            if (!$this->isValid($this->create_role, $_POST)) {
                $this->_viewjson(['error' => $this->errors, 'message' => '']);
            }
            if (MarkModel::isunque($_POST['title']) !== false){
                $this->_viewjson(['error' => [$this->language->feedKey('text_error_exist'  , [$this->language->get('text_label_tittle'  )])] , 'message' => '']);
            }
            $item = new MarkModel();
            if (empty($_FILES['file'])) {
                $this->_viewjson(['error' => $this->errors, 'message' => '']);
            } else {
                $image = new FileUpload($_FILES['file']);
                $item->image = "public/uploads/images/" . $image->upload();
            }
            $item->tittle = $_POST['title'];
            $item->text = $_POST['text'];
            if ($item->save()) {
                $this->_viewjson(['errors' => [] , 'message' => $this->language->get('message_create_success') , 'state'=> 1 ,'data' => $item]);
            }
            $this->_viewjson(['errors' => [$this->language->get('message_create_failed')] , 'message' => $this->language->get('message_create_failed') , 'state'=> 1]);
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
        $this->language->load("admincars.labels");
        $this->language->load("admincars.messages");

        if (!isset($this->_param[0]) ||  $this->_param[0] <= 0 )
            $this->_viewjson(['error' => [$this->language->get('text_error_notfound')] , 'message' => '']);
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $id = $this->_param[0];
            $this->isajax = true;
            if (!$this->isValid($this->edite_role , $_POST)) {
                $this->_viewjson(['error' => $this->errors, 'message' => '']);
            }
            if (MarkModel::isunque($_POST['title'] , $id ) !== false){
                $this->_viewjson(['error' => [$this->language->feedKey('text_error_exist'  , [$this->language->get('text_label_tittle'  )]) ] , 'message' => '']);
            }
            $item = MarkModel::getByPK($id);
            if (!empty($_FILES['file'])) {
                $image = new FileUpload($_FILES['file']);
                $item->image = "public/uploads/images/" . $image->upload();
            }
            $item->tittle = $_POST['title'];
            $item->text = $_POST['text'];
            if ($item->save()) {
                $this->_viewjson(['errors' => [] , 'message' => $this->language->get('message_create_success') , 'state'=> 1 ,'data' => $item]);
            }
            $this->_viewjson(['errors' => [$this->language->get('message_create_failed')] , 'message' => $this->language->get('message_create_failed') , 'state'=> 1]);
        }

    }


    public function deleteAction()
    {

        $this->language->load("validation.errors");
        $this->language->load("admincars.labels");
        $this->language->load("admincars.messages");

        if (!isset($this->_param[0]) ||  $this->_param[0] <= 0 )
            $this->_viewjson(['error' => [$this->language->get('text_error_notfound')] , 'message' => '']);
        $id = $this->_param[0];
        $item = MarkModel::getByPK($id);
        if ($item == false)
            $this->_viewjson(['error' => [$this->language->get('text_error_notfound')] , 'message' => '']);
//
        if ($item->delete()) {
            $this->_viewjson(['errors' => [] , 'message' => $this->language->get('message_delete_success') , 'state'=> 1 ,'data' => $item]);
        }
        $this->_viewjson(['errors' => [$this->language->get('message_delete_failed')] , 'message' => $this->language->get('message_create_failed') , 'state'=> 1]);

    }

    public function deletceAction()
    {
        $this->isUser(2);
        $this->_data['title'] = "courses";
        if (!isset($this->_param[0]))
            $this->redirect("/course");

        $course = CourseModel::getByPK($this->_param[0]);

        if ($this->session->u->USER_ID != $course->USER_ID)
            $this->redirect("/course");


        foreach ($course->chapters() as $c) {
            $c->isdeleted = 1;
            $c->save();
            if ($c->getQuestion() != false)
                foreach ($c->getQuestion() as $q) {
                    $q->is_deleted = 1;
                    $q->save();
                }
        }


        $course->isdeleted = 1;

        if ($course->save())
            $this->messenger->add(" course deleted success ", Messenger::APP_MESSAGE_SUCCESS);
        else
            $this->messenger->add(" fail to delete course ", Messenger::APP_MESSAGE_ERROR);


        $this->redirect("/Course");


    }


    public function addQuestionAction()
    {
        $this->isUser(2);
        $this->_data['title'] = "courses";
        //print_r($_POST);exit();
        $this->_param[0];
        if (isset($_POST['DESCREPTION'])) {
            $item = new QuestionModel();
            $item->setvalue($_POST);
            $item->USER_ID = $this->session->u->USER_ID;
            //print_r($item);
            //var_dump($_POST);
            if ($item->save())
                $this->messenger->add(" Question has been added successfully", Messenger::APP_MESSAGE_SUCCESS);
            else
                $this->messenger->add(" Questions has not been added ", Messenger::APP_MESSAGE_ERROR);

            $this->redirect('/Course/view/' . $this->_param[0]);

        } else {
            $this->redirect('/Course/view/' . $this->_param[0]);
        }
    }

    public function viewAction()
    {
        $this->isUser(2);
        $this->_data['title'] = "courses";
        if (!isset($this->_param[0]))
            $this->redirect("/Course");
        $id = $this->filterInt($this->_param[0]);
        $course = CourseModel::getByPK($id);
        if ($course == false)
            $this->redirect("/Course");

        $chapters = ChapterModel::getBy(['COURSE_ID' => $course->COURSE_ID, 'isdeleted' => 0]);

        $this->_data['course'] = $course;
        $this->_data['chapters'] = $chapters;
        $this->_data['types'] = QtypeModel::getAll();
        //

        $this->_view();

    }


    public function importAction()
    {
        $this->isUser(2);
        $this->_data['title'] = "courses";

        if (!isset($this->_param[0]))
            $this->redirect("/Course");

        $id = $this->filterInt($this->_param[0]);
        $course = CourseModel::getByPK($id);

        if ($course == false)
            $this->redirect("/Course");
        $chnum = 1;

        include __DIR__ . DS . '..' . DS . 'PHPExcel' . DS . 'PHPExcel.php';
        if (isset($_POST["import"])) {
            $output = "";
            $extension = explode(".", $_FILES["excel"]["name"]);
            $extension = $extension[sizeof($extension) - 1];

            $allowed_extension = array("xls", "xlsx", "csv");
            if (in_array($extension, $allowed_extension)) {
                $file = $_FILES["excel"]["tmp_name"];

                $objPHPExcel = \PHPExcel_IOFactory::load($file); // create object of PHPExcel library by using load() method and in load method define path of selected file

                $chapter = new ChapterModel();
                $chapter->CHAPTER_NAME = $_FILES["excel"]["name"];
                $chapter->COURSE_ID = $id;
                $chapter->save();


                $m = "";
                foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
                    $highestRow = $worksheet->getHighestRow();

                    for ($row = 2; $row <= $highestRow; $row++) {
                        //$idchapter = $worksheet->getCellByColumnAndRow(2, $row)->getValue();


                        $q = new QuestionModel();
                        $q->USER_ID = $this->session->u->USER_ID;
                        $q->ANSWER = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                        $q->TYPE_ID = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                        $q->CHAPTER_ID = $chapter->CHAPTER_ID;

                        $q->DESCREPTION = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                        $q->DESCREPTION = str_replace("\n", '<br> ', $q->DESCREPTION);
                        $q->DESCREPTION = str_replace('"', " \" ", $q->DESCREPTION);
                        $q->DESCREPTION = str_replace("'", " \' ", $q->DESCREPTION);

                        if ($q->DESCREPTION == "") {
                            $m .= " row number $row  is empty ";
                            continue;
                        }
                        $bool = false;

                        $bool = QuestionModel::get("SELECT * FROM `questions` WHERE `CHAPTER_ID` = $chapter->CHAPTER_ID AND `DESCREPTION` = '$q->DESCREPTION' ");
                        if ($bool != false) {
                            $m .= " row number $row  is inserted before ";
                            continue;
                        }
                        $q->DIFFICULTY = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                        $q->SCORE = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
                        $q->TIME = $worksheet->getCellByColumnAndRow(3, $row)->getValue();

                        $q->save();
                    }

                }

                if ($m != "") {
                    $this->messenger->add($m, Messenger::APP_MESSAGE_ERROR);
                }

            }

        }

        $this->redirect('/course/view/' . $id);


    }

    // getchapters
    public function getchaptersAction()
    {
        $this->isUser(2);
        $this->_data['title'] = "courses";
        if (!isset($this->_param[0]))
            exit(0);

        $course = CourseModel::getByPK($this->_param[0]);

        $this->_data['item'] = $course;
        if ($this->session->u->USER_ID != $course->USER_ID) {
            exit(0);
        }
        foreach ($course->chapters() as $chapter) {
            echo "<div class='mr-2 float-left d-inline-block col-12 text-left'> <input type='checkbox' class='form-check-input' 
name='chapters[]' 
value='"
                . $chapter->CHAPTER_ID
                . "'> 
" . $chapter->CHAPTER_NAME . "</div>";
        }
        //echo json_decode($course->chapters());


    }
}

