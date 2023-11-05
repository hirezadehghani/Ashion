<?php

declare(strict_types=1);

namespace app\models;

use app\core\Model;

class Inventory extends Model
{
    public int $id = 0;
    public string $quantity = '';

    public function tableName(): string
    {
        return 'product_inventory';
    }

    public function attributes(): array
    {
        return ['title', 'detail'];
    }

    public function labels(): array
    {
        return [
            'quantity' => 'value of quantity of product'
        ];
    }

    public function rules(): array
    {
        return [
            'quantity' => [self::RULES_REQUIRED, [
                self::RULES_UNIQUE, 'class' => self::class
            ]]
        ];
    }

    public function addInventory(){
        return $this->save();
    }

    public function save()
    {
        parent::saveToDb($this->tableName, $this->attributes);
    }
}