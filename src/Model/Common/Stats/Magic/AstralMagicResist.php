<?php
/**
 * wizard
 *
 * @author    lyozsi (kristof.dekany@apex-it-services.eu)
 * @copyright internal usage
 *
 * Date: 8/14/17 10:07 AM
 */

namespace App\Model\Common\Stats\Magic;


class AstralMagicResist extends MagicResist
{
    public  const NAME = "Astral Magic Resist";

    public function getType() : string
    {
        return self::TYPE_ASTRAL;
    }
}
