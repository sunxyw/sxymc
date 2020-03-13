<?php

namespace Sunxyw\Sxymc\Abstracts;

use Sunxyw\Sxymc\Entities\Invoker;
use Illuminate\Support\Collection;

/**
 * 命令抽象类
 *
 * @package Sunxyw\Sxymc\Abstracts
 * @author sunxyw <xy2496419818@gmail>
 */
abstract class CommandAbstract
{
    /**
     * 命令名称
     *
     * @var string
     */
    public $name;

    /**
     * 命令调用者
     *
     * @var Invoker
     */
    public $invoker;

    /**
     * 命令参数
     *
     * @var Collection
     */
    public $arguments;

    /**
     * 实例化命令类
     *
     * @param string $name
     * @param Invoker $invoker
     * @param Collection $arguments
     */
    public function __construct($name, Invoker $invoker, Collection $arguments)
    {
        $this->name = $name;
        $this->invoker = $invoker;
        $this->arguments = $arguments;
    }

    /**
     * 定义如何执行命令
     *
     * @return void
     */
    abstract public function exec();
}
