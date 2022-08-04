<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Application;

use app\core\Request;

class PanelController extends Controller
{
    public function dashboard()
    {
        $params = [
            'title' => 'فروشگاه اینترنتی اشیون',
            'pageTitle' => 'پیشخوان',
            'dependencyAddr' => '/',
        ];
        $this->setlayout('admin');
        return $this->render('admin/panel', $params);
    }

    public function addProduct()
    {
        $params = [
            'pageTitle' => 'اضافه کردن کالا',
            'title' => 'فروشگاه اینترنتی اشیون',
            'dependencyAddr' => '../',
        ];
        $this->setLayout('admin');
        return $this->render('admin/addProduct', $params);
    }
}
