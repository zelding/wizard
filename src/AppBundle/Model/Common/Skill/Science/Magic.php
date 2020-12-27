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
    public  const TYPE = "Magic";

    public static string $category = self::SKILL_TYPE_SCIENCE;

    public static int $baseCost       = 15;
    public static int $masteryCost    = 45;
    public static int $basePoints     = 0;
    public static array $pointsPerLevel = [0,0];
    public static string $magicType      = "generic";

    protected static string $name = "magic";

    public function getBasePoints() : int
    {
        return self::$basePoints;
    }

    public function getPointsPerLevel() : array
    {
        return self::$pointsPerLevel;
    }
}
