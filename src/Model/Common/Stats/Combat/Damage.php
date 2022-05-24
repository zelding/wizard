<?php
/**
 * wizard
 *
 * @author    lyozsi (kristof.dekany@apex-it-services.eu)
 * @copyright internal usage
 *
 * Date: 5/20/22 11:32 AM
 */

namespace App\Model\Common\Stats\Combat;

use App\Model\Common\Stats\DiceRollStat;

class Damage extends DiceRollStat
{
    public  const TYPE = "DMG";

    public  const NAME = "Damage";

    public  const BASE_STAT = false;
}
