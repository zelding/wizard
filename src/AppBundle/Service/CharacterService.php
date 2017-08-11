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


use AppBundle\Model\Common\Character;
use AppBundle\Model\Common\CharacterClass\aClass;
use AppBundle\Model\Common\Race\aRace;
use AppBundle\Model\PC\PlayerCharacter;

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

    public function generateCharacter(aRace $race, aClass $class)
    {
        $character = new PlayerCharacter($race, $class);
        $character->setBaseStats($this->generateBaseStats($race, $class))
                  ->setBaseCombatStats($this->generateBaseCombatStats($class));

        $this->raceService->applyRacialBonuses($character);
        $this->classService->applyClassBonuses($character);

        $this->applyBonuses($character);

        return $character;
    }

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

    protected function generateBaseCombatStats(aClass $class)
    {
        $stats = [];

        foreach($class->getModifiers() as $type => $value) {
            $name = ClassService::$StatTypeToStatName[ $type ];

            $stats[ $name ] = $value;
        }

        return $stats;
    }

    protected function applyBonuses(Character $character)
    {
        $baseStats   = $character->getBaseStats();
        $combatStats = $character->getBaseCombatStats();

        $combatStats->addSequence(
            $baseStats->getDexterity()->getRollModifierValue() +
            $baseStats->getSpeed()->getRollModifierValue()
        );

        $combatStats->addAttack(
            $baseStats->getStrength()->getRollModifierValue() +
            $baseStats->getDexterity()->getRollModifierValue() +
            $baseStats->getSpeed()->getRollModifierValue()
        );

        $combatStats->addDefense(
            $baseStats->getDexterity()->getRollModifierValue() +
            $baseStats->getSpeed()->getRollModifierValue()
        );

        $combatStats->addAim(
            $baseStats->getDexterity()->getRollModifierValue()
        );

        return $this;
    }
}
