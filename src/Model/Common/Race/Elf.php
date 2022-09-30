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
        Strength::class   => -2,
        Stamina::class    => -1,
        Speed::class      =>  1,
        Dexterity::class  =>  1,
        Beauty::class     =>  1,
        Perception::class =>  2
    ];

    protected static array $combatStatModifiers = [
        Aim::class => 30
    ];

    protected static array $maxBaseStats        = [
        Strength::class     => 18,
        Stamina::class      => 18,
        Dexterity::class    => 21,
        Speed::class        => 21,
        Vitality::class     => 18,
        Beauty::class       => 21,
        Intelligence::class => 18,
        Willpower::class    => 18,
        Astral::class       => 18,
        Perception::class   => 20
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
