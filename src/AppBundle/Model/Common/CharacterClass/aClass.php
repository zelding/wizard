<?php
/**
 * wizard
 *
 * @author    lyozsi (kristof.dekany@apex-it-services.eu)
 * @copyright internal usage
 *
 * Date: 8/10/17 9:30 AM
 */

namespace AppBundle\Model\Common\CharacterClass;


use AppBundle\Model\Common\Stats\aStat;
use AppBundle\Model\Common\Stats\Astral;
use AppBundle\Model\Common\Stats\Beauty;
use AppBundle\Model\Common\Stats\Dexterity;
use AppBundle\Model\Common\Stats\Intelligence;
use AppBundle\Model\Common\Stats\Perception;
use AppBundle\Model\Common\Stats\Speed;
use AppBundle\Model\Common\Stats\Stamina;
use AppBundle\Model\Common\Stats\Strength;
use AppBundle\Model\Common\Stats\Vitality;
use AppBundle\Model\Common\Stats\Willpower;

abstract class aClass
{
    /** @var int|string */
    const TYPE     = "-1" ?? -1;
    /** @var int|string */
    const SUB_TYPE = "-1" ?? -1;

    public static $playable = false;

    /** @var string */
    protected static $name      = "";
    /** @var aStat[] */
    protected static $modifiers = [];

    /**
     * minimum, maximum, number of rolls (highest counts), allow special training
     *
     * @var array[]
     */
    protected static $baseStatRanges = [
        Strength::TYPE     => [0, 0, 1, false],
        Stamina::TYPE      => [0, 0, 1, false],
        Dexterity::TYPE    => [0, 0, 1, false],
        Speed::TYPE        => [0, 0, 1, false],
        Vitality::TYPE     => [0, 0, 1, false],
        Beauty::TYPE       => [0, 0, 1, false],
        Intelligence::TYPE => [0, 0, 1, false],
        Willpower::TYPE    => [0, 0, 1, false],
        Astral::TYPE       => [0, 0, 1, false],
        Perception::TYPE   => [0, 0, 1, false]
    ];
    /** @var int */
    protected static $skillPointBase     = 0;
    /** @var int */
    protected static $skillPointPerLevel = 0;
    /** @var int */
    protected static $hpBase             = 1;
    /** @var int */
    protected static $ppBase             = 1;
    /** @var int[] min, max */
    protected static $painPointsPerLevel = [0, 0];
    /** @var int[] point, mandatory points */
    protected static $combatModifiersPerLevel = [0, []];

    protected static $baseSkills = [];

    #region Getters

    /**
     * @return aStat[]
     */
    public static function getModifiers(): array
    {
        return static::$modifiers;
    }

    /**
     * @return string
     */
    public static function getName(): string
    {
        return static::$name;
    }

    /**
     * @return int
     */
    public static function getSkillPointBase(): int
    {
        return static::$skillPointBase;
    }

    /**
     * @return int
     */
    public static function getSkillPointPerLevel(): int
    {
        return static::$skillPointPerLevel;
    }

    /**
     * @return int
     */
    public static function getHpBase(): int
    {
        return static::$hpBase;
    }

    /**
     * @return int
     */
    public static function getPpBase(): int
    {
        return static::$ppBase;
    }

    /**
     * @return array
     */
    public static function getPainPointsPerLevel(): array
    {
        return static::$painPointsPerLevel;
    }

    /**
     * @return array
     */
    public static function getCombatModifiersPerLevel(): array
    {
        return static::$combatModifiersPerLevel;
    }

    /**
     * @return array
     */
    public static function getBaseStatRanges(): array
    {
        return static::$baseStatRanges;
    }

    /**
     * @return array
     */
    public function getBaseSkills(): array
    {
        return static::$baseSkills;
    }

    #endregion
}