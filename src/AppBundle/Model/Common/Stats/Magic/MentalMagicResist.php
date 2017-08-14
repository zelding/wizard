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
    const NAME = "Mental Magic Resist";

    public function getType()
    {
        return static::TYPE_MENTAL;
    }
}
