<?php


namespace App\Model\Common\Item;


use App\Exception\AppException;
use App\Service\InventoryService;

class Equipment extends Inventory
{
    public const INV_TYPE_EQUIPMENT = "equipment";

    protected string $type = self::INV_TYPE_EQUIPMENT;

    /**
     * @see InventoryService::$defaultInventorySlots
     * @var array
     */
    protected array $slots = [];

    public function __construct(int $maxWeight, array $slots)
    {
        parent::__construct($maxWeight);

        $this->slots = $slots;

        foreach( $slots as $key => $max ) {
            $this->items[ $key ] = [];
        }
    }

    public function addItem(Item $item, array $slotData = []) : self
    {
        if ( !array_key_exists($slotData[0], $this->items) ) {
            $this->items[ $slotData[0] ] = [];
        }

        $this->items[ $slotData[0] ][] = $item;

        return $this;
    }

    public function equipItem(Equippable $item, $slot)
    {
        if ( !array_key_exists($slot, $this->slots) ) {
            throw new AppException("No slot ({$slot}) is available");
        }

        if ( count($this->items[ $slot ]) + $item->slots() > $this->slots[ $slot ] ) {
            throw new AppException("Slot ({$slot}) is full");
        }

        $this->items[ $slot ][] = $item;
    }
}
