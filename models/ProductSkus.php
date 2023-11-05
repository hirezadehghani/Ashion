<?php

namespace app\models;

use app\core\Model;

class ProductSkus extends Model
{
    public int $product_id = 0;
    public string $sku = '';
    public int $sku_id = 0;
    public int $regular_price = 0;
    public int $sale_price = 0;
    public int $quantity = 0;
    public int $stock_id = 0;

    public function tableName(): string
    {
        return 'product_skus';
    }

    public function attributes(): array
    {
        return ['product_id', 'sku', 'regular_price', 'sale_price', 'quantity', 'stock_id'];
    }

    public function labels(): array
    {
        return [
            'product_id' => 'Id of product',
            'sku' => 'SKU code of specific product',
            'regular_price' => 'regular_price of product',
            'sale_price' => 'sale price of product',
            'quantity' => 'quantity of product',
            'stock_id' => 'stock_id of product'
        ];
    }

    public function rules(): array
    {

        return [
            'product_id' => [self::RULES_REQUIRED],
            'sku' => [self::RULES_REQUIRED],
            'regular_price' => [self::RULES_REQUIRED],
            'sale_price' => [self::RULES_REQUIRED],
            'quantity' => [self::RULES_REQUIRED],
            'stock_id' => [self::RULES_REQUIRED],
        ];
    }

    public function add()
    {
        $this->product_id = $_GET['product_id'];
        $this->sku = $_GET['sku'];
        $this->regular_price = $_GET['regular_price'];
        $this->sale_price = $_GET['sale_price'];
        $this->quantity = $_GET['quantity'];
        $this->stock_id = $_GET['stock_id'];
        //set product_skus values in table
        return $this->save();
    }

    public function save()
    {
        parent::saveToDb($this->tableName(), $this->attributes());
    }

    public function fetchLastProductRow($tableName, $number, $order, $product_id)   {
        $stmt = self::prepare("
        SELECT * from $tableName
        WHERE product_id = $product_id
        order by sku_id $order, sku_id $order limit $number");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getObject (int $product_id) : ProductSkus {
        $stmt = parent::prepare("
        SELECT * from product_skus WHERE product_id=:product_id");
        $stmt->bindParam(":product_id", $product_id);
        $stmt->execute();
        $product_skus = new ProductSkus;
        $data = $stmt->fetch();
        if($data != null)   {
        $product_skus->product_id = $product_id;
        $product_skus->regular_price = $data['regular_price'];
        $product_skus->sale_price = $data['sale_price'];
        $product_skus->quantity = $data['quantity'];
        $product_skus->stock_id = $data['stock_id'];
        $product_skus->sku = $data['sku'];
        }
        return $product_skus;
    }

    public function getPriceStock_id (int $product_id) : array  {
        $stmt = self::prepare("
        SELECT sale_price,stock_id from product_skus
        WHERE product_id = $product_id
        AND quantity > 0
        order by sale_price ASC, sale_price ASC limit 1");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getAllObjects (int $product_id, $sku_id) : ProductSkus {
        $stmt = parent::prepare("
        SELECT * from product_skus WHERE product_id=:product_id AND sku_id =:sku_id");
        $stmt->bindParam(":product_id", $product_id);
        $stmt->bindParam(":sku_id", $sku_id);
        $stmt->execute();
        $product_skus = new ProductSkus;
        $data = $stmt->fetch();
        if($data != null)   {
        $product_skus->product_id = $product_id;
        $product_skus->regular_price = $data['regular_price'];
        $product_skus->sale_price = $data['sale_price'];
        $product_skus->quantity = $data['quantity'];
        $product_skus->stock_id = $data['stock_id'];
        $product_skus->sku = $data['sku'];
        }
        return $product_skus;
    }
}
