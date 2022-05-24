<?php
/**
 * wizard
 *
 * @author    lyozsi (kristof.dekany@apex-it-services.eu)
 * @copyright internal usage
 *
 * Date: 8/10/17 11:55 AM
 */

namespace App\Service;

use App\Exception\AppException;
use App\Exception\GameRuleException;
use App\Model\Common\Character;
use App\Model\Common\CharacterClass\aClass;
use App\Model\Common\Item\Weapon\ShortSword;
use App\Model\Common\Race\aRace;
use App\Model\Common\Skill\aSkill;
use App\Model\Common\Skill\Science\Magic;
use App\Model\Common\Skill\Science\Psy;
use App\Model\Common\Skill\Science\PyarronPsy;
use App\Model\Common\Stats\aStat;
use App\Model\Common\Stats\Base\Astral;
use App\Model\Common\Stats\Base\Dexterity;
use App\Model\Common\Stats\Base\Intelligence;
use App\Model\Common\Stats\Base\Perception;
use App\Model\Common\Stats\Base\Speed;
use App\Model\Common\Stats\Base\Stamina;
use App\Model\Common\Stats\Base\Strength;
use App\Model\Common\Stats\Base\Vitality;
use App\Model\Common\Stats\Base\Willpower;
use App\Model\Common\Stats\Combat\Aim;
use App\Model\Common\Stats\Combat\Attack;
use App\Model\Common\Stats\Combat\Damage;
use App\Model\Common\Stats\Combat\Defense;
use App\Model\Common\Stats\Combat\Sequence;
use App\Model\Common\Stats\General\Health;
use App\Model\Common\Stats\General\Mana;
use App\Model\Common\Stats\General\PainPoint;
use App\Model\Common\Stats\General\PsyPoints;
use App\Model\Common\Stats\General\SkillPoint;
use App\Model\Common\Stats\Magic\AstralMagicResist;
use App\Model\Common\Stats\Magic\MagicResist;
use App\Model\Common\Stats\Magic\MentalMagicResist;
use App\Model\Common\Stats\Modifier;
use App\Model\Mechanics\Dice\D100;
use App\Model\Mechanics\Dice\DiceRoll;
use App\Model\PC\PlayerCharacter;

/**
 * Class CharacterService
 *
 * @package App\Service
 */
class CharacterService
{
    public function __construct(protected RaceService $raceService, protected ClassService $classService, protected InventoryService $inventoryService, protected SkillService $skillService)
    {
    }

    /**
     * Generates a character with random stats
     *
     * @param aRace  $race
     * @param aClass $class
     * @param int    $level
     *
     * @return PlayerCharacter
     * @throws GameRuleException
     * @throws AppException
     */
    public function generateCharacter(aRace $race, aClass $class, int $level = 7) : PlayerCharacter
    {
        $character = new PlayerCharacter($race, $class);

        $base = $this->generateBaseStats($race, $class);

        $character->setBaseStats($base);

        //die("<pre>".print_r($character->getBaseStats(), true));

        $character->setFirstName("Allento");
        $character->setLastName("Al'amall");
        $character->setOtherNames(["Ly"]);

        $this->setCharacterLevel($character, $level)
             ->setSkills($character);

        $this->addXpToCharacter($character, mt_rand(12, 2001));

        //first set class bonuses
        $this->classService->applyClassBonuses($character);

        $this->raceService->applyRacialBonuses($character);

        $this->applySpecialTraining($character, [Strength::class, Stamina::class, Dexterity::class, Speed::class]);

        $this->applyBonuses($character);
        $this->calculateOtherStats($character);
        //die("<pre>".print_r($character->getGeneralStats(), true));
        $this->setUpStaticMagicResists($character);
        $this->regenerateCharacter($character);

        $character->setCurrentSp($character->getGeneralStats()->getStat(SkillPoint::class)->getValue());

        $shortSw = new ShortSword();
        $shortSw->setName("Short sword");

        $this->inventoryService->setUpInventories($character);
        $this->inventoryService->equipItem($character, $shortSw);

        return $character;
    }

    public function regenerateCharacter(Character $character) : self
    {
        $character->setCurrentHP($character->getGeneralStats()->getStat(Health::class)->getValue())
                  ->setCurrentPP($character->getGeneralStats()->getStat(PainPoint::class)->getValue());

        if ( $character->getPsySkill() ) {
            $character->setCurrentPsy($character->getGeneralStats()->getStat(PsyPoints::class)->getValue());
        }

        if ( $character->getMagicSkill() ) {
            $character->setCurrentMP($character->getGeneralStats()->getStat(Mana::class)->getValue());
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

        foreach($statRanges as $statClass => $rollData) {
            $roll = new DiceRoll(...$rollData);

            $statValue = $roll->execute();

            if ( $statValue > $statMaxValues[ $statClass ] ) {
                $statValue = $statMaxValues[ $statClass ];
            }

            $statValues[ $statClass ] = $statValue;
        }

        return $statValues;
    }

    protected function applySpecialTraining(Character $character, array $applyTo = []): void
    {
        $statRanges = $character->getClass()::getBaseStatRanges();

        foreach( $applyTo as $statClass ) {
            $roll = new DiceRoll(...$statRanges[ $statClass ]);

            /** @var aStat $stat */
            $stat = $character->getBaseStats()->getStat($statClass);

            // if allowed for special training
            if ( !empty($statRanges[ $statClass ][3]) && $stat->getOriginalValue() === $roll->getMax()) {
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

                $modifier->setModifies($statClass);

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

        $combatStats->addModifier(Sequence::class,
            $baseStats->getStat(Dexterity::class)->getRollModifierValue(),
            "Base Dexterity bonus"
        )->addModifier(Sequence::class,
            $baseStats->getStat(Speed::class)->getRollModifierValue(),
            "Base Speed bonus"
        )->addModifier(Attack::class,
            $baseStats->getStat(Strength::class)->getRollModifierValue(),
            "Base Strength bonus"
        )->addModifier(Attack::class,
            $baseStats->getStat(Dexterity::class)->getRollModifierValue(),
            "Base Dexterity bonus"
        )->addModifier(Attack::class,
            $baseStats->getStat(Speed::class)->getRollModifierValue(),
            "Base Speed bonus"
        )->addModifier(Defense::class,
            $baseStats->getStat(Dexterity::class)->getRollModifierValue(),
            "Base Dexterity bonus"
        )->addModifier(Defense::class,
            $baseStats->getStat(Speed::class)->getRollModifierValue(),
            "Base Speed bonus"
        )->addModifier(Aim::class,
            $baseStats->getStat(Perception::class)->getRollModifierValue(),
            "Base perception bonus"
        )->addModifier(Aim::class,
            $baseStats->getStat(Dexterity::class)->getRollModifierValue(),
            "Base Dexterity bonus"
        );

        $combatStats->addModifier(Damage::class,
            $baseStats->getStat(Strength::class)->getRollModifierValue(),
            "Base Strength bonus"
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

        $generalStats->addModifier(Health::class,
            $character->getBaseStats()->getStat(Vitality::class)->getRollModifierValue(),
            "Vitality bonus"
        )->addModifier(PainPoint::class,
            $character->getBaseStats()->getStat(Stamina::class)->getRollModifierValue(),
            "Stamina bonus"
        )->addModifier(PainPoint::class,
            $character->getBaseStats()->getStat(Willpower::class)->getRollModifierValue(),
            "Willpower bonus"
        )->addModifier(PainPoint::class,
            $character->getClass()::getPainPointsPerLevel()->getMax(), //on level 1 they get the max
            "First level bonus"
        )->addModifier(SkillPoint::class,
            $character->getBaseStats()->getStat(Dexterity::class)->getRollModifierValue(),
            "Dexterity bonus"
        )->addModifier(SkillPoint::class,
            $character->getBaseStats()->getStat(Intelligence::class)->getRollModifierValue(),
            "Intelligence bonus"
        );

        $psySkill = $character->getPsySkill();

        if ( $psySkill instanceof Psy ) {
            if ( $psySkill instanceof PyarronPsy && $psySkill->getLearnedAt() === 1 ) {
                $generalStats->setStat(PsyPoints::class,
                    // if it was upgraded, then we need to just use the basic mastery stats
                    $psySkill->getUpgradedAt() === 0 ?
                        $psySkill->getBasePoints() :
                        $psySkill::$basePoints
                );
            }
            else {
                $generalStats->setStat(PsyPoints::class, $psySkill->getBasePoints());
            }
        }

        $magicSkill = $character->getMagicSkill();

        if ( $magicSkill instanceof Magic) {
            $generalStats->setStat(Mana::class, $magicSkill->getBasePoints());
        }

        $this->classService->setCombatModifiers($character, 1);

        if ( $character->getLevel() > 1 ) {
            $painPointRoll = $character->getClass()::getPainPointsPerLevel();

            for( $i = 1; $i < $character->getLevel(); $i++ ) {
                if ($i > 1) {
                    //the first level is already given
                    $generalStats->addModifier(PainPoint::class,
                        $painPointRoll->execute(),
                        "Extra PainPoint on lvl {$i}"
                    );

                    $generalStats->addModifier(SkillPoint::class,
                        $character->getClass()::getSkillPointPerLevel(),
                        "Extra SkillPoint on lvl {$i}"
                    );
                }

                if ( $psySkill instanceof PyarronPsy ) {
                    if ( $i + 1 < $psySkill->getUpgradedAt() ) {
                        $generalStats->addModifier(PsyPoints::class,
                            $psySkill::$pointsPerLevel,
                            "Extra psy on lvl {$i}"
                        );
                    }
                    else {
                        $generalStats->addModifier(PsyPoints::class,
                            $psySkill->getPointsPerLevel(),
                            "Extra psy on lvl {$i}");
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

        if ( $character->getPsySkill() ) {
            $astral->setStatic($character->getGeneralStats()->getStat(PsyPoints::class)->getValue());
            $mental->setStatic($character->getGeneralStats()->getStat(PsyPoints::class)->getValue());
        }

        $astral->setDynamic(0)
               ->setSubConscious($character->getBaseStats()->getStat(Astral::class)->getRollModifierValue())
               ->setMagic(0);

        $mental->setDynamic(0)
               ->setSubConscious($character->getBaseStats()->getStat(Willpower::class)->getRollModifierValue())
               ->setMagic(0);

        $modifiers = $character->getRace()::getGeneralStatModifiers();

        if ( array_key_exists(MagicResist::class, $modifiers) ) {
            $astral->setPerLevel($modifiers[ MagicResist::class ]);
            $mental->setPerLevel($modifiers[ MagicResist::class ]);
        }

        if ( array_key_exists(AstralMagicResist::class, $modifiers) ) {
            $astral->addModifier(
                (new Modifier($modifiers[ AstralMagicResist::class ]))
                    ->setDescription("Racial bonus for being {$character->getRace()::getName()}")
                    ->setModifies(AstralMagicResist::class)
            );
        }

        if ( array_key_exists(MentalMagicResist::class, $modifiers) ) {
            $mental->addModifier(
                (new Modifier($modifiers[ MentalMagicResist::class ]))
                    ->setDescription("Racial bonus for being {$character->getRace()::getName()}")
                    ->setModifies(MentalMagicResist::class)
            );
        }

        $character->setMagicResists($astral);
        $character->setMagicResists($mental);

        return $this;
    }

    protected function addXpToCharacter(Character $character, int $xp): self
    {
        $nextAt = $character->getXpToNextLevel();

        if ( $character->getXpToNextLevel() < $xp ) {
            $this->setCharacterLevel($character, $character->getLevel() + 1);
            $xp -= $nextAt;

            $this->addXpToCharacter($character, $xp);
        }

        $character->setExperience($character->getExperience() + $xp);

        return $this;
    }

    protected function setCharacterLevel(Character $character, int $level = 1) : self
    {
        $xpTable = $character->getClass()::getExperienceTable();

        $xp = 0;
        $i  = 1;
        $maxTable = count($xpTable) - 1;

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
