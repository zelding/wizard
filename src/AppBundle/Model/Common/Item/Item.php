<?php
/**
 * wizard
 *
 * @author    lyozsi (kristof.dekany@apex-it-services.eu)
 * @copyright internal usage
 *
 * Date: 8/21/17 4:12 PM
 */

namespace AppBundle\Model\Common\Item;


use AppBundle\Model\Mechanics\Price;

abstract class Item
{
    const TYPE = "ITM";

    public static $category    = "misc";

    public static $subCategory = "default";

    protected static $weight = 0.0;

    protected static $quantity = 1;

    protected static $modifiers = [];

    /** @var Price */
    protected $basePrice;

    /**
     * @return float
     */
    public static function getWeight(): float
    {
        return static::$weight;
    }

    /**
     * @return int
     */
    public static function getQuantity(): int
    {
        return static::$quantity;
    }

    /**
     * @return array
     */
    public static function getModifiers(): array
    {
        return static::$modifiers;
    }

    /**
     * @return Price
     */
    public function getBasePrice(): Price
    {
        return $this->basePrice;
    }

    /**
     * @param Price $basePrice
     *
     * @return Item
     */
    public function setBasePrice(Price $basePrice): Item
    {
        $this->basePrice = $basePrice;

        return $this;
    }


}
