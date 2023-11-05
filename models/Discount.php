<?php

// declare(strict_types=1);

namespace app\models;

use app\core\Application;
use app\core\Cast;
use app\core\Model;
use DateTime;

class Discount extends Model
{
    public int $id = 0;
    public string $title = '';
    public string $detail = '';
    public int $discount_percent = 0;
    public int $active = 2;
    public string $created_at = '';
    public string $modified_at = '';
    public $deleted_at = NULL;


    public function tableName(): string
    {
        return 'discount';
    }

    public function attributes(): array
    {
        return ['title', 'detail', 'discount_percent', 'active', 'created_at', 'modified_at', 'deleted_at'];
    }

    public function labels(): array
    {
        return [
            'title' => 'Title of discount',
            'detail' => 'Description of discount',
            'discount_percent' => 'Discount percent of product',
            'active' => 'Whether is discount active or not active',
            'created_at' => 'date of creating discount',
            'modified_at' => 'date of modifing discount',
            'deleted_at' => 'date of deleting discount'
        ];
    }

    public function rules(): array
    {
        return [
            'title' => [self::RULES_REQUIRED, [
                self::RULES_UNIQUE, 'class' => self::class
            ]],
            'discount_percent' => [self::RULES_REQUIRED, [self::RULES_MINVALUE, 'min' => 1], [self::RULES_MAXVALUE, 'max' => 100]],
            'active' => [self::RULES_REQUIRED],
        ];
    }

    public function addDiscount()
    {
        return $this->save();
    }

    public function save()
    {
        $this->setDates();
        parent::saveToDb($this->tableName(), $this->attributes());
    }

    public function setDates()
    {
        $this->created_at = Date("Y:m:d H:i:s");
        $this->modified_at = Date("Y:m:d H:i:s");
    }
}
