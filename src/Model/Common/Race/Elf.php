<?php
/**
 * wizard
 *
 * @author    lyozsi (kristof.dekany@apex-it-services.eu)
 * @copyright internal usage
 *
 * Date: 8/10/17 11:31 AM
 */

namespace App\Model\Common\Race;

use App\Model\Common\Skill\aSkill;
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

class Elf extends aRace
{
    public  const TYPE = "ELF";

    /** @var string */
    protected static string $name      = "Elf";
    /** @var int[]  */
    protected static array $baseStatModifiers = [
        Strength::TYPE   => -2,
        Stamina::TYPE    => -1,
        Speed::TYPE      =>  1,
        Dexterity::TYPE  =>  1,
        Beauty::TYPE     =>  1,
        Perception::TYPE =>  2
    ];

    protected static array $combatStatModifiers = [
        Aim::TYPE => 30
    ];

    protected static array $maxBaseStats        = [
        Strength::TYPE     => 18,
        Stamina::TYPE      => 18,
        Dexterity::TYPE    => 21,
        Speed::TYPE        => 21,
        Vitality::TYPE     => 18,
        Beauty::TYPE       => 21,
        Intelligence::TYPE => 18,
        Willpower::TYPE    => 18,
        Astral::TYPE       => 18,
        Perception::TYPE   => 20
    ];

    protected static bool $playable            = true;

    protected static array $baseSkills          = [
        HorsebackRiding::class => aSkill::MASTERY_MASTER,
        Language::class        => [[
            "for"     => "Elvish",
            "mastery" => aSkill::MASTERY_BASIC,
            "level"   => 5
        ]]
    ];
}
