<?php

namespace app\models;

use app\core\Application;
use app\core\Model;

class User extends Model
{
    public int $id = 0;
    public string $firstName = '';
    public string $lastName = '';
    public string $email = '';
    public string $password = '';
    public string $passwordConfirm = '';
    public string $telephone = '';
    public string $created_at = '';
    public string $modified_at = '';

    public function __construct($object = null)
    {
        $this->cast($object);
    }
    public function cast($object)
    {
        if (is_array($object) || is_object($object)) {
            foreach ($object as $key => $value) {
                $this->$key = $value;
            }
        }
    }

    public static function tableName(): string
    {
        return 'user';
    }

    public function attributes(): array
    {
        return ['firstName', 'lastName', 'email', 'password', 'telephone', 'created_at', 'modified_at'];
    }

    public function labels(): array
    {
        return [
            'firstName' => 'First name',
            'lastName' => 'Last name',
            'telephone' => 'telephone',
            'email' => 'Email',
            'password' => 'Password',
            'passwordConfirm' => 'Password Confirm'
        ];
    }

    public function rules() : array
    {
        //for User login
        if($_SERVER['REQUEST_URI'] == '/login'){
            return [
                'email' => [self::RULES_EMAIL, self::RULES_REQUIRED],
                'password' => [self::RULES_REQUIRED]
            ];
        }
        //for User Register
        else{
        return [
            'firstName' => [self::RULES_REQUIRED],
            'lastName' => [self::RULES_REQUIRED],
            'telephone' => [self::RULES_REQUIRED, [
                self::RULES_UNIQUE, 'class' => self::class
            ], [self::RULES_MIN, 'min' => 11], [self::RULES_MAX, 'max' => 11]],
            'email' => [self::RULES_REQUIRED, self::RULES_EMAIL, [
                self::RULES_UNIQUE, 'class' => self::class
            ]],
            'password' => [self::RULES_REQUIRED, [self::RULES_MIN, 'min' => 8]],
            'passwordConfirm' => [[self::RULES_MATCH, 'match' => 'رمز عبور']],
        ];
    }
    }

    public function save()
    {
        parent::saveToDb($this->tableName, $this->attributes);
    }

    public function getDisplayName(): string
    {
        return $this->firstName . ' ' . $this->lastName;
    }

    public function auth () :bool {
        $user = new User();
        $user_select = parent::prepare("SELECT * FROM user WHERE email = :email AND password = :password");
        $user_select->execute(['email' => $this->email, 'password' => $this->password]);
        $user = $user_select->fetch();
        if($user_select->rowCount() == 1){
            session_start();
            $_SESSION['id'] = $user['id'];
            return 1;
        }
        else {
            $this->addError('email', self::RULES_UNCORRECT);
        }
        return 0;
    }
}