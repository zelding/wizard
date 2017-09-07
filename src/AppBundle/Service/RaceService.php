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
use AppBundle\Model\Common\Skill\aSkill;
use AppBundle\Model\Common\Skill\Social\Language;

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
    public function applyRacialBonuses(Character $character)
    {
        $this->setRacialBonuses($character)
             ->addRacialCombatBonuses($character);

        return $this;
    }

    /**
     * @param Character $character
     *
     * @return aSkill[]
     */
    public function getRacialSkills(Character $character)
    {
        $skills = $character->getRace()::getBaseSkills();

        $racialSkills = [];

        if ( !empty($skills) ) {
            foreach ($skills as $class => $mastery) {
                /** @var aSkill $skill */
                $skill = new $class();

                if ( $skill instanceof Language ) {
                    foreach($mastery as $langData) {
                        /** @var Language $lang */
                        $lang = new $class($langData["mastery"]);
                        $lang->setLevel($langData["level"]);
                        $lang->setRelatesTo($langData["for"]);

                        $racialSkills[] = $lang;
                    }
                }
                else {
                    $skill->setMastery($mastery);
                    $racialSkills[] = $skill;
                }
            }
        }

        return $racialSkills;
    }

    /**
     * @param Character $character
     *
     * @return $this
     */
    protected function setRacialBonuses(Character $character)
    {
        $raceBonuses = $character->getRace()::getBaseStatModifiers();

        if ( !empty($raceBonuses) ) {
            foreach($raceBonuses as $type => $bonus) {

                $method = StatsHelper::$BaseStatTypeToStatName[ $type ];
                $character->getBaseStats()->{"add{$method}"}($bonus);
            }
        }

        return $this;
    }

    /**
     * @param Character $character
     *
     * @return $this
     */
    protected function addRacialCombatBonuses(Character $character)
    {
        $raceBonuses = $character->getRace()::getCombatStatModifiers();

        if ( !empty($raceBonuses) ) {
            foreach($raceBonuses as $type => $bonus) {
                $method = StatsHelper::$CombatStatTypeToStatName[ $type ];
                $character->getBaseCombatStats()->{"add{$method}"}($bonus, "Racial bonus");
            }
        }

        return $this;
    }
}
