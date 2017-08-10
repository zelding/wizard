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

    const MASTERY_BASIC  = 0;
    const MASTERY_MASTER = 1;
    /** @var string */
    public static $category = self::SKILL_TYPE_COMBAT;
    /** @var int cost of SP to learn the basics*/
    public static $baseCost     = 0;
    /** @var int cost of SP to master the skill */
    public static $masteryCost  = 0;
    /** @var bool is percent based */
    public static $isPercent    = false;
    /** @var bool is a hard to learn skill */
    public static $isSecret     = false;

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

    protected static $otherRelations =  [];

    /** @var string */
    protected static $name  = "";
    /** @var int */
    protected $mastery = self::MASTERY_BASIC ?? self::MASTERY_MASTER;
    /** @var int */
    protected $level   = 1;
}
