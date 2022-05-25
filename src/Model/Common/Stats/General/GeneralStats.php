<?php
/**
 * wizard
 *
 * @author    lyozsi (kristof.dekany@apex-it-services.eu)
 * @copyright internal usage
 *
 * Date: 8/18/17 1:48 PM
 */

namespace App\Model\Common\Stats\General;


use App\Exception\AppException;
use App\Model\Common\Stats\aStat;
use App\Model\Common\Stats\Base\BaseStats;

/**
 * Class GeneralStats
 *
 * @package App\Model\Common\Stats\General
 *
 */
class GeneralStats extends BaseStats
{
    public static array $baseStats = [
        Health::NAME     => Health::class,
        PainPoint::NAME  => PainPoint::class,
        PsyPoints::NAME  => PsyPoints::class,
        Mana::NAME       => Mana::class,
        SkillPoint::NAME => SkillPoint::class
    ];

    public function getStat(string $statClass) : aStat
    {
        if ( array_key_exists($statClass, $this->getAllStats()) ) {
            return $this->stats[ $statClass ];
        }
        else {
            throw new AppException("{$statClass} is not yet defined");
        }
    }
}
