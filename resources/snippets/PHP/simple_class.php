<?php 

class HelloWorld {
    private $prop;

    function __construct($prop)
    {
        $this->prop = $prop;
    }

    function getProp() {
        return $this->prop;
    }
}