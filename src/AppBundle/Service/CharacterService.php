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
use AppBundle\Model\Common\Item\Weapon\Weapon;
use AppBundle\Model\Common\Race\aRace;
use AppBundle\Model\Common\Skill\aSkill;
use AppBundle\Model\Common\Skill\Science\Magic;
use AppBundle\Model\Common\Skill\Science\Psy;
use AppBundle\Model\Common\Skill\Science\PyarronPsy;
use AppBundle\Model\Common\Stats\aStat;
use AppBundle\Model\Common\Stats\Magic\AstralMagicResist;
use AppBundle\Model\Common\Stats\Magic\MentalMagicResist;
use AppBundle\Model\PC\PlayerCharacter;

use AppBundle\Helper\Stats as StatsHelper;

/**
 * Class CharacterService
 *
 * @package AppBundle\Service
 */
class CharacterService
{
    protected RaceService $raceService;

    protected ClassService $classService;

    protected ItemService $itemService;

    public function __construct(RaceService $raceService, ClassService $classService, ItemService $itemService)
    {
        $this->raceService  = $raceService;

        $this->classService = $classService;

        $this->itemService  = $itemService;
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
    public function generateCharacter(aRace $race, aClass $class, int $level = 7) : PlayerCharacter
    {
        $character = new PlayerCharacter($race, $class);
        $character->setBaseStats($this->generateBaseStats($race, $class));
        $character->setFirstName("Allento");
        $character->setLastName("Al'amall");
        $character->setOtherNames(["Ly"]);

        $this->setCharacterLevel($character, $level)
             ->setSkills($character);

        //first set class bonuses
        $this->classService->applyClassBonuses($character);

        $this->raceService->applyRacialBonuses($character);

        $this->applyBonuses($character)
             ->calculateOtherStats($character)
             ->setUpStaticMagicResists($character)
             ->regenerateCharacter($character);

        $character->setCurrentSp($character->getGeneralStats()->getSkillPoint()->getValue());

        $longSw = new Weapon(Weapon::SUB_CATEGORY_LONG);
        $longSw->setName("Long sword");

        $character->getInventory()->addItem($longSw);

        return $character;
    }

    public function regenerateCharacter(Character $character) : self
    {
        $character->setCurrentHP($character->getGeneralStats()->getHealth()->getValue())
                  ->setCurrentPP($character->getGeneralStats()->getPainPoint()->getValue());

        if ( $character->getPsySkill() ) {
            $character->setCurrentPsy($character->getGeneralStats()->getPsyPoint()->getValue());
        }

        if ( $character->getMagicSkill() ) {
            $character->setCurrentMP($character->getGeneralStats()->getMana()->getValue());
        }

        return $this;
    }

    /**
     * Rolls base stats
     *
     * @param aRace  $race
     * @param aClass $class
     *
     * @return aStat[]
     */
    protected function generateBaseStats(aRace $race, aClass $class) : array
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

            $statValues[ StatsHelper::$BaseStatTypeToStatName[ $statType ] ] = $statValue;
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
    protected function applyBonuses(Character $character) : self
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
            $baseStats->getPerception()->getRollModifierValue(),
            "Base perception bonus"
        )->addAim(
            $baseStats->getDexterity()->getRollModifierValue(),
            "Base Dexterity bonus"
        );

        return $this;
    }

    /**
     * Sets health-, pain, mana- and psypoints
     *
     * @param Character $character
     *
     * @return $this
     * @throws AppException
     */
    protected function calculateOtherStats(Character $character) : self
    {
        $generalStats = $character->getGeneralStats();

        $generalStats->addHealth(
            $character->getBaseStats()->getVitality()->getRollModifierValue(),
            "Vitality bonus"
        )->addPainPoint(
            $character->getBaseStats()->getStamina()->getRollModifierValue(),
            "Stamina bonus"
        )->addPainPoint(
            $character->getBaseStats()->getWillpower()->getRollModifierValue(),
            "Willpower bonus"
        )->addPainPoint(
            $character->getClass()::getPainPointsPerLevel()[1], //on level 1 they get the max
            "First level bonus"
        )->addSkillPoint(
            $character->getBaseStats()->getDexterity()->getRollModifierValue(),
            "Dexterity bonus"
        )->addSkillPoint(
            $character->getBaseStats()->getIntelligence()->getRollModifierValue(),
            "Intelligence bonus"
        );

        $psySkill = $character->getPsySkill();

        if ( $psySkill instanceof Psy ) {
            if ( $psySkill instanceof PyarronPsy && $psySkill->getLearnedAt() === 1 ) {
                $generalStats->setPsyPoint(
                    // if it was upgraded, then we need to just use the basic mastery stats
                    $psySkill->getUpgradedAt() === 0 ?
                        $psySkill->getBasePoints() :
                        $psySkill::$basePoints
                );
            }
            else {
                $generalStats->setPsyPoint($psySkill->getBasePoints());
            }
        }

        $magicSkill = $character->getMagicSkill();

        if ( $magicSkill instanceof Magic) {
            $generalStats->setMana($magicSkill->getBasePoints());
        }

        $this->classService->setCombatModifiers($character, 1);

        if ( $character->getLevel() > 1 ) {
            list($min, $max) = $character->getClass()::getPainPointsPerLevel();

            for( $i = 1; $i < $character->getLevel(); $i++ ) {
                if ($i !== 1) {
                    //the first level pp is already given
                    $generalStats->addPainPoint(mt_rand($min, $max), "Extra PainPoint on lvl {$i}");
                }

                if ($i > 1)
                $generalStats->addSkillPoint(
                    $character->getClass()::getSkillPointPerLevel(),
                    "Extra on lvl {$i}"
                );

                if ( $psySkill instanceof PyarronPsy ) {
                    if ( $i + 1 < $psySkill->getUpgradedAt() ) {
                        $generalStats->addPsyPoint( $psySkill::$pointsPerLevel, "Extra psy on lvl {$i}" );
                    }
                    else {
                        $generalStats->addPsyPoint($psySkill->getPointsPerLevel(), "Extra psy on lvl {$i}");
                    }
                }

                $this->classService->setCombatModifiers($character, ($i+1));
            }
        }

        return $this;
    }

    /**
     * @param Character $character
     *
     * @return $this
     * @throws AppException
     */
    protected function setUpStaticMagicResists(Character $character) : self
    {
        $astral = new AstralMagicResist(0);
        $mental = new MentalMagicResist(0);

        if ( $character->getPsySkill() !== false) {
            $astral->setStatic($character->getGeneralStats()->getPsyPoint()->getValue());
            $mental->setStatic($character->getGeneralStats()->getPsyPoint()->getValue());
        }

        $astral->setDynamic(0)
               ->setSubConscious($character->getBaseStats()->getAstral()->getRollModifierValue())
               ->setMagic(0);

        $mental->setDynamic(0)
               ->setSubConscious($character->getBaseStats()->getWillpower()->getRollModifierValue())
               ->setMagic(0);

        $character->setMagicResists($astral);
        $character->setMagicResists($mental);

        return $this;
    }

    protected function setCharacterLevel(Character $character, int $level = 1) : self
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

    protected function setSkills(Character $character) : self
    {
        $racialSkills = $this->raceService->getRacialSkills($character);
        $classSkills  = $this->classService->getClassSkills($character);

        foreach($classSkills as $skill) {
            if ( empty($skill->getOrigin()) ) {
                $skill->updateOrigin("from class: ".$character->getClass()::getName());
            }

            $this->addCharacterSkill($character, $skill);
        }

        if ( !empty($racialSkills) ) {
            foreach( $racialSkills as $skill ) {
                if ( empty($skill->getOrigin()) ) {
                    $skill->setOrigin("from race: ".$character->getRace()::getName());
                }

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
    protected function addCharacterSkill(Character $character, aSkill $skill) : self
    {
        if ( $oldSkill = $this->getSkill($character, $skill) ) {
            $oldSkill->updateOrigin( "updated by: ".$skill->getOrigin()[0] );
            $oldSkill->setMastery($skill->getMastery());

            if ( $oldSkill instanceof PyarronPsy ) {
                /** @var $skill PyarronPsy */
                $oldSkill->setUpgradedAt($skill->getUpgradedAt());
            }
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
     * @return aSkill|null
     */
    protected function getSkill(Character $character, aSkill $newSkill) : ?aSkill
    {
        $skills = $character->getSkills();

        if ( !empty($skills) ) {
            foreach ($skills as $cat => $skillGroup) {
                foreach($skillGroup as $skill) {
                    /** @var aSkill $skill */
                    if (get_class($skill) === get_class($newSkill)) {

                        if ($skill::$allowMultiple) {
                            if ($newSkill->getRelatesTo() === $skill->getRelatesTo()) {
                                return $skill;
                            }
                        }
                        else {
                            return $skill;
                        }
                    }
                }
            }
        }

        return null;
    }
}
