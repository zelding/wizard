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

use AppBundle\Model\Common\Skill\aSkill;
use AppBundle\Model\Common\Skill\Science\Psy;
use AppBundle\Model\Common\Skill\Science\PyarronPsy;
use AppBundle\Model\Common\Skill\Social\Language;
use AppBundle\Model\Common\Stats\aStat;
use AppBundle\Model\Common\Stats\General\Health;
use AppBundle\Model\Common\Stats\General\Mana;
use AppBundle\Model\Common\Stats\General\PainPoint;
use AppBundle\Model\Common\Stats\General\PsyPoints;
use AppBundle\Model\Common\Stats\General\SkillPoint;

use AppBundle\Helper\Stats as StatsHelper;

class ClassService
{
    public function applyClassBonuses(Character $character) : self
    {
        $character->setBaseCombatStats($this->generateBaseCombatStats($character))
                  ->setGeneralStats($this->generateGeneralStats($character));

        return $this;
    }

    /**
     * @param Character $character
     *
     * @return aSkill[]
     */
    public function getClassSkills(Character $character) : array
    {
        $skills = $character->getClass()::getBaseSkills();

        $classSkills = [];

        foreach( $skills as $class => $skillData ) {
            /** @var aSkill $skill */
            $skill = new $class();

            if ( $skill instanceof Language ) {
                foreach($skillData as $langData) {
                    /** @var Language $lang */
                    $lang = new $class($langData["mastery"]);
                    $lang->setLevel($langData["level"]);
                    $lang->setRelatesTo($langData["for"]);

                    $classSkills[] = $lang;
                }
            }
            //probably weapon handling
            elseif ( is_array($skillData) && is_array($skillData["relations"]) ) {
                // If multiple of the same type are present like weapon handling or language
                for($i = 0; $i < count($skillData["relations"]); $i++) {
                    $skill = new $class($skillData["mastery"]);
                    $skill->setRelatesTo($skillData["relations"][ $i ]);
                    $classSkills[] = $skill;
                }
            }
            else {
                if ( $skill instanceof Psy) {
                    /** @var Psy $skill */
                    $skill->setLearnedAt(1);
                }

                /** @var string $skillData */
                $skill->setMastery($skillData);
                $classSkills[] = $skill;
            }
        }

        if ( $character->getLevel() > 1 ) {
            $laterSkills = $character->getClass()::getLateSkills();
            foreach( $laterSkills as $lvl => $skills ) {
                if ( $lvl <= $character->getLevel() ) {
                    foreach( $skills as $class => $mastery ) {
                        $skill = new $class($mastery);

                        //in case of Pyarron Psy we need to set the level when it was upgraded
                        if ( $skill instanceof PyarronPsy ) {
                            if ($skill->getMastery() === aSkill::MASTERY_BASIC) {
                                $skill->setLearnedAt($lvl);
                            }
                            else {
                                $skill->setUpgradedAt($lvl);
                            }
                        }

                        $classSkills[] = $skill->setOrigin(
                            "from class: ".$character->getClass()::getName().", unlocked at lvl {$lvl}"
                        );
                    }
                }
            }
        }

        return $classSkills;
    }

    public function setCombatModifiers(Character $character, int $lvl = 1) : self
    {
        $class       = $character->getClass();
        $combatStats = $character->getBaseCombatStats();

        /** @var int $combatStatModifiersPerLevel */
        /** @var aStat[] $requiredStats */
        list($combatStatModifiersPerLevel, $requiredStats) = $class::getCombatModifiersPerLevel();

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
    protected function generateBaseCombatStats(Character $character) : array
    {
        $class = $character->getClass();
        $stats = [];

        foreach($class->getModifiers() as $type => $value) {
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
