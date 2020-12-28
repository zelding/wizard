<?php
/**
 * wizard
 *
 * @author    lyozsi (kristof.dekany@apex-it-services.eu)
 * @copyright internal usage
 *
 * Date: 8/10/17 10:46 AM
 */

namespace AppBundle\Model\Common\Skill;


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
    protected static array $modifiers = [
        self::MASTERY_BASIC  => [],
        self::MASTERY_MASTER => []
    ];

    /**
     * Relation to base stats
     *
     * @var array
     */
    protected static array $statRelations  = [];

    protected static array $otherRelations = [];

    /** @var string */
    protected static string $name  = "";
    /** @var string */
    protected string $mastery = self::MASTERY_BASIC ?? self::MASTERY_MASTER;

    /** @var string only used if $allowMultiple */
    protected string $relatesTo = "";
    /** @var string[]  */
    protected array $origin = [];

    /**
     * aSkill constructor.
     *
     * @param string $mastery
     */
    public function __construct(string $mastery = self::MASTERY_BASIC)
    {
        $this->mastery = $mastery;
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
    public function getName(): string
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
