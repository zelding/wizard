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


use AppBundle\Model\Common\Item\Equippable;
use AppBundle\Model\Common\Item\Item;

class ItemService
{
    public const SLOT_HANDS   = "slot.hands";
    public const SLOT_HEAD    = "slot.head";
    public const SLOT_NECK    = "slot.neck";
    public const SLOT_TORSO   = "slot.torso";
    public const SLOT_FEET    = "slot.feet";
    public const SLOT_LEGS    = "slot.legs";
    public const SLOT_BELT    = "slot.belt";
    public const SLOT_FINGERS = "slot.fingers";

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

                return self::SLOT_HANDS;

            case Item::CATEGORY_ARMOR:
                return self::SLOT_TORSO;

            case Item::CATEGORY_HELMET:
                return self::SLOT_HEAD;
        }

        return null;
    }
}
