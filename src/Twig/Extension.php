<?php
/**
 * wizard
 *
 * @author    lyozsi (kristof.dekany@apex-it-services.eu)
 * @copyright internal usage
 *
 * Date: 12/31/20 11:06 AM
 */

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigTest;

class Extension extends AbstractExtension
{
    public function getTests() : array
    {
        return [
            new TwigTest('instanceof', [$this, 'isInstanceof'])
        ];
    }

    /**
     * @param mixed  $var
     * @param string $instance
     * @return bool
     */
    public function isInstanceof($var, string $instance): bool
    {
        return $var instanceof $instance;
    }
}
