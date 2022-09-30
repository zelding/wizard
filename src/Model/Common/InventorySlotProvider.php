<?php


namespace App\Model\Common;


interface InventorySlotProvider
{
    public const SLOT_HANDS   = "slot.hands";
    public const SLOT_HEAD    = "slot.head";
    public const SLOT_NECK    = "slot.neck";
    public const SLOT_TORSO   = "slot.torso";
    public const SLOT_FEET    = "slot.feet";
    public const SLOT_LEGS    = "slot.legs";
    public const SLOT_BELT    = "slot.belt";
    public const SLOT_FINGERS = "slot.fingers";

    public static function getSlotConfiguration() : array;
}
