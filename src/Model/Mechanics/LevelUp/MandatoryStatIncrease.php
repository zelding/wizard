<?php
/**
 * wizard
 *
 * @author    lyozsi (kristof.dekany@apex-it-services.eu)
 * @copyright internal usage
 *
 * Date: 5/23/22 5:03 PM
 */

namespace App\Model\Mechanics\LevelUp;

class MandatoryStatIncrease implements \Stringable
{
    private function __construct(private string $class, private int $amount) {}

    public static function create(string $class, int $amount): self
    {
        return new static($class, $amount);
    }

    public function __ToString(): string
    {
        return $this->class;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }
}
