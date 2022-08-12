<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Application;
use app\models\product;
use app\core\Request;
use app\models\Category;
use app\models\Discount;

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

    public function addProduct(Request $request)    {
        $product = new Product();

        $params = [
            'pageTitle' => 'اضافه کردن کالا',
            'title' => 'فروشگاه اینترنتی اشیون',
            'dependencyAddr' => '../',
            'model' => $product
        ];

            if ($request->isPost()) {
                $product->loadData($request->getBody());
                if($product->validate() && $product->save())    {
                    Application::$app->response->redirect('/panel/addProduct');
                }
                $this->setLayout('admin');
                return $this->render('/admin/addProduct',$params);
    
            }
            $this->setLayout('admin');
            return $this->render('admin/addProduct', $params);
    }

    public function productCategory(Request $request)  {
        $category = new Category();

        $params = [
            'pageTitle' => 'افزودن دسته بندی',
            'title' => 'فروشگاه اینترنتی اشیون',
            'dependencyAddr' => '../',
            'model' => $category
        ];

        if ($request->isPost()) {
            $category->loadData($request->getBody());
            
            if($category->validate() && $category->save())    {
                Application::$app->response->redirect('/panel/productCategory');
            }
            $this->setLayout('admin');
            return $this->render('/admin/addCategory',$params);
        }
        $this->setLayout('admin');
        return $this->render('admin/addCategory',$params);
    }

    public function productDiscount(Request $request)  {
        $discount = new Discount();

        $params = [
            'pageTitle' => 'افزودن تخفیف',
            'title' => 'فروشگاه اینترنتی اشیون',
            'dependencyAddr' => '../',
            'model' => $discount
        ];

        if ($request->isPost()) {
            $discount->loadData($request->getBody());
            if($discount->validate() && $discount->save())    {
                Application::$app->response->redirect('/panel/discount');
            }
            $this->setLayout('admin');
            return $this->render('/admin/discount',$params);
        }
        $this->setLayout('admin');
        return $this->render('admin/discount',$params);
    }


}