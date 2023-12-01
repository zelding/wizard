<?php
/**
 * wizard
 *
 * @author    lyozsi (kristof.dekany@apex-it-services.eu)
 * @copyright internal usage
 *
 * Date: 8/18/17 12:06 PM
 */

namespace App\Model\Common\Skill\Science;


use App\Model\Common\Skill\aSkill;
use App\Model\Common\Skill\Mastery;

class SlanPsy extends Psy
{
    public  const TYPE = "PSY-SL";

    public static string $category = self::SKILL_TYPE_SCIENCE;

    public static int $baseCost    = 0;
    public static int $masteryCost = 0;

    public static int $basePoints     = 6;
    public static int $pointsPerLevel = 5;

    protected static string $name = "Psy (Slan)";

    public function getMastery(): Mastery
    {
        return Mastery::Master();
    }

    public function setMastery(Mastery $mastery): aSkill
    {
        $this->mastery = $mastery::Master();

        return $this;
    }
}
