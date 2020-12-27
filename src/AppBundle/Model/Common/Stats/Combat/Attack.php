<?php
/**
 * wizard
 *
 * @author    lyozsi (kristof.dekany@apex-it-services.eu)
 * @copyright internal usage
 *
 * Date: 8/10/17 10:32 AM
 */

namespace AppBundle\Model\Common\Stats\Combat;


use AppBundle\Model\Common\Stats\aStat;

class Attack extends aStat
{
    public  const TYPE = "ATK";

    public  const NAME = "Attack";

    public  const BASE_STAT = false;
}
