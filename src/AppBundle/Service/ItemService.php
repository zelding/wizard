<?php
/**
 * wizard
 *
 * @author    lyozsi (kristof.dekany@apex-it-services.eu)
 * @copyright internal usage
 *
 * Date: 10/11/17 10:56 AM
 */

namespace AppBundle\Service;


use AppBundle\Model\Common\InventorySlotProvider;
use AppBundle\Model\Common\Item\Equippable;
use AppBundle\Model\Common\Item\Item;

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

        switch( $item::$category ) {

            case Item::CATEGORY_WEAPON:

                return InventorySlotProvider::SLOT_HANDS;

            case Item::CATEGORY_ARMOR:
                return InventorySlotProvider::SLOT_TORSO;

            case Item::CATEGORY_HELMET:
                return InventorySlotProvider::SLOT_HEAD;
        }

        return null;
    }
}
