<?php
/**
 * wizard
 *
 * @author    lyozsi (kristof.dekany@apex-it-services.eu)
 * @copyright internal usage
 *
 * Date: 8/10/17 12:04 PM
 */

namespace App\Service;


use App\Model\Common\Character;
use App\Model\Common\CharacterClass\aClass;
use App\Model\Common\Stats\aStat;
use App\Model\Common\Stats\Combat\Aim;
use App\Model\Common\Stats\Combat\Attack;
use App\Model\Common\Stats\Combat\Defense;
use App\Model\Common\Stats\Combat\Sequence;
use App\Model\Common\Stats\General\Health;
use App\Model\Common\Stats\General\Mana;
use App\Model\Common\Stats\General\PainPoint;
use App\Model\Common\Stats\General\PsyPoints;
use App\Model\Common\Stats\General\SkillPoint;
use App\Model\Mechanics\LevelUp\MandatoryStatIncrease;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;

class ClassService
{
    public function createClass(string $class, array $attributes = []): aClass
    {
        /** @var aClass $class */
        $class = new $class($attributes);

        return $class;
    }

    public function applyClassBonuses(Character $character) : self
    {
        $character->setBaseCombatStats($this->generateBaseCombatStats($character))
                  ->setGeneralStats($this->generateGeneralStats($character));

        return $this;
    }

    public function setCombatModifiers(Character $character, int $lvl = 1) : self
    {
        $class       = $character->getClass();
        $combatStats = $character->getBaseCombatStats();
        $statsPerLevel = $class::getCombatModifiersPerLevel();

        $character->addAvailableCombatModifier($statsPerLevel->getTotalPerLevel());

        $mcsm = $statsPerLevel->getMandatoryStats();

        foreach($mcsm as $required) {
            /** @see MandatoryStatIncrease::__ToString */
            $classname = (string)$required;

            $combatStats->addModifier($classname,
                $required->getAmount(),
                "Mandatory Combat modifier bonus in level {$lvl}"
            );

            $character->useAvailableCombatModifier($required->getAmount());
        }

        return $this;
    }

    /**
     * Returns base combat stats based on the class
     *
     * @param Character $character
     *
     * @return aStat[]
     */
    #[Pure]
    #[ArrayShape([
        Sequence::class => "int",
        Attack::class   => "int",
        Defense::class  => "int",
        Aim::class      => "int"
    ])]
    protected function generateBaseCombatStats(Character $character) : array
    {
        $class = $character->getClass();
        $stats = [];

        foreach($class::getModifiers() as $class => $value) {
             $stats[ $class ] = $value;
        }

        return $stats;
    }

    /**
     * Generates basic stats like health and pain points
     *
     * @param Character $character
     *
     * @return array
     */
    #[ArrayShape([
        Health::class     => "int",
        PainPoint::class  => "int",
        SkillPoint::class => "int",
        PsyPoints::class  => "int",
        Mana::class       => "int"
    ])]
    protected function generateGeneralStats(Character $character) : array
    {
        $class = $character->getClass();

        return [
            Health::class     => $class::getHpBase(),
            PainPoint::class  => $class::getPpBase(),
            SkillPoint::class => $class::getSkillPointBase(),
            PsyPoints::class  => 0,
            Mana::class       => 0
        ];
    }
}
