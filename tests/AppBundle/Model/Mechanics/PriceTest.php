<?php
/**
 * wizard
 *
 * @author    lyozsi (kristof.dekany@apex-it-services.eu)
 * @copyright internal usage
 *
 * Date: 1/27/22 10:08 AM
 */

namespace Tests\AppBundle\Model\Mechanics;

use AppBundle\Model\Mechanics\Price;
use PHPUnit\Framework\TestCase;

class PriceTest extends TestCase
{
    public function testSetLowestCountPrice()
    {
        $price = new Price(true, true);
        $price->setLowestCountPrice(123456789);

        $this->assertEquals("1234m 56g 7s 89c", (string)$price);

        $price = new Price(false, true);
        $price->setLowestCountPrice(123456789);

        $this->assertEquals("1234m 567s 89c", (string)$price);

        $price = new Price(true, false);
        $price->setLowestCountPrice(123456789);

        $this->assertEquals("123456g 7s 89c", (string)$price);

        $price = new Price(false, false);
        $price->setLowestCountPrice(123456789);

        $this->assertEquals("1234567s 89c", (string)$price);
    }
}
