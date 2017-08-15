<?php
/**
 * wizard
 *
 * @author    lyozsi (kristof.dekany@apex-it-services.eu)
 * @copyright internal usage
 *
 * Date: 8/11/17 9:21 AM
 */

namespace AppBundle\Model\Common\Stats\Combat;


use AppBundle\Model\Common\Stats\BaseStats;
use AppBundle\Model\Common\Stats\aStat;

/**
 * Class BaseCombatStats
 *
 * @package AppBundle\Model\Common\Stats\Combat
 *
 * @method BaseCombatStats addSequence(int $seq, string $description = "")
 * @method aStat getSequence()
 *
 * @method BaseCombatStats addAttack(int $atk, string $description = "")
 * @method aStat getAttack()
 *
 * @method BaseCombatStats addDefense(int $def, string $description = "")
 * @method aStat getDefense()
 *
 * @method BaseCombatStats addAim(int $aim, string $description = "")
 * @method aStat getAim()
 */
class BaseCombatStats extends BaseStats
{
    public static $baseStats = [
        Sequence::NAME => Sequence::class,
        Attack::NAME   => Attack::class,
        Defense::NAME  => Defense::class,
        Aim::NAME      => Aim::class
    ];
}
