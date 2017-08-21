<?php
/**
 * wizard
 *
 * @author    lyozsi (kristof.dekany@apex-it-services.eu)
 * @copyright internal usage
 *
 * Date: 8/21/17 1:34 PM
 */

namespace AppBundle\Model\Common\Item;


class Inventory
{
    const INV_TYPE_BAG      = "bag";
    const INV_TYPE_BACKPACK = "backpack";
    const INV_TYPE_POCKET   = "pocket";
    const INV_TYPE_BELT     = "belt";

    protected $type = "";

    /** @var array */
    protected $items = [];

    protected static $maxWeight = 0;
}
