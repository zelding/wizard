<?php


namespace App\Model\Common\Race;


use App\Model\Common\InventorySlotProvider;
use App\Model\Common\Skill\aSkill;
use App\Model\Common\Skill\Combat\WeaponHandling;
use App\Model\Common\Stats\aStat;
use App\Model\Common\Stats\Base\{
    Astral,
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
        Strength::TYPE     => 1,
        Stamina::TYPE      => 2,
        Dexterity::TYPE    => 4,
        Speed::TYPE        => 1,
        Vitality::TYPE     => 1,
        Beauty::TYPE       => -5,
        Intelligence::TYPE => -1,
        Willpower::TYPE    => -1,
        Astral::TYPE       => -2,
        Perception::TYPE   => 1
    ];

    /** @var aStat[] */
    protected static array $combatStatModifiers = [
        Aim::TYPE     => 30,
        Defense::TYPE => 15
    ];

    /** @var aStat[] */
    protected static array $generalStatModifiers = [
        MagicResist::TYPE => 4
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
        Strength::TYPE     => 19,
        Stamina::TYPE      => 20,
        Dexterity::TYPE    => 22,
        Speed::TYPE        => 19,
        Vitality::TYPE     => 19,
        Beauty::TYPE       => 13,
        Intelligence::TYPE => 17,
        Willpower::TYPE    => 17,
        Astral::TYPE       => 16,
        Perception::TYPE   => 19
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
