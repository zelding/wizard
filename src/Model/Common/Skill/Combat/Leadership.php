<?php
/**
 * wizard
 *
 * @author    lyozsi (kristof.dekany@apex-it-services.eu)
 * @copyright internal usage
 *
 * Date: 8/16/17 12:17 PM
 */

namespace App\Model\Common\Skill\Combat;


use App\Model\Common\Skill\aSkill;

class Leadership extends aSkill
{
    public  const TYPE = "LDS";

    public static string $category = self::SKILL_TYPE_COMBAT;

    public static int $baseCost    =  5;
    public static int $masteryCost = 20;

    protected static string $name = "Leadership";
}
