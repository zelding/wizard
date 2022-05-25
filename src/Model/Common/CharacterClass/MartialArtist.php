<?php
/**
 * wizard
 *
 * @author    lyozsi (kristof.dekany@apex-it-services.eu)
 * @copyright internal usage
 *
 * Date: 5/20/22 10:42 AM
 */

namespace App\Model\Common\CharacterClass;

use App\Model\Common\Skill\aSkill;
use App\Model\Common\Skill\Combat\{Leadership, WeaponHandling, WeaponThrowing};
use App\Model\Common\Skill\Social\HorsebackRiding;
use App\Model\Common\Skill\Social\Language;
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

class MartialArtist extends aClass
{
    public  const TYPE     = "MAR";
    public  const SUB_TYPE = "MAR";

    protected static array $modifiers = [
        Sequence::class         => 10,
        Attack::class           => 20,
        Defense::class          => 75,
        Aim::class              =>  0,
        Damage::class           => [[D6::class], 0, 1],
        Armor::class            => 0,
        ArmorPenetration::class => 0
    ];

    public static bool $playable = true;

    protected static string $name = "Martial artist";

    protected static int $skillPointBase     = 4;
    protected static int $skillPointPerLevel = 5;
    protected static int $hpBase             = 4;
    protected static int $ppBase             = 8;

    protected static array $painPointsPerLevel = [[D6::class], 5];

    protected static array $combatModifiersPerLevel = [8, [
        Attack::class  => 3,
        Defense::class => 3
    ]];

    protected static array $baseStatRanges  = [
        Strength::class     => [ [D10::class],  8, 1, false ],
        Stamina::class      => [ [ D6::class], 12, 1, true ],
        Dexterity::class    => [ [ D6::class], 12, 1, true ],
        Speed::class        => [ [ D6::class], 14, 1, true ],
        Vitality::class     => [ [D10::class], 10, 1, false ],
        Beauty::class       => [ [ D6::class, D6::class, D6::class], 0, 2, false ],
        Intelligence::class => [ [ D6::class, D6::class, D6::class], 0, 2, false ],
        Willpower::class    => [ [ D6::class], 12, 1, false ],
        Astral::class       => [ [D10::class],  8, 2, false ],
        Perception::class   => [ [ D6::class], 12, 1, false ]
    ];

    protected static array $baseSkills      = [
        WeaponHandling::class  => [
            "relations" => [
                "Short sword",
                "Long sword",
                "Pike",
                "Slan sword",
                "Slan dagger",
                "Slan star",
                "Nunchaku",
                "San Sien Do",
                "Bola",
                "Garott"
            ],
            "mastery"   => aSkill::MASTERY_BASIC
        ],
        WeaponThrowing::class => [
            "relations" => [
                "Slan sword",
                "Slan dagger",
                "Slan star",
                "Bola"
            ],
            "mastery"   => aSkill::MASTERY_BASIC
        ],
        HorsebackRiding::class => aSkill::MASTERY_BASIC,
        Language::class        => [[
            "for"     => "Common",
            "mastery" => aSkill::MASTERY_BASIC,
            "level"   => 3
        ]],
        //"BlindFight" => aSkill::MASTERY_BASIC
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
