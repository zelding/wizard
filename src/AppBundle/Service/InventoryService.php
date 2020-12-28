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


use AppBundle\Exception\AppException;
use AppBundle\Helper\Stats;
use AppBundle\Model\Common\Character;
use AppBundle\Model\Common\Item\Equipment;
use AppBundle\Model\Common\Item\Equippable;
use AppBundle\Model\Common\Item\Inventory;
use AppBundle\Model\Common\Item\Item;
use AppBundle\Model\Common\Race\aRace;

class InventoryService
{
    protected ItemService $itemService;

    public static array $defaultInventorySlots = [
        ItemService::SLOT_HEAD    =>  1,
        ItemService::SLOT_NECK    =>  1,
        ItemService::SLOT_TORSO   =>  1,
        ItemService::SLOT_HANDS   =>  2,
        ItemService::SLOT_BELT    =>  1,
        ItemService::SLOT_FINGERS => 10,
        ItemService::SLOT_LEGS    =>  2,
        ItemService::SLOT_FEET    =>  2,
    ];

    /**
     * InventoryService constructor.
     * @param ItemService $itemService
     */
    public function __construct(ItemService $itemService)
    {
        $this->itemService = $itemService;
    }

    public function setUpInventories(Character  $character) : self
    {
        $inv = new Inventory($character->getBaseStats()->getStrength()->getRollModifierValue() + 10);

        $eq = $this->createEquipmentForRace($character->getRace());

        //$eq->

        $character->setEquipment($eq)
                  ->setInventory($inv);

        return $this;
    }

    protected function createEquipmentForRace(aRace $aRace) : Equipment
    {
        $eq = new Equipment(100, self::$defaultInventorySlots);

        return $eq;
    }

    public function equipItem(Character $character, Item $item) : self
    {
        $inventory = $character->getInventory();
        $equipment = $character->getEquipment();

        $inventory->addItem($item);

        if  ( $item instanceof Equippable && $slot = $this->itemService->getItemSlot($item) ) {
            //TODO equip

            if ( !empty($item->requires()) ) {

                foreach( $item->requires() as $statType => $min ) {

                    $currentValue = $character->getBaseStats()->getAllStats()[ $statType ]->getValue();

                    if( $currentValue < $min) {

                        $statName = Stats::$BaseStatTypeToStatName[ $statType ];

                        throw new AppException("Unable to equip, Minimum {$statName} of {$min} not reached; available: {$currentValue}");
                    }

                }

            }

            $equipment->equipItem($item, $slot);
        }

        return $this;
    }
}
