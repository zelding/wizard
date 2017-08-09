<?php
/**
 * Created by PhpStorm.
 * User: Lyozsi
 * Date: 2017. 08. 08.
 * Time: 18:42
 */

namespace AppBundle\Model\Common\Stats;

/**
 * Class BaseStats
 *
 * Base stats of a character
 *
 * @package AppBundle\Model\Common\Stats
 */
class BaseStats
{
    public static $baseStatTypes = [
        Strength::class,
        Stamina::class,
        Dexterity::class,
        Speed::class,
        Vitality::class,

        Beauty::class,
        Intelligence::class,
        Willpower::class,
        Astral::class,
        Perception::class
    ];

    /** BaseStat */
    const TYPE = 1;
    /** @var int|null */
    protected $id = 0 ?? null;
    /** @var aStat[] */
    protected $stats = [];
}
