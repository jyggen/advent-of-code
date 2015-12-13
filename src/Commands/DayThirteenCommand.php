<?php
namespace Boo\AdventOfCode\Commands;

class DayThirteenCommand extends DayCommandAbstract
{
    protected $testDataOne = [
        [
            'input' => [
                'Alice would gain 54 happiness units by sitting next to Bob.',
                'Alice would lose 79 happiness units by sitting next to Carol.',
                'Alice would lose 2 happiness units by sitting next to David.',
                'Bob would gain 83 happiness units by sitting next to Alice.',
                'Bob would lose 7 happiness units by sitting next to Carol.',
                'Bob would lose 63 happiness units by sitting next to David.',
                'Carol would lose 62 happiness units by sitting next to Alice.',
                'Carol would gain 60 happiness units by sitting next to Bob.',
                'Carol would gain 55 happiness units by sitting next to David.',
                'David would gain 46 happiness units by sitting next to Alice.',
                'David would lose 7 happiness units by sitting next to Bob.',
                'David would gain 41 happiness units by sitting next to Carol.',
            ],
            'output' => 330,
        ],
    ];

    protected $testDataTwo = [
    ];

    protected function configure()
    {
        parent::configure();
        $this->setDescription('Knights of the Dinner Table');
    }

    protected function normalizeData(array $input)
    {
        return $input;
    }

    protected function getDayNumber()
    {
        return 13;
    }

    protected function perform(array &$input)
    {
        $regex  = '/^([\w]+) would (gain|lose) ([\d]+) happiness units by sitting next to ([\w]+).$/';
        $stats  = [];
        $people = [];

        foreach ($input as $instruction) {
            if (preg_match($regex, $instruction, $match) !== 1) {
                throw new \RuntimeException('Unable to parse instruction');
            }

            $people[]                    = $match[1];
            $stats[$match[1]][$match[4]] = ($match[2] === 'gain') ? (int) $match[3] : 0 - $match[3];
        }

        $people = array_unique($people);

        foreach ($people as $person) {
            $stats['Me'][$person] = 0;
            $stats[$person]['Me'] = 0;
        }

        return [$this->findOptimalSeating($people, $stats), $this->findOptimalSeating(array_merge($people, [
            'Me',
        ]), $stats)];
    }

    protected function findOptimalSeating($people, $stats)
    {
        $numOfPeople  = count($people);
        $permutations = permutate($people);
        $highest      = 0;

        foreach ($permutations as $people) {
            $happiness   = 0;

            foreach ($people as $key => $person) {
                if ($key + 1 === $numOfPeople) {
                    $happiness += $stats[$person][$people[0]];
                    $happiness += $stats[$people[0]][$person];
                    continue;
                }

                $happiness += $stats[$person][$people[$key + 1]];
                $happiness += $stats[$people[$key + 1]][$person];
            }

            if ($happiness > $highest) {
                $highest = $happiness;
            }
        }

        return $highest;
    }
}
