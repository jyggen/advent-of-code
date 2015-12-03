<?php
namespace Boo\AdventOfCode\Commands;

class DayThreeCommand extends DayCommandAbstract
{
    protected $testDataOne = [
        '>'          => 2,
        '^>v<'       => 4,
        '^v^v^v^v^v' => 2,
    ];

    protected $testDataTwo = [
        '^v'         => 3,
        '^>v<'       => 3,
        '^v^v^v^v^v' => 11,
    ];

    protected function configure()
    {
        parent::configure();
        $this->setDescription('Perfectly Spherical Houses in a Vacuum');
    }

    protected function normalizeData(array $input)
    {
        return str_split($input[0], 1);
    }

    protected function getDayNumber()
    {
        return 3;
    }

    protected function perform(array &$input)
    {
        // 0 => How many houses receive at least one present?
        // 1 => How many houses receive at least one present?
        return [$this->moveSantas($input, 1), $this->moveSantas($input, 2)];
    }

    protected function moveSantas(array &$input, $numberOfSantas)
    {
        // He begins by delivering a present to the house at his starting location.
        $houses      = [md5('0x0') => null];
        $inputLength = count($input);

        for ($santa = 0; $santa < $numberOfSantas; $santa++) {
            // Santa is delivering presents to an infinite two-dimensional grid of houses.
            $xAxis = 0;
            $yAxis = 0;

            for ($step = $santa; $step < $inputLength; $step += $numberOfSantas) {
                // Moves are always exactly one house to the north (^), south (v), east (>), or west (<).
                switch ($input[$step]) {
                    case '^':
                        $yAxis--;
                        break;
                    case 'v':
                        $yAxis++;
                        break;
                    case '>':
                        $xAxis++;
                        break;
                    case '<':
                        $xAxis--;
                        break;
                }

                $houseId = md5($xAxis.'x'.$yAxis);

                // After each move, he delivers another present to the house at his new location.
                if (isset($houses[$houseId]) === false) {
                    $houses[$houseId] = null;
                }
            }
        }

        return count($houses);
    }
}
