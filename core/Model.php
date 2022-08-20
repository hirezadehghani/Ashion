<?php

namespace app\core;

abstract class Model
{
    public const RULES_REQUIRED = 'required';
    public const RULES_EMAIL = 'email';
    public const RULES_MIN = 'min';
    public const RULES_MAX = 'max';
    public const RULES_MATCH = 'match';
    public const RULES_UNIQUE = 'unique';
    public const RULES_MINVALUE = 'minValue';
    public const RULES_MAXVALUE = 'maxvalue';
    public const RULES_UNCORRECT = 'uncorrect';

    public function loadData($data)
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }

    abstract public function rules(): array;

    public array $errors = [];

    public function validate()
    {
        foreach ($this->rules() as $attribute => $rules) {
            $value = $this->{$attribute};
            foreach ($rules as $rule) {
                $ruleName = $rule;
                if (!is_string($ruleName)) {
                    $ruleName = $rule[0];
                }
                if ($ruleName === self::RULES_REQUIRED && !$value) {
                    $this->addError($attribute, self::RULES_REQUIRED);
                }
                if ($ruleName === self::RULES_EMAIL && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->addError($attribute, self::RULES_EMAIL);
                }
                if ($ruleName === self::RULES_MIN && strlen($value) < $rule['min']) {
                    $this->addError($attribute, self::RULES_MIN, $rule);
                }
                if ($ruleName === self::RULES_MAX && strlen($value) > $rule['max']) {
                    $this->addError($attribute, self::RULES_MAX, $rule);
                }
                if ($ruleName === self::RULES_MINVALUE && $value < $rule['min']) {
                    $this->addError($attribute, self::RULES_MINVALUE, $rule);
                }
                if ($ruleName === self::RULES_MAXVALUE && $value > $rule['max']) {
                    $this->addError($attribute, self::RULES_MAXVALUE, $rule);
                }
                if ($ruleName === self::RULES_MATCH && $value !== $this->{$rule['match']}) {
                    $this->addError($attribute, self::RULES_MATCH, $rule);
                }
                if ($ruleName === self::RULES_UNIQUE) {
                    $className = $rule['class'];
                    $uniqueAttr = $rule['attribute'] ?? $attribute;
                    $tableName = $className::tableName();
                    $statement = Application::$app->db->prepare("SELECT * from $tableName WHERE $uniqueAttr = :$uniqueAttr");
                    $statement->bindValue(":$uniqueAttr", $value);
                    $statement->execute();
                    $record = $statement->fetchObject();
                    if ($record) {
                        $this->addError($attribute, self::RULES_UNIQUE, ['field' => $attribute]);
                    }
                }
            }
        }

        return empty($this->errors);
    }

    public function addError(string $attribute, string $rule, $params = [])
    {
        $message = $this->errorMessages()[$rule] ?? '';
        foreach ($params as $key => $value) {
            $message = str_replace("{{$key}}", $value, $message);
        }
        $this->errors[$attribute][] = $message;
    }
    public function errorMessages()
    {
        return [
            self::RULES_REQUIRED => 'این فیلد ضروری است! لطفا آن را تکمیل نمایید',
            self::RULES_EMAIL => 'ایمیل وارد شده می بایست معتبر باشد مثل example@gmail.com',
            self::RULES_MIN => 'حداقل طول فیلد {min} است',
            self::RULES_MAX => 'حداکثر طول فیلد {max} است',
            self::RULES_MATCH => 'این فیلد باید با فیلد {match} یکسان باشد',
            self::RULES_UNIQUE => 'اطلاعات وارد شده تکراری می باشد',
            self::RULES_MINVALUE => 'عدد وارد شده باید بیشتر یا مساوی {min} باشد',
            self::RULES_MAXVALUE => 'عدد وارد شده باید کمتر یا مساوی {max} باشد',
            self::RULES_UNCORRECT => 'ایمیل یا رمز عبور وارد شده اشتباه است'
        ];
    }

    public function hasError($attribute)
    {
        return $this->errors[$attribute] ?? false;
    }
    public function getFirstError($attribute)
    {
        return $this->errors[$attribute][0] ?? false;
    }

    public function saveToDb($tableName, $attributes)
    {
        $params = [];
        $params = array_map(fn ($attr) => ":$attr", $attributes);
        $statement = self::prepare(
            "INSERT INTO $tableName (" . implode(',', $attributes) . ") 
        VALUES (" . implode(',', $params) . ")"
        );

        foreach ($attributes as $attribute) {
            $statement->bindValue(":$attribute", $this->{$attribute});
        }
        $statement->execute();
        return true;
    }

    public function prepare($sql)
    {
        return Application::$app->db->pdo->prepare($sql);
    }

    public function fetchItem($tableName, $param)
    {
        $statement = self::prepare(
            "SELECT $param from $tableName"
        );
        $statement->execute();
        return $statement->fetchAll();
    }


    public function fetchGroup($tableName, $params)
    {
        $statement = self::prepare(
            "SELECT " . implode(',', $params) . " from $tableName"
        );

        $statement->execute();
        return $statement->fetchAll();
    }

    public function fetchAll($tableName)
    {
        $stmt = self::prepare(
            "SELECT * from $tableName"
        );
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function fetchWithLimit($tableName, $limit, $params)
    {
        $statement = self::prepare(
            "SELECT " . implode(',', $params) . " from $tableName LIMIT $limit"
        );
        $statement->execute();
        return $statement->fetchAll();
    }

    public function fetchRow($tableName, $RowId, $params = [], $colIdName = 'id')
    {
        $statement = self::prepare(
            "SELECT " . implode(',', $params) . " from $tableName WHERE $colIdName = $RowId"
        );
        $statement->execute();
        return $statement->fetch();
    }

    public function fetchWhere($tableName, $colName, $where)
    {
        $statement = self::prepare(
            "SELECT * from $tableName WHERE $colName = $where"
        );
        $statement->execute();
        return $statement->fetchAll();
    }

    public function fetchLastRow($tableName, $number, $order)   {
        $stmt = self::prepare("
        SELECT * from $tableName
        order by id $order, id $order limit $number");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function update($what, $tableName, $value, $colName, $where)
    {
        $statement = self::prepare(
            "UPDATE $what from $tableName SET $what=$value WHERE $colName = $where"
        );
        $statement->execute();
        return $statement->fetchAll();
    }
}
