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
 * @method BaseCombatStats addSequence(int $seq)
 * @method aStat getSequence()
 *
 * @method BaseCombatStats addAttack(int $atk)
 * @method aStat getAttack()
 *
 * @method BaseCombatStats addDefense(int $def)
 * @method aStat getDefense()
 *
 * @method BaseCombatStats addAim(int $aim)
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
