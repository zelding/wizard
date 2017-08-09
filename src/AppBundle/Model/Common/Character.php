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

use AppBundle\Model\Common\Stats\BaseStats;

abstract class Character
{
    /** @var string */
    protected $firstName  = "";
    /** @var string[] */
    protected $otherNames = [];
    /** @var string */
    protected $lastName  = "";

    /** @var null|BaseStats */
    protected $baseStats = null;

    public function __construct(
        int $str, int $spd, int $dex, int $sta, int $vit,
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

        return $fullName .= $this->getLastName();
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

    #endregion
}
