<?php
/**
 * wizard
 *
 * @author    lyozsi (kristof.dekany@apex-it-services.eu)
 * @copyright internal usage
 *
 * Date: 8/10/17 9:33 AM
 */

namespace AppBundle\Model\Common\CharacterClass;


use AppBundle\Model\Common\Stats\aStat;

use AppBundle\Model\Common\Stats\Astral;
use AppBundle\Model\Common\Stats\Beauty;
use AppBundle\Model\Common\Stats\Dexterity;
use AppBundle\Model\Common\Stats\Intelligence;
use AppBundle\Model\Common\Stats\Perception;
use AppBundle\Model\Common\Stats\Speed;
use AppBundle\Model\Common\Stats\Stamina;
use AppBundle\Model\Common\Stats\Strength;
use AppBundle\Model\Common\Stats\Vitality;
use AppBundle\Model\Common\Stats\Willpower;

use AppBundle\Model\Common\Stats\Combat\Aim;
use AppBundle\Model\Common\Stats\Combat\Attack;
use AppBundle\Model\Common\Stats\Combat\Defense;
use AppBundle\Model\Common\Stats\Combat\Sequence;

class Warrior extends aClass
{
    const TYPE     = "WAR";
    const SUB_TYPE = "WAR";

    /** @var aStat[] */
    protected static $modifiers = [
        Sequence::TYPE =>  9,
        Attack::TYPE   => 20,
        Defense::TYPE  => 75,
        Aim::TYPE      =>  0
    ];

    public static $playable = true;

    protected static $name = "Warrior";

    protected static $skillPointBase     = 10;

    protected static $skillPointPerLevel = 14;

    protected static $hpBase             = 7;

    protected static $ppBase             = 6;

    protected static $painPointsPerLevel = [5, 10];

    protected static $combatModifiersPerLevel = [11, [
        Attack::TYPE  => 3,
        Defense::TYPE => 3,
    ]];

    protected static $baseStatRanges = [
        Strength::TYPE     => [13, 18, 1, true],
        Stamina::TYPE      => [ 9, 18, 1, true],
        Dexterity::TYPE    => [ 8, 18, 1, true],
        Speed::TYPE        => [ 8, 18, 1, true],
        Vitality::TYPE     => [11, 20, 1, false],
        Beauty::TYPE       => [ 3, 18, 2, false],
        Intelligence::TYPE => [ 3, 18, 2, false],
        Willpower::TYPE    => [ 8, 18, 1, false],
        Astral::TYPE       => [ 3, 18, 2, false],
        Perception::TYPE   => [ 8, 18, 1, false]
    ];

    protected static $baseSkills = [

    ];

    public function __construct()
    {
    }
}
