<?php
/**
 * wizard
 *
 * @author    lyozsi (kristof.dekany@apex-it-services.eu)
 * @copyright internal usage
 *
 * Date: 8/11/17 9:21 AM
 */

namespace App\Model\Common\Stats\Combat;


use App\Model\Common\Stats\Base\BaseStats;

/**
 * Class BaseCombatStats
 *
 * @package App\Model\Common\Stats\Combat
 *
 */
class BaseCombatStats extends BaseStats
{
    public static array $baseStats = [
        Sequence::NAME         => Sequence::class,
        Attack::NAME           => Attack::class,
        Defense::NAME          => Defense::class,
        Aim::NAME              => Aim::class,
        Damage::NAME           => Damage::class,
        Armor::NAME            => Armor::class,
        ArmorPenetration::NAME => ArmorPenetration::class
    ];

    /** @var BaseCombatStats[] */
    protected array $stats = [];
}
