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


use AppBundle\Model\Common\Item\Item;
use AppBundle\Model\Common\Item\Weapon\Weapon;

class ItemService
{
    const SLOT_HANDS   = "slot.hands";
    const SLOT_HEAD    = "slot.head";
    const SLOT_NECK    = "slot.neck";
    const SLOT_TORSO   = "slot.torso";
    const SLOT_FEET    = "slot.feet";
    const SLOT_LEGS    = "slot.legs";
    const SLOT_BELT    = "slot.belt";
    const SLOT_FINGERS = "slot.fingers";

    /**
     * @param Item $item
     *
     * @return string[]|null
     */
    public function getItemSlot(Item $item) : ?array
    {
        switch( $item::$category ) {

            case Item::CATEGORY_WEAPON:
                if ( $item instanceof Weapon) {
                    return [
                        self::SLOT_HANDS,
                        $item->isTwoHanded() ? 2 : 1
                    ];
                }
            break;

            case Item::CATEGORY_ARMOR:
                return [self::SLOT_TORSO, 1];
        }

        return null;
    }
}
