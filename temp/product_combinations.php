<?php

namespace app\models;

use app\core\Model;

class product_combinations extends Model
{
    public int $id = 0;
    public int $sku_id = 0;
    public string $combination_string = '';


    public function tableName(): string
    {
        return 'product_combinations';
    }

    public function attributes(): array
    {
        return ['sku_id', 'combination_string'];
    }

    public function labels(): array
    {
        return [
            'combination_string' => 'string that consist of product values',
            'sku_id' => 'SKU code of specific product',
        ];
    }

    public function rules(): array
    {

        return [
            'combination_string' => [self::RULES_REQUIRED],
            'sku_id' => [self::RULES_REQUIRED],
        ];
    }

    public function add($sku_id)
    {
        $this->combination_string = $_GET['combination_string'];
        $this->sku_id = $sku_id;

        // set combination_string in table
        return $this->save();
    }

    public function save()
    {
            parent::saveToDb($this->tableName(), $this->attributes());
    }
}
