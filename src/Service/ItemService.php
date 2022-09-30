<?php
/**
 * wizard
 *
 * @author    lyozsi (kristof.dekany@apex-it-services.eu)
 * @copyright internal usage
 *
 * Date: 10/11/17 10:56 AM
 */

namespace App\Service;


use App\Model\Common\InventorySlotProvider;
use App\Model\Common\Item\Equippable;
use App\Model\Common\Item\Item;

class ItemService
{
    /**
     * @param Item $item
     *
     * @return string|null
     */
    public function getItemSlot(Item $item) : ?string
    {
        if ( !$item instanceof Equippable ) {
            return null;
        }

        return match ($item::$category) {
            Item::CATEGORY_WEAPON => InventorySlotProvider::SLOT_HANDS,
            Item::CATEGORY_ARMOR  => InventorySlotProvider::SLOT_TORSO,
            Item::CATEGORY_HELMET => InventorySlotProvider::SLOT_HEAD,
            default               => null
        };
    }
}
