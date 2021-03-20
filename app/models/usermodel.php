<?php
/**
 * Created by PhpStorm.
 * User: Ahmed Reda
 * Date: 24/04/2018
 * Time: 05:47 م
 */

namespace PHPMVC\Models;


class userModel extends AbstractModel
{
    public $id;
    public $username;
    public $password;
    public $bio;
    public $type;
    public $location;
    public $phone;
    public $email;
    public $active = 0;
    public $mode = 1;
    public $logo = "/public/img/userlogo.png";
 // ADDRESS_ID FULL_NAME USER_NAME EMAIL BIRTHDAY PHONE_NUMBER

    public static $tableName = 'car_users';

    protected static $tableSchema = array(
        'username' => self::DATA_TYPE_STR,
        'password' => self::DATA_TYPE_STR,
        'type' => self::DATA_TYPE_INT,
        'bio' => self::DATA_TYPE_STR,
        'location' => self::DATA_TYPE_STR,
        'email' => self::DATA_TYPE_STR,
        'phone' => self::DATA_TYPE_STR,
//        'mode' => self::DATA_TYPE_STR,
        'logo' => self::DATA_TYPE_STR,
        'active' => self::DATA_TYPE_INT,
        'mode' => self::DATA_TYPE_INT,
    );

    protected static $primaryKey = 'id';

    public function cryptPassword($password)
    {
        $this->password = crypt($password, APP_SALT);
    }

    // TODO:: FIX THE TABLE ALIASING
    public static function getUsers(UserModel $user)
    {
        return self::get(
            'SELECT au.*  FROM ' . self::$tableName . ' au  WHERE au.id != ' . $user->id
        );
    }

    public static function userExistsEmail($email)
    {
        return self::get('SELECT * FROM ' . self::$tableName . ' WHERE Email = "' . $email . '" ');
    }

    public static function userExists($username)
    {
        return self::get('SELECT * FROM ' . self::$tableName . ' WHERE Username = "' . $username . '" ');
    }

    public static function authenticate($username, $password, $session)
    {
        // where (  `USER_NAME` = '$username' or Email = '$username'  ) and PASSWORD = '$pass'
        $password = crypt($password, APP_SALT);
        $sql = 'SELECT *  FROM ' . self::$tableName . ' WHERE (  username = "' . $username . '" OR email = "' . $username . '" ) AND password = "' . $password . '"';
        $foundUser = self::getOne($sql);
//        var_dump($sql ,$foundUser);exit();
        if (false !== $foundUser) {
            if($foundUser->active == 1)
                $session->u = $foundUser;
            else
                return 2;
            return 1;
        }
        return false;
    }


}
