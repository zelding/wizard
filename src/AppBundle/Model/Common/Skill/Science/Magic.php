<?php
/**
 * wizard
 *
 * @author    lyozsi (kristof.dekany@apex-it-services.eu)
 * @copyright internal usage
 *
 * Date: 8/18/17 11:45 AM
 */

namespace AppBundle\Model\Common\Skill\Science;


use AppBundle\Model\Common\Skill\aSkill;

abstract class Magic extends aSkill
{
    const TYPE = "Magic";

    public static $category = self::SKILL_TYPE_SCIENCE;

    public static $baseCost    = 15;
    public static $masteryCost = 45;

    public static $basePoints     = 0;
    public static $pointsPerLevel = 0;

    protected static $name = "magic";

    public function getBasePoints()
    {
        return static::$basePoints;
    }

    public function getPointsPerLevel()
    {
        return static::$pointsPerLevel;
    }
}
