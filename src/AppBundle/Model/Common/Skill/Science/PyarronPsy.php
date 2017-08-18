<?php
/**
 * wizard
 *
 * @author    lyozsi (kristof.dekany@apex-it-services.eu)
 * @copyright internal usage
 *
 * Date: 8/18/17 11:58 AM
 */

namespace AppBundle\Model\Common\Skill\Science;


class PyarronPsy extends Psy
{
    const TYPE = "PSY-PY";

    public static $baseCost    = 20;
    public static $masteryCost = 55;

    /** @var int at mastery_basic */
    public static $basePoints     = 4;
    /** @var int at mastery_basic */
    public static $pointsPerLevel = 3;

    protected static $name = "Psy (Pyarron)";
    /** @var int The character level when when skill was learned */
    protected $learnedAt = 1;
    /** @var int The level when the mastery was updated */
    protected $upgradedAt = 0;

    public function getName(): string
    {
        return self::$name;
    }

    public function getBasePoints()
    {
        if ( $this->mastery === self::MASTERY_BASIC ) {
            return 4;
        }

        return 5;
    }

    public function getPointsPerLevel()
    {
        if ( $this->mastery === self::MASTERY_BASIC ) {
            return 3;
        }

        return 4;
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
     * @return PyarronPsy
     */
    public function setLearnedAt(int $learnedAt): PyarronPsy
    {
        $this->learnedAt = $learnedAt;

        return $this;
    }

    /**
     * @return int
     */
    public function getUpgradedAt(): int
    {
        return $this->upgradedAt;
    }

    /**
     * @param int $upgradedAt
     *
     * @return PyarronPsy
     */
    public function setUpgradedAt(int $upgradedAt): PyarronPsy
    {
        $this->upgradedAt = $upgradedAt;

        return $this;
    }


}
