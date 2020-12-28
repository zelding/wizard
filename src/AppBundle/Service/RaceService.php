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

use AppBundle\Helper\Stats as StatsHelper;

class RaceService
{
    /**
     * Applies bonuses inherited from race
     *
     *  - statBonuses
     *  - skills
     *  - abilities
     *
     * @param Character $character
     *
     * @return $this
     */
    public function applyRacialBonuses(Character $character) : self
    {
        $this->setRacialBonuses($character)
             ->addRacialCombatBonuses($character);

        return $this;
    }

    /**
     * @param Character $character
     *
     * @return $this
     */
    protected function setRacialBonuses(Character $character) : self
    {
        $raceBonuses = $character->getRace()::getBaseStatModifiers();

        if ( !empty($raceBonuses) ) {
            foreach($raceBonuses as $type => $bonus) {

                $method = StatsHelper::$BaseStatTypeToStatName[ $type ];
                $character->getBaseStats()->{"add{$method}"}(
                    $bonus,
                    "Racial bonus for being {$character->getRace()::getName()}"
                );
            }
        }

        return $this;
    }

    /**
     * @param Character $character
     *
     * @return $this
     */
    protected function addRacialCombatBonuses(Character $character) : self
    {
        $raceBonuses = $character->getRace()::getCombatStatModifiers();

        if ( !empty($raceBonuses) ) {
            foreach($raceBonuses as $type => $bonus) {
                $method = StatsHelper::$CombatStatTypeToStatName[ $type ];
                $character->getBaseCombatStats()->{"add{$method}"}(
                    $bonus,
                    "Racial bonus for being {$character->getRace()::getName()}"
                );
            }
        }

        return $this;
    }
}
