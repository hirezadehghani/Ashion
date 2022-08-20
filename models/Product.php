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
    public float $regular_price = 0;
    public float $sale_price = 0;
    public string $promotions = '';
    public float $ranking = 0;
    public string $pictures = '';
    public int $category_id;
    public string $created_at = '';
    public $modified_at = '';
    public $deleted_at = '';
    public int $stock_id;

    public function tableName(): string
    {
        return 'product';
    }

    public function attributes(): array
    {
        return ['title', 'detail', 'sku', 'regular_price', 'sale_price', 'promotions', 'ranking', 'category_id', 'pictures', 'stock_id'];
    }

    public function labels(): array
    {
        return [
            'title' => 'Title of product',
            'detail' => 'Description of product',
            'SKU' => 'SKU code',
            'regular_price' => 'Regular price of product',
            'sale_price' => 'Sale price of product',
            'discount_id' => 'Discount',
            'category_id' => 'Category',
            'stock_id' => 'Id of stock of product',
            'promotions' => 'profits of buying product',
            'ranking' => 'how many thumbs up',
            'pictures' => 'Pictures of product'
        ];
    }

    public function rules(): array
    {
        return [
            'regular_price' => [[self::RULES_MINVALUE, 'min' => 0]],
            'sale_price' => [self::RULES_REQUIRED, [self::RULES_MINVALUE, 'min' => 0]],
            'title' => [self::RULES_REQUIRED, [self::RULES_UNIQUE, 'class' => self::class]],
            'sku' => [self::RULES_REQUIRED, [self::RULES_UNIQUE, 'class'=> self::class]],
            'pictures' => [self::RULES_REQUIRED]
        ];
    }

    public function addProduct()
    {
        return $this->save();
    }

    public function save()
    {
        self::setDates();
        // self::setInventory_id();
        parent::saveToDb($this->tableName(), $this->attributes());
    }

    public function setDates()
    {
        $this->created_at = Date("Y:m:d H:i:s");
        $this->modified_at = Date("Y:m:d H:i:s");
    }
    // public function setInventory_id()
    // {
    //     $quantity = '"'. $this->inventory_id . '"';
    //     $stmt = parent::prepare("
    //     insert into product_inventory (quantity, created_at) values (:param, '$this->created_at')
    //     ");
    //     $stmt->bindParam("param", $quantity);
    //     $stmt->execute();
    //     $stmt = parent::prepare("SELECT LAST_INSERT_ID()");
    //     $stmt->execute();
    //     $this->inventory_id = $stmt->fetchColumn();
    // }
    
    public function getLastProduct($number, $order)   {
        $stmt = parent::prepare("
        SELECT * from product
        order by id $order, id $order limit $number");
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function getAttributes ()   {
        $stmt = parent::prepare("
        SELECT * from product_attributes;
        ");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getObject (int $id) : Product {
        $stmt = parent::prepare("
        SELECT * from product WHERE id=:id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        $product = new Product;
        $data = $stmt->fetch();
        $product->id = $data['id'];
        $product->title = $data['title'];
        $product->detail = $data['detail'];
        $product->sku = $data['sku'];
        $product->regular_price = $data['regular_price'];
        $product->sale_price = $data['sale_price'];
        $product->promotions = $data['promotions'];
        $product->ranking = $data['ranking'];
        $product->pictures = $data['pictures'];
        $product->category_id = $data['category_id'];
        $product->created_at = $data['created_at'];
        $product->modified_at = $data['modified_at'];
        $product->deleted_at = $data['deleted_at'];
        $product->stock_id = $data['stock_id'];

        return $product;
    }

    // public function getLastRowProduct   {
    //     return $this->fetchRow()
    // }

    public function findRelatedProducts() :array {
        $category = new Category;
        //Finding Related Products
            //if in category of this product not found search in other categories

            $products = $this->fetchGroup("product", ['id', 'category_id']);
            $productIds = [];
            $relatedProducts = [];
            foreach ($products as $productItem) {
                if ($productItem['id'] != $this->id)
                    array_push($productIds, ['id' => $productItem['id'], 'category_id' => $productItem['category_id']]);
            }
            //Unset this product from related 
            $categoryId = $this->category_id;
            $find = 1;
            $count = 1;
            while ($find != 0) {
                if ($count > 4)
                    $find = 0;
                else {
                    foreach ($productIds as $productItem) {
                        if ($categoryId == $productItem['category_id']) {
                            if($count > 4)  break;
                            unset($productIds[array_search(['id' => $productItem['id'], 'category_id' => $productItem['category_id']], $productIds)]);
                            $count++;
                            array_push($relatedProducts, $productItem['id']);
                        }
                    }
                }
                if ($count < 4) {
                    $lastCategory = $category->getLastCategory(1, 'DESC')[0];
                    $categoryId = rand(1, $lastCategory['id']);
                    foreach ($productIds as $productItem) {
                        if($count > 4)  break;
                        unset($productIds[array_search(['id' => $productItem['id'], 'category_id' => $productItem['category_id']], $productIds)]);
                        array_push($relatedProducts, $productItem['id']);
                        $count++;
                    }
                }
            }
            return $relatedProducts;
    }
    public function getPictureAddr($index, $pictures) : string {
        return UPLOAD_DIR . json_decode($pictures, true)[$index];
        
    }

    public function getPriceSign() : string {
        return 'ریال';
    }

    public function addToCart () {
        return 1;
        
    }
}