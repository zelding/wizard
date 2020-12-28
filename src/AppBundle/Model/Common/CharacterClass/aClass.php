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
use AppBundle\Model\Common\SkillProvider;
use AppBundle\Model\Common\Stats\aStat;
use AppBundle\Model\Common\Stats\Base\{
    Astral,Beauty,Dexterity,Intelligence,Perception,Speed,Stamina,Strength,Vitality,Willpower
};
use AppBundle\Model\Mechanics\Dice\D4;
use AppBundle\Model\Mechanics\Dice\D6;
use AppBundle\Model\Mechanics\Dice\DiceRoll;

abstract class aClass implements SkillProvider
{
    /** @var int|string */
    public  const TYPE     = "-1" ?? -1;
    /** @var int|string */
    public  const SUB_TYPE = "-1" ?? -1;

    public static bool $playable = false;

    protected static string $name      = "";
    /** @var aStat[] */
    protected static array $modifiers = [];

    /**
     * aDice[], modifier, number of rolls (highest counts), allow special training
     *
     * @var array[]
     */
    protected static array $baseStatRanges = [
        Strength::TYPE     => [ [D6::class], 0, 1, true ],
        Stamina::TYPE      => [ [D6::class], 0, 1, true ],
        Dexterity::TYPE    => [ [D6::class], 0, 1, true ],
        Speed::TYPE        => [ [D6::class], 0, 1, true ],
        Vitality::TYPE     => [ [D6::class], 0, 1, true ],
        Beauty::TYPE       => [ [D6::class], 0, 1, true ],
        Intelligence::TYPE => [ [D6::class], 0, 1, true ],
        Willpower::TYPE    => [ [D6::class], 0, 1, true ],
        Astral::TYPE       => [ [D6::class], 0, 1, true ],
        Perception::TYPE   => [ [D6::class], 0, 1, true ]
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
    protected static array $painPointsPerLevel = [[D4::class], 0, 1];
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
     * @return DiceRoll
     */
    public static function getPainPointsPerLevel(): DiceRoll
    {
        return new DiceRoll(...static::$painPointsPerLevel);
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
