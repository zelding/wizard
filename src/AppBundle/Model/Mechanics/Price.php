<?php
/**
 * wizard
 *
 * @author    lyozsi (kristof.dekany@apex-it-services.eu)
 * @copyright internal usage
 *
 * Date: 8/21/17 4:17 PM
 */

namespace AppBundle\Model\Mechanics;


class Price
{
    public  const MITHRIL = 100000;
    public  const GOLD    =   1000;
    public  const SILVER  =    100;
    public  const COPPER  =      1;

    /** @var int base value */
    protected int $copper  = 0;

    /** @var int 100 copper = 1 silver */
    protected int $silver  = 0;

    /** @var int 10 silver = 1 gold */
    protected int $gold    = 0;

    /** @var int 100 gold = 1 mithril */
    protected int $mithril = 0;

    protected bool $allowMithril = false;
    protected bool $allowGold    = true;

    /**
     * if you set the value by this, it will be reduced to minimal coins
     *
     * @param bool $allowGold
     * @param bool $allowMithril
     *
     */
    public function __construct($allowGold = true, $allowMithril = false)
    {
        $this->allowMithril = $allowMithril;
        $this->allowGold    = $allowGold;
    }

    public function __toString() : string
    {
        return "{$this->gold} g {$this->silver} s {$this->copper} c";
    }

    public function getFullValue() : int
    {
        return $this->mithril * self::MITHRIL +
               $this->gold    * self::GOLD    +
               $this->silver  * self::SILVER  +
               $this->copper;
    }

    public function setLowestCountPrice(int $value = 0) : self
    {
        if ( $this->allowMithril ) {
            $this->mithril = floor($value / self::MITHRIL);

            if ( $this->allowGold ) {
                $this->gold    = floor(($value % self::MITHRIL) / self::GOLD);

                $this->silver  = floor(($value % self::GOLD) / self::SILVER);

                $this->copper  = floor($value % self::SILVER );
            }
            else {
                $this->silver  =
                    floor(($value % self::MITHRIL) / self::GOLD) * (self::GOLD / self::SILVER) +
                    floor(($value % self::GOLD) / self::SILVER);

                $this->copper  = floor($value % self::SILVER );
            }
        }
        else {
            if ( $this->allowGold ) {
                $this->gold =
                    floor($value / self::MITHRIL) * (self::MITHRIL / self::GOLD) +
                    floor(($value % self::MITHRIL) / self::GOLD);

                $this->silver  = floor(($value % self::GOLD) / self::SILVER);

                $this->copper  = floor($value % self::SILVER );
            }
            else {
                $this->silver  =
                    floor($value / self::MITHRIL) * (self::MITHRIL / self::GOLD) * (self::GOLD / self::SILVER) +
                    floor(($value % self::MITHRIL) / self::GOLD) * (self::GOLD / self::SILVER) +
                    floor(($value % self::GOLD) / self::SILVER);

                $this->copper  = floor($value % self::SILVER );
            }
        }

        return $this;
    }

    public function simplify() : self
    {
        $val = $this->getFullValue();

        $this->setLowestCountPrice($val);

        return $this;
    }

    #region GETTERS / SETTERS

    /**
     * @return int
     */
    public function getCopper(): int
    {
        return $this->copper;
    }

    /**
     * @param int $copper
     *
     * @return Price
     */
    public function setCopper(int $copper): Price
    {
        $this->copper = $copper;

        return $this;
    }

    /**
     * @return int
     */
    public function getGold(): int
    {
        return $this->gold;
    }

    /**
     * @param int $gold
     *
     * @return Price
     */
    public function setGold(int $gold): Price
    {
        $this->gold = $gold;

        return $this;
    }

    /**
     * @return int
     */
    public function getMithril(): int
    {
        return $this->mithril;
    }

    /**
     * @param int $mithril
     *
     * @return Price
     */
    public function setMithril(int $mithril): Price
    {
        $this->mithril = $mithril;

        return $this;
    }

    public function getSilver(): int
    {
        return $this->silver;
    }

    public function setSilver(int $silver) : Price
    {
        $this->silver = $silver;

        return $this;
    }

    #endregion
}
