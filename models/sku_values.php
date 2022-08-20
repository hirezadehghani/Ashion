<?php

namespace app\models;

use app\core\Model;

class sku_values extends Model
{
    public int $product_id = 0;
    public int $sku_id = 0;
    public int $attribute_id = 0;
    public int $value_id = 0;


    public function tableName(): string
    {
        return 'sku_values';
    }

    public function attributes(): array
    {
        return ['product_id', 'sku_id', 'attribute_id', 'value_id'];
    }

    public function labels(): array
    {
        return [
            'product_id' => 'Id of product',
            'sku_id' => 'SKU code of specific product',
            'attribute_id' => 'attribute of product',
            'value_id' => 'value of atrribute of product'
        ];
    }

    public function rules(): array
    {

        return [
            'product_id' => [self::RULES_REQUIRED],
            'sku' => [self::RULES_REQUIRED],
            'attribute_id' => [self::RULES_REQUIRED],
            'value_id' => [self::RULES_REQUIRED],
        ];
    }

    public function add($sku_id)
    {
        $this->product_id = $_GET['product_id'];
        $this->sku_id = $sku_id;
        $this->attribute_id = $_GET['attribute_id'];
        $this->value_id = $_GET['value_id'];
        // set sku_values in table
        return $this->save();
    }

    public function save()
    {
            parent::saveToDb($this->tableName(), $this->attributes());
    }
}
