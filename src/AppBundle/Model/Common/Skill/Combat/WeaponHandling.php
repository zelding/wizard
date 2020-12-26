<?php
/**
 * wizard
 *
 * @author    lyozsi (kristof.dekany@apex-it-services.eu)
 * @copyright internal usage
 *
 * Date: 8/10/17 11:19 AM
 */

namespace AppBundle\Model\Common\Skill\Combat;


use AppBundle\Model\Common\Skill\aSkill;
use AppBundle\Model\Common\Stats\Combat\Aim;
use AppBundle\Model\Common\Stats\Combat\Attack;
use AppBundle\Model\Common\Stats\Combat\Defense;
use AppBundle\Model\Common\Stats\Combat\Sequence;

class WeaponHandling extends aSkill
{
    const TYPE = "WPH";

    public static string $category = self::SKILL_TYPE_COMBAT;

    public static int $baseCost      =  3;
    public static int $masteryCost   = 30;
    public static bool $allowMultiple = true;

    protected static array $modifiers = [
        self::MASTERY_BASIC  => [],
        self::MASTERY_MASTER => [
            Sequence::TYPE => 5,
            Attack::TYPE   => 10,
            Defense::TYPE  => 10,
            Aim::TYPE      => 10
        ]
    ];

    protected static array $otherRelations = [
        "Item\Weapon"
    ];

    protected static string $name = "Weapon handling";

    public function getName(): string
    {
        return $this->getRelatesTo()." handling";
    }

}
