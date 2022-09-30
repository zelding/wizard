<?php
/**
 * wizard
 *
 * @author    lyozsi (kristof.dekany@apex-it-services.eu)
 * @copyright internal usage
 *
 * Date: 22/03/21 22:22
 */

namespace AppBundle\Model\Common\Skill;

trait PercentageSkill 
{
    private const int _limit = 67;

    protected int $percent = 0;

    /**
     * Returns true if the percentage is higher than the defined constant
     *
     * @override
     *
     * @return int
     */
    public function isMaster() : bool
    {
        return self::_limit <= $this->percent;
    }

    public function getPercentage() : int 
    {
        return $this->percent;
    }

    public function setPercentage(int $percent) : self
    {
        $this->percent = $percent;

        return $this;
    }

    /**
     * @override
     */
    public function getMastery(): string
    {
        return $this->mastery." ({$this->percent} %)";
    }

    /**
     * @override
     */
    public function setMastery(string $mastery): self
    {
        // if we set for master, we need to make sure
        // the percent is also above the limit, so
        // otherwise we don't care
        //
        // sidenote
        // might be a nice buff effect to grant temporary master effect for a skill
        $this->percent = $this->mastery === aSkill::MASTERY_MASTER && 
                         $this->percent < self::_limit ? self::_limit : $this->percent;

        return $this;
    }
}
