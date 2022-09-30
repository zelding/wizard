<?php
/**
 * wizard
 *
 * @author    lyozsi (kristof.dekany@apex-it-services.eu)
 * @copyright internal usage
 *
 * Date: 8/10/17 10:46 AM
 */

namespace App\Model\Common\Skill;


use App\Model\Common\Stats\Combat\Aim;
use App\Model\Common\Stats\Combat\Armor;
use App\Model\Common\Stats\Combat\ArmorPenetration;
use App\Model\Common\Stats\Combat\Attack;
use App\Model\Common\Stats\Combat\Damage;
use App\Model\Common\Stats\Combat\Defense;
use App\Model\Common\Stats\Combat\Sequence;
use JetBrains\PhpStorm\ArrayShape;

abstract class aSkill
{
    public  const TYPE = "-1" ?? -1;

    public  const SKILL_TYPE_COMBAT  = "combat";
    public  const SKILL_TYPE_SCIENCE = "science";
    public  const SKILL_TYPE_SOCIAL  = "social";
    public  const SKILL_TYPE_CRIME   = "crime";

    public  const MASTERY_BASIC  = "Basic";
    public  const MASTERY_MASTER = "Master";
    /** @var string */
    public static string $category      = self::SKILL_TYPE_COMBAT;
    /** @var int cost of SP to learn the basics*/
    public static int $baseCost      = 0;
    /** @var int cost of SP to master the skill */
    public static int $masteryCost   = 0;
    /** @var bool is percent based */
    public static bool $isPercent     = false;
    /** @var bool is a hard to learn skill */
    public static bool $isSecret      = false;
    /** @var bool */
    public static bool $allowMultiple = false;

    /**
     * Various bonuses that the skill might give
     *
     * @var array
     */
    #[ArrayShape([
        self::MASTERY_BASIC  => [
            Sequence::TYPE         => "int",
            Attack::TYPE           => "int",
            Defense::TYPE          => "int",
            Aim::TYPE              => "int",
            Damage::TYPE           => "array", //  [[D6::class], 0, 1],
            Armor::TYPE            => "int",
            ArmorPenetration::TYPE => "int"
        ],
        self::MASTERY_MASTER => [
            Sequence::TYPE         => "int",
            Attack::TYPE           => "int",
            Defense::TYPE          => "int",
            Aim::TYPE              => "int",
            Damage::TYPE           => "array", //  [[D6::class], 0, 1],
            Armor::TYPE            => "int",
            ArmorPenetration::TYPE => "int"
        ]
    ])]
    protected static array $modifiers = [
        self::MASTERY_BASIC  => [],
        self::MASTERY_MASTER => []
    ];

    protected string $mastery = self::MASTERY_BASIC;

    /**
     * Relation to base stats
     *
     * @var array
     */
    protected static array $statRelations  = [];

    /** @var string[] */
    protected static array $otherRelations = [];

    /** @var string */
    protected static string $name  = "";

    /** @var string only used if $allowMultiple */
    protected string $relatesTo = "";

    /** @var string[]  */
    protected array $origin = [];

    /**
     * aSkill constructor.
     */
    public function __construct()
    {

    }

    public function isMaster() : bool
    {
        return $this->mastery === static::MASTERY_MASTER;
    }

    #region Getters/Setters

    /**
     * @return array
     */
    public static function getModifiers(): array
    {
        return static::$modifiers;
    }

    /**
     * @return array
     */
    public static function getStatRelations(): array
    {
        return static::$statRelations;
    }

    /**
     * @return array
     */
    public static function getOtherRelations(): array
    {
        return static::$otherRelations;
    }

    /**
     * @return string
     */
    public static function getName(): string
    {
        return static::$name;
    }

    /**
     * @return string
     */
    public function getMastery(): string
    {
        return $this->mastery;
    }

    /**
     * @param string $mastery
     *
     * @return aSkill
     */
    public function setMastery(string $mastery): aSkill
    {
        $this->mastery = $mastery;

        return $this;
    }

    /**
     * @return string
     */
    public function getRelatesTo(): string
    {
        return $this->relatesTo;
    }

    /**
     * @param string $relatesTo
     *
     * @return aSkill
     */
    public function setRelatesTo(string $relatesTo): aSkill
    {
        $this->relatesTo = $relatesTo;

        return $this;
    }

    /**
     * @return string[]
     */
    public function getOrigin(): array
    {
        return $this->origin;
    }

    /**
     * @param string $origin
     *
     * @return aSkill
     */
    public function setOrigin(string $origin): aSkill
    {
        $this->origin = [$origin];

        return $this;
    }

    public function updateOrigin(string $origin) : aSkill
    {
        $this->origin[] = $origin;

        return $this;
    }

    #endregion
}
