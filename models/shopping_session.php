<?php

declare(strict_types=1);

namespace app\models;

use app\core\Model;

class Shopping_session extends Model
{
    public int $id = 0;
    public $user_id = 0;
    public $guest_session_id = 0;
    public int $total = 0;
    public string $created_at = '';
    public string $modified_at = '';

    public function tableName(): string
    {
        return 'shopping_session';
    }

    public function attributes(): array
    {
        return ['user_id', 'guest_session_id', 'total', 'created_at', 'modified_at'];
    }

    public function labels(): array
    {
        return [
            'user_id' => 'Id of specific user of user table',
            'guest_session_id' => 'The ID of session for guest visitors',
            'total' => 'total amount of current cart price',
            'created_at' => 'Date of creating this item',
            'modified_at' => 'Date of modifing this item'
        ];
    }

    public function rules(): array
    {
        return [
            'total' => [self::RULES_REQUIRED],
            'user_id' => [self::RULES_UNIQUE, 'class' => self::class],
            'guest_session_id' => [self::RULES_UNIQUE, 'class' => self::class]
        ];
    }

    public function add($guest_session_id = null, $user_id = null, $total)
    {

        $this->guest_session_id = $guest_session_id;
        $this->user_id = $user_id;
        self::setDates();
        if ($this->checkDuplicate()) {
            $this->save();
        }
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

    public function getLastSessionId($number, $order)
    {
        $stmt = parent::prepare("
        SELECT * from shopping_session
        order by id $order, id $order limit $number");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function checkDuplicate()
    {
        if ($this->guest_session_id != null) {
            if ($this->fetchRow($this->tableName(), "'$this->guest_session_id'", ['guest_session_id'], 'guest_session_id')) {
                return 0;
            }
        } else if ($this->user_id != null) {
            if ($this->fetchRow($this->tableName(), $this->user_id, ['user_id'], 'user_id')) {
                return 0;
            }
        }
        return 1;
    }

    public function mode() :string {
        if ($this->guest_session_id != null)    return "guest";
        if ($this->user_id != null)    return "user";
    }

    public function getSessionId()  {
        if($this->mode()=='guest') return $this->guest_session_id; 
        if($this->mode()=='user') return $this->user_id; 
    }
}
