<?php
/**
 * wizard
 *
 * @author    lyozsi (kristof.dekany@apex-it-services.eu)
 * @copyright internal usage
 *
 * Date: 8/10/17 11:55 AM
 */

namespace AppBundle\Service;


use AppBundle\Exception\AppException;
use AppBundle\Model\Common\Character;
use AppBundle\Model\Common\CharacterClass\aClass;
use AppBundle\Model\Common\Race\aRace;
use AppBundle\Model\PC\PlayerCharacter;

/**
 * Class CharacterService
 *
 * @package AppBundle\Service
 */
class CharacterService
{
    /** @var RaceService */
    protected $raceService;
    /** @var ClassService */
    protected $classService;

    public function __construct(RaceService $raceService, ClassService $classService)
    {
        $this->raceService  = $raceService;

        $this->classService = $classService;
    }

    /**
     * Generates a character with random stats
     *
     * @param aRace  $race
     * @param aClass $class
     *
     * @return PlayerCharacter
     * @throws AppException
     */
    public function generateCharacter(aRace $race, aClass $class)
    {
        $character = new PlayerCharacter($race, $class);
        $character->setBaseStats($this->generateBaseStats($race, $class));

        //first set class bonuses
        $this->classService->applyClassBonuses($character);

        $this->raceService->applyRacialBonuses($character);

        $this->applyBonuses($character);

        return $character;
    }

    /**
     * Rolls base stats
     *
     * @param aRace  $race
     * @param aClass $class
     *
     * @return int[]
     */
    protected function generateBaseStats(aRace $race, aClass $class)
    {
        $statRanges    = $class::getBaseStatRanges();
        $statMaxValues = $race::getMaxBaseStats();

        $statValues = [];

        foreach($statRanges as $statType => $range) {
            $i = 1;

            $statValue = mt_rand($range[0], $range[1]);

            //if you are allowed to re-roll
            while($range[2] > $i) {
                $next = mt_rand($range[0], $range[1]);
                $i++;

                if ( $next > $statValue ) {
                    $statValue = $next;
                }
            }

            if ( $statValue > $statMaxValues[ $statType ] ) {
                $statValue = $statMaxValues[ $statType ];
            }

            $statValues[ RaceService::$StatTypeToStatName[ $statType ] ] = $statValue;
        }

        return $statValues;
    }

    /**
     * Adds combat stat modifiers based on base stats
     *
     * @param Character $character
     *
     * @return $this
     * @throws AppException
     */
    protected function applyBonuses(Character $character)
    {
        $baseStats   = $character->getBaseStats();
        $combatStats = $character->getBaseCombatStats();

        $combatStats->addSequence(
            $baseStats->getDexterity()->getRollModifierValue(), "Base Dexterity bonus"
        )->addSequence(
            $baseStats->getSpeed()->getRollModifierValue(), "Base Speed bonus"
        )->addAttack(
            $baseStats->getStrength()->getRollModifierValue(), "Base Strength bonus"
        )->addAttack(
            $baseStats->getDexterity()->getRollModifierValue(), "Base Dexterity bonus"
        )->addAttack(
            $baseStats->getSpeed()->getRollModifierValue(), "Base Speed bonus"
        )->addDefense(
            $baseStats->getDexterity()->getRollModifierValue(), "Base Dexterity bonus"
        )->addDefense(
            $baseStats->getSpeed()->getRollModifierValue(), "Base Speed bonus"
        )->addAim(
            $baseStats->getDexterity()->getRollModifierValue(), "Base Dexterity bonus"
        );

        return $this;
    }
}
