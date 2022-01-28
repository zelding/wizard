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


use App\Model\Common\Stats\aStat;
use App\Model\Common\Stats\Base\BaseStats;

/**
 * Class BaseCombatStats
 *
 * @package App\Model\Common\Stats\Combat
 *
 * @method BaseCombatStats setSequence(int $seq, string $description = "")
 * @method BaseCombatStats addSequence(int $seq, string $description = "")
 * @method aStat getSequence()
 *
 * @method BaseCombatStats setAttack(int $seq, string $description = "")
 * @method BaseCombatStats addAttack(int $atk, string $description = "")
 * @method aStat getAttack()
 *
 * @method BaseCombatStats setDefense(int $seq, string $description = "")
 * @method BaseCombatStats addDefense(int $def, string $description = "")
 * @method aStat getDefense()
 *
 * @method BaseCombatStats setAim(int $seq, string $description = "")
 * @method BaseCombatStats addAim(int $aim, string $description = "")
 * @method aStat getAim()
 */
class BaseCombatStats extends BaseStats
{
    public static array $baseStats = [
        Sequence::NAME => Sequence::class,
        Attack::NAME   => Attack::class,
        Defense::NAME  => Defense::class,
        Aim::NAME      => Aim::class
    ];

    /** @var BaseCombatStats[] */
    protected array $stats = [];
}
