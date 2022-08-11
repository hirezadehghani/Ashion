<?php

declare(strict_types=1);

namespace app\models;

use app\core\Application;
use app\core\Model;

class Category extends Model
{
    public int $id = 0;
    public string $title = '';
    public string $detail = '';

    public function tableName(): string
    {
        return 'product_category';
    }

    public function attributes(): array
    {
        return ['title', 'detail'];
    }

    public function labels(): array
    {
        return [
            'title' => 'Title of category',
            'detail' => 'Description of category',
        ];
    }

    public function rules(): array
    {
        return [
            'title' => [self::RULES_REQUIRED, [
                self::RULES_UNIQUE, 'class' => self::class
            ]]
        ];
    }

    public function addCategory(){
        return $this->save();
    }

    public function save()
    {
        parent::saveToDb($this->tableName(), $this->attributes());
    }
    public function fetchTitle($param)  {
        return parent::fetchFromDb($this->tableName(), $param);
    }
}