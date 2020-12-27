<?php
/**
 * wizard
 *
 * @author    lyozsi (kristof.dekany@apex-it-services.eu)
 * @copyright internal usage
 *
 * Date: 8/18/17 12:06 PM
 */

namespace AppBundle\Model\Common\Skill\Science;


use AppBundle\Model\Common\Skill\aSkill;

class SlanPsy extends Psy
{
    public  const TYPE = "PSY-SL";

    public static string $category = self::SKILL_TYPE_SCIENCE;

    public static int $baseCost    = 0;
    public static int $masteryCost = 0;

    public static int $basePoints     = 6;
    public static int $pointsPerLevel = 5;

    protected static string $name = "Psy (Slan)";

    public function getMastery(): string
    {
        return self::MASTERY_MASTER;
    }

    public function setMastery(string $mastery): aSkill
    {
        $this->mastery = self::MASTERY_MASTER;

        return $this;
    }
}
