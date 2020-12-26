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


use AppBundle\Model\Common\Skill\aSkill;
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

abstract class aClass
{
    /** @var int|string */
    const TYPE     = "-1" ?? -1;
    /** @var int|string */
    const SUB_TYPE = "-1" ?? -1;

    public static bool $playable = false;

    protected static string $name      = "";
    /** @var aStat[] */
    protected static array $modifiers = [];

    /**
     * minimum, maximum, number of rolls (highest counts), allow special training
     *
     * @var array[]
     */
    protected static array $baseStatRanges = [
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
    protected static int $skillPointBase     = 0;
    /** @var int */
    protected static int $skillPointPerLevel = 0;
    /** @var int */
    protected static int $hpBase             = 1;
    /** @var int */
    protected static int $ppBase             = 1;
    /** @var int[] min, max */
    protected static array $painPointsPerLevel = [0, 0];
    /** @var array[] point, mandatory points */
    protected static array $combatModifiersPerLevel = [0, []];
    /** @var aSkill[] starting professions */
    protected static array $baseSkills = [];
    /** @var aSkill[] later professions: level => aSkill|aSkill[] */
    protected static array $lateSkills = [];
    /** @var int[] experience limit for a given level */
    protected static array $experienceTable = [];
    /** @var int experience needed after level 12 */
    protected static int $xpAfter12 = 30000;

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
    public static function getBaseSkills(): array
    {
        return static::$baseSkills;
    }

    /**
     * @return aSkill[]
     */
    public static function getLateSkills(): array
    {
        return static::$lateSkills;
    }

    /**
     * @return int[]
     */
    public static function getExperienceTable(): array
    {
        return static::$experienceTable;
    }

    /**
     * @return int
     */
    public static function getXpAfter12(): int
    {
        return static::$xpAfter12;
    }

    #endregion
}
