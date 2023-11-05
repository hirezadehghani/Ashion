<?php

namespace app\core\form;

use app\core\Model;
use app\core\UserModel;
use app\models\user;
use app\models\Product;
use app\core\ProductModel;
use app\models\Category;

class Form 
{
    public static function begin($action, $method)  {
        echo sprintf('<form action="%s" method="%s">', $action, $method);
        return new Form();
    }
    public static function beginWithId($action, $method, $id)  {
        echo sprintf('<form action="%s" method="%s" id="%s">', $action, $method, $id);
        return new Form();
    }
    public static function end()    {
        echo '</form>';
    }

    public function field(Model $model, $type, $attribute, $placeHolder) {
        return new Field($model, $type, $attribute, $placeHolder);
    }

    public static function hasUpload($action, $method) {
        echo sprintf('<form action="%s" method="%s" enctype="multipart/form-data" id="phpForm">', $action, $method);
        return new Form();
    }
}