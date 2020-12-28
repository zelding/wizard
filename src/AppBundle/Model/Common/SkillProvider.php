<?php


namespace AppBundle\Model\Common;


use AppBundle\Model\Common\Skill\aSkill;

interface SkillProvider
{
    /**
     * @return aSkill[]
     */
    public static function getBaseSkills() : array;

    /**
     * @return aSkill[]
     */
    public static function getLateSkills() : array;

    public static function getName(): string;
}