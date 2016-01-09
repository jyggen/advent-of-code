<?php
namespace Boo\AdventOfCode\Commands;

class DayTwentyFourCommand extends DayCommandAbstract
{
    protected $testDataOne = [
        [
            'input'  => [1, 2, 3, 4, 5, 7, 8, 9, 10, 11],
            'output' => 99,
        ],
    ];

    protected $testDataTwo = [
    ];

    protected function configure()
    {
        parent::configure();
        $this->setDescription('It Hangs in the Balance');
    }

    protected function normalizeData(array $input)
    {
        return $input;
    }

    protected function getDayNumber()
    {
        return 24;
    }

    protected function perform(array &$input)
    {


        return [$this->getIdealQuantumEntanglement($input, 3), $this->getIdealQuantumEntanglement($input, 4)];
    }

    protected function getIdealQuantumEntanglement($input, $groups)
    {
        $weightPerGroup      = array_sum($input) / $groups;
        $combinations        = $this->findCombinations($input, $weightPerGroup);
        $smallestConfigSize  = null;
        $quantumEntanglement = null;
        $productClosure      = function ($quantum, $item) {
            $quantum *= $item;
            return $quantum;
        };

        foreach ($combinations as $combination) {
            $currentSize = count($combination);

            if ($smallestConfigSize === null || $smallestConfigSize > $currentSize) {
                $smallestConfigSize  = $currentSize;
                $quantumEntanglement = array_reduce($combination, $productClosure, 1);
            } elseif ($smallestConfigSize === $currentSize) {
                $quantumEntanglement = min($quantumEntanglement, array_reduce($combination, $productClosure, 1));
            }
        }

        return $quantumEntanglement;
    }

    protected function findCombinations($input, $number)
    {
        $found = [];

        foreach (array_keys($input) as $gift) {
            $found = array_merge($found, $this->bruteforce([$gift], $input, $number));
        }

        $combinations = [];

        foreach ($found as $gifts) {
            $combination = [];

            foreach ($gifts as $gift) {
                $combination[] = $input[$gift];
            }

            $combinations[] = $combination;
        }

        return $combinations;
    }

    protected function bruteforce(array $giftStack, array $all, $targetWeight)
    {
        $sum = 0;
        foreach ($giftStack as $gift) {
            $sum += $all[$gift];
        }

        $potentialGifts = [];
        $stackSize      = count($giftStack);

        foreach ($all as $gift => $weight) {
            if ($gift <= $giftStack[$stackSize - 1]) {
                continue;
            }

            if (in_array($gift, $giftStack) === true) {
                continue;
            }

            $newSum = $sum + $weight;

            if ($newSum > $targetWeight) {
                continue;
            } elseif ($newSum === $targetWeight) {
                $potentialGifts[] = array_merge($giftStack, [$gift]);
            } elseif ($newSum < $targetWeight) {
                $newStack = array_merge($giftStack, [$gift]);
                $potentialGifts = array_merge($potentialGifts, $this->bruteforce($newStack, $all, $targetWeight));
            }
        }

        return $potentialGifts;
    }
}
