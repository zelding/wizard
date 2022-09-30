<?php
/**
 * Created by PhpStorm.
 * User: Lyozsi
 * Date: 2017. 08. 08.
 * Time: 18:32
 */

namespace App\Model\PC;

use App\Model\Common\Character;

class Player
{
    /** @var int|null */
    protected ?int $id;

    public function __construct(protected Character $character)
    {
    }
}
