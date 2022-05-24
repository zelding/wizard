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
use App\Model\Common\Skill\Combat\{Leadership, WeaponHandling};
use App\Model\Common\Skill\Social\{HorsebackRiding, Language};
use App\Model\Common\Stats\Base\{Astral,
    Beauty,
    Dexterity,
    Intelligence,
    Perception,
    Speed,
    Stamina,
    Strength,
    Vitality,
    Willpower};
use App\Model\Common\Stats\Combat\{Aim, Armor, ArmorPenetration, Attack, Damage, Defense, Sequence};
use App\Model\Mechanics\Dice\D10;
use App\Model\Mechanics\Dice\D6;

class Warrior extends aClass
{
    public  const TYPE     = "WAR";
    public  const SUB_TYPE = "WAR";

    protected static array $modifiers = [
        Sequence::class         =>  9,
        Attack::class           => 20,
        Defense::class          => 75,
        Aim::class              =>  0,
        Damage::class           => [[D6::class, D6::class], 0, 1],
        Armor::class            => 0,
        ArmorPenetration::class => 0
    ];

    public static bool $playable = true;

    protected static string $name = "Warrior";

    protected static int $skillPointBase     = 10;
    protected static int $skillPointPerLevel = 14;
    protected static int $hpBase             = 7;
    protected static int $ppBase             = 6;

    protected static array $painPointsPerLevel = [[D6::class], 4];

    protected static array $combatModifiersPerLevel = [11, [
        Attack::class  => 3,
        Defense::class => 3
    ]];

    protected static array $baseStatRanges  = [
        Strength::class     => [ [ D6::class], 12, 1, true ],
        Stamina::class      => [ [D10::class],  8, 1, true ],
        Dexterity::class    => [ [D10::class],  8, 1, true ],
        Speed::class        => [ [D10::class],  8, 1, true ],
        Vitality::class     => [ [D10::class], 10, 1, false ],
        Beauty::class       => [ [ D6::class, D6::class, D6::class], 0, 2, false ],
        Intelligence::class => [ [ D6::class, D6::class, D6::class], 0, 2, false ],
        Willpower::class    => [ [D10::class],  8, 1, false ],
        Astral::class       => [ [ D6::class, D6::class, D6::class], 0, 2, false ],
        Perception::class   => [ [D10::class],  8, 1, false ]
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
