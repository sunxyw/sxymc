<?php

use Sunxyw\Sxymc\Entities\Invoker;

abstract class CommandAbstract
{
    public $name;
    public $invoker;
    public $arguments;

    public function __construct($name, Invoker $invoker, $arguments)
    {
        $this->name = $name;
        $this->invoker = $invoker;
        $this->arguments = $arguments;
    }

    abstract public function exec();
}
