<?php

namespace app\models;

use app\core\Model;

class product_attributes extends Model
{
    public int $attribute_id = 0;
    public string $attribute_name = '';
    public int $product_id = 0;
    public string $value_name = '';

    public function tableName(): string
    {
        return 'product_attributes';
    }

    public function attributes(): array
    {
        return ['attribute_name', 'product_id'];
    }

    public function labels(): array
    {
        return [
            'attribute_name' => 'Title of attributes',
            'product_id' => 'Id of varient product'
        ];
    }

    public function rules(): array
    {
        return [
            // 'attribute_name' => [self::RULES_REQUIRED],
        ];
    }

    public function addAttribute()
    {
        return $this->save();
    }

    public function save()
    {
        if($this->value_name)
        parent::saveToDb("attribute_values", ['attribute_id', 'value_name']);
        if($this->attribute_name)
        parent::saveToDb($this->tableName(), $this->attributes());
    }

    public function getValueName ($value_id) {
        return $this->fetchRow("attribute_values", $value_id, ['value_name'], 'value_id');
    }
}
