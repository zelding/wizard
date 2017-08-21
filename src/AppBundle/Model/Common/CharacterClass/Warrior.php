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


use AppBundle\Model\Common\Skill\aSkill;
use AppBundle\Model\Common\Skill\Combat\Leadership;
use AppBundle\Model\Common\Skill\Combat\WeaponHandling;
use AppBundle\Model\Common\Skill\Social\HorsebackRiding;
use AppBundle\Model\Common\Skill\Social\Language;
use AppBundle\Model\Common\Stats\aStat;

use AppBundle\Model\Common\Stats\Base\Astral;
use AppBundle\Model\Common\Stats\Base\Beauty;
use AppBundle\Model\Common\Stats\Base\Dexterity;
use AppBundle\Model\Common\Stats\Base\Intelligence;
use AppBundle\Model\Common\Stats\Base\Perception;
use AppBundle\Model\Common\Stats\Base\Speed;
use AppBundle\Model\Common\Stats\Base\Stamina;
use AppBundle\Model\Common\Stats\Base\Strength;
use AppBundle\Model\Common\Stats\Base\Vitality;
use AppBundle\Model\Common\Stats\Base\Willpower;

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
        Defense::TYPE => 3
    ]];

    protected static $baseStatRanges  = [
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

    protected static $baseSkills      = [
        WeaponHandling::class  => [
            "relations" => [
                "Short sword",
                "Long sword",
                "Pike"
            ],
            "mastery"   => aSkill::MASTERY_BASIC
        ],
        HorsebackRiding::class => aSkill::MASTERY_BASIC,
        Language::class        => [[
            "for"     => "Common",
            "mastery" => aSkill::MASTERY_BASIC,
            "level"   => 3
        ]]
    ];

    protected static $lateSkills      = [
        6 => [Leadership::class => aSkill::MASTERY_BASIC]
    ];

    protected static $experienceTable = [
             0,
           161,
           321,
           641,
          1441,
          2801,
          6501,
         10001,
         20001,
         40001,
         60001,
         80001,
        112001
    ];

    protected static $xpAfter12       = 31200;

    public function __construct()
    {
    }
}
