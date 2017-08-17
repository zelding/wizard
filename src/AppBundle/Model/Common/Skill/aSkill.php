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
    const TYPE = "-1" ?? -1;

    const SKILL_TYPE_COMBAT  = "combat";
    const SKILL_TYPE_SCIENCE = "science";
    const SKILL_TYPE_SOCIAL  = "social";
    const SKILL_TYPE_CRIME   = "crime";

    const MASTERY_BASIC  = "Basic";
    const MASTERY_MASTER = "Master";
    /** @var string */
    public static $category      = self::SKILL_TYPE_COMBAT;
    /** @var int cost of SP to learn the basics*/
    public static $baseCost      = 0;
    /** @var int cost of SP to master the skill */
    public static $masteryCost   = 0;
    /** @var bool is percent based */
    public static $isPercent     = false;
    /** @var bool is a hard to learn skill */
    public static $isSecret      = false;
    /** @var bool */
    public static $allowMultiple = false;

    /**
     * Various bonuses that the skill might give
     *
     * @var array
     */
    protected static $modifiers = [
        self::MASTERY_BASIC  => [],
        self::MASTERY_MASTER => []
    ];

    /**
     * Relation to base stats
     *
     * @var array
     */
    protected static $statRelations  = [];

    protected static $otherRelations = [];

    /** @var string */
    protected static $name  = "";
    /** @var int */
    protected $mastery = self::MASTERY_BASIC ?? self::MASTERY_MASTER;

    /** @var string only used if $allowMultiple */
    protected $relatesTo = "";

    protected $origin = "";

    /**
     * aSkill constructor.
     *
     * @param string $mastery
     */
    public function __construct(string $mastery = self::MASTERY_BASIC)
    {
        $this->mastery = $mastery;
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
     * @return string
     */
    public function getOrigin(): string
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
        $this->origin = $origin;

        return $this;
    }

    public function updateOrigin(string $origin) : aSkill
    {
        $this->origin = trim($this->origin.$origin);

        return $this;
    }

    #endregion
}
