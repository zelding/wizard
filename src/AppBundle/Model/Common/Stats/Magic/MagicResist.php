<?php
/**
 * wizard
 *
 * @author    lyozsi (kristof.dekany@apex-it-services.eu)
 * @copyright internal usage
 *
 * Date: 8/14/17 9:45 AM
 */

namespace AppBundle\Model\Common\Stats\Magic;


use AppBundle\Exception\AppException;
use AppBundle\Model\Common\Stats\aStat;

abstract class MagicResist extends aStat
{
    public const TYPE = "MR";

    public const NAME = "Magic Resist";

    public const BASE_STAT = false;

    public const TYPE_ASTRAL = "Astral";
    public const TYPE_MENTAL = "Mental";

    protected int $static       = 0;
    protected int $dynamic      = 0;
    protected int $subConscious = 0;
    protected int $magic        = 0;

    protected int $perLevel = 0;

    public abstract function getType() : string;

    public function getCurrentTotal(bool $conscious = true, int $level = 1) : int
    {
        $x = 0;
        if ( $conscious ) {
            $x += $this->getStatic() +
                  $this->getDynamic();
        }

        return $x +
               $this->getSubConscious($level) +
               $this->getMagic();
    }

    #region Setters

    /**
     * @param int $static
     *
     * @return MagicResist
     */
    public function setStatic(int $static): MagicResist
    {
        $this->static = $static;

        return $this;
    }

    /**
     * @param int $dynamic
     *
     * @return MagicResist
     */
    public function setDynamic(int $dynamic): MagicResist
    {
        $this->dynamic = $dynamic;

        return $this;
    }

    /**
     * @param int $subConscious
     *
     * @return MagicResist
     */
    public function setSubConscious(int $subConscious): MagicResist
    {
        $this->subConscious = $subConscious;

        return $this;
    }

    /**
     * @param int $magic
     *
     * @return MagicResist
     */
    public function setMagic(int $magic): MagicResist
    {
        $this->magic = $magic + $this->getModifierValue();

        return $this;
    }

    /**
     * @return int
     */
    public function getPerLevel(): int
    {
        return $this->perLevel;
    }

    /**
     * @param int $perLevel
     * @return MagicResist
     */
    public function setPerLevel(int $perLevel): MagicResist
    {
        $this->perLevel = $perLevel;
        return $this;
    }

    #endregion

    #region invalid Getters/Setters

    /**
     * @throws AppException
     */
    public function getOriginalValue(): int
    {
        throw new AppException("Not allowed in resists");
    }

    /**
     * @throws AppException
     */
    public function getBaseValue(): int
    {
        throw new AppException("Not allowed in resists");
    }

    #endregion

    public function getStatic() : int
    {
        return $this->static;
    }

    public function getDynamic() : int
    {
        return $this->dynamic;
    }

    public function getSubConscious(int $level = 1) : int
    {
        return $this->subConscious + $this->getModifierValue() + $level * $this->getPerLevel();
    }

    public function getMagic() : int
    {
        return $this->magic;
    }
}
