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
        return [$this->moveSantas($input, 1), $this->moveSantas($input, 2)];
    }

    protected function moveSantas(array &$input, $numberOfSantas)
    {
        $houses      = [md5('0x0') => null];
        $inputLength = count($input);

        for ($santa = 0; $santa < $numberOfSantas; $santa++) {
            $xAxis = 0;
            $yAxis = 0;

            for ($step = $santa; $step < $inputLength; $step += $numberOfSantas) {
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

                if (isset($houses[$houseId]) === false) {
                    $houses[$houseId] = null;
                }
            }
        }

        return count($houses);
    }
}
