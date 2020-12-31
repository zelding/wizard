<?php


namespace AppBundle\Model\Mechanics\Dice;


class DiceRoll
{
    /** @var aDice[] */
    protected array $dice;

    protected int $modifier = 0;

    protected int $n = 1;

    /**
     * DiceRoll constructor.
     * @param aDice[] $dice     dice to roll
     * @param int     $modifier plus/minus to add to the end result
     * @param int     $n        number of rolls, defaults to 1
     */
    public function __construct(array $dice, int $modifier = 0, int $n = 1)
    {
        $this->dice     = $dice;
        $this->modifier = $modifier;
        $this->n        = $n;
    }

    public function __toString(): string
    {
        $c = [];

        // Group them by type
        foreach ($this->dice as $d) {
            //can be instance or FCN
            if ( $d instanceof aDice) {
                // Use the overridden method on the dye
                $s = (string)$d;
            }
            else {
                $s = $d;
            }

            $p = explode('\\', $s);

            $name = array_pop($p);

            if ( !array_key_exists($name, $c)) {
                $c[ $name ] = 0;
            }

            $c[ $name ]++;
        }


        $dice = [];
        foreach($c as $n => $x) {
            $dice[] = $x > 1 ? "$x$n" : "$n";
        }

        return implode(" + ", $dice)." + {$this->modifier}";
    }

    public function getMin() : int
    {
        $sum = 0;
        foreach( $this->dice as $dice ) {
            $sum += $dice::getMin();
        }

        return $sum + $this->modifier;
    }

    public function getMax() : int
    {
        $sum = 0;
        foreach( $this->dice as $dice ) {
            $sum += $dice::getMax();
        }

        return $sum + $this->modifier;
    }

    public function execute() : int
    {
        $sum = 0;

        foreach( $this->dice as $dice ) {
            $val = $dice::roll();

            if ($this->n > 1) {
                for ($i = 1; $i < $this->n; $i++) {
                    $new = $dice::roll();

                    if ($new > $val) {
                        $val = $new;
                    }
                }
            }

            $sum += $val;
        }

        return $sum + $this->modifier;
    }
}
