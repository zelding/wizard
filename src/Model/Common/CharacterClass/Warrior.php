<?php
/**
 * wizard
 *
 * @author    lyozsi (kristof.dekany@apex-it-services.eu)
 * @copyright internal usage
 *
 * Date: 8/10/17 9:33 AM
 */

namespace App\Model\Common\CharacterClass;


use App\Model\Common\Skill\aSkill;
use App\Model\Common\Skill\Combat\Leadership;
use App\Model\Common\Skill\Combat\WeaponHandling;
use App\Model\Common\Skill\Social\HorsebackRiding;
use App\Model\Common\Skill\Social\Language;
use App\Model\Common\Stats\Base\Astral;
use App\Model\Common\Stats\Base\Beauty;
use App\Model\Common\Stats\Base\Dexterity;
use App\Model\Common\Stats\Base\Intelligence;
use App\Model\Common\Stats\Base\Perception;
use App\Model\Common\Stats\Base\Speed;
use App\Model\Common\Stats\Base\Stamina;
use App\Model\Common\Stats\Base\Strength;
use App\Model\Common\Stats\Base\Vitality;
use App\Model\Common\Stats\Base\Willpower;
use App\Model\Common\Stats\Combat\Aim;
use App\Model\Common\Stats\Combat\Attack;
use App\Model\Common\Stats\Combat\Defense;
use App\Model\Common\Stats\Combat\Sequence;
use App\Model\Mechanics\Dice\D10;
use App\Model\Mechanics\Dice\D6;

class Warrior extends aClass
{
    public  const TYPE     = "WAR";
    public  const SUB_TYPE = "WAR";

    protected static array $modifiers = [
        Sequence::TYPE =>  9,
        Attack::TYPE   => 20,
        Defense::TYPE  => 75,
        Aim::TYPE      =>  0
    ];

    public static bool $playable = true;

    protected static string $name = "Warrior";

    protected static int $skillPointBase     = 10;
    protected static int $skillPointPerLevel = 14;
    protected static int $hpBase             = 7;
    protected static int $ppBase             = 6;

    protected static array $painPointsPerLevel = [[D6::class], 4];

    protected static array $combatModifiersPerLevel = [11, [
        Attack::TYPE  => 3,
        Defense::TYPE => 3
    ]];

    protected static array $baseStatRanges  = [
        Strength::TYPE     => [ [ D6::class], 12, 1, true ],
        Stamina::TYPE      => [ [D10::class],  8, 1, true ],
        Dexterity::TYPE    => [ [D10::class],  8, 1, true ],
        Speed::TYPE        => [ [D10::class],  8, 1, true ],
        Vitality::TYPE     => [ [D10::class], 10, 1, false ],
        Beauty::TYPE       => [ [ D6::class, D6::class, D6::class], 0, 2, false ],
        Intelligence::TYPE => [ [ D6::class, D6::class, D6::class], 0, 2, false ],
        Willpower::TYPE    => [ [D10::class],  8, 1, false ],
        Astral::TYPE       => [ [ D6::class, D6::class, D6::class], 0, 2, false ],
        Perception::TYPE   => [ [D10::class],  8, 1, false ]
    ];

    protected static array $baseSkills      = [
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

    protected static array $lateSkills      = [
        6 => [Leadership::class => aSkill::MASTERY_BASIC]
    ];

    protected static array $experienceTable = [
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

    protected static int $xpAfter12       = 31200;
}
