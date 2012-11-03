<?php
require_once 'phing/Task.php';
require_once __DIR__.'/../../vendor/composer/autoload_classmap.php';
require_once __DIR__.'/../../vendor/autoload.php';

class Parameter extends Task
{
    private $key = null;
    private $value = null;

    public function setKey($key)
    {
        $this->key = $key;
    }

    public function setValue($value)
    {
        $this->value = $value;
    }

    public function init()
    {

    }

    public function main()
    {
        print("foo");
    }
}
