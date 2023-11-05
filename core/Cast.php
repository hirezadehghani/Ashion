<?php

namespace app\core;

class Cast
{
public function __construct($object = null)
    {
        $this->cast($object);
    }
    public function cast($object)
    {
        if (is_array($object) || is_object($object)) {
            foreach ($object as $key => $value) {
                $this->$key = $value;
            }
        }
    }
}