<?php

declare(strict_types=1);

/*
 * This file is part of the Advent of Code package.
 *
 * (c) Jonas Stendahl <jonas@stendahl.me>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Boo\AdventOfCode\Solvers\Year2015;

use Boo\AdventOfCode\ResultCollection;
use Boo\AdventOfCode\SolverInterface;

/**
 * Day 21: RPG Simulator 20XX
 *
 * @see http://adventofcode.com/2015/day/21
 */
final class Day21 implements SolverInterface
{
    /**
     * {@inheritdoc}
     */
    public function __invoke(string $input): ResultCollection
    {
        $input = explode("\n", $input);
        $stats = [];

        foreach ($input as $stat) {
            list($stat, $value) = explode(': ', $stat);
            $stats[$stat] = $value;
        }

        $test = $this->simulateBattle(8, $stats);
        #$real = $this->simulateBattle(100, $stats);

        return new ResultCollection($test[0], $test[1], $test[0], $test[1]);
    }

    private function simulateBattle(int $health, array $bossStats): array
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

    private function findCheapestWinner(int $health, array $bossStats, array $combinations): int
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

    private function findMostExpensiveLoser(int $health, array $bossStats, array $combinations): int
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

    private function getAllShopCombinations(array $inventory): array
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
