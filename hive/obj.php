<?php

/* this is object for convert array to class */

namespace Hive;

class Obj
{
    private $object = [];
    public function __construct($array)
    {
        $this->object = $this;
        foreach ($array as $key => $value) {
            $this->object->$key = $value;
        }
    }
}
