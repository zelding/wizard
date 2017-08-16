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
use AppBundle\Model\Common\Skill\aSkill;
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
     * @param int    $level
     *
     * @return PlayerCharacter
     * @throws AppException
     */
    public function generateCharacter(aRace $race, aClass $class, int $level = 7)
    {
        $character = new PlayerCharacter($race, $class);
        $character->setBaseStats($this->generateBaseStats($race, $class));

        $this->setCharacterLevel($character, $level)
             ->calculateOtherStats($character)
             ->setSkills($character);

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
            $baseStats->getDexterity()->getRollModifierValue(),
            "Base Dexterity bonus"
        )->addSequence(
            $baseStats->getSpeed()->getRollModifierValue(),
            "Base Speed bonus"
        )->addAttack(
            $baseStats->getStrength()->getRollModifierValue(),
            "Base Strength bonus"
        )->addAttack(
            $baseStats->getDexterity()->getRollModifierValue(),
            "Base Dexterity bonus"
        )->addAttack(
            $baseStats->getSpeed()->getRollModifierValue(),
            "Base Speed bonus"
        )->addDefense(
            $baseStats->getDexterity()->getRollModifierValue(),
            "Base Dexterity bonus"
        )->addDefense(
            $baseStats->getSpeed()->getRollModifierValue(),
            "Base Speed bonus"
        )->addAim(
            $baseStats->getDexterity()->getRollModifierValue(),
            "Base Dexterity bonus"
        );

        return $this;
    }

    protected function calculateOtherStats(Character $character)
    {
        $character->setBaseHP(
            $character->getClass()::getHpBase() +
            $character->getBaseStats()->getVitality()->getRollModifierValue()
        )->setBasePP(
            $character->getClass()::getPpBase() +
            $character->getBaseStats()->getStamina()->getRollModifierValue() +
            $character->getBaseStats()->getWillpower()->getRollModifierValue() +
            $character->getClass()::getPainPointsPerLevel()[1] //on level 1 they get the max
        );

        if ( $character->getLevel() > 1 ) {
            list($min, $max) = $character->getClass()::getPainPointsPerLevel();

            for( $i = 1; $i < $character->getLevel(); $i++ ) {
                $character->addPP(mt_rand($min, $max));
            }
        }

        return $this;
    }

    protected function setCharacterLevel(Character $character, int $level = 1)
    {
        $xpTable = $character->getClass()::getExperienceTable();

        $xp = 0;
        $i  = 1;
        $maxTable = count($xpTable);

        while ( $i < $level && $i < $maxTable ) {
            $xp = $xpTable[ $i ];
            $i++;
        }

        //the tables only account until lvl 12 usually
        if ( $level > $maxTable ) {
            $xp += ($level - $maxTable) * $character->getClass()::getXpAfter12();
        }

        $character->setLevel($level)
                  ->setExperience($xp);

        return $this;
    }

    protected function setSkills(Character $character)
    {
        $racialSkills = $this->raceService->getRacialSkills($character);
        $classSkills  = $this->classService->getClassSkills($character);

        foreach($classSkills as $skill) {
            $this->addCharacterSkill($character, $skill);
        }

        if ( !empty($racialSkills) ) {
            foreach( $racialSkills as $skill ) {
                $this->addCharacterSkill($character, $skill);
            }
        }

        return $this;
    }

    /**
     * Adds or updates a profession
     *
     * @param Character $character
     * @param aSkill    $skill
     *
     * @return $this
     */
    protected function addCharacterSkill(Character $character, aSkill $skill)
    {
        if ( $oldSkill = $this->getSkill($character, $skill) ) {
            $oldSkill->setMastery($skill->getMastery());
        }
        else {
            $character->addSkill($skill);
        }

        return $this;
    }

    /**
     * returns an existing profession if exists
     *
     * @param Character $character
     * @param aSkill    $newSkill
     *
     * @return aSkill|bool
     */
    protected function getSkill(Character $character, aSkill $newSkill)
    {
        $skills = $character->getSkills();

        if ( !empty($skills) ) {
            foreach ($skills as $skill) {
                /** @var aSkill $skill */
                if ( get_class($skill) === get_class($newSkill) ) {

                    if ( $skill::$allowMultiple ) {
                        if( $newSkill->getRelatesTo() === $skill->getRelatesTo() ) {
                            return $skill;
                        }
                    }
                    else {
                        return $skill;
                    }
                }
            }
        }

        return false;
    }
}
