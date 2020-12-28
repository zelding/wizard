<?php


namespace AppBundle\Model\Common\Item;


interface Equippable
{
    public function requires() : array;

    public function slots() : int;
}