<?php
/**
 * wizard
 *
 * @author    lyozsi (kristof.dekany@apex-it-services.eu)
 * @copyright internal usage
 *
 * Date: 8/10/17 9:28 AM
 */

namespace AppBundle\Model\Common\Race;

use AppBundle\Model\Common\Stats\aStat;
use AppBundle\Model\Common\Stats\Base\Astral;
use AppBundle\Model\Common\Stats\Base\Beauty;
use AppBundle\Model\Common\Stats\Base\Dexterity;
use AppBundle\Model\Common\Stats\Base\Intelligence;
use AppBundle\Model\Common\Stats\Base\Perception;
use AppBundle\Model\Common\Stats\Base\Speed;
use AppBundle\Model\Common\Stats\Base\Stamina;
use AppBundle\Model\Common\Stats\Base\Strength;
use AppBundle\Model\Common\Stats\Base\Vitality;
use AppBundle\Model\Common\Stats\Base\Willpower;

abstract class aRace
{
    /** @var int|string */
    const TYPE = "-1" ?? -1;

    /** @var string */
    protected static $name      = "";
    /** @var aStat[] */
    protected static $baseStatModifiers = [];
    /** @var aStat[] */
    protected static $combatStatModifiers = [];

    protected static $maxBaseStats      = [
        Strength::TYPE     => 18,
        Stamina::TYPE      => 18,
        Dexterity::TYPE    => 18,
        Speed::TYPE        => 18,
        Vitality::TYPE     => 18,
        Beauty::TYPE       => 18,
        Intelligence::TYPE => 18,
        Willpower::TYPE    => 18,
        Astral::TYPE       => 18,
        Perception::TYPE   => 18
    ];

    protected static $playable          = false;

    /**
     * list of skills that the race has naturally
     *
     * @var array
     */
    protected static $baseSkills = [];

    #region Getters

    /**
     * @return string
     */
    public static function getName(): string
    {
        return static::$name;
    }

    /**
     * @return aStat[]
     */
    public static function getBaseStatModifiers(): array
    {
        return static::$baseStatModifiers;
    }

    /**
     * @return array
     */
    public static function getMaxBaseStats(): array
    {
        return static::$maxBaseStats;
    }

    /**
     * @return bool
     */
    public static function isPlayable(): bool
    {
        return static::$playable;
    }

    /**
     * @return array
     */
    public static function getBaseSkills(): array
    {
        return static::$baseSkills;
    }

    /**
     * @return aStat[]
     */
    public static function getCombatStatModifiers(): array
    {
        return static::$combatStatModifiers;
    }

    #endregion
}
