<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Application;
use app\models\product;
use app\core\Request;
use app\models\Category;
use app\models\Inventory;

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

    public function saveProduct(Request $request)
    {
        $product = new Product();
            if ($request->isPost()) {
                $product->loadData($request->getBody());
                
                if($product->validate() && $product->save())    {
                    Application::$app->response->redirect('/admin/panel');
                }
                $this->setLayout('admin');
                $params = [
                    'pageTitle' => 'اضافه کردن کالا',
                    'title' => 'فروشگاه اینترنتی اشیون',
                    'dependencyAddr' => '../',
                    'model' => $product
                ];
                return $this->render('/admin/addProduct',$params);
    
            }
            $this->setLayout('admin');
            return $this->render('admin/panel', [
                'model' => $product
            ]);
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
            $params = [
                'pageTitle' => 'افزودن دسته بندی',
                'title' => 'فروشگاه اینترنتی اشیون',
                'dependencyAddr' => '../',
                'model' => $category
            ];
            return $this->render('/admin/addCategory',$params);
        }
        $this->setLayout('admin');
        return $this->render('admin/addCategory',$params);
    }

    public function productInventory(Request $request)  {
        $inventory = new Inventory();

        $params = [
            'pageTitle' => 'افزودن موجودی',
            'title' => 'فروشگاه اینترنتی اشیون',
            'dependencyAddr' => '../',
            'model' => $inventory
        ];

        if ($request->isPost()) {
            $inventory->loadData($request->getBody());
            
            if($inventory->validate() && $inventory->save())    {
                Application::$app->response->redirect('/panel/productinventory');
            }
            $this->setLayout('admin');
            $params = [
                'pageTitle' => 'افزودن دسته بندی',
                'title' => 'فروشگاه اینترنتی اشیون',
                'dependencyAddr' => '../',
                'model' => $inventory
            ];
            return $this->render('/admin/addinventory',$params);
        }
        $this->setLayout('admin');
        return $this->render('admin/addinventory',$params);
    }


}