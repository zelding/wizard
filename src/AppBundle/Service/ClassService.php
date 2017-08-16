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

use AppBundle\Model\Common\Skill\aSkill;
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
     * @param Character $character
     *
     * @return aSkill[]
     */
    public function getClassSkills(Character $character)
    {
        $skills = $character->getClass()::getBaseProfessions();

        $classSkills = [];

        foreach( $skills as $class => $skillData ) {
            if ( is_array($skillData) ) {
                // If multiple of the same type are present like weapon handling or language
                for($i = 0; $i < count($skillData["relations"]); $i++) {
                    /** @var aSkill $skill */
                    $skill = new $class($skillData["mastery"]);
                    $skill->setRelatesTo($skillData["relations"][ $i ]);

                    $classSkills[] = $skill;
                }
            }
            else {
                $classSkills[] = new $class($skillData);
            }
        }

        if ( $character->getLevel() > 1 ) {
            $laterSkills = $character->getClass()::getLateProfessions();
            foreach( $laterSkills as $lvl => $skills ) {
                if ( $lvl <= $character->getLevel() ) {
                    foreach( $skills as $class => $mastery ) {
                        $classSkills[] = new $class($mastery);
                    }
                }
            }
        }

        return $classSkills;
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

    /**
     * @param Character $character
     *
     * @return $this
     * @throws \AppBundle\Exception\AppException
     */
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
