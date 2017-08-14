<?php
/**
 * wizard
 *
 * @author    lyozsi (kristof.dekany@apex-it-services.eu)
 * @copyright internal usage
 *
 * Date: 8/10/17 12:04 PM
 */

namespace AppBundle\Service;


use AppBundle\Model\Common\Character;

use AppBundle\Model\Common\CharacterClass\aClass;
use AppBundle\Model\Common\Stats\Combat\Aim;
use AppBundle\Model\Common\Stats\Combat\Attack;
use AppBundle\Model\Common\Stats\Combat\Defense;
use AppBundle\Model\Common\Stats\Combat\Sequence;
use AppBundle\Model\Common\Stats\Magic\AstralMagicResist;
use AppBundle\Model\Common\Stats\Magic\MentalMagicResist;

class ClassService
{
    public static $StatTypeToStatName = [
        Sequence::TYPE => Sequence::NAME,
        Attack::TYPE   => Attack::NAME,
        Defense::TYPE  => Defense::NAME,
        Aim::TYPE      => Aim::NAME
    ];

    public function applyClassBonuses(Character $character)
    {
        $character->setBaseCombatStats($this->generateBaseCombatStats($character));
        $this->setUpMagicResists($character);

        return $this;
    }

    /**
     * Returns base combat stats based on the class
     *
     * @param Character $character
     *
     * @return int[]
     */
    protected function generateBaseCombatStats(Character $character)
    {
        $class = $character->getClass();
        $stats = [];

        foreach($class->getModifiers() as $type => $value) {
            $name = ClassService::$StatTypeToStatName[ $type ];

            $stats[ $name ] = $value;
        }

        return $stats;
    }

    protected function setUpMagicResists(Character $character)
    {
        $astral = new AstralMagicResist(0);
        $astral->setStatic($character->getBasePsy())
               ->setDynamic(0)
               ->setSubConscious($character->getBaseStats()->getAstral()->getRollModifierValue())
               ->setMagic(0);

        $character->setMagicResists($astral);

        $mental = new MentalMagicResist(0);
        $mental->setStatic($character->getBasePsy())
               ->setDynamic(0)
               ->setSubConscious($character->getBaseStats()->getWillpower()->getRollModifierValue())
               ->setMagic(0);

        $character->setMagicResists($mental);

        return $this;
    }

}
