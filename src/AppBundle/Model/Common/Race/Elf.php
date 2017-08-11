<?php
/**
 * wizard
 *
 * @author    lyozsi (kristof.dekany@apex-it-services.eu)
 * @copyright internal usage
 *
 * Date: 8/10/17 11:31 AM
 */

namespace AppBundle\Model\Common\Race;

use AppBundle\Model\Common\Stats\aStat;
use AppBundle\Model\Common\Stats\Astral;
use AppBundle\Model\Common\Stats\Beauty;
use AppBundle\Model\Common\Stats\Combat\Aim;
use AppBundle\Model\Common\Stats\Dexterity;
use AppBundle\Model\Common\Stats\Intelligence;
use AppBundle\Model\Common\Stats\Perception;
use AppBundle\Model\Common\Stats\Speed;
use AppBundle\Model\Common\Stats\Stamina;
use AppBundle\Model\Common\Stats\Strength;
use AppBundle\Model\Common\Stats\Vitality;
use AppBundle\Model\Common\Stats\Willpower;

class Elf extends aRace
{
    const TYPE = "ELF";

    /** @var string */
    protected static $name      = "Elf";
    /** @var aStat[]  */
    protected static $baseStatModifiers = [
        Strength::TYPE   => -2,
        Stamina::TYPE    => -1,
        Speed::TYPE      =>  1,
        Dexterity::TYPE  =>  1,
        Beauty::TYPE     =>  1,
        Perception::TYPE =>  2
    ];

    protected static $combatStatModifiers = [
        Aim::TYPE => 30
    ];

    protected static $maxBaseStats      = [
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

    protected static $playable = true;

    protected static $baseSkills = [];
}
