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
    protected ?int $id;

    protected Character $character;

    public function __construct(Character $character)
    {
        $this->character = $character;
    }
}
