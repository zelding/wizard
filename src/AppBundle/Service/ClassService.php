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
use AppBundle\Model\Common\Skill\Science\PyarronPsy;
use AppBundle\Model\Common\Skill\Social\Language;
use AppBundle\Model\Common\Stats\Combat\Aim;
use AppBundle\Model\Common\Stats\Combat\Attack;
use AppBundle\Model\Common\Stats\Combat\Defense;
use AppBundle\Model\Common\Stats\Combat\Sequence;
use AppBundle\Model\Common\Stats\General\Health;
use AppBundle\Model\Common\Stats\General\PainPoint;
use AppBundle\Model\Common\Stats\General\SkillPoint;

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
        $character->setBaseCombatStats($this->generateBaseCombatStats($character))
                  ->setGeneralStats($this->generateGeneralStats($character));

        return $this;
    }

    /**
     * @param Character $character
     *
     * @return aSkill[]
     */
    public function getClassSkills(Character $character)
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
                            $skill->setUpgradedAt($lvl);
                        }

                        $classSkills[] = $skill->setOrigin("from class: ".$character->getClass()::getName().", unlocked at lvl {$lvl}");
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

    protected function generateGeneralStats(Character $character)
    {
        $class = $character->getClass();
        $stats = [
            Health::NAME     => $class::getHpBase(),
            PainPoint::NAME  => $class::getPpBase(),
            SkillPoint::NAME => $class::getSkillPointBase()
        ];

        return $stats;
    }
}
