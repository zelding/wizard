<?php


namespace AppBundle\Model\Mechanics;


class DiceRoll
{
    protected aDice $dice;

    protected int $n = 1;

    public function __construct(aDice $dice, int $n)
    {
        $this->dice = $dice;
        $this->n = $n;
    }

    public function execute() : int
    {
        $sum = $this->dice->roll();

        if ( $this->n > 1 ) {
            for($i = 1; $i < $this->n; $i++ ) {
                $new = $this->dice->roll();

                if ( $new > $sum ) {
                    $sum = $new;
                }
            }
        }

        return $sum;
    }
}