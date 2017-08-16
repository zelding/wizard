<?php
/**
 * wizard
 *
 * @author    lyozsi (kristof.dekany@apex-it-services.eu)
 * @copyright internal usage
 *
 * Date: 8/16/17 12:17 PM
 */

namespace AppBundle\Model\Common\Skill\Combat;


use AppBundle\Model\Common\Skill\aSkill;

class Leadership extends aSkill
{
    const TYPE = "LDS";

    public static $category = self::SKILL_TYPE_COMBAT;

    public static $baseCost    =  5;
    public static $masteryCost = 20;

    protected static $name = "Horseback riding";
}
