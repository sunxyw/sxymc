<?php

namespace Sunxyw\Sxymc;

use Illuminate\Support\Collection;
use Sunxyw\Sxymc\Abstracts\CommandAbstract;
use Sunxyw\Sxymc\Entities\Invoker;
use Sunxyw\Sxymc\Exceptions\CommandNotExistException;
use Sunxyw\Sxymc\Exceptions\InvalidArgumentException;
use Sunxyw\Sxymc\Helpers\OutputHelper;

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
     * @param string|callable $command 命令实体类名|匿名命令
     * @param string|null $command_name 命令名称
     * @return void
     */
    public function register($command, $command_name = null)
    {
        if (is_callable($command)) {
            if (is_null($command_name)) {
                throw new InvalidArgumentException('Required command_name when passed object that not extends CommandAbstract.');
            }

            $type = 'function';
            $exec = $command;
        } elseif (is_string($command)) {
            $type = 'class';
            $command_name = $command->name;
            $exec = $command;
        } else {
            throw new InvalidArgumentException('Unknown command type.');
        }

        $this->commands->add([
            'type' => $type,
            'name' => $command_name,
            'exec' => $exec
        ]);
    }

    /**
     * 处理请求
     *
     * @param array $request 请求参数，$_POST 或 request()->all()
     * @return void
     */
    public function handle(array $request)
    {
        if (!isset($request['args']) || count($request['args']) < 1) {
            throw new InvalidArgumentException('Argument missing: Required command name.');
        }
        $command_name = array_shift($request['args']);
        $command = $this->commands->where('name', $command_name)->first();

        if (is_null($command)) {
            throw new CommandNotExistException("Unknown command: {$command_name}.");
        }

        $jdata = json_decode($request['jsonData'], true);

        $invoker = new Invoker($jdata['Invoker']);

        if ($command['type'] == 'class') {
            $command_instance = new $command['exec']($invoker, $request['args']);
            return $command_instance->exec(...$request['args']);
        } else {
            return $command['exec'](new class
            {
                use OutputHelper;
            }, $invoker, ...$request['args']);
        }
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
