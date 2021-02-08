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


use AppBundle\Helper\Stats;
use AppBundle\Model\Common\Character;
use AppBundle\Model\Common\Stats\aStat;
use AppBundle\Model\Common\Stats\Combat\Aim;
use AppBundle\Model\Common\Stats\Combat\Attack;
use AppBundle\Model\Common\Stats\Combat\Defense;
use AppBundle\Model\Common\Stats\Combat\Sequence;
use AppBundle\Model\Common\Stats\General\Health;
use AppBundle\Model\Common\Stats\General\Mana;
use AppBundle\Model\Common\Stats\General\PainPoint;
use AppBundle\Model\Common\Stats\General\PsyPoints;
use AppBundle\Model\Common\Stats\General\SkillPoint;

use AppBundle\Helper\Stats as StatsHelper;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;

class ClassService
{
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

        /** @var int $combatStatModifiersPerLevel */
        /** @var aStat[] $requiredStats */
        [$combatStatModifiersPerLevel, $requiredStats] = $class::getCombatModifiersPerLevel();

        $character->addAvailableCombatModifier($combatStatModifiersPerLevel);

        foreach($requiredStats as $statType => $requiredAmount) {

            $combatStatName = Stats::$CombatStatTypeToStatName[ $statType ];

            $combatStats->{"add{$combatStatName}"}(
                $requiredAmount,
                "Mandatory Combat modifier bonus in level {$lvl}"
            );

            $character->useAvailableCombatModifier($requiredAmount);
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
        Sequence::NAME => "int",
        Attack::NAME   => "int",
        Defense::NAME  => "int",
        Aim::NAME      => "int"
    ])]
    protected function generateBaseCombatStats(Character $character) : array
    {
        $class = $character->getClass();
        $stats = [];

        foreach($class::getModifiers() as $type => $value) {
            $name = StatsHelper::$CombatStatTypeToStatName[ $type ];

            $stats[ $name ] = $value;
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
        Health::NAME     => "int",
        PainPoint::NAME  => "int",
        SkillPoint::NAME => "int",
        PsyPoints::NAME  => "int",
        Mana::NAME       => "int"
    ])]
    protected function generateGeneralStats(Character $character) : array
    {
        $class = $character->getClass();

        return [
            Health::NAME     => $class::getHpBase(),
            PainPoint::NAME  => $class::getPpBase(),
            SkillPoint::NAME => $class::getSkillPointBase(),
            PsyPoints::NAME  => 0,
            Mana::NAME       => 0
        ];
    }
}
