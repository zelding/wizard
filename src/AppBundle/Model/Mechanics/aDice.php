<?php


namespace AppBundle\Model\Mechanics;


abstract class aDice
{
    protected static int $min;

    protected static int $max;

    public abstract function roll() : int;
}