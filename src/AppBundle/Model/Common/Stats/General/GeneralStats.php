<?php
/**
 * wizard
 *
 * @author    lyozsi (kristof.dekany@apex-it-services.eu)
 * @copyright internal usage
 *
 * Date: 8/18/17 1:48 PM
 */

namespace AppBundle\Model\Common\Stats\General;


use AppBundle\Model\Common\Stats\Base\BaseStats;
use AppBundle\Model\Common\Stats\aStat;

/**
 * Class GeneralStats
 *
 * @package AppBundle\Model\Common\Stats\General
 *
 * @method aStat getHealth()
 * @method GeneralStats addHealth(int $hp, $description = "")
 * @method GeneralStats setHealth(int $hp)
 *
 * @method aStat getPainPoint()
 * @method GeneralStats addPainPoint(int $pp, $description = "")
 * @method GeneralStats setPainPoint(int $pp)
 *
 * @method aStat getPsyPoint()
 * @method GeneralStats addPsyPoint(int $pp, $description = "")
 * @method GeneralStats setPsyPoint(int $pp)
 *
 * @method aStat getMana()
 * @method GeneralStats addMana(int $mp, $description = "")
 * @method GeneralStats setMana(int $mp)
 *
 * @method aStat getSkillPoint()
 * @method GeneralStats addSkillPoint(int $sp, $description = "")
 * @method GeneralStats setSkillPoint(int $sp)
 */
class GeneralStats extends BaseStats
{
    public static array $baseStats = [
        Health::NAME    => Health::class,
        PainPoint::NAME => PainPoint::class,
        PsyPoints::NAME => PsyPoints::class,
        Mana::NAME      => Mana::class,

        SkillPoint::NAME => SkillPoint::class
    ];

    /** @var GeneralStats[]  */
    protected array $stats = [];
}
