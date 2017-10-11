<?php
/**
 * wizard
 *
 * @author    lyozsi (kristof.dekany@apex-it-services.eu)
 * @copyright internal usage
 *
 * Date: 10/11/17 11:15 AM
 */

namespace AppBundle\Service;


use AppBundle\Model\Common\Character;
use AppBundle\Model\Common\Item\Item;

class InventoryService
{
    public static $defaultInventorySlots = [
        ItemService::SLOT_HEAD    =>  1,
        ItemService::SLOT_NECK    =>  1,
        ItemService::SLOT_TORSO   =>  1,
        ItemService::SLOT_HANDS   =>  2,
        ItemService::SLOT_BELT    =>  1,
        ItemService::SLOT_FINGERS => 10,
        ItemService::SLOT_LEGS    =>  2,
        ItemService::SLOT_FEET    =>  2,
    ];

    public function equipItem(Character $character, Item $item)
    {
        $inventory = $character->getInventory();
        $equipment = $character->getEquipment();

        //TODO equip
    }
}
