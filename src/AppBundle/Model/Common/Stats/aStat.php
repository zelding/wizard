<?php
/**
 * Created by PhpStorm.
 * User: Lyozsi
 * Date: 2017. 08. 08.
 * Time: 18:43
 */

namespace AppBundle\Model\Common\Stats;

use AppBundle\Exception\AppException;

/**
 * Class aStat
 *
 * Base class for stats
 *
 * @package AppBundle\Model\Common\Stats
 */
abstract class aStat
{
    /** @var int|string */
    const TYPE = -1 ?? "-1";

    /**
     * @var int
     * @readonly
     */
    protected $originalValue = 0;
    /** @var int */
    protected $baseValue     = 0;
    /** @var aStat[]  */
    protected $modifiers     = [];

    public function __construct(int $value)
    {
        $this->originalValue = $this->baseValue = $value;
    }

    public function getValue()
    {
        return $this->baseValue + $this->getModifierValue();
    }

    /**
     * @recursion
     * @return int
     */
    protected function getModifierValue()
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

    #region Getters/Setters

    /**
     * @return int
     */
    public function getOriginalValue() : int
    {
        return $this->originalValue;
    }

    /**
     * @readonly
     * @param int $originalValue
     * @return aStat
     * @throws AppException
     */
    public function setOriginalValue(int $originalValue) : aStat
    {
        throw new AppException("Setter called on readonly property");
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
     * @return aStat[]
     */
    public function getModifiers() : array
    {
        return $this->modifiers;
    }

    /**
     * @param aStat[] $modifiers
     * @return aStat
     */
    public function setModifiers(array $modifiers) : aStat
    {
        $this->modifiers = $modifiers;
        return $this;
    }

    #endregion

    /**
     * @param aStat $modifier
     * @return $this|aStat
     * @throws AppException
     */
    public function addModifier(aStat $modifier) : aStat
    {
        if ( $modifier::TYPE === static::TYPE ) {
            $this->modifiers[] = $modifier;
        }
        else {
            throw new AppException('Modifier type mismatch. Expected '.static::TYPE.', got '.$modifier::TYPE.'.');
        }

        return $this;
    }
}
