<?php
/**
 * wizard
 *
 * @author    lyozsi (kristof.dekany@apex-it-services.eu)
 * @copyright internal usage
 *
 * Date: 8/10/17 11:55 AM
 */

namespace AppBundle\Service;


use AppBundle\Model\Common\CharacterClass\aClass;
use AppBundle\Model\Common\Race\aRace;
use AppBundle\Model\PC\PlayerCharacter;

class CharacterService
{
    /** @var RaceService */
    protected $raceService;
    /** @var ClassService */
    protected $classService;

    public function __construct(RaceService $raceService, ClassService $classService)
    {
        $this->raceService  = $raceService;

        $this->classService = $classService;
    }

    public function generateCharacter(aRace $race, aClass $class)
    {
        list ($str,  $spd,  $dex,  $sta,  $vit, $bea,  $int,  $wil,  $ast,  $per) = $this->generateBaseStats($race, $class);

        $character = new PlayerCharacter($race, $class);
        $character->setBaseStats($str,  $spd,  $dex,  $sta,  $vit, $bea,  $int,  $wil,  $ast,  $per);

        $this->raceService->setRacialBonuses($character);

        return $character;
    }

    protected function generateBaseStats(aRace $race, aClass $class)
    {
        $statRanges    = $class::getBaseStatRanges();
        $statMaxValues = $race::getMaxBaseStats();

        $statValues = [];

        foreach($statRanges as $statName => $range) {
            $i = 1;

            $statValue = mt_rand($range[0], $range[1]);

            //if you are allowed to re-roll
            while($range[2] > $i) {
                $next = mt_rand($range[0], $range[1]);
                $i++;

                if ( $next > $statValue ) {
                    $statValue = $next;
                }
            }

            if ( $statValue > $statMaxValues[ $statName ] ) {
                $statValue = $statMaxValues[ $statName ];
            }

            $statValues[] = $statValue;
        }

        return $statValues;
    }
}
