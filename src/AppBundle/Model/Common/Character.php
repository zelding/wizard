<?php
/**
 * wizard
 *
 * @author    lyozsi (kristof.dekany@apex-it-services.eu)
 * @copyright internal usage
 *
 * Date: 8/9/17 1:21 PM
 */

namespace AppBundle\Model\Common;

use AppBundle\Model\Common\CharacterClass\aClass;
use AppBundle\Model\Common\Item\Equipment;
use AppBundle\Model\Common\Item\Inventory;
use AppBundle\Model\Common\Race\aRace;
use AppBundle\Model\Common\Skill\aSkill;
use AppBundle\Model\Common\Skill\Science\Magic;
use AppBundle\Model\Common\Skill\Science\Psy;
use AppBundle\Model\Common\Stats\aStat;
use AppBundle\Model\Common\Stats\Base\BaseStats;
use AppBundle\Model\Common\Stats\Combat\BaseCombatStats;
use AppBundle\Model\Common\Stats\General\GeneralStats;
use AppBundle\Model\Common\Stats\Magic\MagicResist;

abstract class Character
{
    /** @var string */
    protected string $firstName  = "";
    /** @var string[] */
    protected array $otherNames = [];
    /** @var string */
    protected string $lastName  = "";

    /** @var aRace */
    protected aRace $race;
    /** @var aClass */
    protected aClass $class;

    protected int $level = 1;

    protected int $experience = 0;

    protected BaseStats $baseStats;
    protected BaseCombatStats $baseCombatStats;
    protected GeneralStats $generalStats;
    protected Inventory $inventory;
    protected Equipment $equipment;

    protected int $currentHP  = 0;
    protected int $currentPP  = 0;
    protected int $currentMP  = 0;
    protected int $currentPsy = 0;
    protected int $currentSp  = 0;

    protected int $availableCombatModifiers = 0;

    /** @var Stats\Magic\MagicResist[] */
    protected array $magicResists = [];

    /** @var aSkill[][] */
    protected array $skills = [];

    public function __construct(aRace $race, aClass $class)
    {
        $this->race  = $race;
        $this->class = $class;

       //$this->inventory = new Inventory();
       //$this->equipment = new Equipment();
    }

    /**
     * @return string
     */
    public function getFullName() : string
    {
        $fullName = $this->getFirstName()." ";

        if ( !empty($this->otherNames) ) {
            $fullName .= implode(" ", $this->otherNames)." ";
        }

        $fullName .= $this->getLastName();

        return $fullName;
    }

    public function getXpToNextLevel() : int
    {
        if ( $this->class instanceof aClass) {
            $table = $this->class::getExperienceTable();

            return $table[ $this->level ] - $this->experience;
        }

        return -1;
    }

    public function getPsySkill() : ?Psy
    {
        if ( !empty($this->skills[ aSkill::SKILL_TYPE_SCIENCE ]) ) {
            $a = array_filter($this->skills[ aSkill::SKILL_TYPE_SCIENCE ], function ($skill) {
                return is_a($skill, Psy::class);
            });

            return !empty($a) ? reset($a) : null;
        }

        return null;
    }

    public function getMagicSkill() : ?Magic
    {
        if ( !empty($this->skills[ aSkill::SKILL_TYPE_SCIENCE ]) ) {
            $a = array_filter($this->skills[ aSkill::SKILL_TYPE_SCIENCE ], function ($skill) {
                return is_a($skill, Magic::class);
            });

            return !empty($a) ? reset($a) : null;
        }

        return null;
    }

    public function addAvailableCombatModifier(int $amount) : self
    {
        $this->availableCombatModifiers += $amount;

        return $this;
    }

    public function useAvailableCombatModifier(int $amount) : self
    {
        $this->availableCombatModifiers -= $amount;

        return $this;
    }

    public function getMaxCombatModifier() : int
    {
        list($perLvl, $stats) = $this->class::getCombatModifiersPerLevel();

        // negated the operation so the ide will shut up about operations on arrays
        return array_sum($stats) * -1 + $perLvl;
    }

    #region Getters/Setters

    /**
     * @param aStat[] $baseStats
     *
     * @return $this
     */
    public function setBaseStats(array $baseStats) : self
    {
        $this->baseStats = new BaseStats($baseStats);

        return $this;
    }

    /**
     * @param aStat[] $baseCombatStats
     *
     * @return $this
     */
    public function setBaseCombatStats(array $baseCombatStats) : self
    {
        $this->baseCombatStats = new BaseCombatStats($baseCombatStats);

        return $this;
    }

    /**
     * @param aStat[] $generalStats
     *
     * @return Character
     */
    public function setGeneralStats(array $generalStats): Character
    {
        $this->generalStats = new GeneralStats($generalStats);

        return $this;
    }


    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     *
     * @return Character
     */
    public function setFirstName(string $firstName): Character
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * @return string[]
     */
    public function getOtherNames(): array
    {
        return $this->otherNames;
    }

    /**
     * @param string[] $otherNames
     *
     * @return Character
     */
    public function setOtherNames(array $otherNames): Character
    {
        $this->otherNames = $otherNames;

        return $this;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     *
     * @return Character
     */
    public function setLastName(string $lastName): Character
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * @return aRace
     */
    public function getRace(): aRace
    {
        return $this->race;
    }

    /**
     * @param aRace $race
     *
     * @return Character
     */
    public function setRace(aRace $race): Character
    {
        $this->race = $race;

        return $this;
    }

    /**
     * @return aClass
     */
    public function getClass() : aClass
    {
        return $this->class;
    }

    /**
     * @param aClass $class
     *
     * @return Character
     */
    public function setClass(aClass $class): Character
    {
        $this->class = $class;

        return $this;
    }

    public function getBaseStats() : BaseStats
    {
        return $this->baseStats;
    }

    public function getBaseCombatStats() : BaseCombatStats
    {
        return $this->baseCombatStats;
    }

    public function getGeneralStats() : GeneralStats
    {
        return $this->generalStats;
    }

    public function getMagicResist( $type = Stats\Magic\MagicResist::TYPE_ASTRAL ) : MagicResist
    {
        return $this->magicResists[ $type ];
    }

    public function setMagicResists(Stats\Magic\MagicResist $magicResist) : self
    {
        $this->magicResists[ $magicResist->getType() ] = $magicResist;

        return $this;
    }

    /**
     * @return Inventory
     */
    public function getInventory() : Inventory
    {
        return $this->inventory;
    }

    /**
     * @param Inventory $inventory
     * @return Character
     */
    public function setInventory(Inventory $inventory) : self
    {
        $this->inventory = $inventory;
        return $this;
    }

    /**
     * @return aSkill[]
     */
    public function getSkills() : array
    {
        return $this->skills;
    }

    /**
     * @param aSkill[] $skills
     * @return Character
     */
    public function setSkills(array $skills) : self
    {
        $this->skills = $skills;
        return $this;
    }

    public function addSkill(aSkill $skill)
    {
        $this->skills[ $skill::$category ][] = $skill;
    }

    /**
     * @return int
     */
    public function getLevel(): int
    {
        return $this->level;
    }

    /**
     * @param int $level
     *
     * @return Character
     */
    public function setLevel(int $level): self
    {
        $this->level = $level;

        return $this;
    }

    /**
     * @return int
     */
    public function getExperience(): int
    {
        return $this->experience;
    }

    /**
     * @param int $experience
     *
     * @return Character
     */
    public function setExperience(int $experience): self
    {
        $this->experience = $experience;

        return $this;
    }

    /**
     * @return int
     */
    public function getCurrentHP(): int
    {
        return $this->currentHP;
    }

    /**
     * @param int $currentHP
     *
     * @return Character
     */
    public function setCurrentHP(int $currentHP): self
    {
        $this->currentHP = $currentHP;

        return $this;
    }

    /**
     * @return int
     */
    public function getCurrentPP(): int
    {
        return $this->currentPP;
    }

    /**
     * @param int $currentPP
     *
     * @return Character
     */
    public function setCurrentPP(int $currentPP): self
    {
        $this->currentPP = $currentPP;

        return $this;
    }

    /**
     * @return int
     */
    public function getCurrentMP(): int
    {
        return $this->currentMP;
    }

    /**
     * @param int $currentMP
     *
     * @return Character
     */
    public function setCurrentMP(int $currentMP): self
    {
        $this->currentMP = $currentMP;

        return $this;
    }

    /**
     * @return int
     */
    public function getCurrentPsy(): int
    {
        return $this->currentPsy;
    }

    /**
     * @param int $currentPsy
     *
     * @return Character
     */
    public function setCurrentPsy(int $currentPsy): self
    {
        $this->currentPsy = $currentPsy;

        return $this;
    }

    /**
     * @return int
     */
    public function getCurrentSp() : int
    {
        return $this->currentSp;
    }

    /**
     * @param int $currentSp
     * @return Character
     */
    public function setCurrentSp(int $currentSp) : self
    {
        $this->currentSp = $currentSp;
        return $this;
    }

    public function getAvailableCombatModifier() : int
    {
        return $this->availableCombatModifiers;
    }

    public function getEquipment(): Equipment
    {
        return $this->equipment;
    }

    public function setEquipment(Equipment $equipment): Character
    {
        $this->equipment = $equipment;
        return $this;
    }

    #endregion

}
