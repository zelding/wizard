<?php
/**
 * Created by PhpStorm.
 * User: Lyozsi
 * Date: 2017. 08. 08.
 * Time: 18:32
 */

namespace AppBundle\Model\PC;

use AppBundle\Model\Common\Character;

class Player
{
    /** @var int|null */
    protected $id = 0 ?? null;

    /** @var Character */
    protected $character;

    public function __construct(Character $character)
    {
        $this->character = $character;
    }
}
