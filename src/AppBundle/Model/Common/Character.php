<?php
/**
 * wizard
 *
 * @author    lyozsi (kristof.dekany@apex-it-services.eu)
 * @copyright internal usage
 *
 * Date: 8/9/17 1:21 PM
 */

namespace AppBundle\Model\Common;

use AppBundle\Model\Common\Stats\BaseStats;

abstract class Character
{
    /** @var null|BaseStats */
    protected $baseStats = null;

    public function __construct(
        int $str, int $spd, int $dex, int $sta, int $vit,
        int $bea, int $int, int $wil, int $ast, int $per)
    {
        $this->baseStats = new BaseStats(
            $str,  $spd,  $dex,  $sta,  $vit,
            $bea,  $int,  $wil,  $ast,  $per
        );
    }
}
