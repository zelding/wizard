<?php
/**
 * wizard
 *
 * @author    lyozsi (kristof.dekany@apex-it-services.eu)
 * @copyright internal usage
 *
 * Date: 8/16/17 12:09 PM
 */

namespace AppBundle\Model\Common\Skill\Social;


use AppBundle\Model\Common\Skill\aSkill;

class HorsebackRiding extends aSkill
{
    const TYPE = "HBR";

    public static $category = self::SKILL_TYPE_SOCIAL;

    public static $baseCost    =  1;
    public static $masteryCost = 15;

    protected static $name = "Horseback riding";
}
