<?php
/**
 * wizard
 *
 * @author    lyozsi (kristof.dekany@apex-it-services.eu)
 * @copyright internal usage
 *
 * Date: 8/15/17 9:07 AM
 */

namespace App\Model\Common\Stats;


class Modifier extends aStat
{
    /** @var string */
    protected string $modifies = Modifier::TYPE;
    /** @var string */
    protected string $description = "";

    protected bool $permanent = true;

    public function __construct($value, $description = "", bool $permanent = true)
    {
        parent::__construct($value);

        $this->setDescription($description);
        $this->permanent = $permanent;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     *
     * @return $this
     */
    public function setDescription(string $description) : self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return string
     */
    public function getModifies() : string
    {
        return $this->modifies;
    }

    /**
     * @param string $modifies
     *
     * @return Modifier
     */
    public function setModifies(string $modifies) : self
    {
        $this->modifies = $modifies;

        return $this;
    }

    /**
     * @return bool
     */
    public function isPermanent(): bool
    {
        return $this->permanent;
    }
}
