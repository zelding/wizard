<?php
/**
 * wizard
 *
 * @author    lyozsi (kristof.dekany@apex-it-services.eu)
 * @copyright internal usage
 *
 * Date: 8/17/17 9:20 AM
 */

namespace App\Model\Common\Skill\Social;


use App\Model\Common\Skill\aSkill;
use App\Model\Common\Skill\Mastery;

class Language extends aSkill
{
    public  const TYPE = "LNG";

    public static bool $allowMultiple = true;

    public static string $name = "Language";

    /** @var string */
    public static string $category      = self::SKILL_TYPE_SCIENCE;
    /** @var int cost of SP to learn the basics*/
    public static int $baseCost      = 1;
    /** @var int cost of SP to master the skill */
    public static int $masteryCost   = 20;

    /** @var int */
    protected int $level   = 1;

    /*public function getName() : string
    {
        return self::$name.": ".$this->getRelatesTo()." (".$this->getLevel().")";
    }*/

    public function setMastery(Mastery $mastery): aSkill
    {
        $this->mastery = $mastery;

        if ( $mastery->isMaster() ) {
            $this->setLevel(5);
        }

        return $this;
    }

    /**
     * @param int $level
     *
     * @return aSkill
     */
    public function setLevel(int $level): aSkill
    {
        $this->level = $level;

        return $this;
    }

    /**
     * @return int
     */
    public function getLevel(): int
    {
        return $this->level;
    }
}
