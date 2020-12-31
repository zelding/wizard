<?php


namespace AppBundle\Model\Common\Item\Weapon;


use AppBundle\Model\Common\Stats\Base\Strength;
use AppBundle\Model\Mechanics\Dice\D6;

class ShortSword extends Weapon
{
    public static string $category    = self::CATEGORY_WEAPON;

    public static string $subCategory = self::SUB_CATEGORY_BLADE;

    /** @var float attacks per round */
    protected static float $baseAttacksPerRound = self::ATTACK_ONCE;

    /** @var int base sequence bonus */
    protected static int $baseSequence        = 5;

    /** @var int base attack bonus */
    protected static int $baseAttack          = 10;

    /** @var int base defense bonus */
    protected static int $baseDefense         = 10;

    /** @var int[] base damage range */
    protected static array $baseDamage          = [[D6::class], 1];

    /** @var int Amount of armor ignored */
    protected static int $basePierce          = 0;

    /** @var int Default price in copper */
    protected static int $basePrice           = 1320;

    protected static float $weight    = 3.0;

    /** @var string name */
    protected string $name = "Short sword";

    protected static array $requires          = [Strength::TYPE => 10];
}
