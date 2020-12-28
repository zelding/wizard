<?php
/**
 * wizard
 *
 * @author    lyozsi (kristof.dekany@apex-it-services.eu)
 * @copyright internal usage
 *
 * Date: 9/7/17 11:05 AM
 */

namespace AppBundle\Helper;

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

final class Stats
{
    public static array $CombatStatTypeToStatName = [
        Sequence::TYPE => Sequence::NAME,
        Attack::TYPE   => Attack::NAME,
        Defense::TYPE  => Defense::NAME,
        Aim::TYPE      => Aim::NAME
    ];

    public static array $BaseStatTypeToStatName = [
        Strength::TYPE     => Strength::NAME,
        Stamina::TYPE      => Stamina::NAME,
        Dexterity::TYPE    => Dexterity::NAME,
        Speed::TYPE        => Speed::NAME,
        Vitality::TYPE     => Vitality::NAME,
        Beauty::TYPE       => Beauty::NAME,
        Intelligence::TYPE => Intelligence::NAME,
        Willpower::TYPE    => Willpower::NAME,
        Astral::TYPE       => Astral::NAME,
        Perception::TYPE   => Perception::NAME,
    ];
}
