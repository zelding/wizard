<?php
/**
 * Created by PhpStorm.
 * User: Lyozsi
 * Date: 2017. 08. 08.
 * Time: 18:43
 */

namespace App\Model\Common\Stats;

use App\Exception\AppException;
use App\Model\Mechanics\Dice\DiceRoll;

/**
 * Class aStat
 *
 * Base class for stats
 *
 * @package App\Model\Common\Stats
 */
abstract class aStat implements \Stringable
{
    public const TYPE = "";

    public const NAME = "";

    public const BASE_STAT = true;

    protected readonly int|DiceRoll $originalValue;
    protected int|DiceRoll          $baseValue;

    private bool $isRoll;

    /** @var Modifier[]  */
    protected array $modifiers     = [];

    public function __construct(int|array $value)
    {
        $this->isRoll = is_array($value);

        if ( $this->isRoll ) {
            $value = new DiceRoll(...$value);
            $this->originalValue = clone $value;
        }
        else {
            $this->originalValue = $value;
        }

        $this->baseValue = $value;
    }

    public function __toString(): string
    {
        /** @see DiceRoll::__ToString */
        return $this->baseValue instanceof DiceRoll ?  (string) $this->baseValue : $this->baseValue;
    }

    /**
     * @see templates/App/Macro/stats.twig
     *
     * @return string[]
     */
    public function getModifierTexts(): array
    {
        /** @see DiceRoll::__ToString
        return $this->baseValue->getModifier() instanceof DiceRoll ?
            (string) $this->baseValue->getModifier()
            : implode(' ',);*/

        $strings = [];

        foreach($this->getModifiers() as $modifier) {
            $strings[] = ($modifier->getValue() < 0 ? "" : "+").
                         str_pad($modifier->getValue(), 2, pad_type: STR_PAD_LEFT).
                         " {$modifier->getDescription()}";
        }

        return $strings;
    }

    /**
     * @return int
     * @throws AppException
     */
    final public function getRollModifierValue() : int
    {
        if ( static::BASE_STAT ) {
            return $this->getValue() > 10 ? $this->getValue() - 10 : 0;
        }

        throw new AppException("Only base stats have roll modifiers");
    }

    /**
     * @return int
     */
    public function getValue() : int
    {
        return $this->getBaseValue() + $this->getModifierValue();
    }

    public function getPermanentValue() : int
    {
        return $this->getBaseValue() + $this->getPermanentModifierValue();
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
        $sum = 0;

        if ( empty($this->modifiers) ) {
            return $sum;
        }

        foreach($this->modifiers as $modifier) {
            //recursion
            $sum += $modifier->getValue();
        }

        return $sum;
    }

    public function getPermanentModifierValue() : int
    {
        $sum = $this->getModifierValue();

        if ( empty($this->modifiers) ) {
            return $sum;
        }

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
        return $this->isRoll ? $this->originalValue->getAvg() : $this->originalValue;
    }

    /**
     * @return int
     */
    public function getBaseValue() : int
    {
        return $this->isRoll ? $this->baseValue->getAvg() :$this->baseValue;
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
        if ( $modifier->getModifies() === static::class ) {
            $this->modifiers[] = $modifier;
        }
        else {
            throw new AppException('Modifier type mismatch. Expected '.static::class.', got '.$modifier::class.'.');
        }

        return $this;
    }
}
