<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $user = new user();
        $params = [
            'title'=> 'فروشگاه اینترنتی اشیون | صفحه ورود',
            'type' => 'ورود',
            'model' => $user
        ];

        if ($request->isPost()) {
            $user->loadData($request->getBody());
            
            if($user->validate() && $user->auth())    {
                $this->setLayout('home');
                Application::$app->response->redirect('/');
            }
            $this->setLayout('auth');
            return $this->render('/admin/login',$params);
        }
        //If request GET
        $this->setLayout('auth');
        return $this->render('/admin/login', $params);
        }

    public function register(Request $request)
    {

        $user = new user();
        $params = [
            'title'=> 'فروشگاه اینترنتی اشیون | صفحه ثبت نام',
            'type' => 'ثبت نام',
            'model' => $user
        ];

        if ($request->isPost()) {
            $user->loadData($request->getBody());

            if($user->validate() && $user->save())    {
                Application::$app->response->redirect('/');
            }
            $this->setLayout('auth');
            return $this->render('/admin/register',$params);
        }
        $this->setLayout('auth');
        return $this->render('/admin/register', $params);
    }

    public function logout()
    {
        $params = [
        ];

        //If request GET
        $this->setLayout('auth');
        return $this->render('/admin/logout', $params);
        }

}