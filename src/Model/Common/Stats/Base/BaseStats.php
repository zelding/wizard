<?php
/**
 * Created by PhpStorm.
 * User: Lyozsi
 * Date: 2017. 08. 08.
 * Time: 18:42
 */

namespace App\Model\Common\Stats\Base;

use App\Exception\AppException;
use App\Model\Common\Stats\aStat;
use App\Model\Common\Stats\Modifier;
use Traversable;

/**
 * Class BaseStats
 *
 * Base stats of a character
 *
 * @package App\Model\Common\Stats
 */
class BaseStats implements \IteratorAggregate
{
    public static array $baseStats = [
        Strength::NAME     => Strength::class,
        Stamina::NAME      => Stamina::class,
        Dexterity::NAME    => Dexterity::class,
        Speed::NAME        => Speed::class,
        Vitality::NAME     => Vitality::class,
        Beauty::NAME       => Beauty::class,
        Intelligence::NAME => Intelligence::class,
        Willpower::NAME    => Willpower::class,
        Astral::NAME       => Astral::class,
        Perception::NAME   => Perception::class,
    ];

    public function getIterator(): Traversable
    {
        $array = [];

        foreach (static::$baseStats as $name => $class) {
            $array[$name] = $this->getStat($class);
        }

        return new \ArrayIterator($array);
    }

    /** @var aStat[] */
    protected array $stats = [];

    /**
     * BaseStats constructor.
     *
     * @param array{fcn: int} $stats
     */
    public function __construct(array $stats)
    {
        foreach( $stats as $class => $value) {
            if ( in_array($class, static::$baseStats) ) {
                //$this->{"set$class"}($value);
                $this->setStat($class, $value);
            }
        }
    }

    /**
     * @param           $statClass
     * @param int|array $value
     *
     * @return $this
     * @throws AppException
     */
    public function setStat($statClass, int|array $value) : self
    {
        if ( !array_key_exists($statClass, $this->getAllStats()) ) {
            $this->stats[ $statClass ] = new $statClass($value);
        }
        else {
            throw new AppException("{$statClass} is already defined");
        }

        return $this;
    }

    /**
     * @param string $statClass
     *
     * @return aStat
     * @throws AppException
     */
    public function getStat(string $statClass) : aStat
    {
        if ( array_key_exists($statClass, $this->getAllStats()) ) {
            return $this->stats[ $statClass ];
        }
        else {
            throw new AppException("{$statClass} is not yet defined");
        }
    }

    /**
     * Adds a modifier for a stat
     *
     * @param string $modifierClassName
     * @param int    $value
     * @param string $description
     * @param bool   $permanent
     *
     * @return $this
     * @throws AppException
     */
    public function addModifier(string $modifierClassName, int $value, string $description = "", bool $permanent = true) : self
    {
        $modifierClass = new Modifier($value, $description, $permanent);
        $modifierClass->setModifies($modifierClassName);

        if ( !key_exists($modifierClassName, $this->getAllStats()) ) {
            throw new AppException("{$modifierClassName}/".$modifierClass::class." is not yet defined");
        }

        $this->stats[ $modifierClassName ]->addModifier($modifierClass);

        return $this;
    }

    public function getAllStats() : array
    {
        return $this->stats;
    }

    /**
     * Returns the appropriate class from name
     *
     * @param string    $name
     * @param int|array $value
     *
     * @return aStat
     */
    protected function resolveStatClass(string $name, int|array $value = 0) : aStat
    {
        $statClassName = static::$baseStats[ $name ];

        return new $statClassName($value);
    }

    /**
     * @param string $name
     * @param int    $value
     * @param string $description
     * @param bool   $permanent
     *
     * @return Modifier
     */
    protected function resolveModifierClass(string $name, int $value = 0, $description = "", bool $permanent = true) : Modifier
    {
        /** @var aStat $statClassName */
        $statClassName = static::$baseStats[ $name ];

        $modifier = new Modifier($value, $description, $permanent);
        $modifier->setModifies($statClassName::class);

        return $modifier;
    }
}
