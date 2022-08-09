<?php

namespace app\core\form;

use app\core\Model;
use app\core\ProductModel;
use app\models\Category;
use app\models\User;
use app\models\Product;

class Field
{
    public const TYPE_TEXT = 'text';
    public const TYPE_PASSWORD = 'password';
    public const TYPE_NUMBER = 'number';

    public string $type;
    public Model $model;
    public string $attribute;
    public string $placeHolder;

    public function __construct(\app\core\Model $model, string $attribute, string $placeHolder)  {
        $this->type = self::TYPE_TEXT;
        $this->model = $model;
        $this->attribute = $attribute;
        $this->placeHolder= $placeHolder;
    }

    public function __toString()
    {
        return sprintf('
        <div class="form-group">
        <label class="form-label">%s</label>
    <input type="%s" name="%s" value="%s" class="form-control%s">
    <div class ="invalid-feedback">
    %s
    </div>
    </div>    
    ',
     $this->placeHolder,
     $this->type,
     $this->attribute,
     $this->model->{$this->attribute},
     $this->model->hasError($this->attribute) ? ' is-invalid' : '',
     $this->model->getFirstError($this->attribute)
    );
    }

    public function passwordField() {
        $this->type = self::TYPE_PASSWORD;
        return $this;
    }
}