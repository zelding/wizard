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

use AppBundle\Exception\AppException;
use AppBundle\Model\Common\CharacterClass\aClass;
use AppBundle\Model\Common\Race\aRace;
use AppBundle\Model\Common\Skill\aSkill;
use AppBundle\Model\Common\Skill\Science\Magic;
use AppBundle\Model\Common\Skill\Science\Psy;
use AppBundle\Model\Common\Stats\Base\BaseStats;
use AppBundle\Model\Common\Stats\Combat\BaseCombatStats;
use AppBundle\Model\Common\Stats\General\GeneralStats;

abstract class Character
{
    /** @var string */
    protected $firstName  = "";
    /** @var string[] */
    protected $otherNames = [];
    /** @var string */
    protected $lastName  = "";

    /** @var aRace */
    protected $race;
    /** @var aClass */
    protected $class;

    protected $level = 1;

    protected $experience = 0;

    /** @var BaseStats */
    protected $baseStats = null;
    /** @var Stats\Combat\BaseCombatStats */
    protected $baseCombatStats = null;
    /** @var GeneralStats  */
    protected $generalStats = null;

    protected $currentHP  = 0;
    protected $currentPP  = 0;
    protected $currentMP  = 0;
    protected $currentPsy = 0;
    protected $currentSp  = 0;

    /** @var Stats\Magic\MagicResist[] */
    protected $magicResists = [];

    protected $inventory;

    protected $equipment;

    /** @var aSkill[[]] */
    protected $skills = [];

    public function __construct(aRace $race, aClass $class)
    {
        $this->race  = $race;
        $this->class = $class;
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

    public function getXpToNextLevel()
    {
        if ( $this->class instanceof aClass) {
            $table = $this->class::getExperienceTable();

            return $table[ $this->level ] - $this->experience;
        }

        return -1;
    }

    /**
     * @return bool|Psy
     */
    public function getPsySkill()
    {
        if ( !empty($this->skills[ aSkill::SKILL_TYPE_SCIENCE ]) ) {
            $a = array_filter($this->skills[ aSkill::SKILL_TYPE_SCIENCE ], function ($skill) {
                return is_a($skill, Psy::class);
            });

            return !empty($a) ? reset($a) : false;
        }

        return false;
    }

    /**
     * @return bool|Magic
     */
    public function getMagicSkill()
    {
        if ( !empty($this->skills[ aSkill::SKILL_TYPE_SCIENCE ]) ) {
            $a = array_filter($this->skills[ aSkill::SKILL_TYPE_SCIENCE ], function ($skill) {
                return is_a($skill, Magic::class);
            });

            return !empty($a) ? reset($a) : false;
        }

        return false;
    }

    #region Getters/Setters

    /**
     * @param int[] $baseStats
     *
     * @return $this
     */
    public function setBaseStats(array $baseStats)
    {
        $this->baseStats = new BaseStats($baseStats);

        return $this;
    }

    /**
     * @param int[] $baseCombatStats
     *
     * @return $this
     */
    public function setBaseCombatStats(array $baseCombatStats)
    {
        $this->baseCombatStats = new BaseCombatStats($baseCombatStats);

        return $this;
    }

    /**
     * @param int[] $generalStats
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

    /**
     * @return BaseStats
     */
    public function getBaseStats()
    {
        return $this->baseStats;
    }

    /**
     * @return Stats\Combat\BaseCombatStats
     */
    public function getBaseCombatStats()
    {
        return $this->baseCombatStats;
    }

    /**
     * @return GeneralStats
     */
    public function getGeneralStats()
    {
        return $this->generalStats;
    }

    /**
     * @param string $type
     * @return Stats\Magic\MagicResist
     */
    public function getMagicResist( $type = Stats\Magic\MagicResist::TYPE_ASTRAL )
    {
        return $this->magicResists[ $type ];
    }

    /**
     * @param Stats\Magic\MagicResist $magicResist
     * @return Character
     * @throws AppException
     */
    public function setMagicResists(Stats\Magic\MagicResist $magicResist)
    {
        $this->magicResists[ $magicResist->getType() ] = $magicResist;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getInventory()
    {
        return $this->inventory;
    }

    /**
     * @param mixed $inventory
     * @return Character
     */
    public function setInventory($inventory)
    {
        $this->inventory = $inventory;
        return $this;
    }

    /**
     * @return aSkill[[]]
     */
    public function getSkills() : array
    {
        return $this->skills;
    }

    /**
     * @param aSkill[] $skills
     * @return Character
     */
    public function setSkills(array $skills) : Character
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
    public function setLevel(int $level): Character
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
    public function setExperience(int $experience): Character
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
    public function setCurrentHP(int $currentHP): Character
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
    public function setCurrentPP(int $currentPP): Character
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
    public function setCurrentMP(int $currentMP): Character
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
    public function setCurrentPsy(int $currentPsy): Character
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
    public function setCurrentSp(int $currentSp) : Character
    {
        $this->currentSp = $currentSp;
        return $this;
    }

    #endregion
}
