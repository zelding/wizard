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
use AppBundle\Model\Common\Race\aRace;
use AppBundle\Model\Common\Skill\aSkill;
use AppBundle\Model\Common\Stats\BaseStats;

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
    /** @var aClass[] */
    protected $classes = [];

    /** @var null|BaseStats */
    protected $baseStats = null;

    protected $baseHP;

    protected $basePP;

    protected $baseMP;

    protected $basePsy;

    protected $magicResists;

    protected $inventory;

    /** @var aSkill[] */
    protected $skills = [];

    public function __construct(aRace $race, aClass $class)
    {
        $this->race    = $race;
        $this->classes = [$class];
    }

    public function setBaseStats(int $str, int $spd, int $dex, int $sta, int $vit,
                                 int $bea, int $int, int $wil, int $ast, int $per)
    {
        $this->baseStats = new BaseStats(
            $str,  $spd,  $dex,  $sta,  $vit,
            $bea,  $int,  $wil,  $ast,  $per
        );
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

    public function setRacialStatBonuses()
    {


        return $this;
    }

    #region Getters/Setters

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
     * @return aClass[]
     */
    public function getClasses(): array
    {
        return $this->classes;
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
     * @return BaseStats|null
     */
    public function getBaseStats()
    {
        return $this->baseStats;
    }

    #endregion
}
