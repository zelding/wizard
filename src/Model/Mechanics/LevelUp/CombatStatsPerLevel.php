<?php
/**
 * wizard
 *
 * @author    lyozsi (kristof.dekany@apex-it-services.eu)
 * @copyright internal usage
 *
 * Date: 5/23/22 5:00 PM
 */

namespace App\Model\Mechanics\LevelUp;

use App\Model\Common\Stats\Combat\{Attack, Defense};

class CombatStatsPerLevel
{
    protected static array $combatModifiersPerLevel = [11, [
        Attack::TYPE  => 3,
        Defense::TYPE => 3
    ]];

    private int $totalPerLevel;

    /** @var MandatoryStatIncrease[] */
    protected array $mandatoryStats;

    public function __construct(array $statsData)
    {
        $this->totalPerLevel = reset($statsData);

        next($statsData);
        $perlevel = current($statsData);

        foreach($perlevel as $class => $value)
        {
            $this->mandatoryStats[] = MandatoryStatIncrease::create($class, $value);
        }
    }

    public function getMaximum(): int
    {
        $sum = 0;
        foreach($this->mandatoryStats as $stat) {
            $sum += $stat->getAmount();
        }

        return $sum;
    }

    public function getTotalPerLevel(): int
    {
        return $this->totalPerLevel;
    }

    /**
     * @return MandatoryStatIncrease[]
     */
    public function getMandatoryStats(): array
    {
        return $this->mandatoryStats;
    }
}
