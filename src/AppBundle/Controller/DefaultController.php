<?php

namespace AppBundle\Controller;

use AppBundle\Model\Common\CharacterClass\Warrior;
use AppBundle\Model\Common\Race\Elf;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $player = $this->get('service.character')->generateCharacter(new Elf(), new Warrior());

        // replace this example code with whatever you need
        return $this->render('AppBundle:Character:character.html.twig', [
            'char' => $player
        ]);
    }
}
