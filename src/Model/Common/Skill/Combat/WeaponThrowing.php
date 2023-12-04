<?php
/**
 * wizard
 *
 * @author    lyozsi (kristof.dekany@apex-it-services.eu)
 * @copyright internal usage
 *
 * Date: 5/20/22 11:30 AM
 */

namespace App\Model\Common\Skill\Combat;

use App\Model\Common\Skill\aSkill;
use App\Model\Common\Skill\Mastery;
use App\Model\Common\Stats\Combat\Aim;
use App\Model\Common\Stats\Combat\Attack;
use App\Model\Common\Stats\Combat\Defense;
use App\Model\Common\Stats\Combat\Sequence;

class WeaponThrowing extends aSkill
{
    public  const TYPE = "WPT";

    public static string $category = self::SKILL_TYPE_COMBAT;

    public static int $baseCost       =  4;
    public static int $masteryCost    = 40;
    public static bool $allowMultiple = true;

    protected static array $modifiers = [
        Mastery::Basic->value  => [],
        Mastery::Master->value => [
            Sequence::TYPE => 0,
            Attack::TYPE   => 10,
            Defense::TYPE  => 0,
            Aim::TYPE      => 0
        ]
    ];

    protected static array $otherRelations = [
        "Item\Weapon"
    ];

    protected static string $name = "Weapon throwing";
}
