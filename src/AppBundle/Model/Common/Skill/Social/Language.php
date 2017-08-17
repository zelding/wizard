<?php
/**
 * wizard
 *
 * @author    lyozsi (kristof.dekany@apex-it-services.eu)
 * @copyright internal usage
 *
 * Date: 8/17/17 9:20 AM
 */

namespace AppBundle\Model\Common\Skill\Social;


use AppBundle\Model\Common\Skill\aSkill;

class Language extends aSkill
{
    const TYPE = "LNG";

    public static $allowMultiple = true;

    public static $name = "Language";

    /** @var string */
    public static $category      = self::SKILL_TYPE_SCIENCE;
    /** @var int cost of SP to learn the basics*/
    public static $baseCost      = 1;
    /** @var int cost of SP to master the skill */
    public static $masteryCost   = 20;

    /** @var int */
    protected $level   = 1;

    public function getName() : string
    {
        return static::$name.": ".$this->getRelatesTo()." (".$this->getLevel().")";
    }

    public function setMastery(string $mastery): aSkill
    {
        $this->mastery = $mastery;

        if ( $mastery === self::MASTERY_MASTER ) {
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
