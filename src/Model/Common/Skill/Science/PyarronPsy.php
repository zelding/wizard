<?php
/**
 * wizard
 *
 * @author    lyozsi (kristof.dekany@apex-it-services.eu)
 * @copyright internal usage
 *
 * Date: 8/18/17 11:58 AM
 */

namespace App\Model\Common\Skill\Science;


class PyarronPsy extends Psy
{
    public  const TYPE = "PSY-PY";

    public static int $baseCost    = 20;
    public static int $masteryCost = 55;

    /** @var int at mastery_basic */
    public static int $basePoints     = 4;
    /** @var int at mastery_basic */
    public static int $pointsPerLevel = 3;

    protected static string $name = "Psy (Pyarron)";
    /** @var int The character level when when skill was learned */
    protected int $learnedAt  = 1;
    /** @var int The level when the mastery was updated */
    protected int $upgradedAt = 0;

    public function getName(): string
    {
        return self::$name;
    }

    public function getBasePoints() : int
    {
        if ( $this->mastery === self::MASTERY_BASIC ) {
            return 4;
        }

        return 5;
    }

    public function getPointsPerLevel() : int
    {
        if ( $this->mastery === self::MASTERY_BASIC ) {
            return 3;
        }

        return 4;
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
