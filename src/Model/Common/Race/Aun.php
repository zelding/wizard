<?php


namespace App\Model\Common\Race;


use App\Model\Common\InventorySlotProvider;
use App\Model\Common\Skill\aSkill;
use App\Model\Common\Skill\Combat\WeaponHandling;
use App\Model\Common\Stats\aStat;
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
use App\Model\Common\Stats\Combat\Aim;
use App\Model\Common\Stats\Combat\Defense;
use App\Model\Common\Stats\Magic\MagicResist;

class Aun extends aRace
{
    public const TYPE = "Aun";

    /** @var string */
    protected static string $name = "Mantis";

    /** @var aStat[] */
    protected static array $baseStatModifiers = [
        Strength::class     => 1,
        Stamina::class      => 2,
        Dexterity::class    => 4,
        Speed::class        => 1,
        Vitality::class     => 1,
        Beauty::class       => -5,
        Intelligence::class => -1,
        Willpower::class    => -1,
        Astral::class       => -2,
        Perception::class   => 1
    ];

    /** @var aStat[] */
    protected static array $combatStatModifiers = [
        Aim::class     => 30,
        Defense::class => 15
    ];

    /** @var aStat[] */
    protected static array $generalStatModifiers = [
        MagicResist::class => 4
    ];

    protected static array $defaultInventorySlots = [
        // no helmets - sry
        InventorySlotProvider::SLOT_HEAD    =>  0,
        InventorySlotProvider::SLOT_TORSO   =>  1,
        InventorySlotProvider::SLOT_HANDS   =>  4,
        // two per arm only - they have scissors
        InventorySlotProvider::SLOT_FINGERS =>  4,
        InventorySlotProvider::SLOT_LEGS    =>  2,
        // no shoes - sry
        InventorySlotProvider::SLOT_FEET    =>  0
    ];

    protected static array $maxBaseStats = [
        Strength::class     => 19,
        Stamina::class      => 20,
        Dexterity::class    => 22,
        Speed::class        => 19,
        Vitality::class     => 19,
        Beauty::class       => 13,
        Intelligence::class => 17,
        Willpower::class    => 17,
        Astral::class       => 16,
        Perception::class   => 19
    ];

    protected static bool $playable = true;

    protected static array $baseSkills = [
        WeaponHandling::class  => [
            "relations" => [
                "Star dagger",
                "Double blade"
            ],
            "mastery"   => aSkill::MASTERY_BASIC
        ],
    ];

    /** @var aSkill[] later professions: level => aSkill|aSkill[] */
    protected static array $lateSkills = [
        10 => [
            WeaponHandling::class  => [
                "relations" => [
                    "Star dagger",
                    "Double blade"
                ],
                "mastery"   => aSkill::MASTERY_MASTER
            ],
        ]
    ];

    protected static array $inventorySlotOverrides = [];
}
