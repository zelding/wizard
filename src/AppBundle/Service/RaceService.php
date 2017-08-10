<?php
/**
 * wizard
 *
 * @author    lyozsi (kristof.dekany@apex-it-services.eu)
 * @copyright internal usage
 *
 * Date: 8/10/17 12:03 PM
 */

namespace AppBundle\Service;

use AppBundle\Model\Common\Character;
use AppBundle\Model\Common\Stats\Astral;
use AppBundle\Model\Common\Stats\Beauty;
use AppBundle\Model\Common\Stats\Dexterity;
use AppBundle\Model\Common\Stats\Intelligence;
use AppBundle\Model\Common\Stats\Perception;
use AppBundle\Model\Common\Stats\Speed;
use AppBundle\Model\Common\Stats\Stamina;
use AppBundle\Model\Common\Stats\Strength;
use AppBundle\Model\Common\Stats\Vitality;
use AppBundle\Model\Common\Stats\Willpower;

class RaceService
{
    public static $StatTypeToStatName = [
        Strength::TYPE     => Strength::NAME,
        Stamina::TYPE      => Stamina::NAME,
        Dexterity::TYPE    => Dexterity::NAME,
        Speed::TYPE        => Speed::NAME,
        Vitality::TYPE     => Vitality::NAME,
        Beauty::TYPE       => Beauty::NAME,
        Intelligence::TYPE => Intelligence::NAME,
        Willpower::TYPE    => Willpower::NAME,
        Astral::TYPE       => Astral::NAME,
        Perception::TYPE   => Perception::NAME,
    ];

    public function setRacialBonuses(Character $character)
    {
        $race        = $character->getRace();
        $raceBonuses = $race::getModifiers();

        if ( !empty($raceBonuses) ) {
            foreach($raceBonuses as $type => $bonus) {

                $method = self::$StatTypeToStatName[ $type ];
                $character->getBaseStats()->{"add{$method}"}($bonus);
            }
        }

        return $this;
    }
}
