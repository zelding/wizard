<?php
/**
 * wizard
 *
 * @author    lyozsi (kristof.dekany@apex-it-services.eu)
 * @copyright internal usage
 *
 * Date: 8/21/17 1:34 PM
 */

namespace AppBundle\Model\Common\Item;


class Inventory
{
    const INV_TYPE_BAG      = "bag";
    const INV_TYPE_BACKPACK = "backpack";
    const INV_TYPE_POCKET   = "pocket";
    const INV_TYPE_BELT     = "belt";

    protected string $type = self::INV_TYPE_BACKPACK;

    /** @var Item[][] */
    protected array $items = [];

    protected static int $maxWeight = 0;

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return Item[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @return int
     */
    public static function getMaxWeight(): int
    {
        return self::$maxWeight;
    }

    public function getTotalWeight() : float
    {
        if ( empty($this->items) ) {
            return 0.0;
        }

        $sum = 0.0;

        foreach($this->items as $cat => $categories) {
            foreach($categories as $sCat => $subCategories) {
                foreach($subCategories as $item) {
                    /** @var Item $item */
                    $sum += $item::getWeight();
                }
            }
        }

        return $sum;
    }

    /**
     * @param Item $item
     *
     * @return $this
     */
    public function addItem(Item $item) : self
    {
        if ( !array_key_exists($item::$category, $this->items) ) {
            $this->items[ $item::$category ] = [];
        }

        if ( !array_key_exists($item::$subCategory, $this->items[ $item::$category ]) ) {
            $this->items[ $item::$category ][ $item::$subCategory ] = [];
        }

        $this->items[ $item::$category ][ $item::$subCategory ][] = $item;

        return $this;
    }
}
