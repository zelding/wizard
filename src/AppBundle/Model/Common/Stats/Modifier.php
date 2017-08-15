<?php
/**
 * wizard
 *
 * @author    lyozsi (kristof.dekany@apex-it-services.eu)
 * @copyright internal usage
 *
 * Date: 8/15/17 9:07 AM
 */

namespace AppBundle\Model\Common\Stats;


class Modifier extends aStat
{
    /** @var int|string */
    protected $modifies = self::TYPE;
    /** @var string */
    protected $description = "";

    public function __construct($value, $description = "")
    {
        parent::__construct($value);

        $this->setDescription($description);
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
    public function setDescription(string $description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return int|string
     */
    public function getModifies()
    {
        return $this->modifies;
    }

    /**
     * @param int|string $modifies
     *
     * @return Modifier
     */
    public function setModifies(string $modifies)
    {
        $this->modifies = $modifies;

        return $this;
    }
}
