<?php

namespace AppBundle\Controller;

use AppBundle\Model\Common\CharacterClass\Warrior;
use AppBundle\Model\Common\Race\Human;
use AppBundle\Model\PC\Player;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $player = new Player(
            new Human(),
            [new Warrior()]
        );

        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'char' => $player,
        ]);
    }
}
