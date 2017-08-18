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

    public static $category = self::SKILL_TYPE_COMBAT;

    public static $baseCost      =  3;
    public static $masteryCost   = 30;
    public static $allowMultiple = true;

    protected static $modifiers = [
        self::MASTERY_BASIC  => [],
        self::MASTERY_MASTER => [
            Sequence::TYPE => 5,
            Attack::TYPE   => 10,
            Defense::TYPE  => 10,
            Aim::TYPE      => 10
        ]
    ];

    protected static $otherRelations = [
        "Item\Weapon"
    ];

    protected static $name = "Weapon handling";

    public function getName(): string
    {
        return $this->getRelatesTo()." handling";
    }

}
