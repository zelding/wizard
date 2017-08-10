<?php
/**
 * wizard
 *
 * @author    lyozsi (kristof.dekany@apex-it-services.eu)
 * @copyright internal usage
 *
 * Date: 8/10/17 9:28 AM
 */

namespace AppBundle\Model\Common\Race;


use AppBundle\Model\Common\Stats\aStat;

abstract class aRace
{
    /** @var int|string */
    const TYPE = "-1" ?? -1;

    /** @var string */
    protected $name      = "";
    /** @var aStat[]  */
    protected $modifiers = [];

    protected $baseSkills = [];
}