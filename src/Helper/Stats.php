<?php
/**
 * wizard
 *
 * @author    lyozsi (kristof.dekany@apex-it-services.eu)
 * @copyright internal usage
 *
 * Date: 9/7/17 11:05 AM
 */

namespace App\Helper;

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
use App\Model\Common\Stats\Combat\Armor;
use App\Model\Common\Stats\Combat\ArmorPenetration;
use App\Model\Common\Stats\Combat\Attack;
use App\Model\Common\Stats\Combat\Damage;
use App\Model\Common\Stats\Combat\Defense;
use App\Model\Common\Stats\Combat\Sequence;

final class Stats
{
    public static array $CombatStatTypeToStatName = [
        Sequence::TYPE         => Sequence::NAME,
        Attack::TYPE           => Attack::NAME,
        Defense::TYPE          => Defense::NAME,
        Aim::TYPE              => Aim::NAME,
        Damage::TYPE           => Damage::NAME,
        Armor::TYPE            => Armor::NAME,
        ArmorPenetration::TYPE => ArmorPenetration::NAME
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
