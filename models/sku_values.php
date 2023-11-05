<?php

namespace app\models;

use app\core\Model;

class sku_values extends Model
{
    public int $product_id = 0;
    public int $sku_id = 0;
    public int $parent_attribute_id = 0;
    public int $parent_value_id = 0;
    public int $child_attribute_id = 0;
    public int $child_value_id = 0;


    public function tableName(): string
    {
        return 'sku_values';
    }

    public function attributes(): array
    {
        return ['product_id', 'sku_id', 'parent_attribute_id', 'parent_value_id', 'child_attribute_id', 'child_value_id'];
    }

    public function labels(): array
    {
        return [
            'product_id' => 'Id of product',
            'sku_id' => 'SKU code of specific product',
            'parent_attribute_id' => 'parent attribute of product',
            'parent_value_id' => 'parent value of atrribute of product',
            'child_attribute_id' => 'child attribute of product',
            'child_value_id' => 'child value of atrribute of product'
        ];
    }

    public function rules(): array
    {

        return [
            'product_id' => [self::RULES_REQUIRED],
            'sku' => [self::RULES_REQUIRED],
            'parent_attribute_id' => [self::RULES_REQUIRED],
            'parent_value_id' => [self::RULES_REQUIRED],
        ];
    }

    public function add($sku_id)
    {
        $this->product_id = $_GET['product_id'];
        $this->sku_id = $sku_id;
        $this->parent_attribute_id = $_GET['parent_attribute_id'];
        $this->parent_value_id = $_GET['parent_value_id'];
        $this->child_attribute_id = $_GET['child_attribute_id'];
        $this->child_value_id = $_GET['child_value_id'];
        // set sku_values in table
        return $this->save();
    }

    public function save()
    {
        parent::saveToDb($this->tableName(), $this->attributes());
    }

    public function getObject (int $product_id, $sku_id) : sku_values {
        $stmt = parent::prepare("
        SELECT * from sku_values WHERE product_id=:product_id");
        $stmt->bindParam(":product_id", $product_id);
        $stmt->execute();
        $sku_values = new sku_values;
        $data = $stmt->fetch();
        if($data != null)   {
        $sku_values->product_id = $product_id;
        $sku_values->parent_attribute_id = $data['parent_attribute_id'];
        $sku_values->parent_value_id = $data['parent_value_id'];
        $sku_values->child_attribute_id = $data['child_attribute_id'];
        $sku_values->child_value_id = $data['child_value_id'];
        $sku_values->sku_id = $sku_id;
        }
        return $sku_values;
    }
}
