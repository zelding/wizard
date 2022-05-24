<?php
/**
 * wizard
 *
 * @author    lyozsi (kristof.dekany@apex-it-services.eu)
 * @copyright internal usage
 *
 * Date: 5/23/22 11:24 AM
 */

namespace App\Model\Common\Stats\Combat;

use App\Model\Common\Stats\aStat;

class ArmorPenetration extends aStat
{
    public  const TYPE = "ARP";

    public  const NAME = "Armor penetration";

    public  const BASE_STAT = false;
}
