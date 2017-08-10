<?php
/**
 * Created by PhpStorm.
 * User: Lyozsi
 * Date: 2017. 08. 08.
 * Time: 18:32
 */

namespace AppBundle\Model\PC;

use AppBundle\Model\Common\Character;
use AppBundle\Model\Common\CharacterClass\aClass;
use AppBundle\Model\Common\Race\aRace;

class Player
{
    /** @var int|null */
    protected $id = 0 ?? null;

    /** @var Character */
    protected $character;
    /** @var aRace */
    protected $race;
    /** @var aClass[] */
    protected $classes = [];

    public function __construct(aRace $race, array $classes)
    {
        $this->race    = $race;
        $this->classes = $classes;

        //parent::__construct($str, $spd, $dex, $sta, $vit, $bea, $int, $wil, $ast, $per);
    }
}
