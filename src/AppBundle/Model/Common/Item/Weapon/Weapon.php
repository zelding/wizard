<?php
/**
 * wizard
 *
 * @author    lyozsi (kristof.dekany@apex-it-services.eu)
 * @copyright internal usage
 *
 * Date: 9/13/17 10:01 AM
 */

namespace AppBundle\Model\Common\Item\Weapon;


use AppBundle\Model\Common\Item\Item;

class Weapon extends Item
{
    const TYPE = "WPN";

    const ATTACK_THIRD = 0.33;
    const ATTACK_HALF  = 0.5;
    const ATTACK_ONCE  = 1.0;
    const ATTACK_TWICE = 2.0;

    const SUB_CATEGORY_BLADE    = "blade";
    const SUB_CATEGORY_BLUNT    = "blunt";
    const SUB_CATEGORY_LONG     = "long";
    const SUB_CATEGORY_RANGED   = "ranged";
    const SUB_CATEGORY_THROWING = "throwing";
    const SUB_CATEGORY_SHIELD   = "shield";

    public static $category    = self::CATEGORY_WEAPON;

    public static $subCategory = self::SUB_CATEGORY_MISC;

    /** @var float attacks per round */
    protected static $baseAttacksPerRound = self::ATTACK_ONCE;

    /** @var int base sequence bonus */
    protected static $baseSequence        = 0;

    /** @var int base attack bonus */
    protected static $baseAttack          = 0;

    /** @var int base defense bonus */
    protected static $baseDefense         = 0;

    /** @var int[] base damage range */
    protected static $baseDamage          = [1, 1];

    /** @var int Amount of armor ignored */
    protected static $basePierce          = 0;

    /**
     * Return true if one of the modifiers made it magical (runes, gems)
     *
     * (Imbued state is determined in combat)
     *
     * @return bool
     */
    public function isMagical()
    {
        return false;
    }
}
