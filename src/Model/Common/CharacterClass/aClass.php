<?php
/**
 * wizard
 *
 * @author    lyozsi (kristof.dekany@apex-it-services.eu)
 * @copyright internal usage
 *
 * Date: 8/10/17 9:30 AM
 */

namespace App\Model\Common\CharacterClass;


use App\Model\Common\Skill\aSkill;
use App\Model\Common\SkillProvider;
use App\Model\Common\Stats\aStat;
use App\Model\Common\Stats\Base\{Astral,
    Beauty,
    Dexterity,
    Intelligence,
    Perception,
    Speed,
    Stamina,
    Strength,
    Vitality,
    Willpower};
use App\Model\Common\Stats\Combat\Aim;
use App\Model\Common\Stats\Combat\Attack;
use App\Model\Common\Stats\Combat\Damage;
use App\Model\Common\Stats\Combat\Defense;
use App\Model\Common\Stats\Combat\Sequence;
use App\Model\Mechanics\Dice\aDice;
use App\Model\Mechanics\Dice\D4;
use App\Model\Mechanics\Dice\D6;
use App\Model\Mechanics\Dice\DiceRoll;
use App\Model\Mechanics\LevelUp\CombatStatsPerLevel;
use JetBrains\PhpStorm\ArrayShape;

abstract class aClass implements SkillProvider
{
    /** @var int|string */
    public  const TYPE     = "-1" ?? -1;
    /** @var int|string */
    public  const SUB_TYPE = "-1" ?? -1;

    public static bool $playable = false;

    protected static string $name      = "";

    #[ArrayShape([
        Sequence::class => "int",
        Attack::class   => "int",
        Defense::class  => "int",
        Aim::class      => "int",
        Damage::class   => "array",
    ])]
    protected static array $modifiers = [];

    /**
     * aDice[], modifier, number of rolls (the highest counts), allow special training
     *
     * @var array[]
     */
    #[ArrayShape([
        Strength::class     => [DiceRoll::class, "int", "int", "bool"],
        Stamina::class      => [DiceRoll::class, "int", "int", "bool"],
        Dexterity::class    => [DiceRoll::class, "int", "int", "bool"],
        Speed::class        => [DiceRoll::class, "int", "int", "bool"],
        Vitality::class     => [DiceRoll::class, "int", "int", "bool"],
        Beauty::class       => [DiceRoll::class, "int", "int", "bool"],
        Intelligence::class => [DiceRoll::class, "int", "int", "bool"],
        Willpower::class    => [DiceRoll::class, "int", "int", "bool"],
        Astral::class       => [DiceRoll::class, "int", "int", "bool"],
        Perception::class   => [DiceRoll::class, "int", "int", "bool"]
    ])]
    protected static array $baseStatRanges = [
        Strength::class     => [ [D6::class], 0, 1, true ],
        Stamina::class      => [ [D6::class], 0, 1, true ],
        Dexterity::class    => [ [D6::class], 0, 1, true ],
        Speed::class        => [ [D6::class], 0, 1, true ],
        Vitality::class     => [ [D6::class], 0, 1, true ],
        Beauty::class       => [ [D6::class], 0, 1, true ],
        Intelligence::class => [ [D6::class], 0, 1, true ],
        Willpower::class    => [ [D6::class], 0, 1, true ],
        Astral::class       => [ [D6::class], 0, 1, true ],
        Perception::class   => [ [D6::class], 0, 1, true ]
    ];

    protected static int $skillPointBase     = 0;

    protected static int $skillPointPerLevel = 0;

    protected static int $hpBase             = 1;

    protected static int $ppBase             = 1;

    /** @var array min, max */
    #[ArrayShape([
        [aDice::class, aDice::class, aDice::class],   // dices to roll
        "int",                                        // flat modifier
        "int"                                         // number of tries
    ])]
    protected static array $painPointsPerLevel = [[D4::class], 0, 1];

    #[ArrayShape([
        0 => "int",                     // points per level
        1 => [                          // mandatory usage per level per stat
            Sequence::class => "int",
            Attack::class   => "int",
            Defense::class  => "int",
            Aim::class      => "int"
        ]
    ])]
    protected static array $combatModifiersPerLevel = [0, []];
    /** @var aSkill[] starting professions */
    protected static array $baseSkills = [];
    /** @var aSkill[] later professions: level => aSkill|aSkill[] */

    #[ArrayShape([
        "int" => [aSkill::class, aSkill::class]
    ])]
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
     * @return CombatStatsPerLevel
     */
    public static function getCombatModifiersPerLevel()
    {
        return new CombatStatsPerLevel(static::$combatModifiersPerLevel);
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
