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
use AppBundle\Model\Common\Stats\Combat\Aim;
use AppBundle\Model\Common\Stats\Combat\Attack;
use AppBundle\Model\Common\Stats\Combat\Defense;
use AppBundle\Model\Common\Stats\Combat\Sequence;
use AppBundle\Model\Mechanics\Dice\aDice;
use AppBundle\Model\Common\Stats\Base\{
    Astral,Beauty,Dexterity,Intelligence,Perception,Speed,Stamina,Strength,Vitality,Willpower
};
use AppBundle\Model\Mechanics\Dice\D4;
use AppBundle\Model\Mechanics\Dice\D6;
use AppBundle\Model\Mechanics\Dice\DiceRoll;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;

abstract class aClass implements SkillProvider
{
    /** @var int|string */
    public  const TYPE     = "-1" ?? -1;
    /** @var int|string */
    public  const SUB_TYPE = "-1" ?? -1;

    public static bool $playable = false;

    protected static string $name      = "";

    #[ArrayShape([
        Sequence::TYPE => "int",
        Attack::TYPE   => "int",
        Defense::TYPE  => "int",
        Aim::TYPE      => "int"
    ])]
    protected static array $modifiers = [];

    /**
     * aDice[], modifier, number of rolls (highest counts), allow special training
     *
     * @var array[]
     */
    #[ArrayShape([
        Strength::TYPE     => [DiceRoll::class, "int", "int", "bool"],
        Stamina::TYPE      => [DiceRoll::class, "int", "int", "bool"],
        Dexterity::TYPE    => [DiceRoll::class, "int", "int", "bool"],
        Speed::TYPE        => [DiceRoll::class, "int", "int", "bool"],
        Vitality::TYPE     => [DiceRoll::class, "int", "int", "bool"],
        Beauty::TYPE       => [DiceRoll::class, "int", "int", "bool"],
        Intelligence::TYPE => [DiceRoll::class, "int", "int", "bool"],
        Willpower::TYPE    => [DiceRoll::class, "int", "int", "bool"],
        Astral::TYPE       => [DiceRoll::class, "int", "int", "bool"],
        Perception::TYPE   => [DiceRoll::class, "int", "int", "bool"]
    ])]
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

    protected static int $skillPointBase     = 0;

    protected static int $skillPointPerLevel = 0;

    protected static int $hpBase             = 1;

    protected static int $ppBase             = 1;

    /** @var int[] min, max */
    #[ArrayShape([
        [aDice::class, aDice::class, aDice::class],   // dices to roll
        "int",                                        // flat modifier
        "int"                                         // number of tries
    ])]
    protected static array $painPointsPerLevel = [[D4::class], 0, 1];

    #[ArrayShape([
        0 => "int",                     // points per level
        1 => [                          // mandatory usage per level per stat
            Sequence::TYPE => "int",
            Attack::TYPE   => "int",
            Defense::TYPE  => "int",
            Aim::TYPE      => "int"
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
    #[Pure]
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
