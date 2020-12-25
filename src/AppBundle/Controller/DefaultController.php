<?php

namespace AppBundle\Controller;

use AppBundle\Model\Common\CharacterClass\Warrior;
use AppBundle\Model\Common\Race\Elf;
use AppBundle\Service\CharacterService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DefaultController extends AbstractController
{
    public function indexAction(CharacterService $characterService)
    {
        $player = $characterService->generateCharacter(new Elf(), new Warrior());

        // replace this example code with whatever you need
        return $this->render('Character/character.html.twig', [
            'char' => $player
        ]);
    }
}
