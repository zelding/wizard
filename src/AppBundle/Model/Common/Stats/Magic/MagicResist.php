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

class MagicResist extends aStat
{
    const TYPE = "MR";

    const NAME = "Magic Resist";

    const BASE_STAT = false;

    const TYPE_ASTRAL = "Astral";
    const TYPE_MENTAL = "Mental";

    protected $static       = 0;

    protected $dynamic      = 0;

    protected $subConscious = 0;

    protected $magic        = 0;

    public function getName()
    {
        return static::NAME;
    }

    public function getType()
    {
        if ( !($this instanceof AstralMagicResist && $this instanceof MentalMagicResist) ) {
            throw new AppException("invalid resist type");
        }

        return "";
    }

    public function getCurrentTotal($conscious = true)
    {
        if ( $conscious ) {
            return $this->static +
                   $this->dynamic +
                   $this->subConscious +
                   $this->magic;
        }

        return $this->subConscious +
               $this->magic;
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
        $this->magic = $magic;

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

    /**
     * @throws AppException
     */
    public function getModifiers(): array
    {
        throw new AppException("Not allowed in resists");
    }

    #endregion


    /**
     * @return int
     */
    public function getStatic() : int
    {
        return $this->static;
    }

    /**
     * @return int
     */
    public function getDynamic() : int
    {
        return $this->dynamic;
    }

    /**
     * @return int
     */
    public function getSubConscious() : int
    {
        return $this->subConscious;
    }

    /**
     * @return int
     */
    public function getMagic() : int
    {
        return $this->magic;
    }


}
