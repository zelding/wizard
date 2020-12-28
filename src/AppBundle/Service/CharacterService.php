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
use AppBundle\Model\Common\Item\Weapon\ShortSword;
use AppBundle\Model\Common\Item\Weapon\Weapon;
use AppBundle\Model\Common\Race\aRace;
use AppBundle\Model\Common\Skill\aSkill;
use AppBundle\Model\Common\Skill\Science\Magic;
use AppBundle\Model\Common\Skill\Science\Psy;
use AppBundle\Model\Common\Skill\Science\PyarronPsy;
use AppBundle\Model\Common\Stats\aStat;
use AppBundle\Model\Common\Stats\Base\Dexterity;
use AppBundle\Model\Common\Stats\Base\Speed;
use AppBundle\Model\Common\Stats\Base\Stamina;
use AppBundle\Model\Common\Stats\Base\Strength;
use AppBundle\Model\Common\Stats\Magic\AstralMagicResist;
use AppBundle\Model\Common\Stats\Magic\MagicResist;
use AppBundle\Model\Common\Stats\Magic\MentalMagicResist;
use AppBundle\Model\Common\Stats\Modifier;
use AppBundle\Model\Mechanics\Dice\D100;
use AppBundle\Model\Mechanics\Dice\DiceRoll;
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

    protected InventoryService $inventoryService;

    protected SkillService $skillService;

    public function __construct(RaceService $raceService, ClassService $classService, InventoryService $inventoryService, SkillService $skillService)
    {
        $this->raceService  = $raceService;

        $this->classService = $classService;

        $this->inventoryService  = $inventoryService;

        $this->skillService = $skillService;
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

        $this->applySpecialTraining($character, [Strength::TYPE, Stamina::TYPE, Dexterity::TYPE, Speed::TYPE]);

        $this->applyBonuses($character)
             ->calculateOtherStats($character)
             ->setUpStaticMagicResists($character)
             ->regenerateCharacter($character);

        $character->setCurrentSp($character->getGeneralStats()->getSkillPoint()->getValue());

        $shortSw = new ShortSword(Weapon::SUB_CATEGORY_LONG);
        $shortSw->setName("Short sword");

        $this->inventoryService->setUpInventories($character);
        $this->inventoryService->equipItem($character, $shortSw);

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

        foreach($statRanges as $statType => $rollData) {
            $roll = new DiceRoll(...$rollData);

            $statValue = $roll->execute();

            if ( $statValue > $statMaxValues[ $statType ] ) {
                $statValue = $statMaxValues[ $statType ];
            }

            $statValues[ StatsHelper::$BaseStatTypeToStatName[ $statType ] ] = $statValue;
        }

        return $statValues;
    }

    protected function applySpecialTraining(Character $character, array $applyTo = [])
    {
        $statRanges = $character->getClass()::getBaseStatRanges();

        foreach( $applyTo as $statType ) {
            $method = StatsHelper::$BaseStatTypeToStatName[ $statType ];

            $roll = new DiceRoll(...$statRanges[ $statType ]);

            /** @var aStat $stat */
            $stat = $character->getBaseStats()->{"get$method"}();

            // if allowed for special training
            if ( !empty($statRanges[ $statType ][3]) && $stat->getOriginalValue() === $roll->getMax()) {
                $specialRoll = new DiceRoll([new D100()]);

                $result = $specialRoll->execute();

                if ($result > 90) {
                    $modifier = new Modifier(2, "Perfect Special training");
                }
                elseif ($result > 80) {
                    $modifier = new Modifier(1, "Successful Special training");
                }
                elseif( $result > 60 ) {
                    $modifier = new Modifier(0, "Unsuccessful Special training");
                }
                elseif( $result > 30 ) {
                    $modifier = new Modifier(-1, "Very Unsuccessful Special training");
                }
                else {
                    $modifier = new Modifier(-2, "Almost deadly Special training");
                }

                $modifier->setModifies($statType);

                $stat->addModifier($modifier);
            }
        }
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
            $character->getClass()::getPainPointsPerLevel()->getMax(), //on level 1 they get the max
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
            $painPointRoll = $character->getClass()::getPainPointsPerLevel();

            for( $i = 1; $i < $character->getLevel(); $i++ ) {
                if ($i > 1) {
                    //the first level is already given
                    $generalStats->addPainPoint($painPointRoll->execute(), "Extra PainPoint on lvl {$i}");

                    $generalStats->addSkillPoint(
                        $character->getClass()::getSkillPointPerLevel(),
                        "Extra SkillPoint on lvl {$i}"
                    );
                }

                if ( $psySkill instanceof PyarronPsy ) {
                    if ( $i + 1 < $psySkill->getUpgradedAt() ) {
                        $generalStats->addPsyPoint( $psySkill::$pointsPerLevel, "Extra psy on lvl {$i}" );
                    }
                    else {
                        $generalStats->addPsyPoint($psySkill->getPointsPerLevel(), "Extra psy on lvl {$i}");
                    }
                }

                /*if ( $character->getRace()::getGeneralStatModifiers() ) {
                    foreach($character->getRace()::getGeneralStatModifiers() as $type => $bonus ) {
                        $character->getMagicResist(MagicResist::TYPE_ASTRAL);
                    }
                }*/

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

        if ( $character->getPsySkill() instanceof Psy ) {
            $astral->setStatic($character->getGeneralStats()->getPsyPoint()->getValue());
            $mental->setStatic($character->getGeneralStats()->getPsyPoint()->getValue());
        }

        $astral->setDynamic(0)
               ->setSubConscious($character->getBaseStats()->getAstral()->getRollModifierValue())
               ->setMagic(0);

        $mental->setDynamic(0)
               ->setSubConscious($character->getBaseStats()->getWillpower()->getRollModifierValue())
               ->setMagic(0);

        $modifiers = $character->getRace()::getGeneralStatModifiers();

        if ( array_key_exists(MagicResist::TYPE, $modifiers) ) {
            $astral->setPerLevel($modifiers[ MagicResist::TYPE ]);
            $mental->setPerLevel($modifiers[ MagicResist::TYPE ]);
        }

        if ( array_key_exists(MagicResist::TYPE_ASTRAL, $modifiers) ) {
            $astral->addModifier(
                (new Modifier($modifiers[ MagicResist::TYPE_ASTRAL ]))
                    ->setDescription("Racial bonus for being {$character->getRace()::getName()}")
                    ->setModifies(MagicResist::TYPE_ASTRAL)
            );
        }

        if ( array_key_exists(MagicResist::TYPE_MENTAL, $modifiers) ) {
            $mental->addModifier(
                (new Modifier($modifiers[ MagicResist::TYPE_MENTAL ]))
                    ->setDescription("Racial bonus for being {$character->getRace()::getName()}")
                    ->setModifies(MagicResist::TYPE_MENTAL)
            );
        }

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
        $racialSkills = $this->skillService->getSkillsFromProvider($character->getRace());
        $classSkills  = $this->skillService->getSkillsFromProvider($character->getClass());

        foreach( $racialSkills as $skill ) {
            $this->addCharacterSkill($character, $skill);
        }

        foreach($classSkills as $skill) {
            $this->addCharacterSkill($character, $skill);
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
