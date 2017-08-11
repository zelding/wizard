<?php
/**
 * wizard
 *
 * @author    lyozsi (kristof.dekany@apex-it-services.eu)
 * @copyright internal usage
 *
 * Date: 8/10/17 12:04 PM
 */

namespace AppBundle\Service;


use AppBundle\Model\Common\Character;

use AppBundle\Model\Common\Stats\Combat\Aim;
use AppBundle\Model\Common\Stats\Combat\Attack;
use AppBundle\Model\Common\Stats\Combat\Defense;
use AppBundle\Model\Common\Stats\Combat\Sequence;

class ClassService
{
    public static $StatTypeToStatName = [
        Sequence::TYPE => Sequence::NAME,
        Attack::TYPE   => Attack::NAME,
        Defense::TYPE  => Defense::NAME,
        Aim::TYPE      => Aim::NAME
    ];

    public function applyClassBonuses(Character $character)
    {

        return $this;
    }
}
