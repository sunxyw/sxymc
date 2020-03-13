<?php

namespace Sunxyw\Sxymc\Entities;

use Sunxyw\Sxymc\Abstracts\CommandAbstract;
use Sunxyw\Sxymc\Exceptions\InvalidArgumentException;

/**
 * 命令实体类
 *
 * @package Sunxyw\Sxymc\Entities
 * @author sunxyw <xy2496419818@gmail>
 */
class Command extends CommandAbstract
{
    /**
     * 输出缓存
     *
     * @var array
     */
    protected $outputBuffer = [];

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

        return implode(';', $this->outputBuffer);
    }

    /**
     * 输出信息
     *
     * @param string $target 输出对象
     * @param string $content 信息内容
     * @return void
     */
    public function output($target, $content)
    {
        if (!in_array($target, ['Player', 'Console'])) {
            throw new InvalidArgumentException('Invalid target: only accept [\'Player\', \'Console\'].');
        }

        $this->outputBuffer[] = "/Output/PrintTo{$target}:{$content}";
    }

    /**
     * 执行服务器命令
     *
     * @param string $command 要执行的命令
     * @return void
     */
    public function execCommand($command)
    {
        $this->outputBuffer[] = "/Command/ExecuteConsoleCommand:{$command}";
    }

    /**
     * 向玩家输出信息
     *
     * @param string $content 信息内容
     * @return void
     */
    public function tellPlayer($content)
    {
        $this->output('Player', $content);
    }

    /**
     * 全服广播
     *
     * @param string $content 广播内容
     * @return void
     */
    public function broadcast($content)
    {
        $this->execCommand("say $content");
    }

    /**
     * 向控制台输出信息
     *
     * @param string $content 信息内容
     * @return void
     */
    public function logConsole($content)
    {
        $this->output('Console', $content);
    }
}
