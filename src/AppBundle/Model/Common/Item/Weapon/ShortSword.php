<?php


namespace AppBundle\Model\Common\Item\Weapon;


class ShortSword extends Weapon
{
    // public static string $category    = self::CATEGORY_WEAPON;

    public static string $subCategory = self::SUB_CATEGORY_BLADE;

    /** @var float attacks per round */
    protected static float $baseAttacksPerRound = self::ATTACK_ONCE;

    /** @var int base sequence bonus */
    protected static int $baseSequence        = 0;

    /** @var int base attack bonus */
    protected static int $baseAttack          = 0;

    /** @var int base defense bonus */
    protected static int $baseDefense         = 0;

    /** @var int[] base damage range */
    protected static array $baseDamage          = [1, 1];

    /** @var int Amount of armor ignored */
    protected static int $basePierce          = 0;

    /** @var string name */
    protected string $name;
}