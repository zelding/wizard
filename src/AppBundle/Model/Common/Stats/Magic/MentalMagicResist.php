<?php
/**
 * wizard
 *
 * @author    lyozsi (kristof.dekany@apex-it-services.eu)
 * @copyright internal usage
 *
 * Date: 8/14/17 10:17 AM
 */

namespace AppBundle\Model\Common\Stats\Magic;


class MentalMagicResist extends MagicResist
{
    public  const NAME = "Mental Magic Resist";

    public function getType() : string
    {
        return self::TYPE_MENTAL;
    }
}
