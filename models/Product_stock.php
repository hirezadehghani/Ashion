<?php

declare(strict_types=1);

namespace app\models;

use app\core\Model;

class Product_stock extends Model
{
    public int $stock_id = 0;
    public string $stock_name = '';

    public function tableName(): string
    {
        return 'product_stock';
    }

    public function attributes(): array
    {
        return ['stock_id', 'stock_name'];
    }

    public function labels(): array
    {
        return [
            'stock_name' => 'name of status of product stock'
        ];
    }

    public function rules(): array
    {
        return [
            'stock_name' => [self::RULES_REQUIRED]
        ];
    }

    public function addStock(){
        return $this->save();
    }

    public function save()
    {
        parent::saveToDb($this->tableName, $this->attributes);
    }

    public function getStockName($productId)  {
        return $this->fetchRow("product_stock",$productId,['stock_name'], 'stock_id');
    }
}