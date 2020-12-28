<?php


namespace AppBundle\Model\Mechanics\Dice;


abstract class aDice
{
    protected static int $min = 1;

    protected static int $max;

    final public static function getMin() : int
    {
        return static::$min;
    }

    final public static function getMax() : int
    {
        return static::$max;
    }

    final public static function roll() : int
    {
        return mt_rand(static::$min, static::$max);
    }
}