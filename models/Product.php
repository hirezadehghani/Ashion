<?php

declare(strict_types=1);

namespace app\models;

use app\core\Model;

class Product extends Model
{
    public int $id = 0;
    public string $title = '';
    public string $detail = '';
    public string $sku = '';
    public string $price = '';
    public $inventory_id = '';
    public string $stock_price = '';
    public string $color = '';
    public string $size = '';
    public string $promotions = '';
    public string $available_color = '';
    public string $available_size = '';
    public int $ranking = 0;
    public string $pictures = '';
    public int $category_id = 0;
    public string $discount_id = '';
    public string $created_at = '';
    public string $modified_at = '';
    public string $deleted_at = '';

    public function tableName(): string
    {
        return 'product';
    }

    public function attributes(): array
    {
        return ['title', 'detail', 'sku', 'price', 'inventory_id', 'stock_price', 'discount_id', 'color', 'size', 'available_color', 'available_size', 'promotions', 'ranking', 'category_id', 'pictures'];
    }

    public function labels(): array
    {
        return [
            'title' => 'Title of product',
            'detail' => 'Description of product',
            'SKU' => 'SKU code',
            'price' => 'Price of product',
            'inventory_id' => 'Invenory',
            'discount_id' => 'Discount',
            'category_id' => 'Category',
            'stock_price' => 'Stock price',
            'color' => 'Colors of product',
            'size' => 'Sizes of product',
            'promotions' => 'profits of buying product',
            'ranking' => 'how many thumbs up',
            'pictures' => 'Pictures of product'
        ];
    }

    public function rules(): array
    {
        return [
            'title' => [self::RULES_REQUIRED, [
                self::RULES_UNIQUE, 'class' => self::class
            ]],
            'price' => [self::RULES_REQUIRED, [self::RULES_MINVALUE, 'min' => 0]],
            'stock_price' => [self::RULES_REQUIRED,  [self::RULES_MINVALUE, 'min' => 0]],
            'color' => [self::RULES_REQUIRED],
            'size' => [self::RULES_REQUIRED],
        ];
    }

    public function addProduct()
    {
        $available_color = $this->color;
        $available_size = $this->size;
        return $this->save();
    }

    public function save()
    {
        self::setDates();
        self::setInventory_id();
        parent::saveToDb($this->tableName(), $this->attributes());
    }

    public function setDates()
    {
        $this->created_at = Date("Y:m:d H:i:s");
        $this->modified_at = Date("Y:m:d H:i:s");
    }
    public function setInventory_id()
    {
        $quantity = '"'. $this->inventory_id . '"';
        $stmt = parent::prepare("
        insert into product_inventory (quantity, created_at) values (:param, '$this->created_at')
        ");
        $stmt->bindParam("param", $quantity);
        $stmt->execute();
        $stmt = parent::prepare("SELECT LAST_INSERT_ID()");
        $stmt->execute();
        $this->inventory_id = $stmt->fetchColumn();
    }
}
