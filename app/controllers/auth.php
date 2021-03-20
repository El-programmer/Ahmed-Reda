<?php
/**
 * Created by PhpStorm.
 * User: Ahmed Reda
 * Date: 23/06/2018
 * Time: 12:02 ص
 */

namespace PHPMVC\Controllers;

use PHPMVC\lib\Messenger;
use PHPMVC\Lib\Validate;
use PHPMVC\Models\userModel;




class Auth extends AbstractController
{
    use Validate;
    function checkauth()
    {
        if (isset($this->session->u->id) && is_numeric($this->session->u->id)){
            $this->redirect("/");
		}else
		    ;
    }

    protected  $create_role = [
        'username' =>"req|min(5)",
        'email' => "req|email",
        'type'  => "req|int",
        'phone' => "req|num|min(11)|max(11)",
        'password'=>"req|min(8)|alphanum"
    ];
    public function defaultAction()
    {
        //echo crypt("123", APP_SALT);
        $this->checkauth();
        $this->language->load("validation.errors");
        $this->language->load('auth.login');
        $this->_data['title'] = "login";
        if (isset($_POST['username'])) {
            $isAuthorized = UserModel::authenticate($_POST['username'], $_POST['passoword'], $this->session);
            if ($isAuthorized == 2) {
                $this->_viewjson([ 'error'=> [$this->language->get('text_user_disabled')] ,'state'=> 0, 'message'=> $this->language->get('text_user_disabled') ]);
            } elseif ($isAuthorized == 1) {
                $this->_viewjson([ 'error'=> [$this->language->get('text_user_found')] , 'state'=> 1, 'message'=> $this->language->get('text_user_found') ]);
            } elseif ($isAuthorized === false) { //
                $this->_viewjson([ 'error'=> [$this->language->get('text_user_not_found')] , 'state'=> 0, 'message'=> $this->language->get('text_user_not_found') ]);

            }
        }

        $this->_view();
    }

    public function registerAction()
    {
        $this->language->load("validation.errors");
        $this->language->load('auth.login');
        $this->_data['title'] = "register";
        if (isset($_POST['username'])) {
            $this->isajax= true;
            if (!$this->isValid($this->create_role, $_POST)) {
                $this->_viewjson(['error' => $this->errors, 'message' => '' , 'state' => 0 ]);
            }
            $item = UserModel::getBy(['username' => $_POST['username']]);
            if ( $item !=  false) {
                $this->_viewjson(['error' => [$this->language->feedKey('text_error_exist'  , [$this->language->get('text_label_username'  )])], 'message' => '']);

            } else {

                $currentuser = new userModel();
                $currentuser->username = $_POST['username'];
                $currentuser->email = $_POST['email'];
                $currentuser->phone = $_POST['phone'];
                $currentuser->active = 1;
                $currentuser->type = $_POST['type'] == 1 ? 1 : 2 ;
                $currentuser->bio = isset($_POST['bio']) ? $_POST['bio'] : "no bio " ;
                $currentuser->cryptPassword($_POST['password']) ;
                if ($currentuser->save()){
                    $this->session->u = $currentuser;
                    $this->_viewjson(['error' => [ '0' ], 'state' => 1 ,'message' => $this->language->get('message_create_success')]);
                }
                else
                    $this->_viewjson(['error' => [$this->language->get('message_create_failed'  )] , 'state' => 0, 'message' => '']);

            }
        }
        $this->_view();
    }
    public function checkuserAction()
    {
        $this->_param[0]  = $this->filterString($this->_param[0]);
        $this->language->load("validation.errors");
        $this->language->load('auth.login');
        $item = UserModel::getBy(['username' => $this->_param[0]]);
        if ( $item !=  false)
            $this->_viewjson(['error' => [$this->language->feedKey('text_error_exist', [$this->language->get('text_label_username')])], 'state'=> 0 , 'message' => '']);
        $this->_viewjson(['error' => [ 1 => ""], 'state'=> 1 , 'message' => '']);
    }
    public function checkemailAction()
    {
        $this->_param[0]  = $this->filterString($this->_param[0]);
        $this->language->load("validation.errors");
        $this->language->load('auth.login');
        $item = UserModel::getBy(['email' => $this->_param[0] ]);
        if ( $item !=  false)
            $this->_viewjson(['error' => [$this->language->feedKey('text_error_exist', [$this->language->get('text_label_username')])], 'state'=> 0 , 'message' => '']);
        $this->_viewjson(['error' => [ 1 => "" ], 'state'=> 1 , 'message' => '']);
    }

    public function logoutAction()
    {
        $this->session->kill();
        $this->redirect('/auth');
    }
}
/*
 *
 * 10 - 11 - 12 - 13 - 15
 *
 * */