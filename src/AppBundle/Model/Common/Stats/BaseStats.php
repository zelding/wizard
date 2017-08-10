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
        "Strength"     => Strength::class,
        "Stamina"      => Stamina::class,
        "Dexterity"    => Dexterity::class,
        "Speed"        => Speed::class,
        "Vitality"     => Vitality::class,
        "Beauty"       => Beauty::class,
        "Intelligence" => Intelligence::class,
        "Willpower"    => Willpower::class,
        "Astral"       => Astral::class,
        "Perception"   => Perception::class,
    ];

    /** @var int|null */
    protected $id = 0 ?? null;
    /** @var aStat[] */
    protected $stats = [];

    /**
     * BaseStats constructor.
     *
     * @param int|null $str Strength
     * @param int|null $spd Stamina
     * @param int|null $dex Dexterity
     * @param int|null $sta Speed
     * @param int|null $vit Vitality
     * @param int|null $bea Beauty
     * @param int|null $int Intelligence
     * @param int|null $wil Willpower
     * @param int|null $ast Astral
     * @param int|null $per Perception
     */
    public function __construct(
        int $str = null, int $spd = null, int $dex = null, int $sta = null, int $vit = null,
        int $bea = null, int $int = null, int $wil = null, int $ast = null, int $per = null)
    {
        foreach( static::$baseStats as $name => $class) {
            /** @var aStat $class */
            $varName = strtolower($class::TYPE);

            if ( $$varName !== null ) {
                $this->{"set{$name}"}($$varName);
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

        if ( !in_array($statClass::TYPE, $this->stats) ) {
            $this->stats[ Strength::TYPE ] = $statClass;
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

        if ( in_array($statClass::TYPE, $this->stats) ) {
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

        if ( !in_array($statClass::TYPE, $this->stats) ) {
            throw new AppException("{$name} is not yet defined");
        }

        $this->stats[ $statClass::TYPE ]->addModifier($statClass);

        return $this;
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
