<?php
/**
 * wizard
 *
 * @author    lyozsi (kristof.dekany@apex-it-services.eu)
 * @copyright internal usage
 *
 * Date: 8/21/17 4:12 PM
 */

namespace AppBundle\Model\Common\Item;


use AppBundle\Model\Mechanics\Price;

abstract class Item
{
    const TYPE = "ITM";

    public static $category    = "misc";

    public static $subCategory = "";

    /** @var Price */
    protected $basePrice;
}
