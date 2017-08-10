<?php
/**
 * wizard
 *
 * @author    lyozsi (kristof.dekany@apex-it-services.eu)
 * @copyright internal usage
 *
 * Date: 8/10/17 11:56 AM
 */

namespace AppBundle\Model\PC;


use AppBundle\Model\Common\Character;

class PlayerCharacter extends Character
{
    public function __toString()
    {
        $stats = $this->baseStats->getAllStats();
        $string = "";

        foreach($stats as $type => $stat) {
            $string .= "{$type}: ".$stat->getValue().", ";
        }

        return $string;
    }
}
