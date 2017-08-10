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


use AppBundle\Model\Common\Stats\aStat;

abstract class aSkill
{
    const TYPE = "-1" ?? -1;

    const MASTERY_BASIC = 0;

    const MASTERY_MASTER = 1;

    public static $baseCost     = 0;

    public static $masteryConst = 0;

    public static $isPercent = false;

    protected static $statRelations = [];

    /** @var string */
    protected $name    = "";
    /** @var int */
    protected $mastery = self::MASTERY_BASIC ?? self::MASTERY_MASTER;
    /** @var int */
    protected $level   = 1;
    /** @var aStat[]  */
    protected $modifiers = [];
}
