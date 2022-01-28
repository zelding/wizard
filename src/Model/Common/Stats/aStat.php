<?php
/**
 * Created by PhpStorm.
 * User: Lyozsi
 * Date: 2017. 08. 08.
 * Time: 18:43
 */

namespace App\Model\Common\Stats;

use App\Exception\AppException;

/**
 * Class aStat
 *
 * Base class for stats
 *
 * @package App\Model\Common\Stats
 */
abstract class aStat
{
    public const TYPE = "";

    public const NAME = "";

    public const BASE_STAT = true;

    /**
     * @var int
     * @readonly
     */
    protected int $originalValue = 0;
    /** @var int */
    protected int $baseValue     = 0;
    /** @var Modifier[]  */
    protected array $modifiers     = [];

    public function __construct(int $value)
    {
        $this->originalValue = $this->baseValue = $value;
    }

    /**
     * @return int
     */
    public function getValue() : int
    {
        return $this->baseValue + $this->getModifierValue();
    }

    public function getPermanentValue() : int
    {
        return $this->baseValue += $this->getPermanentModifierValue();
    }

    /**
     * @return int
     * @throws AppException
     */
    public function getRollModifierValue() : int
    {
        if ( static::BASE_STAT ) {
            return $this->getValue() > 10 ? $this->getValue() - 10 : 0;
        }

        throw new AppException("Only base stats have roll modifiers");
    }

    public function getName() : string
    {
        return static::NAME;
    }

    /**
     * @recursion
     * @return int
     */
    public function getModifierValue() : int
    {
        if ( empty($this->modifiers) ) {
            return 0;
        }

        $sum = 0;

        foreach($this->modifiers as $modifier) {
            //recursion
            $sum += $modifier->getValue();
        }

        return $sum;
    }

    public function getPermanentModifierValue() : int
    {
        if ( empty($this->modifiers) ) {
            return 0;
        }

        $sum = 0;

        foreach($this->modifiers as $modifier) {
            //recursion
            if ( $modifier->isPermanent() ) {
                $sum += $modifier->getValue();
            }
        }

        return $sum;
    }

    #region Getters/Setters

    /**
     * @return int
     */
    public function getOriginalValue() : int
    {
        return $this->originalValue;
    }

    /**
     * @return int
     */
    public function getBaseValue() : int
    {
        return $this->baseValue;
    }

    /**
     * @param int $baseValue
     * @return aStat
     */
    public function setBaseValue(int $baseValue) : aStat
    {
        $this->baseValue = $baseValue;
        return $this;
    }

    /**
     * @return Modifier[]
     */
    public function getModifiers() : array
    {
        return $this->modifiers;
    }

    /**
     * @param Modifier[] $modifiers
     * @return aStat
     */
    public function setModifiers(array $modifiers) : aStat
    {
        $this->modifiers = $modifiers;
        return $this;
    }

    #endregion

    /**
     * @param Modifier $modifier
     * @return $this
     * @throws AppException
     */
    public function addModifier(Modifier $modifier) : aStat
    {
        if ( $modifier->getModifies() === static::TYPE ) {
            $this->modifiers[] = $modifier;
        }
        else {
            throw new AppException('Modifier type mismatch. Expected '.static::TYPE.', got '.$modifier::TYPE.'.');
        }

        return $this;
    }
}
