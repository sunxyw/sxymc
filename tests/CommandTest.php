<?php

namespace Sunxyw\Sxymc\Tests;

use PHPUnit\Framework\TestCase;
use Sunxyw\Sxymc\Entities\Command;
use Sunxyw\Sxymc\Entities\Invoker;

class CommandTest extends TestCase
{
    public function testInitCommand()
    {
        $invoker = new Invoker(json_decode('{"Health":20,"IP":"\/127.0.0.1:2119","FoodLevel":20,"IsOP":true,"XPLevel":0,"CurrentItemIndex":0,"UUIDVersion":4,"Name":"sunxyw","GameMode":"CREATIVE","Exhaustion":0.30000001192092896,"XP":0,"CurrentItemID":0,"UUID":"97a5eca0-5686-4d7b-beb6-843aae6f8210","Inventory":[],"Location":{"X":-181.28224488535892,"Pitch":42.14999771118164,"Y":88,"Z":203.25455357116917,"World":"world","Yaw":-151.8268585205078}}'));
        $command = new Command($invoker, collect(["example", "arg1", "arg2"]));

        // TODO
    }
}
