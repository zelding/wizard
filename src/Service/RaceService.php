<?php
/**
 * wizard
 *
 * @author    lyozsi (kristof.dekany@apex-it-services.eu)
 * @copyright internal usage
 *
 * Date: 8/10/17 12:03 PM
 */

namespace App\Service;

use App\Model\Common\Character;

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

        //die("<pre>".print_r($character, true));

        if ( !empty($raceBonuses) ) {
            foreach($raceBonuses as $class => $bonus) {

                $character->getBaseStats()->addModifier($class,
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
            foreach($raceBonuses as $statClass => $bonus) {
                $character->getBaseCombatStats()->addModifier(
                    $statClass,
                    $bonus,
                    "Racial bonus for being {$character->getRace()::getName()}"
                );
            }
        }

        return $this;
    }
}
