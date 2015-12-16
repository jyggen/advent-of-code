<?php
namespace Boo\AdventOfCode\Commands;

class DayFourteenCommand extends DayCommandAbstract
{
    protected $testDataOne = [
        [
            'input' => [
                'Comet can fly 14 km/s for 10 seconds, but then must rest for 127 seconds.',
                'Dancer can fly 16 km/s for 11 seconds, but then must rest for 162 seconds.',
            ],
            'output' => 1120,
        ],
    ];

    protected $testDataTwo = [
        [
            'input' => [
                'Comet can fly 14 km/s for 10 seconds, but then must rest for 127 seconds.',
                'Dancer can fly 16 km/s for 11 seconds, but then must rest for 162 seconds.',
            ],
            'output' => 689,
        ],
    ];

    protected function configure()
    {
        parent::configure();
        $this->setDescription('Reindeer Olympics');
    }

    protected function normalizeData(array $input)
    {
        $output = [];
        $regex = '/^([\w]+) can fly ([\d]+) km\/s for ([\d]+) seconds, but then must rest for ([\d]+) seconds.$/';

        foreach ($input as $reindeer) {
            if (preg_match($regex, $reindeer, $match) !== 1) {
                throw new \RuntimeException('Unable to parse input');
            }

            $output[] = [
                'name'    => $match[1],
                'speed'   => (int) $match[2],
                'stamina' => (int) $match[3],
                'rest'    => (int) $match[4],
            ];
        }

        return $output;
    }

    protected function getDayNumber()
    {
        return 14;
    }

    protected function performTest(array &$input)
    {
        return $this->simulateRace($input, 1000);
    }

    protected function perform(array &$input)
    {
        return $this->simulateRace($input, 2503);
    }

    protected function simulateRace($reindeers, $raceLength)
    {
        $reindeerTracker = [];

        for ($i = 0; $i < $raceLength; $i++) {
            foreach ($reindeers as $reindeer) {
                if ($i === 0) {
                    $reindeerTracker[$reindeer['name']] = [
                        'mode'     => 'fly',
                        'distance' => 0,
                        'counter'  => $reindeer['stamina'],
                        'points'   => 0,
                    ];
                }

                if ($reindeerTracker[$reindeer['name']]['mode'] === 'fly') {
                    $reindeerTracker[$reindeer['name']]['distance'] += $reindeer['speed'];
                }

                $reindeerTracker[$reindeer['name']]['counter']--;

                if ($reindeerTracker[$reindeer['name']]['counter'] === 0) {
                    if ($reindeerTracker[$reindeer['name']]['mode'] === 'fly') {
                        $reindeerTracker[$reindeer['name']]['mode']    = 'rest';
                        $reindeerTracker[$reindeer['name']]['counter'] = $reindeer['rest'];
                    } else {
                        $reindeerTracker[$reindeer['name']]['mode']    = 'fly';
                        $reindeerTracker[$reindeer['name']]['counter'] = $reindeer['stamina'];
                    }
                }
            }

            $longest = null;

            foreach ($reindeerTracker as $reindeer) {
                $longest = max($longest, $reindeer['distance']);
            }

            foreach ($reindeerTracker as $key => $reindeer) {
                if ($reindeer['distance'] === $longest) {
                    $reindeerTracker[$key]['points']++;
                }
            }
        }

        $longestDistance = 0;

        foreach ($reindeerTracker as $reindeer) {
            $longestDistance = max($longestDistance, $reindeer['distance']);
        }

        $highestPoints = 0;

        foreach ($reindeerTracker as $reindeer) {
            $highestPoints = max($highestPoints, $reindeer['points']);
        }

        return [$longestDistance, $highestPoints];
    }
}
