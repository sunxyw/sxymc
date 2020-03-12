<?php

namespace Sunxyw\Sxymc;

class Handler
{
    protected $hash;

    public function __construct($password, $hash_algorithm = 'sha512')
    {
        $this->hash = hash($hash_algorithm, $password);
    }

    public function handle(array $request)
    {
        // TODO
    }
}
