<?php
namespace Boo\AdventOfCode\Commands;

class DayTwentyOneCommand extends DayCommandAbstract
{
    protected $testDataOne = [
        [
            'input'  => [
                'Hit Points: 12',
                'Damage: 7',
                'Armor: 2',
            ],
            'output' => 65,
        ],
    ];

    protected $testDataTwo = [
    ];

    protected function configure()
    {
        parent::configure();
        $this->setDescription('RPG Simulator 20XX');
    }

    protected function normalizeData(array $input)
    {
        $stats = [];

        foreach ($input as $stat) {
            list($stat, $value) = explode(': ', $stat);
            $stats[$stat]       = $value;
        }

        return $stats;
    }

    protected function getDayNumber()
    {
        return 21;
    }

    protected function performTest(array &$input)
    {
        return $this->simulateBattle(8, $input);
    }

    protected function perform(array &$input)
    {
        return $this->simulateBattle(100, $input);
    }

    protected function simulateBattle($health, $bossStats)
    {
        $shopInventory = [
            'weapons' => [
                [
                    'cost'   => 8,
                    'damage' => 4,
                    'armor'  => 0,
                ],
                [
                    'cost'   => 10,
                    'damage' => 5,
                    'armor'  => 0,
                ],
                [
                    'cost'   => 25,
                    'damage' => 6,
                    'armor'  => 0,
                ],
                [
                    'cost'   => 40,
                    'damage' => 7,
                    'armor'  => 0,
                ],
                [
                    'cost'   => 74,
                    'damage' => 8,
                    'armor'  => 0,
                ],
            ],
            'armor' => [
                [
                    'cost'   => 13,
                    'damage' => 0,
                    'armor'  => 1,
                ],
                [
                    'cost'   => 31,
                    'damage' => 0,
                    'armor'  => 2,
                ],
                [
                    'cost'   => 53,
                    'damage' => 0,
                    'armor'  => 3,
                ],
                [
                    'cost'   => 75,
                    'damage' => 0,
                    'armor'  => 4,
                ],
                [
                    'cost'   => 102,
                    'damage' => 0,
                    'armor'  => 5,
                ],
            ],
            'rings' => [
                [
                    'cost'   => 25,
                    'damage' => 1,
                    'armor'  => 0,
                ],
                [
                    'cost'   => 50,
                    'damage' => 2,
                    'armor'  => 0,
                ],
                [
                    'cost'   => 100,
                    'damage' => 3,
                    'armor'  => 0,
                ],
                [
                    'cost'   => 20,
                    'damage' => 0,
                    'armor'  => 1,
                ],
                [
                    'cost'   => 40,
                    'damage' => 0,
                    'armor'  => 2,
                ],
                [
                    'cost'   => 80,
                    'damage' => 0,
                    'armor'  => 3,
                ],
            ],
        ];

        $combinations  = $this->getAllShopCombinations($shopInventory);
        $cheapest      = $this->findCheapestWinner($health, $bossStats, $combinations);
        $mostExpensive = $this->findMostExpensiveLoser($health, $bossStats, $combinations);

        return [$cheapest, $mostExpensive];
    }

    protected function findCheapestWinner($health, array $bossStats, array $combinations)
    {
        $iteration = 0;

        while (true) {
            $bossHealth   = $bossStats['Hit Points'];
            $playerHealth = $health;

            do {
                $bossHealth   -= max(1, $combinations[$iteration]['damage'] - $bossStats['Armor']);
                $playerHealth -= max(1, $bossStats['Damage'] - $combinations[$iteration]['armor']);
            } while ($bossHealth > 0 && $playerHealth > 0);

            if ($bossHealth <= 0) {
                break;
            }

            $iteration++;
        }

        return $combinations[$iteration]['cost'];
    }

    protected function findMostExpensiveLoser($health, array $bossStats, array $combinations)
    {
        $iteration = count($combinations) - 1;

        while (true) {
            $bossHealth   = $bossStats['Hit Points'];
            $playerHealth = $health;

            do {
                $bossHealth   -= max(1, $combinations[$iteration]['damage'] - $bossStats['Armor']);
                $playerHealth -= max(1, $bossStats['Damage'] - $combinations[$iteration]['armor']);
            } while ($bossHealth > 0 && $playerHealth > 0);

            if ($playerHealth <= 0 && $bossHealth > 0) {
                break;
            }

            $iteration--;
        }

        return $combinations[$iteration]['cost'];
    }

    protected function getAllShopCombinations(array $inventory)
    {
        $combinations  = [];
        $numberOfRings = count($inventory['rings']);

        foreach ($inventory['weapons'] as $weapon) {
            $combinations[] = [
                'cost'   => $weapon['cost'],
                'damage' => $weapon['damage'],
                'armor'  => $weapon['armor'],
            ];

            foreach ($inventory['armor'] as $armor) {
                $combinations[] = [
                    'cost'   => $weapon['cost'] + $armor['cost'],
                    'damage' => $weapon['damage'] + $armor['damage'],
                    'armor'  => $weapon['armor'] + $armor['armor'],
                ];

                foreach ($inventory['rings'] as $index => $ring) {
                    $combinations[] = [
                        'cost'   => $weapon['cost'] + $armor['cost'] + $ring['cost'],
                        'damage' => $weapon['damage'] + $armor['damage'] + $ring['damage'],
                        'armor'  => $weapon['armor'] + $armor['armor'] + $ring['armor'],
                    ];

                    for ($i = $index + 1; $i < $numberOfRings; $i++) {
                        $combinations[] = [
                            'cost'   => $weapon['cost'] + $armor['cost'] + $ring['cost'] + $inventory['rings'][$i]['cost'],
                            'damage' => $weapon['damage'] + $armor['damage'] + $ring['damage'] + $inventory['rings'][$i]['damage'],
                            'armor'  => $weapon['armor'] + $armor['armor'] + $ring['armor'] + $inventory['rings'][$i]['armor'],
                        ];
                    }
                }
            }

            foreach ($inventory['rings'] as $index => $ring) {
                $combinations[] = [
                    'cost'   => $weapon['cost'] + $ring['cost'],
                    'damage' => $weapon['damage'] + $ring['damage'],
                    'armor'  => $weapon['armor'] + $ring['armor'],
                ];

                for ($i = $index + 1; $i < $numberOfRings; $i++) {
                    $combinations[] = [
                        'cost'   => $weapon['cost'] + $ring['cost'] + $inventory['rings'][$i]['cost'],
                        'damage' => $weapon['damage'] + $ring['damage'] + $inventory['rings'][$i]['damage'],
                        'armor'  => $weapon['armor'] + $ring['armor'] + $inventory['rings'][$i]['armor'],
                    ];
                }
            }
        }

        usort($combinations, function ($one, $two) {
            return $one['cost'] <=> $two['cost'];
        });

        return $combinations;
    }
}
