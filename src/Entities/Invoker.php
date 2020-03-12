<?php

namespace Sunxyw\Sxymc\Entities;

/**
 * 调用者实体
 *
 * @package Sunxyw\Sxymc\Entities
 * @author sunxyw <xy2496419818@gmail>
 */
class Invoker
{
    /**
     * 调用者名称
     *
     * @var string
     */
    public $name;

    /**
     * 是否为 OP
     *
     * @var boolean
     */
    public $isOP;

    /**
     * 游戏模式
     *
     * @var string
     */
    public $gamemode;

    /**
     * 登录IP
     *
     * @var string
     */
    public $ip;

    /**
     * 创建调用者实例
     *
     * @param array $data 包含调用者信息的数组
     */
    public function __construct(array $data)
    {
        $this->name = $data['Name'];
        if ($this->name != '@Console') {
            $this->gamemode = strtolower($data['GameMode']);
            $this->isOP = $data['IsOP'];
            $this->ip = str_replace('\\/', '', $data['IP']);
        }
    }

    /**
     * 判断调用者是否为控制台
     *
     * @return boolean
     */
    public function isConsole()
    {
        return $this->name == '@Console';
    }

    /**
     * 判断调用者有无管理权限
     *
     * @return boolean
     */
    public function hasSudoPermission()
    {
        return $this->isOP || $this->name == '@Console';
    }
}
