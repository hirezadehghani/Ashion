<?php

declare(strict_types=1);

namespace app\models;

use app\core\Model;

class Cart_item extends Model
{
    public int $id = 0;
    public int $session_id = 0;
    public int $product_id = 0;
    public int $quantity = 0;
    public string $created_at = '';
    public string $modified_at = '';

    public function tableName(): string
    {
        return 'cart_item';
    }

    public function attributes(): array
    {
        return ['session_id', 'product_id', 'quantity', 'created_at', 'modified_at'];
    }

    public function labels(): array
    {
        return [
            'session_id' => 'Session Id of shopping_session table',
            'product_id' => 'The ID of product',
            'quantity' => 'quantity of current product item',
            'created_at' => 'Date of creating this item',
            'modified_at' => 'Date of modifing this item'
        ];
    }

    public function rules(): array
    {
        return [
            'product_id' => [self::RULES_REQUIRED],
            'quantity' => [self::RULES_REQUIRED, [self::RULES_MINVALUE , 'min' => 1]],
        ];
    }

    public function addItem($session_id)
    {
        $this->session_id = $session_id;
        self::setDates();
        if($this->save());
            return 1;
    }

    public function setDates()
    {
        $this->created_at = Date("Y:m:d H:i:s");
        $this->modified_at = Date("Y:m:d H:i:s");
    }

    public function save()
    {
        parent::saveToDb($this->tableName(), $this->attributes());
    }
}
