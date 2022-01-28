<?php
/**
 * wizard
 *
 * @author    lyozsi (kristof.dekany@apex-it-services.eu)
 * @copyright internal usage
 *
 * Date: 8/18/17 1:50 PM
 */

namespace App\Model\Common\Stats\General;


use App\Model\Common\Stats\aStat;

class Health extends aStat
{
    public  const TYPE = "HP";

    public  const NAME = "Health";

    public  const BASE_STAT = false;
}
