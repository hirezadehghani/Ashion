<?php

declare(strict_types=1);

namespace app\models;

use app\core\Application;
use app\core\DbModel;
use app\core\Model;
use app\core\ProductModel;

class Product extends Model
{
    public int $id = 0;
    public string $title = '';
    public string $detail = '';
    public string $sku = '';
    public string $price = '';
    public string $inventory = '';
    public string $stockprice = '';
    public array $color = [];
    public array $size = [];
    public string $promotions = '';
    public array $availableColor = [];
    public array $availablesize = [];
    public int $ranking = 0;
    public array $pictures = [];
    public array $category = [];
    public array $discount = [];

    public function tableName(): string
    {
        return 'product';
    }

    public function attributes(): array
    {
        return ['title', 'detail', 'sku', 'price', 'inventory', 'stockprice', 'discount', 'stockprice', 'color', 'size', 'availableColor', 'availableSize', 'promotions', 'ranking', 'category', 'pictures'];
    }

    public function labels(): array
    {
        return [
            'title' => 'Title of product',
            'detail' => 'Description of product',
            'SKU' => 'SKU code',
            'price' => 'Price of product',
            'inventory' => 'Invenory',
            'descount' => 'Discount',
            'stockprice' => 'Stock price',
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
            'sku' => [[
                self::RULES_UNIQUE, 'class' => self::class
            ]],
            'price' => [self::RULES_REQUIRED],
            'stockprice' => [self::RULES_REQUIRED],
            'color' => [self::RULES_REQUIRED],
            'size' => [self::RULES_REQUIRED]
        ];
    }

    public function addProduct(){
        return $this->save();
    }

    public function save()
    {
        parent::saveToDb($this->tableName, $this->attributes);

    }
}
