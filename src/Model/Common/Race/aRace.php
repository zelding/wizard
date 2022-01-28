<?php
/**
 * wizard
 *
 * @author    lyozsi (kristof.dekany@apex-it-services.eu)
 * @copyright internal usage
 *
 * Date: 8/10/17 9:28 AM
 */

namespace App\Model\Common\Race;

use App\Model\Common\{
    InventorySlotProvider,
    SkillProvider};
use App\Model\Common\Skill\aSkill;
use App\Model\Common\Stats\aStat;
use App\Model\Common\Stats\Base\{
    Astral,
    Beauty,
    Dexterity,
    Intelligence,
    Perception,
    Speed,
    Stamina,
    Strength,
    Vitality,
    Willpower};

abstract class aRace implements SkillProvider, InventorySlotProvider
{
    /** @var int|string */
    public const TYPE = "-1" ?? -1;

    /** @var string */
    protected static string $name      = "";
    /** @var int[] */
    protected static array $baseStatModifiers = [];
    /** @var int[] */
    protected static array $combatStatModifiers = [];
    /** @var int[] */
    protected static array $generalStatModifiers = [];

    /**
     * How many "places" you can put things
     * @var array|int[]
     */
    protected static array $defaultInventorySlots = [
        InventorySlotProvider::SLOT_HEAD    =>  1,
        InventorySlotProvider::SLOT_NECK    =>  1,
        InventorySlotProvider::SLOT_TORSO   =>  1,
        InventorySlotProvider::SLOT_HANDS   =>  2,
        InventorySlotProvider::SLOT_BELT    =>  1,
        InventorySlotProvider::SLOT_FINGERS => 10,
        InventorySlotProvider::SLOT_LEGS    =>  2,
        InventorySlotProvider::SLOT_FEET    =>  2,
    ];

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

    /** @var aSkill[] later professions: level => aSkill|aSkill[] */
    protected static array $lateSkills = [];

    protected static array $inventorySlotOverrides = [];

    /**
     * @return array
     */
    final public static function getBaseSkills(): array
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

    final public static function getSlotConfiguration(): array
    {
        return static::$defaultInventorySlots;
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
     * @return int[]
     */
    public static function getCombatStatModifiers(): array
    {
        return static::$combatStatModifiers;
    }

    /**
     * @return int[]
     */
    public static function getGeneralStatModifiers(): array
    {
        return static::$generalStatModifiers;
    }

    #endregion
}
