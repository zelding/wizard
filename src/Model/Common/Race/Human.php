<?php
/**
 * wizard
 *
 * @author    lyozsi (kristof.dekany@apex-it-services.eu)
 * @copyright internal usage
 *
 * Date: 8/10/17 9:32 AM
 */

namespace App\Model\Common\Race;


class Human extends aRace
{
    public  const TYPE = "HUM";

    protected static bool $playable = true;

    protected static string $name = "Human";
}
