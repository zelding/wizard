<?php
/**
 * wizard
 *
 * @author    lyozsi (kristof.dekany@apex-it-services.eu)
 * @copyright internal usage
 *
 * Date: 5/23/22 4:12 PM
 */

namespace App\Model\Common\Stats;
use App\Model\Mechanics\Dice\DiceRoll;

abstract class DiceRollStat extends aStat
{
    /** @var DiceRoll  */
    protected int|DiceRoll $baseValue;

    public function getValue() : int
    {
        return $this->baseValue->execute() + $this->getModifierValue();
    }

    public function getModifierValue() : int
    {
        $sum = $this->baseValue->getModifier();

        if ( empty($this->modifiers) ) {
            return $sum;
        }

        foreach($this->modifiers as $modifier) {
            //recursion
            $sum += $modifier->getValue();
        }

        return $sum;
    }
}
