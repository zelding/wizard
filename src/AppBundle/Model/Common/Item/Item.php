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


use AppBundle\Model\Common\Stats\Modifier;
use AppBundle\Model\Mechanics\Price;

abstract class Item
{
    const TYPE = "ITM";

    const CATEGORY_MISC     = "misc";
    const CATEGORY_ANIMALS  = "animals";
    const CATEGORY_SERVICE  = "service";
    const CATEGORY_CLOTHING = "clothing";
    const CATEGORY_FOOD     = "food";
    const CATEGORY_WEAPON   = "weapon";
    const CATEGORY_ARMOR    = "armor";

    const SUB_CATEGORY_MISC = "misc";

    public static $category    = self::CATEGORY_MISC;

    public static $subCategory = self::SUB_CATEGORY_MISC;

    /** @var float */
    protected static $weight    = 0.0;

    /** @var int */
    protected static $quantity  = 1;

    /** @var Modifier[]  */
    protected static $modifiers = [];

    /** @var int */
    protected static $basePrice = 0;

    /** @var Price */
    protected $price;

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
     * @return Modifier[]
     */
    public static function getModifiers(): array
    {
        return static::$modifiers;
    }

    /**
     * @return Price
     */
    public static function getBasePrice(): Price
    {
        return (new Price())->setLowestCountPrice(static::$basePrice);
    }

    /**
     * @param Price $basePrice
     *
     * @return Item
     */
    public function setPrice(Price $basePrice): Item
    {
        $this->price = $basePrice;

        return $this;
    }


}
