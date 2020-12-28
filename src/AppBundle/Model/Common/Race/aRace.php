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

use AppBundle\Model\Common\Skill\aSkill;
use AppBundle\Model\Common\SkillProvider;
use AppBundle\Model\Common\Stats\aStat;
use AppBundle\Model\Common\Stats\Base\{
    Astral,Beauty,Dexterity,Intelligence,Perception,Speed,Stamina,Strength,Vitality,Willpower
};

abstract class aRace implements SkillProvider
{
    /** @var int|string */
    public const TYPE = "-1" ?? -1;

    /** @var string */
    protected static string $name      = "";
    /** @var aStat[] */
    protected static array $baseStatModifiers = [];
    /** @var aStat[] */
    protected static array $combatStatModifiers = [];

    protected static array $maxBaseStats      = [
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

    protected static bool $playable          = false;

    /**
     * list of skills that the race has naturally
     *
     * @var array
     */
    protected static array $baseSkills = [];

    protected static array $inventorySlotOverrides = [];

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
        return [];
    }

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
     * @return aStat[]
     */
    public static function getCombatStatModifiers(): array
    {
        return static::$combatStatModifiers;
    }

    #endregion
}
