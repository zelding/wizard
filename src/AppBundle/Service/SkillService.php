<?php


namespace AppBundle\Service;


use AppBundle\Model\Common\CharacterClass\aClass;
use AppBundle\Model\Common\Race\aRace;
use AppBundle\Model\Common\Skill\aSkill;
use AppBundle\Model\Common\Skill\Combat\WeaponHandling;
use AppBundle\Model\Common\Skill\Science\Psy;
use AppBundle\Model\Common\Skill\Science\PyarronPsy;
use AppBundle\Model\Common\Skill\Social\Language;
use AppBundle\Model\Common\SkillProvider;

class SkillService
{
    /**
     * @param SkillProvider $provider
     * @param int           $level
     * @return aSkill[]
     */
    public function getSkillsFromProvider(SkillProvider $provider, int $level = 1) : array
    {
        $skills = [];

        foreach( $provider::getBaseSkills() as $class => $skillData ) {
            /** @var aSkill $skill */
            $skill = new $class();

            if ( $skill instanceof Language ) {
                foreach($skillData as $langData) {
                    /** @var Language $skill */
                    $skill = new $class($langData["mastery"]);
                    $skill->setLevel($langData["level"]);
                    $skill->setRelatesTo($langData["for"]);
                }
            }
            elseif ( $skill instanceof WeaponHandling && is_array($skillData["relations"]) ) {
                // If multiple of the same type are present like weapon handling or language
                for($i = 0; $i < count($skillData["relations"]); $i++) {
                    $skill = new $class($skillData["mastery"]);
                    $skill->setRelatesTo($skillData["relations"][ $i ]);

                    if ( $provider instanceof aClass) {
                        $skill->setOrigin(
                            "from class: " . $provider::getName()
                        );
                    }
                    elseif( $provider instanceof aRace) {
                        $skill->setOrigin(
                            "from race: " . $provider::getName()
                        );
                    }

                    $skills[] = $skill;
                }

                // just to skip the rest of the skill setting and adding the last one twice
                continue;
            }
            else {
                if ( $skill instanceof Psy) {
                    /** @var Psy $skill */
                    $skill->setLearnedAt(1);
                }

                /** @var string $skillData */
                $skill->setMastery($skillData);
            }

            if ( $provider instanceof aClass) {
                $skill->setOrigin(
                    "from class: " . $provider::getName()
                );
            }
            elseif( $provider instanceof aRace) {
                $skill->setOrigin(
                    "from race: " . $provider::getName()
                );
            }

            $skills[] = $skill;
        }

        if ( $level > 1 ) {
            $laterSkills = $provider::getLateSkills();

            foreach( $laterSkills as $lvl => $skills ) {
                if ( $lvl <= $level ) {
                    foreach( $skills as $class => $mastery ) {
                        $skill = new $class($mastery);

                        //in case of Pyarron Psy we need to set the level when it was upgraded
                        if ( $skill instanceof PyarronPsy ) {
                            if ($skill->getMastery() === aSkill::MASTERY_BASIC) {
                                $skill->setLearnedAt($lvl);
                            }
                            elseif ( 0 === $skill->getUpgradedAt() ) {
                                $skill->setUpgradedAt($lvl);
                            }
                        }

                        if ( $provider instanceof aClass) {
                            $skills[] = $skill->setOrigin(
                                "from class: " . $provider::getName() . ", unlocked at lvl {$lvl}"
                            );
                        }
                        elseif( $provider instanceof aRace) {
                            $skills[] = $skill->setOrigin(
                                "from race: " . $provider::getName() . ", unlocked at lvl {$lvl}"
                            );
                        }
                    }
                }
            }
        }

        return $skills;
    }
}
