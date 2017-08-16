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
use AppBundle\Model\Common\Stats;

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

    /** @var null|Stats\BaseStats */
    protected $baseStats = null;
    /** @var Stats\Combat\BaseCombatStats */
    protected $baseCombatStats = null;

    protected $baseHP = 0;

    protected $basePP = 0;

    protected $baseMP = 0;

    protected $basePsy = 0;
    /** @var Stats\Magic\MagicResist[] */
    protected $magicResists = [];

    protected $inventory;

    protected $equipment;

    /** @var aSkill[] */
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
            $fullName .= implode(" ", $this->otherNames);
        }

        $fullName .= $this->getLastName();

        return $fullName;
    }

    public function knowsPsy()
    {

    }

    public function knowsMagic()
    {

    }

    #region Getters/Setters

    /**
     * @param int[] $baseStats
     *
     * @return $this
     */
    public function setBaseStats(array $baseStats)
    {
        $this->baseStats = new Stats\BaseStats($baseStats);

        return $this;
    }

    /**
     * @param int[] $baseCombatStats
     *
     * @return $this
     */
    public function setBaseCombatStats(array $baseCombatStats)
    {
        $this->baseCombatStats = new Stats\Combat\BaseCombatStats($baseCombatStats);

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
     * @param aClass[] $classes
     *
     * @return Character
     */
    public function setClasses(array $classes): Character
    {
        $this->classes = $classes;

        return $this;
    }

    /**
     * @return Stats\BaseStats|null
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
     * @return mixed
     */
    public function getBaseHP()
    {
        return $this->baseHP;
    }

    /**
     * @param mixed $baseHP
     * @return Character
     */
    public function setBaseHP($baseHP)
    {
        $this->baseHP = $baseHP;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBasePP()
    {
        return $this->basePP;
    }

    /**
     * @param mixed $basePP
     * @return Character
     */
    public function setBasePP($basePP)
    {
        $this->basePP = $basePP;
        return $this;
    }

    public function addPP($value) {
        $this->basePP += $value;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getBaseMP()
    {
        return $this->baseMP;
    }

    /**
     * @param mixed $baseMP
     * @return Character
     */
    public function setBaseMP($baseMP)
    {
        $this->baseMP = $baseMP;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBasePsy()
    {
        return $this->basePsy;
    }

    /**
     * @param mixed $basePsy
     * @return Character
     */
    public function setBasePsy($basePsy)
    {
        $this->basePsy = $basePsy;
        return $this;
    }

    /**
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
    public function setSkills(array $skills) : Character
    {
        $this->skills = $skills;
        return $this;
    }

    public function addSkill(aSkill $skill)
    {
        $this->skills[] = $skill;
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

    #endregion
}
