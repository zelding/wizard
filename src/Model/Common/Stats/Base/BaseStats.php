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
        Strength::class,
        Stamina::class,
        Dexterity::class,
        Speed::class,
        Vitality::class,
        Beauty::class,
        Intelligence::class,
        Willpower::class,
        Astral::class,
        Perception::class
    ];

    public function getIterator(): Traversable
    {
        $array = [];

        foreach (static::$baseStats as $class) {
            $array[$class] = $this->getStat($class);
        }

        return new \ArrayIterator($array);
    }

    /** @var aStat[] */
    protected array $stats = [];

    /**
     * BaseStats constructor.
     *
     * @param array{fcn: int} $stats
     *
     * @throws AppException
     */
    public function __construct(array $stats)
    {
        foreach( $stats as $class => $value) {
            if ( in_array($class, static::$baseStats) ) {
                $this->setStat($class, $value);
            }
        }
    }

    /**
     * @param string    $statClass
     * @param int|array $value
     *
     * @return $this
     * @throws AppException
     */
    public function setStat(string $statClass, int|array $value) : self
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
}
