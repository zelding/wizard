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
    public  const TYPE = "WPN";

    public  const ATTACK_THIRD = 0.33;
    public  const ATTACK_HALF  = 0.5;
    public  const ATTACK_ONCE  = 1.0;
    public  const ATTACK_TWICE = 2.0;

    public  const SUB_CATEGORY_BLADE    = "blade";
    public  const SUB_CATEGORY_BLUNT    = "blunt";
    public  const SUB_CATEGORY_LONG     = "long";
    public  const SUB_CATEGORY_RANGED   = "ranged";
    public  const SUB_CATEGORY_THROWING = "throwing";
    public  const SUB_CATEGORY_SHIELD   = "shield";

    public static string $category    = self::CATEGORY_WEAPON;

    public static string $subCategory = self::SUB_CATEGORY_MISC;

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

    public function __construct($subCategory = self::SUB_CATEGORY_MISC)
    {
        parent::__construct(self::CATEGORY_WEAPON, $subCategory);
    }

    /**
     * Return true if one of the modifiers made it magical (runes, gems)
     *
     * (Imbued state is determined in combat)
     *
     * @return bool
     */
    public function isMagical() : bool
    {
        return false;
    }

    public function isTwoHanded() : bool
    {
        return false;
    }

    #region getters

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return Weapon
     */
    public function setName(string $name): Weapon
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public static function getCategory(): string
    {
        return self::$category;
    }

    /**
     * @return string
     */
    public static function getSubCategory(): string
    {
        return self::$subCategory;
    }

    /**
     * @return float
     */
    public static function getBaseAttacksPerRound(): float
    {
        return self::$baseAttacksPerRound;
    }

    /**
     * @return int
     */
    public static function getBaseSequence(): int
    {
        return self::$baseSequence;
    }

    /**
     * @return int
     */
    public static function getBaseAttack(): int
    {
        return self::$baseAttack;
    }

    /**
     * @return int
     */
    public static function getBaseDefense(): int
    {
        return self::$baseDefense;
    }

    /**
     * @return int[]
     */
    public static function getBaseDamage(): array
    {
        return self::$baseDamage;
    }

    /**
     * @return int
     */
    public static function getBasePierce(): int
    {
        return self::$basePierce;
    }

    #endregion
}
