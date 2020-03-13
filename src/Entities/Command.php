<?php

namespace Sunxyw\Sxymc\Entities;

use Sunxyw\Sxymc\Abstracts\CommandAbstract;
use Sunxyw\Sxymc\Exceptions\InvalidArgumentException;
use Sunxyw\Sxymc\Helpers\OutputHelper;

/**
 * 命令实体类
 *
 * @package Sunxyw\Sxymc\Entities
 * @author sunxyw <xy2496419818@gmail>
 */
class Command extends CommandAbstract
{
    use OutputHelper;

    /**
     * 定义如何执行命令
     *
     * @return void
     */
    public function handle()
    {
        // Override this
    }

    /**
     * 内部方法
     * 执行命令
     *
     * @return void
     */
    public function exec()
    {
        $this->handle();

        return $this->response();
    }
}
