<?php
/**
 * wizard
 *
 * @author    lyozsi (kristof.dekany@apex-it-services.eu)
 * @copyright internal usage
 *
 * Date: 8/21/17 4:12 PM
 */

namespace App\Model\Common\Item;


use App\Model\Common\Stats\Modifier;
use App\Model\Mechanics\Price;

abstract class Item
{
    public const TYPE = "ITM";

    public const CATEGORY_MISC     = "misc";
    public const CATEGORY_ANIMALS  = "animals";
    public const CATEGORY_SERVICE  = "service";
    public const CATEGORY_CLOTHING = "clothing";
    public const CATEGORY_FOOD     = "food";
    public const CATEGORY_WEAPON   = "weapon";
    public const CATEGORY_ARMOR    = "armor";
    public const CATEGORY_HELMET   = "helmet";

    public const SUB_CATEGORY_MISC = "misc";

    public static string $category    = self::CATEGORY_MISC;

    public static string $subCategory = self::SUB_CATEGORY_MISC;

    /** @var float */
    protected static float $weight    = 0.0;

    /** @var int */
    protected static int $quantity  = 1;

    /** @var Modifier[]  */
    protected static array $modifiers = [];

    /** @var int */
    protected static int $basePrice = 0;

    protected Price $price;

    public function __construct($category = self::CATEGORY_MISC, $subCategory = self::SUB_CATEGORY_MISC)
    {
        static::$category    = $category;
        static::$subCategory = $subCategory;

        $this->price = new Price();
        $this->price->setLowestCountPrice(static::$basePrice);
    }

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

    /**
     * @return string
     */
    public static function getCategory(): string
    {
        return static::$category;
    }

    /**
     * @return string
     */
    public static function getSubCategory(): string
    {
        return static::$subCategory;
    }

    /**
     * @return Price
     */
    public function getPrice(): Price
    {
        return $this->price;
    }
}
