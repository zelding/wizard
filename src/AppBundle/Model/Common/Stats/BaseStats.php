<?php
/**
 * Created by PhpStorm.
 * User: Lyozsi
 * Date: 2017. 08. 08.
 * Time: 18:42
 */

namespace AppBundle\Model\Common\Stats;

use AppBundle\Exception\AppException;

/**
 * Class BaseStats
 *
 * Base stats of a character
 *
 * @package AppBundle\Model\Common\Stats
 *
 * @method BaseStats setStrength(int $str)
 * @method BaseStats setStamina(int $sta)
 * @method BaseStats setDexterity(int $dex)
 * @method BaseStats setSpeed(int $spd)
 * @method BaseStats setVitality(int $vit)
 * @method BaseStats setBeauty(int $bea)
 * @method BaseStats setIntelligence(int $int)
 * @method BaseStats setWillpower(int $wil)
 * @method BaseStats setAstral(int $ast)
 * @method BaseStats setPerception(int $per)
 *
 * @method aStat getStrength()
 * @method aStat getStamina()
 * @method aStat getDexterity()
 * @method aStat getSpeed()
 * @method aStat getVitality()
 * @method aStat getBeauty()
 * @method aStat getIntelligence()
 * @method aStat getWillpower()
 * @method aStat getAstral()
 * @method aStat getPerception()
 *
 * @method BaseStats addStrength(int $str)
 * @method BaseStats addStamina(int $sta)
 * @method BaseStats addDexterity(int $dex)
 * @method BaseStats addSpeed(int $spd)
 * @method BaseStats addVitality(int $vit)
 * @method BaseStats addBeauty(int $bea)
 * @method BaseStats addIntelligence(int $int)
 * @method BaseStats addWillpower(int $wil)
 * @method BaseStats addAstral(int $ast)
 * @method BaseStats addPerception(int $per)
 */
class BaseStats
{
    public static $baseStats = [
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

    /** @var aStat[] */
    protected $stats = [];

    /**
     * BaseStats constructor.
     *
     * @param aStat[] $stats
     */
    public function __construct(array $stats)
    {
        foreach( $stats as $name => $value) {

            if ( array_key_exists($name, static::$baseStats) ) {
                $this->{"set{$name}"}($value);
            }
        }
    }

    /**
     * @param string $name
     * @param array  $arguments
     *
     * @return BaseStats|aStat
     * @throws AppException
     */
    public function __call(string $name, array $arguments)
    {
        $method   = substr($name, 0, 3)   ?? "";
        $statName = ucfirst(substr($name, 3) ?? "");

        if ( "set" === $method ) {

            if ( empty($arguments) || count($arguments) > 1 ) {
                throw new AppException("Only one argument is allowed for statSetters");
            }

            $value = reset($arguments);

            if( in_array($statName, array_keys(static::$baseStats)) ) {
                return $this->setStat($statName, $value);
            }
            else {
                throw new AppException("Invalid stat type: {$statName}");
            }
        }

        if( "get" === $method ) {
            if ( !empty($arguments) ) {
                throw new AppException("No argument is allowed for statGetters");
            }

            if( in_array($statName, array_keys(static::$baseStats)) ) {
                return $this->getStat($statName);
            }
            else {
                throw new AppException("Invalid stat type: {$statName}");
            }
        }

        if ( "add" == $method ) {
            if ( empty($arguments) || count($arguments) > 1 ) {
                throw new AppException("Only one argument is allowed for statAdders");
            }

            $value = reset($arguments);

            if( in_array($statName, array_keys(static::$baseStats)) ) {
                return $this->addStat($statName, $value);
            }
            else {
                throw new AppException("Invalid stat type: {$statName}");
            }
        }

        throw new AppException("Unknown method: {$name}");
    }

    /**
     * @param string $name
     * @param int $value
     *
     * @return $this
     * @throws AppException
     */
    protected function setStat(string $name, int $value)
    {
        $statClass = $this->resolveStatClass($name, $value);

        if ( !array_key_exists($statClass::TYPE, $this->stats) ) {
            $this->stats[ $statClass::TYPE ] = $statClass;
        }
        else {
            throw new AppException("{$name} is already defined");
        }

        return $this;
    }

    /**
     * @param string $name
     *
     * @return aStat
     * @throws AppException
     */
    protected function getStat(string $name) : aStat
    {
        $statClass = $this->resolveStatClass($name);

        if ( array_key_exists($statClass::TYPE, $this->stats) ) {
            return $this->stats[ $statClass::TYPE ];
        }
        else {
            throw new AppException("{$name} is not yet defined");
        }
    }

    /**
     * Adds a modifier for a stat
     *
     * @param string $name
     * @param int    $value
     *
     * @return $this
     * @throws AppException
     */
    protected function addStat(string $name, int $value)
    {
        $statClass = $this->resolveStatClass($name, $value);

        if ( !array_key_exists($statClass::TYPE, $this->stats) ) {
            throw new AppException("{$name}/".$statClass::TYPE." is not yet defined");
        }

        $this->stats[ $statClass::TYPE ]->addModifier($statClass);

        return $this;
    }

    public function getAllStats()
    {
        return $this->stats;
    }

    /**
     * Returns the appropriate class from name
     *
     * @param string $name
     * @param int    $value
     *
     * @return aStat
     */
    protected function resolveStatClass(string $name, int $value = 0) : aStat
    {
        $statClassName = static::$baseStats[ $name ];

        /** @var aStat $statClass */
        return new $statClassName($value);
    }
}
