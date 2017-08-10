<?php
/**
 * wizard
 *
 * @author    lyozsi (kristof.dekany@apex-it-services.eu)
 * @copyright internal usage
 *
 * Date: 8/10/17 9:32 AM
 */

namespace AppBundle\Model\Common\Race;


use AppBundle\Model\Common\Stats\aStat;

class Human extends aRace
{
    const TYPE = "HUM";

    /** @var aStat[]  */
    protected $modifiers = [];

    protected $name = "Human";
}
