<?php
/**
 * Created by PhpStorm.
 * User: Lyozsi
 * Date: 2017. 08. 08.
 * Time: 18:32
 */

namespace AppBundle\Model\PC;

use AppBundle\Model\Common\Stats\BaseStats;

class Player
{
    /** @var int|null */
    protected $id         = 0 ?? null;
    /** @var string */
    protected $firstName  = "";
    /** @var string[] */
    protected $otherNames = [];
    /** @var null|BaseStats */
    protected $baseStats  = null;
}