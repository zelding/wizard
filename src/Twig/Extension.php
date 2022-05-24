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

use App\Model\Common\Stats\Combat\BaseCombatStats;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use Twig\TwigTest;

class Extension extends AbstractExtension
{
    public function getTests() : array
    {
        return [
            new TwigTest('instanceof', [$this, 'isInstanceof'])
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('cs_names', [$this, 'getCombatStats']),
            new TwigFunction('call_static', [$this, 'staticHelper'])
        ];
    }

    #region Tests

    /**
     * @param object $var
     * @param string $instance
     * @return bool
     */
    public function isInstanceof(object $var, string $instance): bool
    {
        return $var instanceof $instance;
    }

    #endregion

    #region Functions

    public function getCombatStats(): array
    {
        //$data = array_flip(Stats::$CombatStatTypeToStatName);

        return array_keys(BaseCombatStats::$baseStats);
    }

    public function staticHelper(string $class, string $method, ...$args)
    {
        if ( !class_exists($class) ) {
            throw new \RuntimeException("$class doesn't exists");
        }

        if (!method_exists($class, $method)) {
            throw new \RuntimeException("$class::$method doesn't exists");
        }

        return forward_static_call_array([$class, $method], $args);
    }

    #endregion
}
