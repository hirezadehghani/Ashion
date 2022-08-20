<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Application;
use app\models\product;
use app\core\Request;
use app\models\Category;
use app\models\Discount;
use app\models\product_attributes;
use app\models\Product_stock;
use app\models\ProductSkus;
use app\models\sku_values;
use Attribute;

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

    public function addProduct(Request $request)
    {
        $product = new Product();

        $params = [
            'pageTitle' => 'اضافه کردن کالا',
            'title' => 'فروشگاه اینترنتی اشیون',
            'dependencyAddr' => '../',
            'model' => $product
        ];

        if ($request->isPost()) {
            $product->loadData($request->getBody());
            if ($product->validate() && $product->save()) {
                Application::$app->response->redirect('/panel/addProduct');
            }
            $this->setLayout('admin');
            return $this->render('/admin/addProduct', $params);
        }
        if (isset($_GET['sku'])) {
            $product_skus = new ProductSkus;
            $product_skus->add();

            //fetch last field sku_id of product_skus table for save in sku_values table
            $sku_id = $product_skus->fetchLastRow($product_skus->tableName(), 1, 'desc');

            $sku_values = new sku_values;
            $sku_values->add($sku_id[0]['sku_id']);
        }
        $this->setLayout('admin');
        return $this->render('admin/addProduct', $params);
    }

    public function productCategory(Request $request)
    {
        $category = new Category();

        $params = [
            'pageTitle' => 'افزودن دسته بندی',
            'title' => 'فروشگاه اینترنتی اشیون',
            'dependencyAddr' => '../',
            'model' => $category
        ];

        if ($request->isPost()) {
            $category->loadData($request->getBody());

            if ($category->validate() && $category->save()) {
                Application::$app->response->redirect('/panel/productCategory');
            }
            $this->setLayout('admin');
            return $this->render('/admin/addCategory', $params);
        }
        $this->setLayout('admin');
        return $this->render('admin/addCategory', $params);
    }

    public function productDiscount(Request $request)
    {
        $discount = new Discount();

        $params = [
            'pageTitle' => 'افزودن تخفیف',
            'title' => 'فروشگاه اینترنتی اشیون',
            'dependencyAddr' => '../',
            'model' => $discount
        ];

        if ($request->isPost()) {
            $discount->loadData($request->getBody());
            if ($discount->validate() && $discount->save()) {
                Application::$app->response->redirect('/panel/discount');
            }
            $this->setLayout('admin');
            return $this->render('/admin/discount', $params);
        }
        $this->setLayout('admin');
        return $this->render('admin/discount', $params);
    }

    public function productAttribute(Request $request)
    {
        $attribute = new product_attributes();

        $params = [
            'pageTitle' => 'افزودن مشخصه',
            'title' => 'فروشگاه اینترنتی اشیون',
            'dependencyAddr' => '../',
            'model' => $attribute
        ];

        if ($request->isPost()) {
            $attribute->loadData($request->getBody());
            if ($attribute->validate() && $attribute->save()) {
                Application::$app->response->redirect('/panel/attribute');
            }
            $this->setLayout('admin');
            return $this->render('/admin/attribute', $params);
        }
        $this->setLayout('admin');
        return $this->render('admin/attribute', $params);
    }
}
