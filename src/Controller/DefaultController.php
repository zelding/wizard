<?php

namespace App\Controller;

use App\Model\Common\CharacterClass\Warrior;
use App\Model\Common\Race\Elf;
use App\Service\CharacterService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends AbstractController
{
    public function indexAction(CharacterService $characterService) : Response
    {
        $player = $characterService->generateCharacter(new Elf(), new Warrior());

        //dump($player);

        // replace this example code with whatever you need
        return $this->render('App/Character/character.html.twig', [
            'char' => $player
        ]);
    }
}
