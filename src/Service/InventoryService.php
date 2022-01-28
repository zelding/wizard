<?php
/**
 * wizard
 *
 * @author    lyozsi (kristof.dekany@apex-it-services.eu)
 * @copyright internal usage
 *
 * Date: 10/11/17 11:15 AM
 */

namespace App\Service;


use App\Exception\AppException;
use App\Helper\Stats;
use App\Model\Common\Character;
use App\Model\Common\InventorySlotProvider;
use App\Model\Common\Item\Equipment;
use App\Model\Common\Item\Equippable;
use App\Model\Common\Item\Inventory;
use App\Model\Common\Item\Item;
use App\Model\Common\Race\aRace;

class InventoryService implements InventorySlotProvider
{
    protected static array $defaultInventorySlots = [
        InventorySlotProvider::SLOT_HEAD    =>  1,
        InventorySlotProvider::SLOT_NECK    =>  1,
        InventorySlotProvider::SLOT_TORSO   =>  1,
        InventorySlotProvider::SLOT_HANDS   =>  2,
        InventorySlotProvider::SLOT_BELT    =>  1,
        InventorySlotProvider::SLOT_FINGERS => 10,
        InventorySlotProvider::SLOT_LEGS    =>  2,
        InventorySlotProvider::SLOT_FEET    =>  2,
    ];

    /**
     * InventoryService constructor.
     */
    public function __construct(protected ItemService $itemService)
    {
    }

    public static function getSlotConfiguration(): array
    {
        return self::$defaultInventorySlots;
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

    protected function createEquipmentForRace(aRace $race) : Equipment
    {
        // we use/treat this service's values as default
        // than we use the current child's version
        // and finally we apply the racial updates
        $eq = new Equipment(100, array_merge(self::getSlotConfiguration(), static::getSlotConfiguration(), $race::getSlotConfiguration()));

        // TODO
        //$race::getLateSkills();

        return $eq;
    }

    public function equipItem(Character $character, Item $item) : self
    {
        $inventory = $character->getInventory();
        $equipment = $character->getEquipment();

        $inventory->addItem($item);

        // also check for available slot
        if ( $item instanceof Equippable && $slot = $this->itemService->getItemSlot($item) ) {

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
