<?php
/**
 * wizard
 *
 * @author    lyozsi (kristof.dekany@apex-it-services.eu)
 * @copyright internal usage
 *
 * Date: 5/23/22 5:26 PM
 */

namespace Tests\App\Service;

use App\Model\Common\CharacterClass\Warrior;
use App\Model\Common\Race\Elf;
use App\Model\Common\Stats\Combat\Attack;
use App\Model\PC\PlayerCharacter;
use App\Service\ClassService;
use PHPUnit\Framework\TestCase;

class ClassServiceTest extends TestCase
{

    private $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = new ClassService();
    }

    public function testSetCombatModifiers()
    {
        $c = new PlayerCharacter(new Elf(), new Warrior());

        $c->setBaseCombatStats([

        ]);

        $this->service->setCombatModifiers($c);

        $this->assertEquals(23, $c->getBaseCombatStats()->getStat(Attack::class));
    }
}
