<?php

namespace Sunxyw\Sxymc;

use Illuminate\Support\Collection;
use Sunxyw\Sxymc\Abstracts\CommandAbstract;

/**
 * 请求处理类
 *
 * @package Sunxyw\Sxymc
 * @author sunxyw <xy2496419818@gmail>
 */
class Handler
{
    /**
     * 用于验证请求有效性的哈希值
     *
     * @var string
     */
    protected $hash;

    /**
     * 已注册的命令
     *
     * @var Collection
     */
    protected $commands;

    /**
     * 实例化请求处理类
     *
     * @param string $password 在 WebSend 配置文件处设置的密码
     * @param string $hash_algorithm 哈希方法
     */
    public function __construct($password, $hash_algorithm = 'sha512')
    {
        $this->hash = hash($hash_algorithm, $password);
        $this->commands = collect();
    }

    /**
     * 注册命令
     *
     * @param CommandAbstract $command 命令实体类
     * @return void
     */
    public function register(CommandAbstract $command)
    {
        $command_name = $command->name;
        $exec = $command->exec;

        $this->commands->add([
            'name' => $command_name,
            'exec' => $exec
        ]);
    }

    /**
     * 处理请求
     *
     * @param array $request
     * @return void
     */
    public function handle(array $request)
    {
        // TODO
    }

    /**
     * 验证请求有效性
     *
     * @param string $authKey WebSend 传来的 authKey
     * @return boolean 是否有效
     */
    protected function verifyRequest($authKey)
    {
        return $authKey == $this->hash;
    }
}
