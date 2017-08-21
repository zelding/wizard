<?php
/**
 * wizard
 *
 * @author    lyozsi (kristof.dekany@apex-it-services.eu)
 * @copyright internal usage
 *
 * Date: 8/16/17 12:43 PM
 */

namespace AppBundle\Model\Common\Skill\Science;


use AppBundle\Model\Common\Skill\aSkill;

abstract class Psy extends aSkill
{
    const TYPE = "PSY";

    public static $category = self::SKILL_TYPE_SCIENCE;

    /** @var int points on lvl 1 */
    public static $basePoints     = 0;
    /** @var int extra points after lvl 1 */
    public static $pointsPerLevel = 0;

    /** @var int The character level when when skill was learned */
    protected $learnedAt = 1;

    protected static $name = "Psy";

    public function getBasePoints()
    {
        return static::$basePoints;
    }

    public function getPointsPerLevel()
    {
        return static::$pointsPerLevel;
    }

    /**
     * @return int
     */
    public function getLearnedAt(): int
    {
        return $this->learnedAt;
    }

    /**
     * @param int $learnedAt
     *
     * @return Psy
     */
    public function setLearnedAt(int $learnedAt): Psy
    {
        $this->learnedAt = $learnedAt;

        return $this;
    }
}
